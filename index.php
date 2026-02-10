<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin-top: 70px;
        }


        /* ----------------------------- SECTION 1: THE FIRST IMPRESSION ----------------------------- */
        .hero-showroom {
            position: relative;
            width: 100%;
            height: 100vh;
            background: #000;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Video Nền & Poster */
        .video-background {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .video-background video,
        .video-background .poster-fallback {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.6);
            /* Làm tối video để nổi bật chữ */
            transition: transform 0.1s ease-out;
            /* Phục vụ Mouse Parallax */
        }

        /* Lớp phủ Obsidian */
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, #000 0%, transparent 60%, rgba(0, 0, 0, 0.4) 100%);
            z-index: 1;
        }

        /* Canvas cho hiệu ứng Bụi Vàng (Gold Dust) */
        #gold-dust-canvas {
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
        }

        /* Khối nội dung trung tâm */
        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 0 20px;
            max-width: 900px;
        }

        .hero-headline {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            margin-bottom: 20px;
            color: #bf953f;
            /* Hiệu ứng mạ vàng Gradient */
            background: linear-gradient(to right, #bf953f 20%, #fcf6ba 40%, #b38728 60%, #fcf6ba 80%, #bf953f 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine-gold 5s linear infinite;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        @keyframes shine-gold {
            to {
                background-position: 200% center;
            }
        }

        .hero-sub {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: #d1d1d1;
            letter-spacing: 0.1em;
            font-weight: 300;
            margin-bottom: 50px;
            opacity: 0;
            transform: translateY(30px);
        }

        /* Button Group & Shimmer Effect */
        .hero-btns {
            display: flex;
            gap: 25px;
            justify-content: center;
        }

        .btn-hero {
            position: relative;
            padding: 18px 45px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            border-radius: 0;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.2, 1, 0.3, 1);
        }

        .btn-primary {
            background: #bf953f;
            color: #000;
            border: none;
        }

        .btn-secondary {
            background: transparent;
            color: #fff;
            border: 1px solid rgba(191, 149, 63, 0.6);
        }

        /* Hiệu ứng tia Laser (Shimmer) chạy qua nút */
        .btn-hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-25deg);
            animation: shimmer 6s infinite;
        }

        @keyframes shimmer {

            20%,
            100% {
                left: 150%;
            }
        }

        .btn-hero:hover {
            box-shadow: 0 0 30px rgba(191, 149, 63, 0.4);
            transform: translateY(-5px);
        }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .hero-btns {
                flex-direction: column;
                gap: 15px;
            }

            .hero-headline {
                letter-spacing: 0.1em;
            }

            .video-background video {
                display: none;
            }

            /* Thay video bằng poster trên mobile */
            .poster-fallback {
                display: block;
            }
        }

        /* ----------------------------- SECTION 2: THE TREASURE VAULT ----------------------------- */
        .treasure-vault {
            background: #080808;
            padding: 120px 0;
            position: relative;
        }

        /* Smart Filter Tối Giản */
        .vault-filters {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 80px;
        }

        .filter-btn {
            color: #666;
            font-size: 11px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.4s;
            border-bottom: 1px solid transparent;
            padding-bottom: 8px;
        }

        .filter-btn:hover,
        .filter-btn.active {
            color: #bf953f;
            border-color: #bf953f;
        }

        /* Grid Layout */
        .vault-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
            padding: 0 40px;
        }

        /* Khối đá Cẩm Thạch (Marble Block) */
        .marble-pedestal {
            background: linear-gradient(145deg, #111 0%, #050505 100%);
            border: 1px solid rgba(191, 149, 63, 0.1);
            padding: 30px;
            position: relative;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            overflow: hidden;
        }

        /* Vân vàng trên đá cẩm thạch */
        .marble-pedestal::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('https://www.transparenttextures.com/patterns/black-linen.png');
            /* Texture giả đá */
            opacity: 0.2;
        }

        .marble-pedestal:hover {
            transform: translateY(-15px);
            border-color: rgba(191, 149, 63, 0.5);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8);
        }

        /* Biển số trắng tinh khiết */
        .plate-display {
            background: #fdfdfd;
            border-radius: 6px;
            padding: 20px;
            box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            position: relative;
            cursor: none;
            /* Ẩn chuột để hiện kính lúp */
        }

        .plate-number {
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            font-size: 42px;
            color: #111;
            text-align: center;
            letter-spacing: -1px;
        }

        /* Khung kính lúp */
        .magnifier {
            position: absolute;
            width: 120px;
            height: 120px;
            border: 2px solid #bf953f;
            /* Viền vàng Gold */
            border-radius: 50%;
            overflow: hidden;
            /* Quan trọng để cắt nội dung phóng đại */
            pointer-events: none;
            background: #fff;
            z-index: 50;
            box-shadow: 0 0 25px rgba(191, 149, 63, 0.5), inset 0 0 15px rgba(0, 0, 0, 0.2);
            display: none;
        }

        /* Nội dung phóng đại bên trong */
        .mag-content {
            position: absolute;
            width: 400px;
            /* Độ rộng lớn để chứa text khi zoom */
            text-align: center;
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            font-size: 42px;
            /* Font gốc */
            color: #111;
            white-space: nowrap;
            transform-origin: center;
            will-change: transform;
        }

        /* Price Pulsing */
        .plate-price {
            font-family: 'Playfair Display', serif;
            color: #bf953f;
            font-size: 24px;
            font-weight: 700;
            animation: pricePulse 2s infinite;
        }

        @keyframes pricePulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Info Text */
        .plate-meta {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        .btn-lock {
            background: transparent;
            border: 1px solid #bf953f;
            color: #bf953f;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .btn-lock:hover {
            background: #bf953f;
            color: #000;
        }

        /* Responsive cho Filter */
        @media (max-width: 768px) {
            .vault-filters {
                justify-content: flex-start;
                /* Căn trái để bắt đầu cuộn */
                overflow-x: auto;
                /* Cho phép cuộn ngang */
                overflow-y: hidden;
                white-space: nowrap;
                /* Không cho nhảy dòng */
                padding: 0 20px 15px 20px;
                gap: 20px;
                -webkit-overflow-scrolling: touch;
                /* Cuộn mượt trên iOS */
                scrollbar-width: none;
                /* Ẩn scrollbar trên Firefox */
            }

            .vault-filters::-webkit-scrollbar {
                display: none;
                /* Ẩn scrollbar trên Chrome/Safari */
            }

            .filter-btn {
                flex: 0 0 auto;
                /* Giữ kích thước nút cố định khi cuộn */
                font-size: 10px;
                /* Nhỏ lại một chút trên mobile */
            }

            /* Hiệu ứng mờ ở hai đầu để báo hiệu còn nội dung cuộn (tùy chọn) */
            .treasure-vault::before {
                content: '';
                position: absolute;
                top: 120px;
                right: 0;
                width: 50px;
                height: 40px;
                background: linear-gradient(to right, transparent, #080808);
                z-index: 5;
                pointer-events: none;
            }
        }

        /* ----------------------------- SECTION 3: THE LUXURY FLEET ----------------------------- */
        .destiny-engine {
            background: #000;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            color: #fff;
            font-family: 'Playfair Display', serif;
        }

        /* Họa tiết Ngũ Hành chìm */
        .bg-pentagram {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at center, rgba(191, 149, 63, 0.05) 0%, transparent 70%);
            opacity: 0.3;
            pointer-events: none;
        }

        /* Vòng xoay Ngũ Hành */
        .wheel-container {
            position: relative;
            width: 450px;
            height: 450px;
            margin: 0 auto;
            transition: transform 2s cubic-bezier(0.15, 0, 0.15, 1);
        }

        .element-wheel {
            width: 100%;
            height: 100%;
            border: 1px solid rgba(191, 149, 63, 0.3);
            border-radius: 50%;
            position: relative;
        }

        .element-sector {
            position: absolute;
            width: 50%;
            height: 50%;
            transform-origin: bottom right;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s;
        }

        .element-sector:hover {
            background: rgba(191, 149, 63, 0.1);
        }

        .element-icon {
            transform: rotate(45deg);
            /* Bù góc để icon thẳng */
            font-size: 10px;
            letter-spacing: 0.2em;
            color: #666;
        }

        /* Ô nhập liệu trung tâm */
        .oracle-input-wrap {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            text-align: center;
        }

        .oracle-input {
            background: transparent;
            border: none;
            border-bottom: 2px solid #bf953f;
            color: #fff;
            font-size: 32px;
            width: 180px;
            text-align: center;
            outline: none;
            font-family: 'Inter', sans-serif;
            letter-spacing: 5px;
        }

        /* Biểu đồ năng lượng (Insight) */
        .energy-stats {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(191, 149, 63, 0.1);
            padding: 30px;
            backdrop-filter: blur(10px);
        }

        .stat-bar-bg {
            width: 100%;
            height: 2px;
            background: #222;
            margin-top: 10px;
            position: relative;
        }

        .stat-bar-gold {
            height: 100%;
            background: #bf953f;
            box-shadow: 0 0 10px #bf953f;
            width: 0%;
            transition: width 1.5s ease-out;
        }

        /* Tooltip mạ vàng */
        .number-tooltip {
            position: absolute;
            background: #bf953f;
            color: #000;
            padding: 5px 10px;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            pointer-events: none;
            opacity: 0;
            transition: 0.3s;
        }


        /* ----------------------------- SECTION 4: THE GOLDEN HAMMER ----------------------------- */
        .golden-hammer {
            background: #0a0a0a;
            background-image: linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 50px 50px;
            /* Lưới sàn giao dịch */
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        /* Hiệu ứng nhịp đập khi còn dưới 60s */
        .critical-timer {
            animation: pulse-red 1s infinite alternate;
        }

        @keyframes pulse-red {
            from {
                box-shadow: inset 0 0 20px rgba(185, 28, 28, 0.2);
                border-color: #bf953f;
            }

            to {
                box-shadow: inset 0 0 50px rgba(185, 28, 28, 0.5);
                border-color: #ef4444;
            }
        }

        /* Card đấu giá */
        .auction-card {
            background: linear-gradient(145deg, #111, #050505);
            border: 1px solid rgba(191, 149, 63, 0.2);
            position: relative;
            transition: 0.3s;
        }

        .live-badge {
            background: #ef4444;
            color: white;
            padding: 2px 8px;
            font-size: 9px;
            border-radius: 2px;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0.5;
            }
        }

        /* Giá hiện tại LED Gold */
        .current-price {
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            color: #bf953f;
            text-shadow: 0 0 15px rgba(191, 149, 63, 0.4);
            font-variant-numeric: tabular-nums;
        }

        /* Bidding History */
        .bid-history-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 10px 0;
            font-size: 11px;
            animation: slideInRight 0.5s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ----------------------------- SECTION 5: THE EDITORIAL WORLD ----------------------------- */
        /* ----------------------------- SECTION 5: TỐI ƯU GRID ----------------------------- */
        .obsidian-editorial .editorial-grid {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            /* Chia 10 cột để dễ căn tỷ lệ 6/4 */
            gap: 0;
            align-items: start;
        }

        /* Bài viết chính bên trái */
        .featured-article {
            grid-column: 1 / span 6;
            /* Chiếm 6 cột bên trái */
            padding-right: 50px;
        }

        /* Cột bên phải chứa 2 bài phụ */
        .side-articles {
            grid-column: 7 / span 4;
            /* Chiếm 4 cột bên phải */
            display: flex;
            flex-direction: column;
            gap: 100px;
            /* Khoảng cách giữa 2 bài phụ */
            padding-top: 150px;
            /* Đẩy bài phụ xuống để tạo sự so le */
        }

        /* Fix lỗi ảnh và chữ không dí nhau */
        .editorial-card {
            display: flex;
            flex-direction: column;
        }

        .editorial-img-box {
            width: 100%;
            line-height: 0;
            /* Khử khoảng cách mặc định dưới ảnh */
        }

        .parallax-text {
            margin-top: 15px;
            /* Giảm từ 30px xuống 15px hoặc 10px để chữ sát ảnh hơn */
            z-index: 5;
            transition: transform 0.2s ease-out;
            /* Tăng nhẹ thời gian để mượt hơn */
            pointer-events: none;
        }

        .read-link {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            font-size: 10px;
            letter-spacing: 0.3em;
            color: #bf953f;
            margin-top: 15px;
            line-height: 1;
        }

        .obsidian-texture {
            position: absolute;
            inset: 0;
            /* Tăng độ sáng từ 0.03 lên 0.08 để thấy rõ hiệu ứng "vân đá" khi di chuột */
            background: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%),
                    rgba(255, 255, 255, 0.08) 0%,
                    transparent 60%);
            pointer-events: none;
            z-index: 1;
        }

        /* Responsive cho Mobile */
        @media (max-width: 1024px) {
            .obsidian-editorial .editorial-grid {
                display: flex;
                flex-direction: column;
                gap: 60px;
            }

            .featured-article,
            .side-articles {
                padding: 0;
            }

            .side-articles {
                padding-top: 0;
            }
        }

        /* ----------------------------- section 6 -----------------------------  */
        /* ----------------------------- SECTION 6: VIP CONCIERGE ----------------------------- */
        .concierge-system {
            background-color: #000;
            padding: 120px 0;
            position: relative;
            overflow: hidden;
            color: #e5e5e5;
            /* Pearl White */
        }

        .map-container {
            position: relative;
            width: 100%;
            height: 600px;
            background: #050505;
            /* Đen Obsidian sâu */
            border: 1px solid rgba(255, 255, 255, 0.05);
            overflow: hidden;
            /* Tạo hiệu ứng vân đá mờ bằng background-image */
            background-image:
                radial-gradient(circle at 50% 50%, rgba(20, 20, 20, 1) 0%, #000 100%),
                url('https://www.transparenttextures.com/patterns/dark-matter.png');
        }

        /* Hiệu ứng quét Radar chạy dọc bản đồ */
        .map-container::before {
            content: '';
            position: absolute;
            top: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom,
                    transparent,
                    rgba(255, 255, 255, 0.03),
                    transparent);
            animation: radar-sweep 4s infinite linear;
            pointer-events: none;
        }

        @keyframes radar-sweep {
            0% {
                top: -100%;
            }

            100% {
                top: 100%;
            }
        }

        .silver-map {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.1));
        }

        /* Điểm sáng nhấp nháy (Pulse) */
        .showroom-point {
            position: absolute;
            width: 8px;
            height: 8px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 15px #fff;
        }

        .pulse-ring {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse-wave 3s infinite;
        }

        @keyframes pulse-wave {
            0% {
                transform: translate(-50%, -50%) scale(0.5);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -50%) scale(3);
                opacity: 0;
            }
        }

        /* Glassmorphism Info Card */
        .concierge-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 2px;
            position: relative;
            z-index: 10;
        }

        /* Coordinates High-tech */
        .coordinates {
            font-family: 'Inter', sans-serif;
            font-size: 9px;
            color: #444;
            letter-spacing: 2px;
        }

        /* Status Online (Ngọc lục bảo) */
        .status-online {
            width: 6px;
            height: 6px;
            background: #50c878;
            /* Emerald Green */
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 8px #50c878;
        }
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section class="hero-showroom" id="hero-parallax">
        <<div class="video-background">
            <video autoplay muted loop playsinline id="hero-video"
                poster="./assets/image/BeautyPlus.png">
                <source src="https://player.vimeo.com/video/259210051?autoplay=1&loop=1&background=1&muted=1" type="video/mp4">
            </video>

            <div class="poster-fallback hidden"
                style="background: url('https://images.pexels.com/photos/3764984/pexels-photo-3764984.jpeg?auto=compress&cs=tinysrgb&w=1260') center/cover;">
            </div>
            </div>

            <div class="hero-overlay"></div>

            <canvas id="gold-dust-canvas"></canvas>

            <div class="hero-content">
                <h1 class="hero-headline" id="reveal-text">ĐỊNH DANH ĐẲNG CẤP</h1>
                <p class="hero-sub" id="reveal-sub">
                    Sở hữu tấm biển số độc bản và những siêu phẩm xe sang dẫn đầu xu thế.
                </p>

                <div class="hero-btns">
                    <button class="btn-hero btn-primary">KHÁM PHÁ KHO BIỂN</button>
                    <button class="btn-hero btn-secondary">BỘ SƯU TẬP XE</button>
                </div>
            </div>

            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 text-center">
                <div class="text-[9px] text-[#bf953f] tracking-[0.4em] uppercase opacity-60 mb-2">Scroll to explore</div>
                <div class="w-[1px] h-12 bg-gradient-to-b from-[#bf953f] to-transparent mx-auto"></div>
            </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section class="treasure-vault">
        <div class="max-w-7xl mx-auto">
            <div class="vault-filters">
                <div class="filter-btn active" data-target="all">Tất cả</div>
                <div class="filter-btn" data-target="ngu-quy">Ngũ Quý</div>
                <div class="filter-btn" data-target="sanh-tien">Sảnh Tiến</div>
                <div class="filter-btn" data-target="phat-loc">Phát Lộc</div>
            </div>

            <div class="vault-grid">
                <div class="marble-pedestal" data-category="ngu-quy">
                    <div class="plate-display"
                        onmousemove="magnify(event)"
                        onmouseenter="showMag(event)"
                        onmouseleave="hideMag(event)">
                        <div class="plate-number">30K - 888.88</div>
                        <div class="magnifier"></div>
                        <div class="absolute top-2 right-2 text-[#bf953f] opacity-30 text-xs">
                            <i class="ri-live-line"></i> LIVE
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <div class="plate-price">3.500.000.000 đ</div>
                            <div class="text-[#e5c07b] text-[11px] italic mt-1">"Đại cát, sinh lộc vĩnh cửu"</div>
                            <div class="plate-meta">
                                <span>Hà Nội</span>
                                <span class="text-green-500"><i class="ri-checkbox-circle-fill"></i> Đã kiểm định</span>
                            </div>
                        </div>
                        <button class="btn-lock" title="Giữ biển ngay">
                            <i class="ri-lock-fill"></i>
                        </button>
                    </div>
                </div>

                <div class="marble-pedestal" data-category="sanh-tien">
                    <div class="plate-display"
                        onmousemove="magnify(event)"
                        onmouseenter="showMag(event)"
                        onmouseleave="hideMag(event)">
                        <div class="plate-number">30L - 123.45</div>
                        <div class="magnifier"></div>
                        <div class="absolute top-2 right-2 text-[#bf953f] opacity-30 text-xs">
                            <i class="ri-live-line"></i> LIVE
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <div class="plate-price">3.500.000.000 đ</div>
                            <div class="text-[#e5c07b] text-[11px] italic mt-1">"Đại cát, sinh lộc vĩnh cửu"</div>
                            <div class="plate-meta">
                                <span>Hà Nội</span>
                                <span class="text-green-500"><i class="ri-checkbox-circle-fill"></i> Đã kiểm định</span>
                            </div>
                        </div>
                        <button class="btn-lock" title="Giữ biển ngay">
                            <i class="ri-lock-fill"></i>
                        </button>
                    </div>
                </div>

                <div class="marble-pedestal" data-category="phat-loc">
                    <div class="plate-display"
                        onmousemove="magnify(event)"
                        onmouseenter="showMag(event)"
                        onmouseleave="hideMag(event)">
                        <div class="plate-number">51K - 686.86</div>
                        <div class="magnifier"></div>
                        <div class="absolute top-2 right-2 text-[#bf953f] opacity-30 text-xs">
                            <i class="ri-live-line"></i> LIVE
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <div class="plate-price">3.500.000.000 đ</div>
                            <div class="text-[#e5c07b] text-[11px] italic mt-1">"Đại cát, sinh lộc vĩnh cửu"</div>
                            <div class="plate-meta">
                                <span>Hà Nội</span>
                                <span class="text-green-500"><i class="ri-checkbox-circle-fill"></i> Đã kiểm định</span>
                            </div>
                        </div>
                        <button class="btn-lock" title="Giữ biển ngay">
                            <i class="ri-lock-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section class="destiny-engine">
        <div class="bg-pentagram"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">

                <div class="w-full lg:w-1/2 relative">
                    <div class="wheel-container" id="main-wheel">
                        <div class="element-wheel">
                            <div class="element-sector" style="transform: rotate(0deg) skew(18deg);" onclick="selectElement('metal', '#E0E0E0')">
                                <span class="element-icon">KIM</span>
                            </div>
                            <div class="element-sector" style="transform: rotate(72deg) skew(18deg);" onclick="selectElement('wood', '#4CAF50')">
                                <span class="element-icon">MỘC</span>
                            </div>
                            <div class="element-sector" style="transform: rotate(144deg) skew(18deg);" onclick="selectElement('water', '#2196F3')">
                                <span class="element-icon">THỦY</span>
                            </div>
                            <div class="element-sector" style="transform: rotate(216deg) skew(18deg);" onclick="selectElement('fire', '#FF5252')">
                                <span class="element-icon">HỎA</span>
                            </div>
                            <div class="element-sector" style="transform: rotate(288deg) skew(18deg);" onclick="selectElement('earth', '#FFC107')">
                                <span class="element-icon">THỔ</span>
                            </div>
                        </div>

                        <div class="oracle-input-wrap">
                            <div class="text-[9px] tracking-[0.4em] mb-2 text-gray-500 uppercase">Input Numbers</div>
                            <input type="text" maxlength="6" placeholder="888.88" class="oracle-input" id="destiny-input">
                            <button onclick="calculateDestiny()" class="block mt-6 mx-auto text-[10px] border border-[#bf953f] px-6 py-2 hover:bg-[#bf953f] hover:text-black transition">GIẢI MÃ</button>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 opacity-0 translate-x-10 transition-all duration-1000" id="analysis-panel">
                    <h3 class="text-3xl italic mb-6">Lời hồi đáp từ các vì sao</h3>

                    <div class="energy-stats space-y-8">
                        <div>
                            <div class="flex justify-between text-[11px] uppercase tracking-widest">
                                <span>Chỉ số Tài Lộc</span>
                                <span id="stat-value">98%</span>
                            </div>
                            <div class="stat-bar-bg">
                                <div class="stat-bar-gold" id="bar-wealth"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="border-l border-gray-800 pl-4">
                                <div class="text-gray-500 text-[9px] uppercase mb-1">Tương hợp</div>
                                <div class="text-sm">Mậu Thìn (1988)</div>
                            </div>
                            <div class="border-l border-gray-800 pl-4">
                                <div class="text-gray-500 text-[9px] uppercase mb-1">Năng lượng</div>
                                <div class="text-sm text-[#bf953f]">Bền vững</div>
                            </div>
                        </div>

                        <p class="text-gray-400 text-sm italic leading-relaxed" id="oracle-advice">
                            "Tấm biển này mang năng lượng của sự vĩnh cửu, phù hợp để dẫn đầu các thương vụ triệu đô."
                        </p>

                        <div class="flex gap-4 pt-4">
                            <button class="bg-[#bf953f] text-black text-[10px] font-bold px-8 py-3 uppercase tracking-tighter">Tìm biển tương tự</button>
                            <button class="border border-gray-700 p-3"><i class="ri-share-line"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section class="golden-hammer" id="auction-section">
        <div class="container mx-auto px-4 relative z-10">

            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-4xl font-serif italic text-white">The Golden Hammer</h2>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="live-badge">LIVE</span>
                        <span class="text-[10px] text-gray-500 tracking-[0.3em] uppercase">Sàn đấu giá thời gian thực</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-2 text-[#4ade80] text-xs">
                    <i class="ri-checkbox-circle-fill"></i> Xác thực bởi Bộ Công An
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2">
                    <div class="auction-card p-8 rounded-sm overflow-hidden" id="main-auction-card">
                        <div class="flex flex-col md:flex-row gap-12 items-center">
                            <div class="w-full md:w-1/2 text-center">
                                <div class="text-[10px] text-gray-500 mb-2 uppercase">Biển số báu vật</div>
                                <div class="text-6xl font-black text-white mb-6 tracking-tighter">51K-999.99</div>
                                <div class="inline-block border border-[#bf953f]/30 px-4 py-1 rounded-full text-[10px] text-[#bf953f]">
                                    <i class="ri-拍卖-fill"></i> 158 lượt bít
                                </div>
                            </div>

                            <div class="w-full md:w-1/2 space-y-6">
                                <div>
                                    <div class="text-[10px] text-gray-500 uppercase mb-1">Giá hiện tại</div>
                                    <div class="current-price text-5xl tracking-tighter" id="current-price">3.450.000.000₫</div>
                                </div>

                                <div class="grid grid-cols-3 gap-2">
                                    <div class="bg-black p-3 rounded text-center">
                                        <div class="text-[18px] font-bold text-white">00</div>
                                        <div class="text-[8px] text-gray-600 uppercase">Giờ</div>
                                    </div>
                                    <div class="bg-black p-3 rounded text-center border-b-2 border-[#bf953f]">
                                        <div class="text-[18px] font-bold text-white">14</div>
                                        <div class="text-[8px] text-gray-600 uppercase">Phút</div>
                                    </div>
                                    <div class="bg-black p-3 rounded text-center border-b-2 border-red-600">
                                        <div class="text-[18px] font-bold text-red-600" id="countdown-sec">45</div>
                                        <div class="text-[8px] text-gray-600 uppercase">Giây</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 flex flex-wrap gap-4">
                            <button onclick="placeBid(50000000)" class="flex-1 bg-white/5 hover:bg-[#bf953f] hover:text-black transition py-4 text-[10px] font-bold border border-white/10">+50.000.000₫</button>
                            <button class="flex-1 bg-[#bf953f] text-black py-4 text-[10px] font-bold uppercase tracking-widest">Đưa giá ngay</button>
                            <button class="w-full md:w-auto px-8 py-4 border border-white/20 text-white text-[10px] uppercase opacity-50 hover:opacity-100">Mua đứt: 5.000.000.000₫</button>
                        </div>
                    </div>
                </div>

                <div class="bg-black/50 p-6 border border-white/5 rounded-sm">
                    <h4 class="text-[11px] uppercase tracking-widest text-gray-400 mb-6 border-b border-white/10 pb-2">Lịch sử trả giá</h4>
                    <div id="bid-history" class="h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                        <div class="bid-history-item flex justify-between">
                            <span class="text-white">Khách VIP **89</span>
                            <span class="text-[#bf953f] font-bold">+50tr</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ----------------------------- section 6 -----------------------------  -->
    <section class="concierge-system" id="vip-concierge">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-16">

                <div class="w-full lg:w-[70%] relative group">
                    <div class="map-container rounded-sm" id="interactive-map">
                        <svg class="silver-map" viewBox="0 0 800 600" preserveAspectRatio="xMidYMid meet">
                            <path d="M420,50 L430,80 L425,120 L440,150 L460,180 L440,210 L410,230 L400,280 L410,320 L430,360 L420,420 L400,480 L380,520 L390,550"
                                fill="none"
                                stroke="rgba(255,255,255,0.3)"
                                stroke-width="1.5"
                                stroke-dasharray="4 2" />

                            <circle cx="420" cy="50" r="2" fill="rgba(255,255,255,0.5)" />
                            <circle cx="390" cy="550" r="2" fill="rgba(255,255,255,0.5)" />
                        </svg>

                        <div class="showroom-point" style="top: 49%; left: 50%;" onmouseover="showDetails('hcm')">
                            <div class="pulse-ring"></div>
                        </div>

                        <div class="absolute bottom-4 left-4 coordinates">
                            LAT: <span id="lat">10.7626</span>22 | LON: <span id="lon">106.6601</span>72
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-[30%] space-y-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="status-online"></div>
                        <span class="text-[10px] tracking-widest uppercase">Concierge Online 24/7</span>
                        <span class="text-[10px] text-gray-600 ml-auto" id="real-time-clock">16:45:22</span>
                    </div>

                    <h2 class="text-3xl font-serif italic mb-10">Dịch vụ Quản gia & Mạng lưới Toàn cầu</h2>

                    <div class="concierge-card group">
                        <div class="flex gap-4 items-center mb-6">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=100"
                                class="w-12 h-12 rounded-full object-cover filter grayscale group-hover:grayscale-0 transition-all" alt="Specialist">
                            <div>
                                <p class="text-[11px] text-gray-500 uppercase">Chuyên viên riêng</p>
                                <p class="text-sm font-bold">Mr. Alexander Vu</p>
                            </div>
                        </div>

                        <ul class="space-y-4 text-xs text-gray-400">
                            <li class="flex justify-between border-b border-white/5 pb-2">
                                <span>Giao xe lồng kính</span>
                                <i class="ri-check-line"></i>
                            </li>
                            <li class="flex justify-between border-b border-white/5 pb-2">
                                <span>Bảo dưỡng tận nơi</span>
                                <i class="ri-check-line"></i>
                            </li>
                            <li class="flex justify-between">
                                <span>Hỗ trợ định danh VIP</span>
                                <i class="ri-check-line"></i>
                            </li>
                        </ul>

                        <button class="w-full mt-8 py-4 bg-white text-black text-[10px] font-bold uppercase tracking-widest hover:bg-[#bf953f] transition haptic-btn">
                            Gọi Quản Gia Ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 5 -----------------------------  -->
    <section class="obsidian-editorial p-5" id="editorial-monolith">
        <div class="obsidian-texture"></div>
        <div class="light-sweep-overlay"></div>

        <div class="container mx-auto px-10 relative z-10">
            <div class="editorial-grid">
                <div class="featured-article">
                    <a href="Detail_News.php">
                        <div class="editorial-card group" onmousemove="handleParallax(event, this)">
                            <div class="editorial-img-box aspect-[16/10]">
                                <img src="https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=2000" class="w-full h-full object-cover">
                            </div>
                            <div class="parallax-text">
                                <span class="text-[9px] tracking-[0.6em] text-gray-500 uppercase block mb-4">The Legacy Collection</span>
                                <h2 class="editorial-title text-4xl lg:text-6xl max-w-xl">Hơi thở của Đá núi lửa và Nghệ thuật Định danh</h2>
                                <a href="#" class="read-link">ĐỌC TIẾP</a>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="side-articles">
                    <a href="Detail_News.php">
                        <div class="editorial-card group" onmousemove="handleParallax(event, this)">
                            <div class="editorial-img-box aspect-square w-full">
                                <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1000" class="w-full h-full object-cover">
                            </div>
                            <div class="parallax-text">
                                <span class="text-[9px] tracking-[0.5em] text-gray-500 uppercase block mb-2">Heritage</span>
                                <h3 class="editorial-title text-2xl italic">Dòng chảy Thượng lưu qua các thế hệ</h3>
                                <a href="#" class="read-link">ĐỌC TIẾP</a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>



    <?php include('footer.php'); ?>
</body>
<script>
    //----------------------------- section 1 ----------------------------- //
    // 1. Hiệu ứng Bụi Vàng (Gold Dust)
    const canvas = document.getElementById('gold-dust-canvas');
    const ctx = canvas.getContext('2d');
    let particles = [];

    function initParticles() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        for (let i = 0; i < 100; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                size: Math.random() * 2,
                speedX: Math.random() * 0.5 - 0.25,
                speedY: Math.random() * 0.5 - 0.25,
                alpha: Math.random()
            });
        }
    }

    function drawParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => {
            ctx.fillStyle = `rgba(191, 149, 63, ${p.alpha})`;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
            ctx.fill();
            p.x += p.speedX;
            p.y += p.speedY;
            if (p.x > canvas.width) p.x = 0;
            if (p.y > canvas.height) p.y = 0;
        });
        requestAnimationFrame(drawParticles);
    }

    // 2. Hiệu ứng Mouse Parallax
    document.addEventListener('mousemove', (e) => {
        const {
            clientX,
            clientY
        } = e;
        const xPos = (clientX / window.innerWidth - 0.5) * 30; // Dịch chuyển tối đa 30px
        const yPos = (clientY / window.innerHeight - 0.5) * 30;

        document.querySelector('.video-background video').style.transform =
            `scale(1.1) translate(${xPos}px, ${yPos}px)`;
        document.querySelector('.hero-content').style.transform =
            `translate(${-xPos * 0.5}px, ${-yPos * 0.5}px)`;
    });

    // 3. Reveal Animation
    window.onload = () => {
        initParticles();
        drawParticles();

        setTimeout(() => {
            const sub = document.getElementById('reveal-sub');
            sub.style.opacity = '1';
            sub.style.transform = 'translateY(0)';
            sub.style.transition = 'all 1.5s ease-out';
        }, 1000);
    };

    // 4. Gyroscope cho Mobile (Hiệu ứng nghiêng)
    window.addEventListener('deviceorientation', (event) => {
        if (window.innerWidth < 768) {
            const x = event.beta; // Độ nghiêng trước sau
            const y = event.gamma; // Độ nghiêng trái phải
            document.querySelector('.video-background').style.transform =
                `translate(${y * 0.5}px, ${x * 0.5}px)`;
        }
    });

    // -----------------------------section 2 ----------------------------- //
    /* ----------------------------- THE TREASURE VAULT LOGIC ----------------------------- */

    /**
     * Hiển thị kính lúp và thiết lập vùng soi
     */
    function showMag(e) {
        const container = e.currentTarget;
        const mag = container.querySelector('.magnifier');
        const plateNumber = container.querySelector('.plate-number');

        // Hiện kính lúp
        mag.style.display = 'block';

        // Kỹ thuật "Mirroring": Lấy nội dung chữ thực tế để đưa vào kính lúp
        // Điều này giúp kính lúp soi đúng biển số mà không cần load ảnh ngoài
        if (!mag.innerHTML) {
            mag.innerHTML = `<div class="mag-content">${plateNumber.innerHTML}</div>`;
        }
    }

    /**
     * Ẩn kính lúp khi chuột rời khỏi vùng biển số
     */
    function hideMag(e) {
        const mag = e.currentTarget.querySelector('.magnifier');
        mag.style.display = 'none';
    }

    /**
     * Xử lý di chuyển kính lúp và hiệu ứng Zoom
     */
    function magnify(e) {
        const container = e.currentTarget;
        const mag = container.querySelector('.magnifier');
        const magContent = mag.querySelector('.mag-content');
        const rect = container.getBoundingClientRect();

        // 1. Tính toán tọa độ chuột tương đối trong khung biển số
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        // 2. Di chuyển tâm kính lúp theo con trỏ (Trừ đi 60px là nửa bán kính kính lúp)
        mag.style.left = `${x - 60}px`;
        mag.style.top = `${y - 60}px`;

        // 3. Hiệu ứng "Phóng đại nội dung" 
        // Di chuyển nội dung bên trong kính lúp ngược hướng chuột để tạo cảm giác soi
        const moveX = (x / rect.width) * 100;
        const moveY = (y / rect.height) * 100;

        if (magContent) {
            magContent.style.transform = `translate(${-moveX + 50}%, ${-moveY + 50}%) scale(2.5)`;
        }
    }

    /* ----------------------------- MOBILE & INTERACTION ----------------------------- */

    // Hiệu ứng Rung (Haptic Feedback) và Tương tác cảm ứng
    document.querySelectorAll('.marble-pedestal').forEach(card => {
        // Rung nhẹ khi chạm (Dành cho Android)
        card.addEventListener('touchstart', () => {
            if (window.navigator && window.navigator.vibrate) {
                window.navigator.vibrate(20);
            }
        }, {
            passive: true
        });

        // Hỗ trợ kính lúp trên Mobile (Chạm để soi)
        card.addEventListener('touchmove', (e) => {
            const touch = e.touches[0];
            const plateDisplay = card.querySelector('.plate-display');
            const rect = plateDisplay.getBoundingClientRect();

            // Kiểm tra nếu ngón tay đang nằm trong vùng biển số
            if (touch.clientX >= rect.left && touch.clientX <= rect.right &&
                touch.clientY >= rect.top && touch.clientY <= rect.bottom) {

                showMag({
                    currentTarget: plateDisplay
                });
                magnify({
                    currentTarget: plateDisplay,
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
            } else {
                hideMag({
                    currentTarget: plateDisplay
                });
            }
        }, {
            passive: true
        });
    });
    // --- Dán đoạn này vào bên dưới phần Logic Kính lúp trong <script> ---

    document.addEventListener('DOMContentLoaded', () => {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const items = document.querySelectorAll('.marble-pedestal');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // 1. Cập nhật trạng thái Active cho nút bấm
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const target = btn.getAttribute('data-target');

                // 2. Lọc các tấm biển (Marble Pedestal)
                items.forEach(item => {
                    const category = item.getAttribute('data-category');

                    // Hiệu ứng mờ dần khi chuyển đổi
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.95) translateY(10px)';

                    setTimeout(() => {
                        if (target === 'all' || category === target) {
                            item.style.display = 'block';
                            // Hiện lại mượt mà
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'scale(1) translateY(0)';
                            }, 50);
                        } else {
                            item.style.display = 'none';
                        }
                    }, 300); // Đợi hiệu ứng ẩn kết thúc rồi mới ẩn hoàn toàn
                });

                // 3. Phản hồi rung nhẹ trên mobile
                if (window.navigator && window.navigator.vibrate) {
                    window.navigator.vibrate(10);
                }
            });
        });
    });
    //----------------------------- section 3 ----------------------------- //// 1. Xử lý xoay vòng và đổi màu mệnh
    function selectElement(type, color) {
        const wheel = document.getElementById('main-wheel');
        const sections = {
            metal: 0,
            wood: -72,
            water: -144,
            fire: -216,
            earth: -288
        };

        // Xoay vòng xoay đến cung tương ứng
        wheel.style.transform = `rotate(${sections[type]}deg)`;

        // Elemental Pulse: Đổi màu glow nền
        document.querySelector('.bg-pentagram').style.backgroundImage =
            `radial-gradient(circle at center, ${color}33 0%, transparent 70%)`;
    }

    // 2. Logic giải mã số (The Oracle Calculation)
    function calculateDestiny() {
        const input = document.getElementById('destiny-input').value;
        if (!input) return;

        const panel = document.getElementById('analysis-panel');
        const wheel = document.getElementById('main-wheel');

        // Hiệu ứng xoay nhanh giả lập tính toán
        wheel.style.transition = 'transform 1s cubic-bezier(0.68, -0.55, 0.27, 1.55)';
        wheel.style.transform += ' rotate(1080deg)';

        setTimeout(() => {
            // Hiện bảng kết quả
            panel.style.opacity = '1';
            panel.style.transform = 'translateX(0)';

            // Chạy thanh chỉ số
            document.getElementById('bar-wealth').style.width = '92%';

            // Rung nhẹ điện thoại khi có kết quả
            if (window.navigator && window.navigator.vibrate) {
                window.navigator.vibrate([30, 50, 30]);
            }
        }, 1000);
    }

    // 3. Number Energy Tooltip (Hover từng số)
    document.getElementById('destiny-input').addEventListener('mousemove', (e) => {
        // Logic này sẽ phức tạp hơn nếu chia nhỏ input thành từng thẻ span
        // Gợi ý: Dùng một div overlay chứa các span số để dễ bắt sự kiện hover
    });

    //----------------------------- section 4 ----------------------------- //
    // 1. Giả lập thông báo nhảy giá real-time
    function placeBid(amount) {
        const priceDisplay = document.getElementById('current-price');
        const history = document.getElementById('bid-history');
        const card = document.getElementById('main-auction-card');

        // Rung nhẹ thẻ card (Live Pulse)
        card.classList.add('translate-y-[-5px]');
        setTimeout(() => card.classList.remove('translate-y-[-5px]'), 100);

        // Cập nhật giá (Giả lập tăng)
        let currentVal = 3450000000;
        let newVal = currentVal + amount;
        priceDisplay.innerText = newVal.toLocaleString('vi-VN') + '₫';

        // Thêm vào lịch sử
        const bidEntry = document.createElement('div');
        bidEntry.className = 'bid-history-item flex justify-between';
        bidEntry.innerHTML = `<span class="text-white">Bạn vừa trả giá</span><span class="text-[#4ade80] font-bold">+${amount/1000000}tr</span>`;
        history.prepend(bidEntry);
    }

    // 2. Xử lý Countdown & Hiệu ứng 60s cuối
    let seconds = 45;
    const timerInterval = setInterval(() => {
        seconds--;
        document.getElementById('countdown-sec').innerText = seconds < 10 ? '0' + seconds : seconds;

        if (seconds <= 20) {
            document.getElementById('main-auction-card').classList.add('critical-timer');
        }

        if (seconds <= 0) {
            clearInterval(timerInterval);
            handleAuctionEnd();
        }
    }, 1000);

    // 3. Hiệu ứng Gavel Strike (Kết thúc)
    function handleAuctionEnd() {
        const card = document.getElementById('main-auction-card');
        card.innerHTML = `
        <div class="flex flex-col items-center justify-center h-full py-20 animate-bounce">
            <div class="text-8xl mb-4">🔨</div>
            <div class="text-6xl font-black text-[#bf953f] tracking-tighter">SOLD OUT</div>
            <div class="text-white mt-4 uppercase text-xs tracking-[0.5em]">Siêu phẩm đã có chủ nhân</div>
        </div>
    `;
        // Thêm hiệu ứng pháo hoa giấy vàng nếu cần
    }

    //----------------------------- section 5 ----------------------------- //
    // 1. Xử lý hiệu ứng Parallax và Vân đá Obsidian
    function handleParallax(e, card) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        // Cập nhật vị trí vân đá phát sáng (CSS Variable)
        document.getElementById('editorial-monolith').style.setProperty('--mouse-x', `${(e.clientX / window.innerWidth) * 100}%`);
        document.getElementById('editorial-monolith').style.setProperty('--mouse-y', `${(e.clientY / window.innerHeight) * 100}%`);

        // Hiệu ứng chữ lơ lửng (Parallax)
        const text = card.querySelector('.parallax-text');
        const moveX = (x - rect.width / 2) / 20;
        const moveY = (y - rect.height / 2) / 20;
        text.style.transform = `translate(${moveX}px, ${moveY}px)`;
    }

    // 2. Tự động điều chỉnh độ tương phản chữ dựa trên ánh sáng (Giả lập)
    window.addEventListener('devicelight', (e) => {
        const editorial = document.getElementById('editorial-monolith');
        if (e.value > 1000) { // Ánh sáng mạnh ngoài trời
            editorial.style.setProperty('--pearl', '#ffffff'); // Trắng tuyệt đối cho ngoài trời
        } else {
            editorial.style.setProperty('--pearl', '#f1f1f1'); // Trắng ngọc trai cho trong nhà
        }
    });

    // 3. Reset Parallax khi chuột rời đi
    document.querySelectorAll('.editorial-card').forEach(card => {
        card.addEventListener('mouseleave', () => {
            card.querySelector('.parallax-text').style.transform = `translate(0, 0)`;
        });
    });


    //----------------------------- section 6 ----------------------------- //
    // 1. Đồng hồ thời gian thực
    setInterval(() => {
        const now = new Date();
        document.getElementById('real-time-clock').innerText = now.toLocaleTimeString('en-GB');
    }, 1000);

    // 2. Hiệu ứng Coordinates chạy nhảy tinh tế
    function updateCoordinates() {
        const lat = 10.7626 + (Math.random() * 0.001);
        const lon = 106.6601 + (Math.random() * 0.001);
        document.getElementById('lat').innerText = lat.toFixed(4);
        document.getElementById('lon').innerText = lon.toFixed(4);
    }
    setInterval(updateCoordinates, 150);

    // 3. Hiệu ứng Rung (Haptic) cho Mobile
    document.querySelector('.haptic-btn').addEventListener('click', function() {
        if (window.navigator && window.navigator.vibrate) {
            window.navigator.vibrate([100, 30, 100]); // Rung mạnh như đóng cửa xe
        }
        window.location.href = "tel:19001234";
    });

    // 4. Gyroscope (Nghiêng điện thoại để lấp lánh bản đồ)
    window.addEventListener('deviceorientation', function(event) {
        const map = document.querySelector('.silver-map');
        const x = event.beta; // Độ nghiêng trước-sau
        const y = event.gamma; // Độ nghiêng trái-phải

        if (map) {
            map.style.transform = `rotateX(${x/10}deg) rotateY(${y/10}deg)`;
        }
    });
</script>

</html>