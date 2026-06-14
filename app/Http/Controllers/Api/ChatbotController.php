<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Car;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $request->message;

        // 1. Lấy ngữ cảnh từ Database (Lấy các xe đang mở bán)
        // Lưu ý: Lấy các trường cần thiết để không làm prompt quá dài
        $cars = Car::with('brand')
                    ->where('status', 1)
                    ->where('quantity', '>', 0)
                    ->get(['name', 'price', 'quantity', 'brand_id']);

        // Format lại dữ liệu xe thành chuỗi văn bản cho AI dễ hiểu
        $carContext = "Danh sách xe cửa hàng đang có:\n";
        foreach ($cars as $car) {
            $brandName = $car->brand ? $car->brand->name : 'Chưa rõ';
            $price = number_format($car->price, 0, ',', '.') . ' VNĐ';
            $carContext .= "- Xe {$car->name} (Hãng: {$brandName}) - Giá: {$price} - Còn: {$car->quantity} chiếc.\n";
        }

        // 2. Tạo System Prompt (Nhập vai cho AI)
        $systemPrompt = "Bạn là nhân viên tư vấn nhiệt tình, chuyên nghiệp của hệ thống bán xe CarStore. 
        Hãy dựa vào thông tin kho xe sau đây để trả lời khách hàng:
        \n$carContext\n
        Quy tắc trả lời:
        1. Chỉ tư vấn các xe có trong danh sách trên. Nếu khách hỏi xe không có, hãy lịch sự xin lỗi và gợi ý xe khác cùng tầm giá.
        2. Trả lời ngắn gọn, súc tích, thân thiện và format bằng Markdown (in đậm giá tiền, tên xe).
        3. Không bịa đặt thông tin hoặc giá cả.";

        // 3. Gọi API của Google Gemini
        try {
            $apiKey = env('GEMINI_API_KEY');
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash:generateContent?key={$apiKey}";
            
            $response = Http::withoutVerifying()->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt . "\n\nKhách hỏi: " . $userMessage]
                        ]
                    ]
                ]
            ]);

            $result = $response->json();

            // LƯU Ý 2: Kiểm tra xem Google có trả về lỗi (Ví dụ: Sai API key, hết hạn mức...)
            if (isset($result['error'])) {
                return response()->json([
                    'status' => 'success',
                    'reply' => 'Lỗi từ Google: ' . $result['error']['message']
                ]);
            }

            // Trích xuất câu trả lời
            $aiReply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Dữ liệu Google trả về không đúng cấu trúc.';

            return response()->json([
                'status' => 'success',
                'reply' => $aiReply
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success', // Vẫn trả về success để hiện bong bóng chat chứa lỗi
                'reply' => 'Lỗi Code/Mạng: ' . $e->getMessage()
            ]);
        }
    }
}