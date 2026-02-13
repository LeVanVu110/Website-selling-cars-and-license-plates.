<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";
require_once __DIR__ . "/models/Place.php";

$plateModel = new Place();

// Lấy dữ liệu ban đầu cho lần load trang đầu tiên
$currentProvince = $_GET['province'] ?? '';
$currentSort = $_GET['sort'] ?? 'newest';
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 4; // Số lượng hiện lúc đầu
$plates = $plateModel->getAllPlates($currentProvince, $currentSort, 1, $limit);

// Đảm bảo $plates luôn là mảng để foreach không báo lỗi
if (!$plates) {
    $plates = [];
}
// Lấy danh sách tiềm năng (giả sử lấy 10 cái giá cao nhất để lọc lại)
$rawTopPlates = $plateModel->getAllPlates('', 'price_desc', 1, 10);

// Lọc chỉ lấy những biển có status == 1
$topPlates = array_filter($rawTopPlates, function ($plate) {
    return $plate['status'] == 1;
});

// Chỉ lấy đúng 3 cái đầu tiên sau khi đã lọc status 1
$topPlates = array_slice($topPlates, 0, 3);
?>

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
        .color-dot.active {
            border-color: #bf953f;
            transform: scale(1.2);
        }

        /* Dynamic Theme Colors */
        .theme-mộc {
            --accent: #2ecc71;
        }

        .theme-hỏa {
            --accent: #e74c3c;
        }

        .theme-thổ {
            --accent: #f1c40f;
        }

        .theme-thủy {
            --accent: #3498db;
        }

        .theme-kim {
            --accent: #bf953f;
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* ----------------------------- section 5 -----------------------------  */
        /* Typography rỗng chân cho số thứ tự */
        .outline-text {
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.1);
            color: transparent;
        }

        .step-card:hover .outline-text {
            -webkit-text-stroke: 1px rgba(191, 149, 63, 0.3);
        }

        /* Hiệu ứng Gold mượt mà */
        .gold-text {
            background: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @media (max-width: 768px) {

            /* Mobile: Đường nối dọc */
            .step-card::after {
                content: '';
                position: absolute;
                left: 24px;
                top: 48px;
                width: 1px;
                height: 100%;
                background: rgba(255, 255, 255, 0.05);
                z-index: 1;
            }

            .step-card:last-child::after {
                display: none;
            }
        }

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

            <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

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
                        <a href="Detail_Plate_warehouse.php">
                            <button class="mt-6 w-full py-3 border border-[#bf953f]/40 hover:bg-[#bf953f] text-[#bf953f] hover:text-black transition-all duration-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                                Liên hệ sở hữu
                            </button>
                        </a>
                    </div>

                </div>

                <div class="master-card group">
                    <a href="Detail_Plate_warehouse.php">

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
                            <a href="Detail_Plate_warehouse.php">
                                <button class="mt-6 w-full py-3 border border-[#bf953f]/40 hover:bg-[#bf953f] text-[#bf953f] hover:text-black transition-all duration-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                                    Liên hệ sở hữu
                                </button>
                            </a>
                        </div>
                    </a>
                </div>

                <div class="master-card group">
                    <a href="Detail_Plate_warehouse.php">

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
                            <a href="Detail_Plate_warehouse.php">
                                <button class="mt-6 w-full py-3 border border-[#bf953f]/40 hover:bg-[#bf953f] text-[#bf953f] hover:text-black transition-all duration-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                                    Liên hệ sở hữu
                                </button>
                            </a>
                        </div>
                    </a>
                </div>
            </div> -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <?php foreach ($topPlates as $index => $plate):
                    // Logic nhãn hiển thị tùy theo index hoặc trạng thái
                    $statusLabel = ($plate['status'] == 1) ? 'Sẵn hàng' : 'Đang đấu giá';
                    $statusClass = ($plate['status'] == 1) ? 'border border-[#bf953f] text-[#bf953f]' : 'bg-[#bf953f] text-black';
                    $badge = $plateModel->getPlateBadge($plate['plate_number']);
                ?>
                    <div class="master-card group" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="relative aspect-[16/10] bg-[#0a0a0a] rounded-t-sm border border-white/5 overflow-hidden flex items-center justify-center p-6">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,_#151515_0%,_#050505_100%)]"></div>

                            <div class="absolute top-4 left-4 z-20">
                                <span class="text-[8px] font-bold px-2 py-1 rounded-full uppercase tracking-tighter <?= $statusClass ?>">
                                    <?= $statusLabel ?>
                                </span>
                            </div>

                            <button class="absolute bottom-4 right-4 z-20 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center gap-2 bg-black/60 backdrop-blur-md border border-white/10 px-3 py-1.5 rounded-sm">
                                <i class="ri-camera-lens-line text-[#bf953f] text-xs"></i>
                                <span class="text-[9px] text-gray-300 uppercase font-bold">Xem ảnh thực tế</span>
                            </button>

                            <div class="plate-mockup relative z-10">
                                <div class="plate-base bg-[#f0f0f0] px-8 py-4 rounded-sm shadow-[0_30px_60px_-15px_rgba(0,0,0,0.9)] border-b-[5px] border-gray-400">
                                    <span class="text-black font-bold text-3xl md:text-4xl tracking-tighter font-serif block">
                                        <?= htmlspecialchars($plate['plate_number']) ?>
                                    </span>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/20 to-transparent pointer-events-none"></div>
                            </div>

                            <div class="absolute bottom-6 w-1/2 h-2 bg-gradient-to-r from-transparent via-gray-800 to-transparent blur-sm"></div>
                        </div>

                        <div class="bg-[#080808] p-6 border-x border-b border-white/5 rounded-b-sm transition-all duration-500 group-hover:border-[#bf953f]/30">
                            <div class="flex items-center gap-2 mb-3 opacity-60 group-hover:opacity-100 transition-opacity">
                                <i class="ri-map-pin-2-fill text-[#bf953f] text-xs"></i>
                                <span class="text-[10px] text-gray-300 uppercase tracking-widest font-bold">
                                    <?= htmlspecialchars($plate['province'] ?? 'Toàn Quốc') ?>
                                </span>
                                <span class="ml-auto text-[9px] gold-text font-bold italic"><?= $badge ?></span>
                            </div>

                            <div class="text-center py-2">
                                <p class="text-2xl md:text-3xl font-bold gold-text tracking-tight counter-price"
                                    data-target="<?= (int)$plate['starting_price'] ?>">
                                    0
                                </p>
                                <p class="text-[8px] text-gray-600 font-bold uppercase mt-1">Việt Nam Đồng</p>
                            </div>

                            <a href="Detail_Plate_warehouse.php?id=<?= $plate['plates_id'] ?>">
                                <button class="mt-6 w-full py-3 border border-[#bf953f]/40 hover:bg-[#bf953f] text-[#bf953f] hover:text-black transition-all duration-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                                    Liên hệ sở hữu
                                </button>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
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
                <div class="flex flex-wrap items-center gap-4 pb-2 md:pb-0" id="sort-filter-group">
                    <span class="text-[9px] text-gray-600 uppercase font-bold whitespace-nowrap">Sắp xếp:</span>

                    <button class="filter-item active" data-sort="newest">Mới nhất</button>
                    <button class="filter-item" data-sort="price-asc">Giá tăng dần</button>
                    <button class="filter-item" data-sort="price-desc">Giá giảm dần</button>

                    <div class="relative dropdown-container">
                        <button class="filter-item flex items-center gap-1 dropdown-trigger" id="province-trigger">
                            <span>Theo tỉnh thành</span>
                            <i class="ri-arrow-down-s-line icon-arrow transition-transform duration-300"></i>
                        </button>

                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-[#0f0f0f] border border-white/10 rounded-sm py-2 opacity-0 invisible z-[100] shadow-2xl transition-all">
                            <a href="#" class="block px-4 py-2 text-[10px] text-gray-400 hover:bg-[#bf953f] hover:text-black font-bold uppercase transition-colors">Hà Nội</a>
                            <a href="#" class="block px-4 py-2 text-[10px] text-gray-400 hover:bg-[#bf953f] hover:text-black font-bold uppercase transition-colors">TP. Hồ Chí Minh</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- hhh  -->
            <!-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-10" id="main-grid">
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
                            <a href="Detail_Plate_warehouse.php?id=123" class="block w-full py-2 bg-[#bf953f]/10 border border-[#bf953f]/30 text-[#bf953f] text-center text-[9px] font-bold uppercase tracking-widest hover:bg-[#bf953f] hover:text-black transition-all">
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

            </div> -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-10" id="main-grid">
                <?php
                // Kiểm tra nếu biến $plates tồn tại và có dữ liệu
                if (isset($plates) && is_array($plates) && count($plates) > 0):
                    foreach ($plates as $item):
                        // 1. Kiểm tra trạng thái: status = 0 là đã giữ chỗ/bán, status = 1 là đang trống
                        $isBooked = ($item['status'] == 0);

                        // 2. Gọi hàm từ Model để lấy nhãn phong thủy (Ngũ quý, Sảnh tiến...)
                        $badge = $plateModel->getPlateBadge($item['plate_number']);
                ?>
                        <div class="standard-card group <?= $isBooked ? 'opacity-60' : '' ?>" data-aos="fade-up">
                            <div class="relative aspect-[16/9] bg-[#050505] border border-white/5 overflow-hidden flex items-center justify-center group-hover:border-[#bf953f]/50 transition-all duration-500">

                                <?php if (!$isBooked): ?>
                                    <div class="absolute top-2 left-2 z-10">
                                        <span class="badge-gold"><?= htmlspecialchars($badge) ?></span>
                                    </div>
                                    <button class="absolute top-2 right-2 z-10 text-gray-600 hover:text-[#bf953f] transition-colors btn-heart">
                                        <i class="ri-heart-fill text-lg"></i>
                                    </button>
                                <?php else: ?>
                                    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
                                        <span class="text-[10px] font-bold text-red-500/80 border border-red-500/30 px-3 py-1 uppercase tracking-widest bg-black/80">
                                            Đã giữ chỗ
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <div class="plate-mini">
                                    <div class="bg-white px-5 py-2 rounded-sm shadow-lg <?= $isBooked ? 'grayscale' : '' ?>">
                                        <span class="text-black font-bold text-xl tracking-tight font-serif italic">
                                            <?= htmlspecialchars($item['plate_number']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex flex-col items-center text-center">
                                <div class="flex items-center gap-1 opacity-40 mb-1">
                                    <i class="ri-map-pin-2-fill text-[8px] text-[#bf953f]"></i>
                                    <span class="text-[9px] text-white uppercase tracking-widest font-bold">
                                        <?= htmlspecialchars($item['province'] ?? 'Toàn Quốc') ?>
                                    </span>
                                </div>

                                <div class="text-lg font-bold <?= $isBooked ? 'text-gray-700 line-through' : 'text-[#bf953f]' ?> tracking-tighter">
                                    <?= number_format($item['starting_price'], 0, ',', '.') ?>
                                    <span class="text-[8px] text-gray-600 ml-1">VND</span>
                                </div>

                                <?php if (!$isBooked): ?>
                                    <div class="h-0 opacity-0 group-hover:h-6 group-hover:opacity-100 transition-all duration-300 overflow-hidden">
                                        <p class="text-[9px] text-gray-500 italic">Kiệt tác phong thủy - Khẳng định vị thế</p>
                                    </div>

                                    <div class="w-full mt-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                        <a href="Detail_Plate_warehouse.php?id=<?= $item['plates_id'] ?>"
                                            class="block w-full py-2 bg-[#bf953f]/10 border border-[#bf953f]/30 text-[#bf953f] text-center text-[9px] font-bold uppercase tracking-widest hover:bg-[#bf953f] hover:text-black transition-all">
                                            Liên hệ ngay
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php
                    endforeach;
                else:
                    ?>
                    <div class="col-span-full text-center py-20 opacity-40 italic">
                        <div class="mb-4"><i class="ri-inbox-archive-line text-4xl"></i></div>
                        <p class="text-[11px] uppercase tracking-widest">Không tìm thấy biển số nào trong kho hiện tại.</p>
                    </div>
                <?php endif; ?>
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
    <section id="destiny-matcher" class="py-24 bg-[#050505] relative overflow-hidden transition-colors duration-1000">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] pointer-events-none">
            <div class="w-full h-full border border-[#bf953f]/10 rounded-full animate-[spin_20s_linear_infinite]"></div>
            <div class="absolute inset-10 border border-[#bf953f]/5 rounded-full animate-[spin_15s_linear_reverse_infinite]"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-4xl font-light text-white tracking-[0.3em] uppercase mb-4">
                    Tìm Con Số <span class="font-bold gold-text">Khai Thông Tài Vận</span>
                </h2>
                <p class="text-gray-500 text-[10px] md:text-xs uppercase tracking-[0.2em]">
                    AI phân tích bản mệnh & kho biển số thực tế trong 5 giây
                </p>
            </div>

            <div class="max-w-4xl mx-auto bg-black/40 backdrop-blur-xl border border-white/5 p-8 rounded-sm shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">

                    <div class="flex flex-col gap-2">
                        <label class="text-[9px] text-gray-500 uppercase font-bold tracking-widest">Năm sinh của bạn</label>
                        <select id="birth-year" class="bg-transparent border-b border-white/20 text-white py-2 focus:outline-none focus:border-[#bf953f] transition-colors cursor-pointer text-sm">
                            <option value="" class="bg-black">Chọn năm sinh</option>
                            <script>
                                for (let y = 2000; y >= 1960; y--) {
                                    document.write(`<option value="${y}" class="bg-black">${y}</option>`);
                                }
                            </script>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[9px] text-gray-500 uppercase font-bold tracking-widest">Màu xe hiện tại</label>
                        <div class="flex gap-3 py-2">
                            <button class="color-dot w-6 h-6 rounded-full bg-white border-2 border-transparent hover:scale-110 transition-all" data-color="Trắng"></button>
                            <button class="color-dot w-6 h-6 rounded-full bg-black border-2 border-white/20 hover:scale-110 transition-all" data-color="Đen"></button>
                            <button class="color-dot w-6 h-6 rounded-full bg-red-600 border-2 border-transparent hover:scale-110 transition-all" data-color="Đỏ"></button>
                            <button class="color-dot w-6 h-6 rounded-full bg-blue-700 border-2 border-transparent hover:scale-110 transition-all" data-color="Xanh"></button>
                            <button class="color-dot w-6 h-6 rounded-full bg-gray-500 border-2 border-transparent hover:scale-110 transition-all" data-color="Xám"></button>
                        </div>
                    </div>

                    <div class="text-center">
                        <button id="btn-match" class="relative w-20 h-20 md:w-24 md:h-24 rounded-full bg-transparent border border-[#bf953f]/50 group flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 bg-[#bf953f]/10 group-hover:bg-[#bf953f] transition-all duration-500"></div>
                            <span class="relative z-10 text-[9px] font-black text-[#bf953f] group-hover:text-black text-center leading-tight uppercase tracking-tighter">Gợi Ý<br>Biển Số</span>
                            <div class="absolute inset-0 rounded-full shadow-[0_0_30px_rgba(191,149,63,0.3)] animate-pulse"></div>
                        </button>
                    </div>
                </div>
            </div>

            <div id="result-zone" class="mt-16 max-w-2xl mx-auto hidden">
                <div class="text-center mb-8 animate-bounce">
                    <i class="ri-arrow-down-double-line text-[#bf953f] text-2xl"></i>
                </div>

                <div class="bg-gradient-to-b from-[#111] to-black border border-[#bf953f]/30 p-10 rounded-sm relative overflow-hidden">
                    <div id="slot-machine" class="text-5xl md:text-7xl font-bold text-white tracking-tighter mb-8 font-serif italic h-20 flex justify-center items-center">
                        30K-XXXXX
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div class="text-left">
                            <h4 id="destiny-label" class="text-[#bf953f] text-xs font-bold uppercase tracking-widest mb-2">Mệnh Kim - Đại Cát</h4>
                            <ul class="text-[11px] text-gray-400 space-y-2 italic">
                                <li>• Tương sinh tuyệt đối với màu xe hiện tại.</li>
                                <li>• Dãy số giúp hóa giải vận hạn năm 2024.</li>
                                <li>• Kích hoạt cung tài lộc cho chủ nhân.</li>
                            </ul>
                        </div>
                        <div class="flex flex-col gap-3">
                            <button class="w-full py-3 bg-[#bf953f] text-black text-[10px] font-black uppercase tracking-widest hover:brightness-110 transition-all">Liên hệ Chốt ngay</button>
                            <button class="w-full py-3 border border-white/10 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-white/5 flex items-center justify-center gap-2">
                                <i class="ri-whatsapp-line"></i> Lưu vào Zalo tư vấn
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 5 -----------------------------  -->
    <section class="py-24 bg-[#080808] relative overflow-hidden border-t border-white/5">
        <div class="container mx-auto px-6 relative z-10">

            <div class="mb-20">
                <h2 class="text-3xl md:text-4xl font-black text-white tracking-tighter uppercase mb-4">
                    QUY TRÌNH SỞ HỮU <span class="gold-text">ĐỊNH DANH</span>
                </h2>
                <div class="h-1 w-20 bg-[#bf953f]"></div>
                <p class="mt-6 text-gray-500 text-[10px] uppercase tracking-[0.3em]">Minh bạch - Pháp lý - Bảo mật</p>
            </div>

            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-12 mb-24">

                <div class="hidden md:block absolute top-12 left-0 w-full h-[1px] bg-white/10">
                    <div id="flow-line" class="h-full bg-[#bf953f] w-0 transition-all duration-1000"></div>
                </div>

                <div class="step-card group relative">
                    <span class="absolute -top-10 -left-4 text-7xl font-black text-white/[0.03] italic outline-text group-hover:text-[#bf953f]/10 transition-colors">01</span>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full bg-black border border-[#bf953f]/30 flex items-center justify-center mb-6 group-hover:bg-[#bf953f] transition-all duration-500">
                            <i class="ri-search-2-line text-[#bf953f] group-hover:text-black"></i>
                        </div>
                        <h3 class="text-white font-bold mb-3 uppercase tracking-widest text-sm">Chọn số & Đặt cọc</h3>
                        <p class="text-gray-500 text-xs leading-relaxed">Lựa chọn biển số mơ ước từ kho số thực tế và thực hiện giữ chỗ trực tuyến an toàn thông qua hệ thống định danh.</p>
                    </div>
                </div>

                <div class="step-card group relative">
                    <span class="absolute -top-10 -left-4 text-7xl font-black text-white/[0.03] italic outline-text">02</span>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full bg-black border border-[#bf953f]/30 flex items-center justify-center mb-6 group-hover:bg-[#bf953f] transition-all duration-500">
                            <i class="ri-file-shield-2-line text-[#bf953f] group-hover:text-black"></i>
                        </div>
                        <h3 class="text-white font-bold mb-3 uppercase tracking-widest text-sm">Hoàn thiện hồ sơ</h3>
                        <p class="text-gray-500 text-xs leading-relaxed">Chuyên viên pháp lý riêng sẽ liên hệ, thu thập thông tin và trực tiếp xử lý các thủ tục tại cơ quan chức năng.</p>
                    </div>
                </div>

                <div class="step-card group relative">
                    <span class="absolute -top-10 -left-4 text-7xl font-black text-white/[0.03] italic outline-text">03</span>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full bg-black border border-[#bf953f]/30 flex items-center justify-center mb-6 group-hover:bg-[#bf953f] transition-all duration-500">
                            <!-- <i class="ri-moped-line text-[#bf953f] group-hover:text-black"></i> -->
                            <i class="ri-car-line text-[#bf953f] group-hover:text-black"></i>
                        </div>
                        <h3 class="text-white font-bold mb-3 uppercase tracking-widest text-sm">Bàn giao tận nơi</h3>
                        <p class="text-gray-500 text-xs leading-relaxed">Nhận biển số và hoàn tất thủ tục sang tên chính chủ ngay tại nhà hoặc Showroom chuyên nghiệp của chúng tôi.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 border-y border-white/5 py-12">
                <div class="flex flex-col items-center text-center p-4 border-r border-white/5">
                    <i class="ri-shield-check-fill text-[#bf953f] text-2xl mb-3"></i>
                    <span class="text-[10px] text-white font-bold uppercase tracking-tighter">Pháp lý 100%</span>
                </div>
                <div class="flex flex-col items-center text-center p-4 md:border-r border-white/5">
                    <i class="ri-refresh-line text-[#bf953f] text-2xl mb-3"></i>
                    <span class="text-[10px] text-white font-bold uppercase tracking-tighter">Hoàn tiền 100%</span>
                </div>
                <div class="flex flex-col items-center text-center p-4 border-r border-white/5">
                    <i class="ri-timer-flash-line text-[#bf953f] text-2xl mb-3"></i>
                    <span class="text-[10px] text-white font-bold uppercase tracking-tighter">Xử lý 3-5 ngày</span>
                </div>
                <div class="flex flex-col items-center text-center p-4">
                    <i class="ri-customer-service-2-fill text-[#bf953f] text-2xl mb-3"></i>
                    <span class="text-[10px] text-white font-bold uppercase tracking-tighter">Trợ lý VIP 24/7</span>
                </div>
            </div>

            <div class="mt-20 flex flex-col md:flex-row items-center gap-12 bg-[#0a0a0a] p-2 border border-white/5">
                <div class="w-full md:w-1/2 h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1560179707-f14e90ef3623?q=80&w=2073&auto=format&fit=crop" alt="Showroom" class="w-full h-full object-cover opacity-60 grayscale hover:grayscale-0 transition-all duration-700">
                    <div class="absolute inset-0 bg-gradient-to-r from-black via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6">
                        <p class="text-[10px] text-[#bf953f] font-bold uppercase tracking-[0.2em]">Hệ thống Showroom</p>
                        <p class="text-white text-sm font-bold">Lotte Center, Liễu Giai, Hà Nội</p>
                    </div>
                </div>
                <div class="w-full md:w-1/2 p-6 md:pr-12 text-center md:text-left">
                    <h4 class="text-white font-bold text-xl mb-4">Sẵn sàng để sở hữu?</h4>
                    <p class="text-gray-500 text-xs mb-8 leading-relaxed">Đội ngũ trợ lý VIP của chúng tôi đã sẵn sàng hỗ trợ bạn hoàn thiện mọi thủ tục định danh biển số trong thời gian ngắn nhất.</p>
                    <a href="#" class="inline-flex items-center gap-4 bg-[#bf953f] text-black px-10 py-4 text-[10px] font-black uppercase tracking-[0.2em] hover:bg-white transition-all">
                        Liên hệ Trợ lý VIP <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

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
    document.addEventListener('DOMContentLoaded', () => {
        const counters = document.querySelectorAll('.counter-price');

        const animateCounter = (counter) => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText.replace(/\./g, '');
            const speed = target / 100; // Tốc độ chạy

            if (count < target) {
                const newValue = Math.ceil(count + speed);
                counter.innerText = newValue.toLocaleString('vi-VN');
                setTimeout(() => animateCounter(counter), 20);
            } else {
                counter.innerText = target.toLocaleString('vi-VN');
            }
        };

        // Chạy hiệu ứng khi cuộn tới phần này
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        counters.forEach(counter => observer.observe(counter));
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
    document.querySelectorAll('#sort-filter-group .filter-item[data-sort]').forEach(button => {
        button.addEventListener('click', async function() {
            // 1. Hiệu ứng giao diện: Chuyển class Active
            document.querySelectorAll('#sort-filter-group .filter-item').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // 2. Lấy kiểu sắp xếp
            const sortType = this.getAttribute('data-sort');

            // 3. Hiệu ứng chờ đợi (Loading) sang trọng
            const mainGrid = document.getElementById('main-grid');
            mainGrid.style.opacity = '0.5';
            mainGrid.style.pointerEvents = 'none';

            try {
                // 4. Gọi API lấy dữ liệu thật (Ngài cần tạo file api_get_plates.php)
                // Hoặc nếu dùng chung file hiện tại, Ngài gửi param qua URL
                const response = await fetch(`api_get_plates.php?sort=${sortType}`);
                const data = await response.json();

                // 5. Vẽ lại Grid bằng hàm renderPlates của Ngài
                if (data && data.length > 0) {
                    renderPlates(data);
                } else {
                    mainGrid.innerHTML = '<div class="col-span-full text-center py-20 opacity-40 italic text-[10px]">Không tìm thấy kiệt tác phù hợp.</div>';
                }
            } catch (error) {
                console.error("Lỗi lấy dữ liệu:", error);
                showToast("Hệ thống không thể kết nối kho dữ liệu.", "gold");
            } finally {
                mainGrid.style.opacity = '1';
                mainGrid.style.pointerEvents = 'auto';
            }
        });
    });
    async function updateSort(sortType) {
        const response = await fetch(`fetch_plates.php?sort=${sortType}`);
        const plates = await response.json();

        // Gọi hàm render của Ngài nhưng truyền đúng dữ liệu từ Model
        renderPlates(plates);
    }

    //----------------------------- section 3 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {

        // 2. Hàm Render (Cập nhật để khớp với Database của Ngài)
        // function renderPlates(data) {
        //     const mainGrid = document.getElementById('main-grid');
        //     if (!mainGrid) return;

        //     mainGrid.innerHTML = '';

        //     data.forEach(item => {
        //         // Khớp với tên cột trong SQL của Ngài: status, plate_number, starting_price
        //         const isBooked = item.status == 0; // Giả sử 0 là đã giữ chỗ

        //         // Logic Badge Ngài có thể xử lý ở PHP rồi gửi qua JSON hoặc xử lý tại đây
        //         const badge = item.badge || 'Đại Cát';

        //         const cardHtml = `
        //     <div class="standard-card group ${isBooked ? 'opacity-60' : ''}" data-aos="fade-up">
        //         <div class="relative aspect-[16/9] bg-[#050505] border border-white/5 overflow-hidden flex items-center justify-center group-hover:border-[#bf953f]/50 transition-all duration-500">
        //             ${!isBooked ? `<div class="absolute top-2 left-2 z-10"><span class="badge-gold">${badge}</span></div>` : ''}

        //             ${isBooked ? `
        //                 <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        //                     <span class="text-[10px] font-bold text-red-500/80 border border-red-500/30 px-3 py-1 uppercase tracking-widest bg-black/80">Đã giữ chỗ</span>
        //                 </div>
        //             ` : `
        //                 <button class="absolute top-2 right-2 z-10 text-gray-600 hover:text-[#bf953f] transition-colors btn-heart">
        //                     <i class="ri-heart-fill text-lg"></i>
        //                 </button>
        //             `}

        //             <div class="plate-mini">
        //                 <div class="bg-white px-5 py-2 rounded-sm shadow-lg ${isBooked ? 'grayscale' : ''}">
        //                     <span class="text-black font-bold text-xl tracking-tight font-serif">
        //                         ${item.plate_number}  
        //                     </span>
        //                 </div>
        //             </div>
        //         </div>

        //         <div class="mt-4 flex flex-col items-center text-center">
        //             <div class="flex items-center gap-1 opacity-40 mb-1">
        //                 <i class="ri-map-pin-2-fill text-[8px] text-[#bf953f]"></i>
        //                 <span class="text-[9px] text-white uppercase tracking-widest font-bold">${item.province || 'Toàn quốc'}</span>
        //             </div>

        //             <div class="text-lg font-bold ${isBooked ? 'text-gray-700 line-through' : 'text-[#bf953f]'} tracking-tighter">
        //                 ${parseFloat(item.starting_price).toLocaleString('vi-VN')} VND 
        //             </div>

        //             ${!isBooked ? `
        //             <div class="h-0 opacity-0 group-hover:h-6 group-hover:opacity-100 transition-all duration-300 overflow-hidden">
        //                 <p class="text-[9px] text-gray-500 italic">Biển số phong thủy - Đẳng cấp chủ nhân</p>
        //             </div>

        //             <div class="w-full mt-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
        //                 <a href="Detail_Plate_warehouse.php?id=${item.plates_id}" class="block w-full py-2 bg-[#bf953f]/10 border border-[#bf953f]/30 text-[#bf953f] text-center text-[9px] font-bold uppercase tracking-widest hover:bg-[#bf953f] hover:text-black transition-all">
        //                     Liên hệ ngay
        //                 </a>
        //             </div>
        //             ` : ''}
        //         </div>
        //     </div>`;
        //         mainGrid.insertAdjacentHTML('beforeend', cardHtml);
        //     });

        //     if (typeof attachHeartEvents === 'function') attachHeartEvents();
        // }
        function renderPlates(data) {
            const mainGrid = document.getElementById('main-grid');
            if (!mainGrid) return;

            // 1. Xóa nội dung cũ trước khi render mới
            mainGrid.innerHTML = '';

            // 2. Kiểm tra nếu không có dữ liệu để tránh lỗi vòng lặp
            if (!data || data.length === 0) {
                mainGrid.innerHTML = `
            <div class="col-span-full text-center py-20 opacity-40 italic">
                <p class="text-[11px] uppercase tracking-widest">Không tìm thấy biển số nào phù hợp.</p>
            </div>`;
                return;
            }

            data.forEach(item => {
                // 3. Ép kiểu dữ liệu để tránh NaN (Vô cùng quan trọng)
                const priceValue = parseFloat(item.starting_price) || 0;
                const plateNumber = item.plate_number || 'Chưa cập nhật';
                const isBooked = parseInt(item.status) === 0; // Đảm bảo so sánh kiểu số
                const badge = item.badge || 'Đại Cát';
                const plateId = item.plates_id;

                const cardHtml = `
        <div class="standard-card group ${isBooked ? 'opacity-60' : ''}" data-aos="fade-up">
            <div class="relative aspect-[16/9] bg-[#050505] border border-white/5 overflow-hidden flex items-center justify-center group-hover:border-[#bf953f]/50 transition-all duration-500">
                ${!isBooked ? `
                    <div class="absolute top-2 left-2 z-10"><span class="badge-gold">${badge}</span></div>
                    <button class="absolute top-2 right-2 z-10 text-gray-600 hover:text-[#bf953f] transition-colors btn-heart">
                        <i class="ri-heart-fill text-lg"></i>
                    </button>
                ` : `
                    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
                        <span class="text-[10px] font-bold text-red-500/80 border border-red-500/30 px-3 py-1 uppercase tracking-widest bg-black/80">Đã giữ chỗ</span>
                    </div>
                `}

                <div class="plate-mini">
                    <div class="bg-white px-5 py-2 rounded-sm shadow-lg ${isBooked ? 'grayscale' : ''}">
                        <span class="text-black font-bold text-xl tracking-tight font-serif italic">
                            ${plateNumber}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-4 flex flex-col items-center text-center">
                <div class="flex items-center gap-1 opacity-40 mb-1">
                    <i class="ri-map-pin-2-fill text-[8px] text-[#bf953f]"></i>
                    <span class="text-[9px] text-white uppercase tracking-widest font-bold">${item.province || 'Toàn quốc'}</span>
                </div>
                
                <div class="text-lg font-bold ${isBooked ? 'text-gray-700 line-through' : 'text-[#bf953f]'} tracking-tighter">
                    ${priceValue.toLocaleString('vi-VN')} <span class="text-[8px] text-gray-600 ml-1">VND</span>
                </div>

                ${!isBooked ? `
                <div class="h-0 opacity-0 group-hover:h-6 group-hover:opacity-100 transition-all duration-300 overflow-hidden">
                    <p class="text-[9px] text-gray-500 italic">Biển số phong thủy - Đẳng cấp chủ nhân</p>
                </div>

                <div class="w-full mt-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                    <a href="Detail_Plate_warehouse.php?id=${plateId}" class="block w-full py-2 bg-[#bf953f]/10 border border-[#bf953f]/30 text-[#bf953f] text-center text-[9px] font-bold uppercase tracking-widest hover:bg-[#bf953f] hover:text-black transition-all">
                        Liên hệ ngay
                    </a>
                </div>
                ` : ''}
            </div>
        </div>`;
                mainGrid.insertAdjacentHTML('beforeend', cardHtml);
            });

            // 4. Khởi tạo lại các hiệu ứng sau khi vẽ lại HTML
            if (typeof attachHeartEvents === 'function') attachHeartEvents();
            if (typeof AOS !== 'undefined') {
                AOS.refreshHard(); // Làm mới hiệu ứng bay lên
            }
        }
        const sortButtons = document.querySelectorAll('#sort-filter-group .filter-item');
        // 3. Xử lý sự kiện Sắp xếp
        // sortButtons.forEach(button => {
        //     button.addEventListener('click', function() {
        //         const sortType = this.getAttribute('data-sort');
        //         if (!sortType) return; // Bỏ qua nếu là nút Tỉnh thành

        //         // Giao diện: Đổi active
        //         sortButtons.forEach(btn => btn.classList.remove('active'));
        //         this.classList.add('active');

        //         // Hiệu ứng mờ Grid
        //         gsap.to(mainGrid, {
        //             opacity: 0,
        //             y: 10,
        //             duration: 0.2,
        //             onComplete: () => {

        //                 // Logic sắp xếp thực tế
        //                 let sortedData = [...plateData];
        //                 if (sortType === 'price-asc') {
        //                     sortedData.sort((a, b) => a.price - b.price);
        //                 } else if (sortType === 'price-desc') {
        //                     sortedData.sort((a, b) => b.price - a.price);
        //                 } else if (sortType === 'newest') {
        //                     sortedData.sort((a, b) => b.id - a.id);
        //                 }

        //                 // Render lại dữ liệu đã sắp xếp
        //                 renderPlates(sortedData);

        //                 // Hiện Grid lại
        //                 gsap.to(mainGrid, {
        //                     opacity: 1,
        //                     y: 0,
        //                     duration: 0.4
        //                 });
        //             }
        //         });
        //     });
        // });
        sortButtons.forEach(button => {
            button.addEventListener('click', async function() {
                // 1. Hiệu ứng giao diện: Xóa active cũ, thêm active vào nút vừa nhấn
                sortButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // 2. Lấy kiểu sắp xếp từ attribute data-sort
                const sortType = this.getAttribute('data-sort');
                // Lấy tỉnh thành hiện tại từ biến global hoặc URL
                const urlParams = new URLSearchParams(window.location.search);
                const currentProvince = urlParams.get('province') || '';

                // 3. Hiệu ứng loading mờ grid trước khi load dữ liệu mới
                const mainGrid = document.getElementById('main-grid');
                mainGrid.style.opacity = '0.5';

                try {
                    // 4. ĐÂY LÀ ĐOẠN NGÀI CẦN CHÈN:
                    const response = await fetch(`api_get_plates.php?sort=${sortType}&province=${currentProvince}`);
                    const data = await response.json();

                    // 5. Gọi hàm render để vẽ lại các tấm biển số mới
                    renderPlates(data);

                } catch (error) {
                    console.error("Lỗi khi tải dữ liệu biển số:", error);
                } finally {
                    // Hiển thị lại grid
                    mainGrid.style.opacity = '1';
                }
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
        // renderPlates(plateData);
    });
    document.querySelectorAll('.dropdown-container').forEach(dropdown => {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const menu = dropdown.querySelector('.dropdown-menu');
        const arrow = dropdown.querySelector('.icon-arrow');

        dropdown.addEventListener('mouseenter', () => {
            gsap.to(menu, {
                autoAlpha: 1,
                y: 5,
                duration: 0.4,
                ease: "power2.out"
            });
            gsap.to(arrow, {
                rotate: 180,
                duration: 0.3
            });
        });

        dropdown.addEventListener('mouseleave', () => {
            gsap.to(menu, {
                autoAlpha: 0,
                y: 0,
                duration: 0.3,
                ease: "power2.in"
            });
            gsap.to(arrow, {
                rotate: 0,
                duration: 0.3
            });
        });
    });
    const trigger = document.getElementById('province-trigger');
    const menu = trigger.nextElementSibling;

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = !menu.classList.contains('invisible');

        if (!isOpen) {
            menu.classList.remove('invisible', 'opacity-0');
            menu.classList.add('visible', 'opacity-100');
            gsap.from(menu, {
                y: -10,
                duration: 0.3
            });
        } else {
            menu.classList.add('invisible', 'opacity-0');
        }
    });

    // Đóng khi bấm ra ngoài
    document.addEventListener('click', () => {
        menu.classList.add('invisible', 'opacity-0');
    });
    let currentPage = 2; // Vì trang 1 đã hiện bằng PHP rồi
    const limitPerLoad = 4; // Mỗi lần bấm hiện thêm 4

    document.getElementById('load-more').addEventListener('click', async function() {
        const btn = this;
        const btnText = btn.querySelector('span');

        // Hiệu ứng Loading đơn giản
        btn.style.pointerEvents = 'none';
        btnText.innerText = 'ĐANG TẢI...';

        try {
            // Gọi API lấy dữ liệu trang tiếp theo
            // Lưu ý: Ngài cần truyền thêm tham số sort và province nếu có
            const response = await fetch(`api_get_plates.php?page=${currentPage}&limit=${limitPerLoad}`);
            const data = await response.json();

            if (data && data.length > 0) {
                // Chỉ lấy những sản phẩm status = 1 (Đang trống)
                const availablePlates = data.filter(item => item.status == 1);

                if (availablePlates.length > 0) {
                    appendPlates(availablePlates); // Hàm thêm mới vào grid
                    currentPage++;
                } else {
                    // Nếu trang này toàn status=0, tự động gọi tiếp trang sau
                    btn.click();
                }
            } else {
                // Không còn dữ liệu nữa
                btnText.innerText = 'ĐÃ HẾT SẢN PHẨM';
                btn.style.opacity = '0.5';
            }
        } catch (error) {
            console.error('Lỗi load more:', error);
        } finally {
            if (btnText.innerText !== 'ĐÃ HẾT SẢN PHẨM') {
                btnText.innerText = 'KHÁM PHÁ THÊM';
                btn.style.pointerEvents = 'auto';
            }
        }
    });

    // Hàm này tương tự renderPlates nhưng dùng insertAdjacentHTML để cộng dồn
    function appendPlates(data) {
        const mainGrid = document.getElementById('main-grid');

        data.forEach(item => {
            const badge = item.badge || 'Đại Cát';
            const price = parseFloat(item.starting_price).toLocaleString('vi-VN');

            const cardHtml = `
            <div class="standard-card group" data-aos="fade-up">
                <div class="relative aspect-[16/9] bg-[#050505] border border-white/5 overflow-hidden flex items-center justify-center group-hover:border-[#bf953f]/50 transition-all duration-500">
                    <div class="absolute top-2 left-2 z-10">
                        <span class="badge-gold">${badge}</span>
                    </div>
                    <button class="absolute top-2 right-2 z-10 text-gray-600 hover:text-[#bf953f] transition-colors btn-heart">
                        <i class="ri-heart-fill text-lg"></i>
                    </button>
                    <div class="plate-mini">
                        <div class="bg-white px-5 py-2 rounded-sm shadow-lg">
                            <span class="text-black font-bold text-xl tracking-tight font-serif italic">
                                ${item.plate_number}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex flex-col items-center text-center">
                    <div class="flex items-center gap-1 opacity-40 mb-1">
                        <i class="ri-map-pin-2-fill text-[8px] text-[#bf953f]"></i>
                        <span class="text-[9px] text-white uppercase tracking-widest font-bold">
                            ${item.province || 'Toàn Quốc'}
                        </span>
                    </div>
                    <div class="text-lg font-bold text-[#bf953f] tracking-tighter">
                        ${price} <span class="text-[8px] text-gray-600 ml-1">VND</span>
                    </div>
                    <div class="h-0 opacity-0 group-hover:h-6 group-hover:opacity-100 transition-all duration-300 overflow-hidden">
                        <p class="text-[9px] text-gray-500 italic">Kiệt tác phong thủy - Khẳng định vị thế</p>
                    </div>
                    <div class="w-full mt-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                        <a href="Detail_Plate_warehouse.php?id=${item.plates_id}"
                            class="block w-full py-2 bg-[#bf953f]/10 border border-[#bf953f]/30 text-[#bf953f] text-center text-[9px] font-bold uppercase tracking-widest hover:bg-[#bf953f] hover:text-black transition-all">
                            Liên hệ ngay
                        </a>
                    </div>
                </div>
            </div>`;
            mainGrid.insertAdjacentHTML('beforeend', cardHtml);
        });

        // Khởi tạo lại AOS để hiệu ứng bay lên hoạt động cho các item mới
        if (typeof AOS !== 'undefined') AOS.refresh();
    }

    //----------------------------- section 4 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        const btnMatch = document.getElementById('btn-match');
        const resultZone = document.getElementById('result-zone');
        const slotMachine = document.getElementById('slot-machine');
        const colorDots = document.querySelectorAll('.color-dot');

        // Xử lý chọn màu xe
        colorDots.forEach(dot => {
            dot.addEventListener('click', () => {
                colorDots.forEach(d => d.classList.remove('active'));
                dot.classList.add('active');
            });
        });

        // Logic AI Gợi ý giả lập
        btnMatch.addEventListener('click', () => {
            const year = document.getElementById('birth-year').value;
            if (!year) return alert("Vui lòng chọn năm sinh");

            // 1. Hiệu ứng cuộn xuống
            resultZone.classList.remove('hidden');
            resultZone.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // 2. Hiệu ứng Slot Machine
            let count = 0;
            const fakePlates = ["51L-999.99", "30K-888.88", "15A-678.89", "43C-555.55", "30K-123.45"];
            const interval = setInterval(() => {
                slotMachine.innerText = fakePlates[Math.floor(Math.random() * fakePlates.length)];
                slotMachine.style.opacity = Math.random();
                count++;
                if (count > 15) {
                    clearInterval(interval);
                    slotMachine.innerText = "30K-999.99"; // Kết quả cuối lấy từ kho thực tế
                    slotMachine.style.opacity = 1;
                    slotMachine.classList.add('gold-text');

                    // 3. Đổi màu theo mệnh (Giả lập logic mệnh)
                    const section = document.getElementById('destiny-matcher');
                    if (year % 5 === 0) {
                        section.style.boxShadow = "inset 0 0 100px rgba(46, 204, 113, 0.1)"; // Mệnh Mộc
                        document.getElementById('destiny-label').innerText = "Mệnh Mộc - Quý Nhân Phù Trợ";
                        document.getElementById('destiny-label').style.color = "#2ecc71";
                    }
                }
            }, 100);
        });
    });

    //----------------------------- section 5 ----------------------------- //
    // Logic "Dòng chảy pháp lý" chạy theo cuộn chuột
    window.addEventListener('scroll', () => {
        const flowLine = document.getElementById('flow-line');
        const section = flowLine.closest('section');
        const rect = section.getBoundingClientRect();

        // Tính toán % tiến độ cuộn qua section
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            const scrollPercent = (window.innerHeight - rect.top) / (window.innerHeight + rect.height);
            const width = Math.min(100, Math.max(0, scrollPercent * 150)); // Hệ số 150 để nhanh hơn chút
            flowLine.style.width = width + '%';
        }
    });

    //----------------------------- section 6 ----------------------------- //
</script>

</html>