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


        /* ----------------------------- section 4 -----------------------------  */
        

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section class="hero-showroom" id="hero-parallax">
        <<div class="video-background">
            <video autoplay muted loop playsinline id="hero-video"
                poster="https://img.tripi.vn/cdn-cgi/image/width=700,height=700/https://gcs.tripi.vn/public-tripi/tripi-feed/img/474068FYW/anh-nen-dep-thanh-pho-ve-dem_022600898.jpg">
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

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

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

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>