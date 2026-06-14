@extends('layouts.app')

@section('title', 'CarStore | Trang chủ xe sang đẳng cấp')

@section('styles')
<style>
    /* Custom video overlay & smooth hover */
    .hero-video {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover; z-index: 0;
    }
    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.4) 100%);
        z-index: 1;
    }
    .hero-content {
        position: relative; z-index: 2;
    }
    .card-hover {
        transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
    }
    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 35px -12px rgba(0,0,0,0.2);
    }
    .btn-primary {
        transition: all 0.2s ease;
    }
    .btn-primary:hover {
        transform: scale(1.02);
        background-color: #1e40af;
        box-shadow: 0 8px 20px rgba(37,99,235,0.3);
    }
    .service-icon {
        transition: 0.2s;
    }
    .service-card:hover .service-icon {
        transform: scale(1.1);
        color: #2563eb;
    }
    html {
        scroll-behavior: smooth;
    }
</style>
@endsection

@section('content')
    <section class="relative h-screen max-h-[750px] md:max-h-[800px] overflow-hidden">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="{{ asset('videos/videoxe.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content relative z-10 flex flex-col justify-center items-center text-center h-full px-4 max-w-5xl mx-auto text-white">
            <span class="inline-block px-4 py-1 rounded-full bg-blue-600/30 backdrop-blur-sm text-sm font-semibold mb-5 border border-white/20">
                <i class="fa-regular fa-gem mr-1"></i> Đẳng cấp vượt thời gian
            </span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold leading-tight drop-shadow-2xl tracking-tight">
                Khám Phá Bộ Sưu Tập <br> <span class="text-blue-400">Siêu Xe & Xe Sang</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-100 mt-6 max-w-2xl mx-auto font-light">Trải nghiệm cảm giác lái đỉnh cao, dịch vụ tận tâm & chế độ bảo hành vượt trội.</p>
            <div class="flex flex-col sm:flex-row gap-4 mt-10">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-bold text-lg shadow-xl btn-primary transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-car"></i> Xem ngay
                </button>
                <button class="bg-white/10 backdrop-blur-sm border border-white/30 hover:bg-white/20 text-white px-8 py-3 rounded-full font-semibold text-lg transition flex items-center justify-center gap-2">
                    <i class="fa-regular fa-circle-play"></i> Lái thử
                </button>
            </div>
            <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-4 text-sm font-medium text-white/80">
                <div class="flex items-center gap-1"><i class="fa-solid fa-check-circle text-blue-400"></i> Miễn phí giao xe</div>
                <div class="flex items-center gap-1"><i class="fa-solid fa-shield-alt text-blue-400"></i> Bảo hành 5 năm</div>
                <div class="flex items-center gap-1"><i class="fa-solid fa-headset text-blue-400"></i> Hỗ trợ 24/7</div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="text-center mb-14">
            <span class="text-blue-600 font-semibold uppercase tracking-wider text-sm">Tuyển chọn hàng đầu</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2 text-gray-800">Mẫu xe bán chạy nhất</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
            <p class="text-gray-500 max-w-2xl mx-auto mt-4">Những siêu phẩm được yêu thích nhất, kết hợp giữa thiết kế Ý, Đức và sức mạnh vượt trội</p>
        </div>
        <div id="featured-cars-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"></div>
    </div>

    <section class="bg-white py-20 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="order-2 md:order-1">
                    <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider"><i class="fa-regular fa-film mr-1"></i> Trải nghiệm sống động</span>
                    <h3 class="text-3xl md:text-4xl font-bold mt-3 leading-tight">Tinh hoa công nghệ <br> & cảm xúc mãnh liệt</h3>
                    <p class="text-gray-600 mt-5 leading-relaxed">Đắm chìm trong thế giới của những chiếc xe – từ sức mạnh động cơ đến thiết kế hoàn hảo. CarStore mang đến chuẩn mực mới cho trải nghiệm lái.</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check-circle text-blue-600 text-lg"></i> <span>Đánh giá chuyên sâu từ các tay lái</span></li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check-circle text-blue-600 text-lg"></i> <span>Góc nhìn 360° nội thất sang trọng</span></li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check-circle text-blue-600 text-lg"></i> <span>Công nghệ an toàn đỉnh cao</span></li>
                    </ul>
                    <button class="mt-8 bg-gray-900 hover:bg-blue-600 text-white px-7 py-3 rounded-full font-semibold transition flex items-center gap-2 shadow-md">
                        <i class="fa-regular fa-circle-play"></i> Xem thư viện video
                    </button>
                </div>
                
                <div class="order-1 md:order-2 relative group w-full">
                    <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-2xl">
                        <iframe class="absolute top-0 left-0 w-full h-full" 
                                src="https://www.youtube.com/embed/0JGQBuHfL7M" 
                                title="VF 3 CHẤT RIÊNG, RẤT NGẦU" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                referrerpolicy="strict-origin-when-cross-origin" 
                                allowfullscreen>
                        </iframe>
                    </div>
                    <div class="absolute -bottom-4 -right-2 bg-blue-600 text-white p-3 rounded-full shadow-lg hidden md:block border-4 border-white">
                        <i class="fa-solid fa-video text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Đẳng cấp phục vụ</h2>
                <p class="text-gray-500 mt-2">Trải nghiệm mua sắm chuyên nghiệp, tận tâm và xứng tầm</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="service-card bg-white p-6 rounded-2xl shadow-sm text-center transition-all hover:shadow-md border border-gray-100">
                    <div class="service-icon text-blue-600 text-4xl mb-4"><i class="fa-solid fa-truck-fast"></i></div>
                    <h3 class="font-bold text-xl">Giao xe toàn quốc</h3>
                    <p class="text-gray-500 text-sm mt-2">Miễn phí vận chuyển nội thành, hỗ trợ tận nơi</p>
                </div>
                <div class="service-card bg-white p-6 rounded-2xl shadow-sm text-center transition-all hover:shadow-md border border-gray-100">
                    <div class="service-icon text-blue-600 text-4xl mb-4"><i class="fa-solid fa-clock"></i></div>
                    <h3 class="font-bold text-xl">Bảo hành dài hạn</h3>
                    <p class="text-gray-500 text-sm mt-2">5 năm hoặc 100.000 km, bảo dưỡng định kỳ</p>
                </div>
                <div class="service-card bg-white p-6 rounded-2xl shadow-sm text-center transition-all hover:shadow-md border border-gray-100">
                    <div class="service-icon text-blue-600 text-4xl mb-4"><i class="fa-solid fa-hand-holding-usd"></i></div>
                    <h3 class="font-bold text-xl">Trả góp linh hoạt</h3>
                    <p class="text-gray-500 text-sm mt-2">Lãi suất ưu đãi, thủ tục nhanh chóng</p>
                </div>
                <div class="service-card bg-white p-6 rounded-2xl shadow-sm text-center transition-all hover:shadow-md border border-gray-100">
                    <div class="service-icon text-blue-600 text-4xl mb-4"><i class="fa-solid fa-star-of-life"></i></div>
                    <h3 class="font-bold text-xl">Hỗ trợ 24/7</h3>
                    <p class="text-gray-500 text-sm mt-2">Đội ngũ chuyên viên tư vấn chuyên nghiệp</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const featuredCars = [];

    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
    }

    function addToCartDemo(carName) {
        alert(`✅ Đã thêm "${carName}" vào giỏ hàng (bản demo).\nĐăng nhập để hoàn tất đặt xe.`);
    }

    function renderFeaturedCars() {
        const container = document.getElementById('featured-cars-grid');
        if (!container) return;

        if (featuredCars.length === 0) {
            container.innerHTML = `
                <div class="col-span-full text-center text-gray-400 py-12">
                    <i class="fa-solid fa-car text-4xl mb-3"></i>
                    <p>Danh sách xe bán chạy đang được cập nhật...</p>
                </div>
            `;
            return;
        }

        container.innerHTML = featuredCars.map(car => `
            <div class="bg-white rounded-2xl shadow-md overflow-hidden card-hover transition border border-gray-100 group">
                <div class="relative overflow-hidden h-52">
                    <img src="${car.image}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105" alt="${car.name}">
                    <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full shadow-md">${car.badge}</div>
                </div>
                <div class="p-5">
                    <h3 class="font-extrabold text-xl tracking-tight">${car.name}</h3>
                    <p class="text-blue-600 font-bold text-xl mt-2">${formatPrice(car.price)}</p>
                    <div class="flex gap-2 mt-5">
                        <button onclick="addToCartDemo('${car.name}')" class="flex-1 bg-gray-900 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm">
                            <i class="fa-solid fa-cart-plus"></i> Đặt xe
                        </button>
                        <button class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
                            <i class="fa-regular fa-heart text-gray-600"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Tương tác nút Xem video
    document.querySelectorAll('.btn-primary, button').forEach(btn => {
        if(btn.innerText.includes('Xem ngay') || btn.innerText.includes('Xem thư viện')) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const videoSection = document.querySelector('iframe'); // Cuộn tới iframe video
                if(videoSection && btn.innerText.includes('Xem thư viện')) {
                    videoSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    alert('🚀 Khám phá ngay bộ sưu tập siêu xe tại showroom hoặc liên hệ hotline để được tư vấn!');
                }
            });
        }
    });

    // Nút Lái thử
    const driveBtn = document.querySelector('.bg-white\\/10');
    if(driveBtn) {
        driveBtn.addEventListener('click', () => {
            alert('📞 Vui lòng để lại số điện thoại, chúng tôi sẽ sắp xếp lịch lái thử miễn phí trong 24h.');
        });
    }

    // Khởi tạo xe nổi bật
    renderFeaturedCars();

    // Kích hoạt Autoplay Video
    document.addEventListener('DOMContentLoaded', () => {
        const video = document.querySelector('.hero-video');
        if (video) {
            video.play().catch(error => {
                console.log("Trình duyệt chặn autoplay, đang thử lại...");
            });
        }
    });
</script>
@endsection