<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller {
    public function home() {
        $danh_sach_xe = Car::all();
        $danh_sach_hang = DB::table('brands')->get();
        return view('index', compact('danh_sach_xe', 'danh_sach_hang'));
    }
    public function thongTinCongTy() {
        return view('Info');
    }
    public function chiTietXe($id) {
        $xe = DB::table('cars')->join('brands', 'cars.brand_id', '=', 'brands.id')->select('cars.*', 'brands.name as brand_name')->where('cars.id', $id)->first();
        if (!$xe) {
            abort(404);
        }
        return view('ChiTietXe', compact('xe'));
    }
    public function timKiem(Request $request) {
        $tu_khoa = $request->get('q');
        $ket_qua = DB::table('cars')->where('name', 'like', '%' . $tu_khoa . '%')->get();
        return response()->json($ket_qua);
    }
}