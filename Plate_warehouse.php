<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kho Biển Số | Luxury Interface</title>
    <style>
        :root {
            --gold-grad: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
            --pitch-black: #050505;
            --luxury-gold: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
        }

        body {
            background-color: #0a0a0a;
            font-family: 'Montserrat', sans-serif;
            color: white;
            overflow-x: hidden;
            margin-top: 100px;
        }

        /* ----------------------------- section 1 -----------------------------  */
        /* Nền Cockpit với lưới mờ */
        .hero-section {
            background-color: var(--pitch-black);
            background-image:
                linear-gradient(rgba(191, 149, 63, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(191, 149, 63, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            position: relative;
        }

        /* Chữ mạ vàng Gradient */
        .gold-text {
            background: var(--gold-grad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Thanh Search Quyền Lực */
        .search-wrapper {
            width: 0%;
            /* Sẽ mở rộng bằng GSAP */
            opacity: 0;
            overflow: hidden;
            border: 1px solid rgba(191, 149, 63, 0.3);
            transition: box-shadow 0.4s ease, border-color 0.4s ease;
        }

        .search-wrapper:focus-within {
            border-color: #bf953f;
            box-shadow: 0 0 30px rgba(191, 149, 63, 0.15);
        }

        /* Hiệu ứng nảy và đổi màu khi gõ số */
        .luxury-input {
            caret-color: #bf953f;
        }

        .luxury-input:not(:placeholder-shown) {
            color: #d4af37;
            font-weight: 800;
            letter-spacing: 4px;
        }

        .filter-tag {
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            /* Tăng độ sáng nền một chút */
            border: 1px solid rgba(191, 149, 63, 0.4);
            /* Viền vàng rõ hơn */
            color: #e5e7eb !important;
            /* Chữ xám trắng (gray-200) để dễ đọc */
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            /* Tạo bóng đổ để nổi khối */
        }

        /* Vệt sáng chạy ngang khi Hover */
        .filter-tag::after {
            content: "";
            position: absolute;
            top: 0;
            left: -150%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(252, 246, 186, 0.3),
                    /* Tăng độ sáng tia sét */
                    transparent);
            transition: 0.6s;
            z-index: 1;
        }

        .filter-tag:hover::after {
            left: 150%;
        }

        .filter-tag::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(191, 149, 63, 0.2), transparent);
            transition: 0.6s;
        }

        .filter-tag:hover::before {
            left: 100%;
        }

        /* Hiệu ứng khi nhấn giữ: Nút biến thành thỏi vàng đặc */
        .filter-tag:active {
            background: var(--luxury-gold);
            color: #1a1a1a !important;
            transform: scale(0.92);
            box-shadow: 0 0 30px rgba(191, 149, 63, 0.5);
        }

        /* Đảm bảo text luôn nằm trên lớp shimmer */
        .filter-tag span {
            position: relative;
            z-index: 2;
        }

        /* Hiệu ứng khi Hover: Chữ trắng sáng và viền vàng rực */
        .filter-tag:hover {
            color: #ffffff !important;
            border-color: #fcf6ba;
            /* Chuyển sang màu vàng nhạt khi hover */
            background: rgba(191, 149, 63, 0.15);
            box-shadow: 0 0 20px rgba(191, 149, 63, 0.3);
            transform: translateY(-3px);
            /* Nhấc cao hơn một chút */
        }

        /* Custom scroll cho mobile tags */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Hiệu ứng 3D cho biển số nghiêng mồi */
        .plate-mockup {
            transform: perspective(1000px) rotateY(-15deg) rotateX(5deg);
            transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .master-card:hover .plate-mockup {
            transform: perspective(1000px) rotateY(0deg) rotateX(0deg) scale(1.05);
        }

        /* Hiệu ứng Gold Text */
        .gold-text {
            background: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
        }

        .master-card {
            transition: transform 0.4s ease;
        }

        @media (max-width: 768px) {

            /* Mobile: Không nghiêng 3D để tập trung vào số */
            .plate-mockup {
                transform: none;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */

        /* Sub-filter styles */
        .filter-item {
            position: relative;
            padding: 4px 12px;
            border-radius: 2px;
            background: transparent;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #4b5563;
            padding-bottom: 4px;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
        }

        .filter-item:hover,
        .filter-item.active {
            color: #bf953f;
            border-bottom-color: #bf953f;
            box-shadow: 0 4px 15px rgba(191, 149, 63, 0.3);
        }

        /* Badge styles (Điểm dừng thị giác) */
        .badge-gold {
            font-size: 7px;
            font-weight: 900;
            color: #000;
            background: #bf953f;
            padding: 2px 6px;
            border-radius: 1px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Standard Card Hover */
        .standard-card {
            transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .standard-card:hover {
            transform: translateY(-8px);
        }

        /* Plate Mini (Sạch sẽ, dễ đọc) */
        .plate-mini {
            transform: perspective(500px) rotateX(5deg);
            transition: transform 0.5s;
        }

        .standard-card:hover .plate-mini {
            transform: perspective(500px) rotateX(0deg) scale(1.05);
        }

        /* Hide scrollbar */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Hiệu ứng xoay mũi tên khi hover tỉnh thành */
        .group\/dropdown:hover i {
            transform: rotate(180deg);
            color: #bf953f;
        }

        /* Responsive Grid */
        @media (max-width: 640px) {
            #main-grid {
                grid-template-columns: 1fr;
                /* 1 cột lớn trên Mobile */
            }

            .standard-card {
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                padding-bottom: 24px;
            }

            /* Hiện sẵn nút Chốt đơn trên Mobile để dễ thao tác */
            .standard-card .md\:opacity-0 {
                opacity: 1 !important;
            }
        }

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section class="hero-section min-h-[80vh] flex flex-col items-center justify-center px-4 pt-20">

        <div class="text-center mb-12" id="hero-title">
            <h2 class="text-gray-500 tracking-[0.6em] text-[10px] md:text-xs font-bold mb-4 uppercase">The Exclusive Collection</h2>
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tighter leading-tight">
                TÌM KIẾM ĐỊNH DANH <br class="md:hidden"> <span class="gold-text">ĐẲNG CẤP</span>
            </h1>
        </div>

        <div id="search-container" class="search-wrapper relative max-w-[800px] w-full bg-black rounded-[4px] flex items-center p-1 md:p-2 mb-8">
            <button class="px-3 text-[#bf953f] hover:scale-110 transition-transform hidden md:block">
                <i class="ri-map-pin-2-fill"></i>
            </button>

            <input type="text"
                inputmode="numeric"
                placeholder="Nhập số mơ ước hoặc ký tự..."
                class="luxury-input w-full bg-transparent border-none outline-none px-4 py-3 md:py-4 text-white text-sm md:text-base placeholder:text-gray-700">

            <button class="bg-transparent px-4 md:px-6 py-2 border-l border-white/10 group">
                <i class="ri-search-2-line text-2xl gold-text group-hover:scale-125 transition-transform duration-300"></i>
            </button>
        </div>

        <div id="filter-container" class="w-full max-w-[900px]">
            <p class="text-[9px] text-gray-600 uppercase tracking-widest text-center mb-4">Gợi ý phân hạng</p>

            <div class="flex overflow-x-auto md:flex-wrap md:justify-center gap-3 md:gap-4 hide-scrollbar pb-4 px-2">
                <button class="filter-tag flex-shrink-0 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 rounded-sm">Tứ Quý</button>
                <button class="filter-tag flex-shrink-0 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 rounded-sm">Phát Lộc (68, 86)</button>
                <button class="filter-tag flex-shrink-0 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 rounded-sm">San Bằng Tất Cả</button>
                <button class="filter-tag flex-shrink-0 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 rounded-sm">Sảnh Tiến</button>
                <button class="filter-tag flex-shrink-0 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 rounded-sm">Thần Tài</button>
            </div>
        </div>

    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section class="royal-gallery py-20 relative bg-[#050505] overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[300px] bg-gradient-to-b from-[#bf953f]/10 to-transparent pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black gold-text tracking-[0.2em] uppercase italic mb-4 drop-shadow-2xl">
                    SIÊU PHẨM TOÀN QUỐC
                </h2>
                <div class="h-[1px] w-24 bg-[#bf953f] mx-auto mb-4"></div>
                <p class="text-[10px] text-gray-500 uppercase tracking-[0.5em]">The Ultimate Digital Assets</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <div class="master-card group">
                    <div class="relative aspect-[16/10] bg-[#0a0a0a] rounded-t-sm border border-white/5 overflow-hidden flex items-center justify-center p-6">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,_#151515_0%,_#050505_100%)]"></div>

                        <div class="absolute top-4 left-4 z-20">
                            <span class="text-[8px] font-bold bg-[#bf953f] text-black px-2 py-1 rounded-full uppercase tracking-tighter">Đang đấu giá</span>
                        </div>

                        <button class="absolute bottom-4 right-4 z-20 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center gap-2 bg-black/60 backdrop-blur-md border border-white/10 px-3 py-1.5 rounded-sm">
                            <i class="ri-camera-lens-line text-[#bf953f] text-xs"></i>
                            <span class="text-[9px] text-gray-300 uppercase font-bold">Xem ảnh thực tế</span>
                        </button>

                        <div class="plate-mockup relative z-10">
                            <div class="plate-base bg-[#f0f0f0] px-8 py-4 rounded-sm shadow-[0_30px_60px_-15px_rgba(0,0,0,0.9)] border-b-[5px] border-gray-400">
                                <span class="text-black font-bold text-4xl tracking-tighter font-serif block">30K - 999.99</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/20 to-transparent pointer-events-none"></div>
                        </div>

                        <div class="absolute bottom-6 w-1/2 h-2 bg-gradient-to-r from-transparent via-gray-800 to-transparent blur-sm"></div>
                    </div>

                    <div class="bg-[#080808] p-6 border-x border-b border-white/5 rounded-b-sm transition-all duration-500 group-hover:border-[#bf953f]/30">
                        <div class="flex items-center gap-2 mb-3 opacity-60 group-hover:opacity-100 transition-opacity">
                            <i class="ri-map-pin-2-fill text-[#bf953f] text-xs"></i>
                            <span class="text-[10px] text-gray-300 uppercase tracking-widest font-bold">TP. Hồ Chí Minh</span>
                        </div>

                        <div class="text-center py-2">
                            <p class="text-2xl md:text-3xl font-bold gold-text tracking-tight counter-price" data-target="9500000000">0</p>
                            <p class="text-[8px] text-gray-600 font-bold uppercase mt-1">Việt Nam Đồng</p>
                        </div>

                        <button class="mt-6 w-full py-3 border border-[#bf953f]/40 hover:bg-[#bf953f] text-[#bf953f] hover:text-black transition-all duration-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                            Liên hệ sở hữu
                        </button>
                    </div>
                </div>

                <div class="master-card group">
                    <div class="relative aspect-[16/10] bg-[#0a0a0a] border border-white/5 overflow-hidden flex items-center justify-center p-6">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,_#151515_0%,_#050505_100%)]"></div>
                        <div class="absolute top-4 left-4 z-20">
                            <span class="text-[8px] font-bold border border-[#bf953f] text-[#bf953f] px-2 py-1 rounded-full uppercase tracking-tighter">Sẵn hàng</span>
                        </div>
                        <div class="plate-mockup relative z-10">
                            <div class="plate-base bg-[#f0f0f0] px-8 py-4 rounded-sm shadow-2xl border-b-[5px] border-gray-400">
                                <span class="text-black font-bold text-4xl tracking-tighter font-serif">51L - 888.88</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#080808] p-6 border-x border-b border-white/5transition-all">
                        <div class="flex items-center gap-2 mb-3 opacity-60 group-hover:opacity-100">
                            <i class="ri-map-pin-2-fill text-[#bf953f] text-xs"></i>
                            <span class="text-[10px] text-gray-300 uppercase tracking-widest font-bold">Hà Nội</span>
                        </div>
                        <div class="text-center py-2">
                            <p class="text-2xl md:text-3xl font-bold gold-text counter-price" data-target="4500000000">0</p>
                            <p class="text-[8px] text-gray-600 font-bold uppercase mt-1">Việt Nam Đồng</p>
                        </div>
                        <button class="mt-6 w-full py-3 border border-[#bf953f]/40 hover:bg-[#bf953f] text-[#bf953f] hover:text-black transition-all text-[10px] font-bold uppercase tracking-[0.2em]">Liên hệ sở hữu</button>
                    </div>
                </div>

                <div class="master-card group">
                    <div class="relative aspect-[16/10] bg-[#0a0a0a] border border-white/5 overflow-hidden flex items-center justify-center p-6">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,_#151515_0%,_#050505_100%)]"></div>
                        <div class="absolute top-4 left-4 z-20">
                            <span class="text-[8px] font-bold bg-white text-black px-2 py-1 rounded-full uppercase tracking-tighter">Hot Sale</span>
                        </div>
                        <div class="plate-mockup relative z-10">
                            <div class="plate-base bg-[#f0f0f0] px-8 py-4 rounded-sm shadow-2xl border-b-[5px] border-gray-400">
                                <span class="text-black font-bold text-4xl tracking-tighter font-serif">15A - 567.89</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#080808] p-6 border-x border-b border-white/5">
                        <div class="flex items-center gap-2 mb-3 opacity-60 group-hover:opacity-100">
                            <i class="ri-map-pin-2-fill text-[#bf953f] text-xs"></i>
                            <span class="text-[10px] text-gray-300 uppercase tracking-widest font-bold">Hải Phòng</span>
                        </div>
                        <div class="text-center py-2">
                            <p class="text-2xl md:text-3xl font-bold gold-text counter-price" data-target="1200000000">0</p>
                            <p class="text-[8px] text-gray-600 font-bold uppercase mt-1">Việt Nam Đồng</p>
                        </div>
                        <button class="mt-6 w-full py-3 border border-[#bf953f]/40 hover:bg-[#bf953f] text-[#bf953f] hover:text-black transition-all text-[10px] font-bold uppercase tracking-[0.2em]">Liên hệ sở hữu</button>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ----------------------------- section 3 -----------------------------  -->
    <section class="general-treasury py-16 bg-[#0a0a0a] relative">
        <div class="container mx-auto px-6">

            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6 border-b border-white/5 pb-8">
                <div>
                    <h3 class="text-xl md:text-2xl font-bold text-white mb-2 uppercase tracking-tighter">
                        Kho Biển Số <span class="text-[#bf953f] ml-2">Tổng Thể</span>
                    </h3>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest">
                        Tìm thấy <span class="text-[#bf953f] font-bold">12,450</span> biển số phù hợp
                    </p>
                </div>
                <div class="flex items-center gap-4 overflow-x-auto hide-scrollbar pb-2 md:pb-0" id="sort-filter-group">
                    <span class="text-[9px] text-gray-600 uppercase font-bold whitespace-nowrap">Sắp xếp:</span>

                    <button class="filter-item active" data-sort="newest">Mới nhất</button>
                    <button class="filter-item" data-sort="price-asc">Giá tăng dần</button>
                    <button class="filter-item" data-sort="price-desc">Giá giảm dần</button>

                    <div class="relative group/dropdown">
                        <button class="filter-item flex items-center gap-1" id="province-trigger">
                            <span>Theo tỉnh thành</span>
                            <i class="ri-arrow-down-s-line transition-transform duration-300"></i>
                        </button>

                        <div class="absolute top-full left-0 mt-2 w-48 bg-[#0f0f0f] border border-white/10 rounded-sm py-2 opacity-0 invisible group-hover/dropdown:opacity-100 group-hover/dropdown:visible transition-all z-50 shadow-2xl">
                            <a href="#" class="block px-4 py-2 text-[10px] text-gray-400 hover:bg-[#bf953f] hover:text-black font-bold uppercase">Hà Nội</a>
                            <a href="#" class="block px-4 py-2 text-[10px] text-gray-400 hover:bg-[#bf953f] hover:text-black font-bold uppercase">TP. Hồ Chí Minh</a>
                            <a href="#" class="block px-4 py-2 text-[10px] text-gray-400 hover:bg-[#bf953f] hover:text-black font-bold uppercase">Đà Nẵng</a>
                            <a href="#" class="block px-4 py-2 text-[10px] text-gray-400 hover:bg-[#bf953f] hover:text-black font-bold uppercase">Hải Phòng</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-10" id="main-grid">

                <div class="standard-card group" data-aos="fade-up">
                    <div class="relative aspect-[16/9] bg-[#050505] border border-white/5 overflow-hidden flex items-center justify-center group-hover:border-[#bf953f]/50 transition-all duration-500">
                        <div class="absolute top-2 left-2 z-10">
                            <span class="badge-gold">Đại Cát</span>
                        </div>

                        <button class="absolute top-2 right-2 z-10 text-gray-600 hover:text-[#bf953f] transition-colors">
                            <i class="ri-heart-fill text-lg"></i>
                        </button>

                        <div class="plate-mini">
                            <div class="bg-white px-5 py-2 rounded-sm shadow-lg">
                                <span class="text-black font-bold text-xl tracking-tight font-serif">30K-123.45</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-col items-center">
                        <div class="flex items-center gap-1 opacity-40 mb-1">
                            <i class="ri-map-pin-2-fill text-[8px] text-[#bf953f]"></i>
                            <span class="text-[9px] text-white uppercase tracking-widest font-bold">Hà Nội</span>
                        </div>

                        <div class="text-lg font-bold text-[#bf953f] tracking-tighter">
                            450,000,000 <span class="text-[8px] text-gray-600 ml-1">VND</span>
                        </div>

                        <div class="h-0 opacity-0 group-hover:h-6 group-hover:opacity-100 transition-all duration-300 overflow-hidden">
                            <p class="text-[9px] text-gray-500 italic">Sảnh tiến quý hiếm - Phong thủy hanh thông</p>
                        </div>

                        <div class="w-full mt-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 md:block">
                            <a href="#" class="block w-full py-2 bg-[#bf953f]/10 border border-[#bf953f]/30 text-[#bf953f] text-center text-[9px] font-bold uppercase tracking-widest hover:bg-[#bf953f] hover:text-black transition-all">
                                Liên hệ ngay
                            </a>
                        </div>
                    </div>
                </div>

                <div class="standard-card group opacity-60">
                    <div class="relative aspect-[16/9] bg-[#050505] border border-white/5 flex items-center justify-center">
                        <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
                            <span class="text-[10px] font-bold text-red-500/80 border border-red-500/30 px-3 py-1 uppercase tracking-widest bg-black/80">Đã giữ chỗ</span>
                        </div>
                        <div class="plate-mini">
                            <div class="bg-white/80 px-5 py-2 rounded-sm grayscale">
                                <span class="text-black font-bold text-xl font-serif">51L-888.08</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <div class="text-[9px] text-gray-600 uppercase font-bold">TP. Hồ Chí Minh</div>
                        <div class="text-lg font-bold text-gray-700 line-through tracking-tighter">180,000,000</div>
                    </div>
                </div>

                <div class="standard-card group">
                    <div class="relative aspect-[16/9] bg-[#050505] border border-white/5 flex items-center justify-center group-hover:border-[#bf953f]/50 transition-all">
                        <div class="absolute top-2 left-2 z-10"><span class="badge-gold">Số Gánh</span></div>
                        <button class="absolute top-2 right-2 z-10 text-gray-600"><i class="ri-heart-fill text-lg"></i></button>
                        <div class="plate-mini">
                            <div class="bg-white px-5 py-2 rounded-sm shadow-lg"><span class="text-black font-bold text-xl tracking-tight font-serif">15A-678.76</span></div>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col items-center">
                        <div class="flex items-center gap-1 opacity-40 mb-1"><i class="ri-map-pin-2-fill text-[8px] text-[#bf953f]"></i><span class="text-[9px] text-white uppercase font-bold">Hải Phòng</span></div>
                        <div class="text-lg font-bold text-[#bf953f]">85,000,000 <span class="text-[8px] text-gray-600 ml-1">VND</span></div>
                        <div class="w-full mt-4 md:opacity-0 group-hover:opacity-100 transition-all"><a href="#" class="block w-full py-2 bg-[#bf953f]/10 border border-[#bf953f]/30 text-[#bf953f] text-center text-[9px] font-bold uppercase tracking-widest">Liên hệ ngay</a></div>
                    </div>
                </div>

            </div>

            <div class="mt-20 text-center">
                <button id="load-more" class="group relative px-12 py-4 overflow-hidden border border-white/10">
                    <span class="relative z-10 text-[10px] text-gray-400 font-bold uppercase tracking-[0.3em] group-hover:text-white transition-colors">Khám phá thêm</span>
                    <div class="absolute inset-0 bg-[#bf953f] translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                </button>
            </div>
        </div>
    </section>




    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include('footer.php'); ?>
</body>
<script>
    //----------------------------- section 1 ----------------------------- //
    window.addEventListener('load', () => {
        const tl = gsap.timeline();

        // 1. Chữ hiện ra từ từ
        tl.from("#hero-title h2", {
                opacity: 0,
                y: 10,
                duration: 0.8
            })
            .from("#hero-title h1", {
                opacity: 0,
                y: 20,
                duration: 0.8
            }, "-=0.4");

        // 2. Hiệu ứng "Đôi cánh" - Thanh Search mở rộng sang 2 bên
        tl.to("#search-container", {
            width: "100%",
            opacity: 1,
            duration: 1.2,
            ease: "expo.inOut"
        }, "-=0.4");

        // 3. Các Tags hiện ra với stagger (so le)
        tl.from(".filter-tag", {
            y: 20,
            opacity: 0,
            stagger: 0.05,
            duration: 0.5,
            ease: "power2.out"
        }, "-=0.5");
    });

    // 4. Hiệu ứng gõ số: Nảy nhẹ (Visual Feedback)
    const searchInput = document.querySelector('.luxury-input');
    searchInput.addEventListener('input', (e) => {
        gsap.fromTo(searchInput, {
            y: -2
        }, {
            y: 0,
            duration: 0.2,
            ease: "bounce.out"
        });
    });

    // -----------------------------section 2 ----------------------------- //
    // JS Đếm số tương tự Section trước để đồng bộ
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.getAttribute('data-target'));
                let current = 0;
                const duration = 2000;
                const step = target / (duration / 16);

                const animate = () => {
                    if (current < target) {
                        current += step;
                        el.innerText = Math.floor(current).toLocaleString('vi-VN');
                        requestAnimationFrame(animate);
                    } else {
                        el.innerText = target.toLocaleString('vi-VN');
                    }
                };
                animate();
                observer.unobserve(el);
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.counter-price').forEach(n => observer.observe(n));


    //----------------------------- section 3 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Dữ liệu mẫu (Thay vì fix cứng HTML, ta quản lý bằng mảng này)
        const plateData = [{
                id: 1,
                plate: "30K-123.45",
                price: 450000000,
                province: "Hà Nội",
                badge: "Đại Cát",
                status: "available"
            },
            {
                id: 2,
                plate: "51L-888.08",
                price: 180000000,
                province: "TP. Hồ Chí Minh",
                badge: "",
                status: "booked"
            },
            {
                id: 3,
                plate: "15A-678.76",
                price: 85000000,
                province: "Hải Phòng",
                badge: "Số Gánh",
                status: "available"
            },
            {
                id: 4,
                plate: "30K-999.99",
                price: 9500000000,
                province: "Hà Nội",
                badge: "Ngũ Quý",
                status: "available"
            }
        ];

        const mainGrid = document.getElementById('main-grid');
        const sortButtons = document.querySelectorAll('#sort-filter-group .filter-item');

        // 2. Hàm Render (Vẽ biển số ra màn hình)
        function renderPlates(data) {
            mainGrid.innerHTML = ''; // Xóa sạch grid cũ

            data.forEach(item => {
                const isBooked = item.status === 'booked';
                const cardHtml = `
                <div class="standard-card group ${isBooked ? 'opacity-60' : ''}" data-aos="fade-up">
                    <div class="relative aspect-[16/9] bg-[#050505] border border-white/5 overflow-hidden flex items-center justify-center group-hover:border-[#bf953f]/50 transition-all duration-500">
                        ${item.badge ? `<div class="absolute top-2 left-2 z-10"><span class="badge-gold">${item.badge}</span></div>` : ''}
                        
                        ${isBooked ? `
                            <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
                                <span class="text-[10px] font-bold text-red-500/80 border border-red-500/30 px-3 py-1 uppercase tracking-widest bg-black/80">Đã giữ chỗ</span>
                            </div>
                        ` : `
                            <button class="absolute top-2 right-2 z-10 text-gray-600 hover:text-[#bf953f] transition-colors btn-heart">
                                <i class="ri-heart-fill text-lg"></i>
                            </button>
                        `}

                        <div class="plate-mini">
                            <div class="bg-white px-5 py-2 rounded-sm shadow-lg ${isBooked ? 'grayscale' : ''}">
                                <span class="text-black font-bold text-xl tracking-tight font-serif">${item.plate}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-col items-center text-center">
                        <div class="flex items-center gap-1 opacity-40 mb-1">
                            <i class="ri-map-pin-2-fill text-[8px] text-[#bf953f]"></i>
                            <span class="text-[9px] text-white uppercase tracking-widest font-bold">${item.province}</span>
                        </div>
                        
                        <div class="text-lg font-bold ${isBooked ? 'text-gray-700 line-through' : 'text-[#bf953f]'} tracking-tighter">
                            ${item.price.toLocaleString('vi-VN')} <span class="text-[8px] text-gray-600 ml-1">VND</span>
                        </div>

                        <div class="h-0 opacity-0 group-hover:h-6 group-hover:opacity-100 transition-all duration-300 overflow-hidden">
                            <p class="text-[9px] text-gray-500 italic">Biển số phong thủy - Đẳng cấp chủ nhân</p>
                        </div>

                        ${!isBooked ? `
                        <div class="w-full mt-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 md:block">
                            <a href="#" class="block w-full py-2 bg-[#bf953f]/10 border border-[#bf953f]/30 text-[#bf953f] text-center text-[9px] font-bold uppercase tracking-widest hover:bg-[#bf953f] hover:text-black transition-all">
                                Liên hệ ngay
                            </a>
                        </div>
                        ` : ''}
                    </div>
                </div>
            `;
                mainGrid.innerHTML += cardHtml;
            });

            // Gán lại sự kiện tim cho các nút mới tạo
            attachHeartEvents();
        }

        // 3. Xử lý sự kiện Sắp xếp
        sortButtons.forEach(button => {
            button.addEventListener('click', function() {
                const sortType = this.getAttribute('data-sort');
                if (!sortType) return; // Bỏ qua nếu là nút Tỉnh thành

                // Giao diện: Đổi active
                sortButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Hiệu ứng mờ Grid
                gsap.to(mainGrid, {
                    opacity: 0,
                    y: 10,
                    duration: 0.2,
                    onComplete: () => {

                        // Logic sắp xếp thực tế
                        let sortedData = [...plateData];
                        if (sortType === 'price-asc') {
                            sortedData.sort((a, b) => a.price - b.price);
                        } else if (sortType === 'price-desc') {
                            sortedData.sort((a, b) => b.price - a.price);
                        } else if (sortType === 'newest') {
                            sortedData.sort((a, b) => b.id - a.id);
                        }

                        // Render lại dữ liệu đã sắp xếp
                        renderPlates(sortedData);

                        // Hiện Grid lại
                        gsap.to(mainGrid, {
                            opacity: 1,
                            y: 0,
                            duration: 0.4
                        });
                    }
                });
            });
        });

        // Hàm phụ: Yêu thích
        function attachHeartEvents() {
            document.querySelectorAll('.btn-heart').forEach(heart => {
                heart.onclick = function() {
                    this.classList.toggle('text-[#bf953f]');
                    gsap.from(this, {
                        scale: 1.5,
                        duration: 0.3
                    });
                };
            });
        }

        // Khởi tạo lần đầu
        renderPlates(plateData);
    });

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>