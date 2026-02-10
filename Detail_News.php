<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        :root {
            --platinum: #e5e4e2;
            --obsidian: #0b0b0b;
            --champagne: #f7e7ce;
        }

        /* -----------------------------section 1 DETAIL HERO: OBSIDIAN PORTAL ----------------------------- */
        .news-hero {
            position: relative;
            width: 100%;
            height: 100vh;
            background-color: #000;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
            /* Căn tiêu đề ở 1/3 dưới */
            padding-bottom: 10vh;
        }

        /* Deep Parallax Background */
        .hero-image-wrap {
            position: absolute;
            inset: 0;
            z-index: 0;
            will-change: transform;
        }

        .hero-image-wrap img {
            width: 100%;
            height: 120%;
            /* Cao hơn 100% để phục vụ parallax khi cuộn */
            object-fit: cover;
            filter: brightness(0.7) contrast(1.1);
            transition: filter 1s ease;
        }

        /* Lớp kính Obsidian ảo (Overlay) */
        .obsidian-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            /* Gradient từ đen đặc ở đáy lên trong suốt ở trên */
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 1) 0%,
                    rgba(11, 11, 11, 0.6) 40%,
                    transparent 100%);
        }

        /* Hiệu ứng Glass Shimmer (Dải sáng bạc) */
        .glass-shimmer {
            position: absolute;
            top: 0;
            left: -150%;
            width: 200%;
            height: 100%;
            background: linear-gradient(110deg, transparent, rgba(229, 228, 226, 0.1), transparent);
            z-index: 2;
            transform: skewX(-20deg);
        }

        .news-hero.loaded .glass-shimmer {
            animation: shimmer-sweep 2s ease-out forwards;
        }

        @keyframes shimmer-sweep {
            to {
                left: 150%;
            }
        }

        /* Typography Platinum */
        .hero-content {
            position: relative;
            z-index: 5;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .metadata {
            font-size: 10px;
            color: var(--champagne);
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 15px;
            opacity: 0;
            transform: translateY(20px);
        }

        .headline {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            /* Responsive font size */
            color: var(--platinum);
            line-height: 1.1;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform: translateY(30px);
        }

        .loaded .metadata,
        .loaded .headline {
            opacity: 1;
            transform: translateY(0);
            transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.5s;
        }

        /* Scroll Indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translate(-50%, 0);
            }

            40% {
                transform: translate(-50%, -10px);
            }

            60% {
                transform: translate(-50%, -5px);
            }
        }

        /* ----------------------------- SECTION 2: CONTENT BODY ----------------------------- */
        .content-body {
            background-color: #0b0b0b;
            /* Matte Obsidian */
            color: #d1d1d1;
            /* Smoke White - Giảm mỏi mắt */
            padding: 100px 0;
            line-height: 1.8;
            font-size: 19px;
            font-family: 'Inter', sans-serif;
        }

        /* Bố cục Single Column */
        .article-container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            padding: 0 20px;
        }

        /* Interactive Drop Cap (Chữ cái đầu dòng) */
        .drop-cap::first-letter {
            font-family: 'Playfair Display', serif;
            float: left;
            font-size: 85px;
            line-height: 1;
            margin-right: 15px;
            background: linear-gradient(45deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            transition: 0.5s;
            cursor: pointer;
        }

        .drop-cap:hover::first-letter {
            animation: gold-flow 3s ease infinite;
        }

        @keyframes gold-flow {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Sub-headings Bạch Kim */
        .content-body h2 {
            font-family: 'Playfair Display', serif;
            color: #e5e4e2;
            /* Platinum */
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 28px;
            margin: 60px 0 30px;
            opacity: 0.9;
        }

        /* Số thứ tự đoạn văn chạy lề trái (Desktop) */
        .paragraph-wrap {
            position: relative;
            margin-bottom: 40px;
            transition: opacity 0.5s, filter 0.5s;
        }

        .paragraph-num {
            position: absolute;
            left: -100px;
            top: 5px;
            font-size: 12px;
            font-family: serif;
            color: #444;
            /* Ash Gray */
            letter-spacing: 2px;
        }

        /* Image Out of Box */
        .image-out-box {
            width: 100%;
            margin: 60px 0;
        }

        .image-caption {
            font-style: italic;
            font-size: 13px;
            color: #666;
            margin-top: 15px;
            text-align: right;
            letter-spacing: 0.5px;
        }

        /* CSS riêng cho Pull Quote để nó không bị lấp bởi nền đen */
        .pull-quote {
            position: relative;
            margin: 80px 0;
            /* Chỉnh lại margin cho an toàn */
            padding: 60px;
            background: rgba(255, 255, 255, 0.03);
            /* Tăng nhẹ độ sáng nền */
            backdrop-filter: blur(10px);
            border-left: 2px solid #bf953f;
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: #f7e7ce;
            font-style: italic;
            z-index: 10;
        }

        /* Hiệu ứng Reveal on Scroll */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 1s ease-out;
            will-change: opacity, transform;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Focus Reading */
        .paragraph-wrap.blur-effect {
            filter: blur(2px);
            opacity: 0.4;
        }

        @media (min-width: 1024px) {
            .image-out-box {
                width: 120%;
                margin-left: -10%;
                /* Tràn ra 2 bên trên màn hình lớn */
            }
        }

        /* ----------------------------- SECTION 3: MULTIMEDIA GALLERY ----------------------------- */
        .multimedia-gallery {
            background-color: #050505;
            padding: 100px 0;
            position: relative;
        }

        /* Mosaic Layout */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-auto-rows: 250px;
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            background: #000;
            border: 4px solid #1a1a1a;
            /* Glossy Obsidian Frame */
            cursor: crosshair;
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Các kích thước khung hình khác nhau */
        .item-large {
            grid-column: span 2;
            grid-row: span 2;
        }

        /* Khung trung tâm */
        .item-vertical {
            grid-row: span 2;
        }

        .item-panoramic {
            grid-column: span 2;
        }

        /* Filter Black-Gold */
        .gallery-item img,
        .gallery-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: sepia(0.3) brightness(0.5) contrast(1.2) saturate(0.8);
            transition: all 0.8s ease;
        }

        .gallery-item:hover img,
        .gallery-item:hover video {
            filter: sepia(0) brightness(1) contrast(1) saturate(1);
            transform: scale(1.05);
        }

        /* Ambient Glow (Ánh sáng môi trường) */
        .gallery-item::after {
            content: '';
            position: absolute;
            inset: 0;
            box-shadow: inset 0 0 50px rgba(0, 0, 0, 0.9);
            pointer-events: none;
        }

        .gallery-item:hover {
            box-shadow: 0 0 30px rgba(191, 149, 63, 0.2);
            /* Ám vàng nhẹ khi hover */
            border-color: #333;
        }

        /* Metadata theo chuột */
        #gallery-cursor-info {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            color: #e5e4e2;
            /* Platinum */
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            background: rgba(0, 0, 0, 0.8);
            padding: 5px 12px;
            display: none;
            backdrop-filter: blur(5px);
        }

        /* Trạng thái nút khi ON */
        #night-vision-toggle.active {
            background: #00ff41;
            /* Màu xanh Matrix/Neon */
            box-shadow: 0 0 15px rgba(0, 255, 65, 0.4);
        }

        #night-vision-toggle.active .dot {
            transform: translateX(24px);
            /* Đẩy nút sang phải */
            background: #fff;
        }

        /* Hiệu ứng Night Vision cho Gallery */
        .multimedia-gallery.nv-active .gallery-item img,
        .multimedia-gallery.nv-active .gallery-item video {
            filter: invert(1) hue-rotate(360deg) brightness(0.5) contrast(2.5);
            /* Invert(1): Đảo ngược màu
       hue-rotate(180deg): Giữ nguyên tông độ nhưng đảo sắc
       saturate(0): Biến thành đen trắng hoặc xanh neon tùy chỉnh */
        }

        /* Thêm lớp nhiễu (Noise) để tăng tính chân thực của ống kính đêm */
        .multimedia-gallery.nv-active::before {
            content: "";
            position: absolute;
            inset: 0;
            background: url('https://www.transparenttextures.com/patterns/stardust.png');
            opacity: 0.1;
            z-index: 5;
            pointer-events: none;
        }

        /* Chữ Night Vision sáng lên khi kích hoạt */
        .nv-text-active {
            color: #00ff41 !important;
            text-shadow: 0 0 5px #00ff41;
        }

        /* ----------------------------- SECTION 4: THE EXPERT'S VOICE ----------------------------- */
        .expert-voice {
            background: radial-gradient(circle at 20% 50%, #111 0%, #050505 100%);
            padding: 150px 0;
            position: relative;
            overflow: hidden;
        }

        /* Khối kính đen Smoked Glass */
        .quote-glass-container {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 60px;
            position: relative;
            z-index: 2;
        }

        /* Chân dung chuyên gia Silhouette */
        .expert-portrait-wrap {
            position: relative;
            width: 280px;
            height: 280px;
        }

        .expert-portrait {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            filter: grayscale(100%) contrast(1.2) brightness(0.8);
            border: 1px solid rgba(229, 228, 226, 0.3);
            /* Platinum Border */
            transition: all 0.8s ease;
        }

        .expert-portrait-wrap::after {
            content: '';
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, transparent, rgba(247, 231, 206, 0.2), transparent);
            animation: rotate-shimmer 10s linear infinite;
            z-index: -1;
        }

        /* Biểu tượng dấu ngoặc kép Glossy Black */
        .big-quote-mark {
            position: absolute;
            top: -40px;
            left: -20px;
            font-size: 150px;
            font-family: 'Playfair Display', serif;
            color: #111;
            /* Chìm vào nền */
            line-height: 1;
            z-index: -1;
            transition: color 0.5s ease;
        }

        .quote-glass-container:hover .big-quote-mark {
            color: #1a1a1a;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.02);
        }

        /* Chữ ký mạ bạc (SVG Animation) */
        .signature-svg {
            width: 150px;
            stroke: #e5e4e2;
            stroke-width: 1;
            fill: none;
            stroke-dasharray: 500;
            stroke-dashoffset: 500;
            transition: stroke-dashoffset 2s ease;
        }

        .quote-glass-container:hover .signature-svg {
            stroke-dashoffset: 0;
        }

        @keyframes rotate-shimmer {
            to {
                transform: rotate(360deg);
            }
        }

        /* Typewriter Cursor */
        .typewriter-text::after {
            content: '|';
            animation: blink 1s infinite;
            color: #bf953f;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }

        /* ----------------------------- SECTION 5: RELATED MASTERPIECES ----------------------------- */
        .related-masterpieces {
            background: #000;
            /* Infinite Black */
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }

        /* Hiệu ứng Obsidian Grain nền */
        .related-masterpieces::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url('https://www.transparenttextures.com/patterns/dark-matter.png');
            opacity: 0.3;
            pointer-events: none;
        }

        .section-title-wrap {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-title-wrap h2 {
            font-family: 'Playfair Display', serif;
            color: #e5e4e2;
            /* Platinum */
            letter-spacing: 12px;
            font-size: 14px;
            text-transform: uppercase;
        }

        /* Grid System */
        .masterpiece-grid {
            display: flex;
            justify-content: center;
            gap: 40px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* Masterpiece Card */
        .masterpiece-card {
            position: relative;
            flex: 1;
            height: 500px;
            background: #0a0a0a;
            border: 1px solid rgba(255, 255, 255, 0.05);
            overflow: hidden;
            cursor: none;
            /* Để hiện custom cursor "XEM" */
            transition: transform 0.1s ease-out, opacity 0.5s ease;
            perspective: 1000px;
            /* Cho hiệu ứng 3D Tilt */
        }

        /* Hiệu ứng Dark Mist Overlay */
        .masterpiece-img-box {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .masterpiece-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.4) saturate(0.5);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .dark-mist {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, #000 10%, transparent 60%);
            z-index: 2;
        }

        /* Glow Outline Laser */
        .masterpiece-card::after {
            content: "";
            position: absolute;
            inset: 0;
            border: 1px solid #e5e4e2;
            clip-path: inset(0 100% 0 0);
            /* Mặc định ẩn viền */
            transition: clip-path 0.6s ease;
            z-index: 10;
            pointer-events: none;
        }

        .masterpiece-card:hover::after {
            clip-path: inset(0 0 0 0);
            /* Chạy dải sáng laser */
        }

        /* Value Reveal (Vàng Champagne) */
        .masterpiece-info {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
            z-index: 5;
            text-align: center;
        }

        .masterpiece-price {
            font-family: 'Playfair Display', serif;
            color: #f7e7ce;
            /* Champagne Gold */
            font-size: 24px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .masterpiece-card:hover .masterpiece-price {
            opacity: 1;
            transform: translateY(0);
        }

        .masterpiece-card:hover .masterpiece-img-box img {
            filter: brightness(0.8) saturate(1);
            transform: scale(1.1);
        }

        /* Hiệu ứng mờ các thẻ khác khi hover một thẻ */
        .masterpiece-grid:hover .masterpiece-card:not(:hover) {
            opacity: 0.5;
            filter: brightness(0.5);
        }

        /* Custom Cursor XEM */
        #custom-cursor-xem {
            position: fixed;
            width: 60px;
            height: 60px;
            background: rgba(229, 228, 226, 0.9);
            color: #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 2px;
            pointer-events: none;
            z-index: 1000;
            transform: scale(0);
            transition: transform 0.3s ease;
        }

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section class="news-hero" id="newsHero">
        <div class="hero-image-wrap" id="parallaxImg">
            <img src="https://images.pexels.com/photos/6894429/pexels-photo-6894429.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Bentley Steering Wheel">
        </div>

        <div class="obsidian-overlay"></div>
        <div class="glass-shimmer"></div>

        <div class="hero-content" id="floatingHeadline">
            <p class="metadata">LỐI SỐNG | 10.02.2026</p>
            <h1 class="headline">
                Bentley Continental GT:<br>
                Tuyệt tác định danh trên cung đường di sản
            </h1>
        </div>

        <div class="scroll-indicator">
            <svg width="24" height="40" viewBox="0 0 24 40" fill="none">
                <path d="M12 40V0M12 40L20 32M12 40L4 32" stroke="#f7e7ce" stroke-width="1.5" />
            </svg>
        </div>
    </section>

    <div class="content-body bg-black py-20">
    </div>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section class="content-body">
        <div class="article-container">

            <div class="paragraph-wrap reveal" data-num="01">
                <span class="paragraph-num">01</span>
                <p class="drop-cap">
                    Trong kỷ nguyên của sự hào nhoáng nhất thời, Bentley Continental GT không chỉ đơn thuần là một cỗ máy vận hành bằng mã lực. Nó là một di sản sống, được chế tác từ những lớp da thượng hạng và những phiến gỗ óc chó có tuổi đời hàng thế kỷ. Mỗi khi bạn bước vào khoang lái, mùi hương của sự xa xỉ ngay lập tức đánh thức mọi giác quan.
                </p>
            </div>

            <h2>Tuyệt tác điêu khắc động</h2>

            <div class="paragraph-wrap reveal" data-num="02">
                <span class="paragraph-num">02</span>
                <p>
                    Sự tĩnh lặng trong khoang cabin của Continental GT được ví như không gian bên trong một thư viện cổ kính tại Anh Quốc. Hệ thống cách âm đa lớp và kính chống ồn được tinh chỉnh để loại bỏ mọi tạp âm từ thế giới bên ngoài, chỉ để lại tiếng trầm đục đầy quyền lực của khối động cơ W12 khi bạn khẽ nhấn ga.
                </p>
            </div>

            <blockquote class="pull-quote reveal">
                "Sự xa xỉ thực sự không nằm ở những gì người khác thấy, mà ở cảm giác tĩnh lặng tuyệt đối khi bạn làm chủ một cung đường."
            </blockquote>

            <div class="image-out-box reveal">
                <img src="https://images.pexels.com/photos/6894429/pexels-photo-6894429.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Bentley Detail" class="w-full">
                <p class="image-caption">Chi tiết cụm đèn pha pha lê cắt thủ công - Ảnh: Alexander Vu</p>
            </div>

            <div class="paragraph-wrap reveal" data-num="03">
                <span class="paragraph-num">03</span>
                <p>
                    Hành trình từ Hà Nội đến các cung đường di sản không còn là một chuyến đi dài mệt mỏi. Với Bentley, đó là một buổi trình diễn nghệ thuật mà bạn là nhân vật chính. Mỗi dặm đường đi qua đều được ghi lại bằng sự êm ái tuyệt đối của hệ thống treo khí nén thông minh.
                </p>
            </div>

            <div class="flex justify-center my-20 opacity-30">
                <svg width="20" height="20" viewBox="0 0 20 20">
                    <rect x="10" y="0" width="14" height="14" transform="rotate(45 10 0)" fill="#bf953f" />
                </svg>
            </div>

        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section class="multimedia-gallery relative overflow-hidden">
        <div id="gallery-cursor-info">XEM CHI TIẾT</div>

        <div class="gallery-grid">
            <div class="gallery-item item-large" data-info="Logo Heritage - 1920" data-sound="engine-low">
                <video autoplay muted loop playsinline>
                    <source src="./assets/video/5309435-hd_1920_1080_25fps.mp4" type="video/mp4">
                </video>
            </div>

            <div class="gallery-item" data-info="Nội thất Bespoke">
                <img src="https://images.unsplash.com/photo-1583121274602-3e2820c69888?q=80&w=1000" alt="Interior">
            </div>

            <div class="gallery-item item-vertical" data-info="Đèn pha Crystal">
                <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000" alt="Detail">
            </div>

            <div class="gallery-item item-panoramic" data-info="Bentley trên cung đường đêm">
                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1200" alt="Night Road">
            </div>

            <div class="gallery-item" data-info="Mặt đồng hồ Breitling">
                <img src="https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000" alt="Watch">
            </div>
        </div>

        <div class="absolute bottom-10 right-10 flex items-center gap-4 z-20">
            <span class="text-[9px] tracking-widest text-gray-500 transition-all">NIGHT VISION</span>
            <button id="night-vision-toggle" class="w-12 h-6 bg-[#1a1a1a] rounded-full relative border border-white/10 transition-all duration-300">
                <div class="dot absolute left-1 top-1 w-4 h-4 bg-gray-600 rounded-full transition-all duration-300"></div>
            </button>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section class="expert-voice" id="expert-section">
        <div class="container mx-auto px-10">
            <div class="flex flex-col lg:flex-row items-center gap-20">

                <div class="w-full lg:w-2/5 flex flex-col items-center text-center lg:items-end lg:text-right" data-speed="0.1">
                    <div class="expert-portrait-wrap mb-8">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=1000" class="expert-portrait" alt="Expert">
                    </div>
                    <h4 class="text-platinum text-xl font-serif italic">Alexander Vu</h4>
                    <p class="text-[10px] tracking-[0.4em] text-gray-500 uppercase mt-2">Góc nhìn thượng lưu</p>

                    <button class="flex items-center gap-3 mt-6 group">
                        <div class="w-8 h-8 rounded-full border border-gray-700 flex items-center justify-center group-hover:border-champagne transition-all">
                            <i class="ri-play-fill text-gray-500 group-hover:text-champagne"></i>
                        </div>
                        <span class="text-[9px] tracking-widest text-gray-600 group-hover:text-gray-300">LISTEN TO VOICE-OVER</span>
                    </button>
                </div>

                <div class="w-full lg:w-3/5 relative">
                    <div class="quote-glass-container" data-speed="0.3">
                        <span class="big-quote-mark">“</span>

                        <div class="min-h-[150px]">
                            <p id="expert-quote" class="text-gray-300 text-xl lg:text-2xl leading-relaxed font-light italic typewriter-text">
                            </p>
                        </div>

                        <div class="mt-10 flex justify-between items-end">
                            <div>
                                <svg class="signature-svg" viewBox="0 0 200 60">
                                    <path d="M10,40 Q30,10 50,40 T90,40 T130,20 T180,40" />
                                </svg>
                                <a href="#" class="text-[10px] text-platinum tracking-[0.3em] uppercase mt-4 block border-b border-platinum/10 pb-1 hover:border-platinum transition-all">
                                    Kết nối riêng với chuyên gia
                                </a>
                            </div>

                            <div class="opacity-40 hover:opacity-100 transition-opacity">
                                <img src="https://cdn-icons-png.flaticon.com/512/1041/1041848.png" class="w-12 h-12 invert" alt="Wax Seal">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 5 -----------------------------  -->
    <section class="related-masterpieces">
        <div id="custom-cursor-xem">XEM</div>

        <div class="section-title-wrap reveal">
            <h2>Có thể bạn đang tìm kiếm</h2>
        </div>

        <div class="masterpiece-grid">
            <div class="masterpiece-card reveal" onmousemove="handleMagnetic(event, this)">
                <div class="masterpiece-img-box">
                    <img src="https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000" alt="Biển số Ngũ Quý">
                    <div class="dark-mist"></div>
                </div>
                <div class="masterpiece-info">
                    <p class="text-[9px] tracking-[0.4em] text-gray-400 mb-2 uppercase">Bảo vật định danh</p>
                    <h3 class="text-white text-lg mb-4">Biển số "Ngũ Quý 9" - Đỉnh cao phong thủy</h3>
                    <div class="masterpiece-price">5.500.000.000 VNĐ</div>
                </div>
            </div>

            <div class="masterpiece-card reveal" onmousemove="handleMagnetic(event, this)">
                <div class="masterpiece-img-box">
                    <img src="https://maytinhgiaphat.vn/wp-content/uploads/2025/08/ferrarilaferrari-11.jpg" alt="Bentley Flying Spur">
                    <div class="dark-mist"></div>
                </div>
                <div class="masterpiece-info">
                    <p class="text-[9px] tracking-[0.4em] text-gray-400 mb-2 uppercase">Cỗ máy di sản</p>
                    <h3 class="text-white text-lg mb-4">Bentley Flying Spur - Onyx Edition</h3>
                    <div class="masterpiece-price">21.000.000.000 VNĐ</div>
                </div>
            </div>

            <div class="masterpiece-card reveal" onmousemove="handleMagnetic(event, this)">
                <div class="masterpiece-img-box">
                    <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1000" alt="Đồng hồ Breitling">
                    <div class="dark-mist"></div>
                </div>
                <div class="masterpiece-info">
                    <p class="text-[9px] tracking-[0.4em] text-gray-400 mb-2 uppercase">Phụ kiện đẳng cấp</p>
                    <h3 class="text-white text-lg mb-4">Đồng hồ Breitling for Bentley</h3>
                    <div class="masterpiece-price">850.000.000 VNĐ</div>
                </div>
            </div>
        </div>

        <div class="mt-20 text-center">
            <a href="#" class="inline-block px-12 py-4 border border-white/20 text-white text-[10px] tracking-[0.5em] uppercase hover:bg-white hover:text-black transition-all duration-500">
                Xem tất cả kho báu
            </a>
        </div>
    </section>

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include('footer.php'); ?>
</body>
<script>
    //----------------------------- section 1 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        const hero = document.getElementById('newsHero');
        const parallaxImg = document.getElementById('parallaxImg');
        const headline = document.getElementById('floatingHeadline');

        // 1. Kích hoạt hiệu ứng Loading
        setTimeout(() => {
            hero.classList.add('loaded');
        }, 100);

        // 2. Mouse Tilt Effect (Desktop)
        window.addEventListener('mousemove', (e) => {
            if (window.innerWidth > 1024) {
                const x = (e.clientX / window.innerWidth - 0.5) * 20; // Nghiêng tối đa 20px
                const y = (e.clientY / window.innerHeight - 0.5) * 20;
                parallaxImg.style.transform = `translate3d(${x}px, ${y}px, 0) scale(1.1)`;
            }
        });

        // 3. Scroll Effects (Floating Headline & Fading Mask)
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;

            // Tiêu đề trôi lên chậm (Ratio 0.5)
            headline.style.transform = `translateY(${-scrolled * 0.5}px)`;
            headline.style.opacity = 1 - (scrolled / 700);

            // Ảnh nền di chuyển chậm hơn tạo độ sâu
            parallaxImg.style.transform = `translateY(${scrolled * 0.2}px) scale(1.1)`;

            // Fading Mask: Che khuất dần ảnh khi cuộn xuống
            const overlay = document.querySelector('.obsidian-overlay');
            overlay.style.background = `linear-gradient(to top, 
            rgba(0,0,0,${Math.min(1, 0.6 + scrolled/500)}) 0%, 
            rgba(11, 11, 11, ${Math.min(1, 0.3 + scrolled/500)}) 100%)`;
        });

        // 4. Tilt-to-Reveal (Mobile Gyroscope)
        if (window.DeviceOrientationEvent) {
            window.addEventListener('deviceorientation', (event) => {
                if (window.innerWidth < 1024) {
                    const tiltX = event.gamma / 2; // Nghiêng trái phải
                    parallaxImg.style.transform = `translateX(${tiltX}px) scale(1.1)`;
                }
            });
        }
    });

    // -----------------------------section 2 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // SỬA TẠI ĐÂY: Chọn tất cả các phần tử có class 'reveal' thay vì chỉ paragraph-wrap
        const revealElements = document.querySelectorAll('.reveal');
        const allParagraphs = document.querySelectorAll('.paragraph-wrap');

        // 1. Hiệu ứng Reveal on Scroll
        const observerOptions = {
            threshold: 0.15
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Quan sát tất cả các phần tử cần hiện ra (bao gồm cả quote và ảnh)
        revealElements.forEach(el => observer.observe(el));

        // 2. Hiệu ứng Focus Reading (Giữ nguyên cho các đoạn văn)
        let focusTimer;

        const handleScroll = () => {
            clearTimeout(focusTimer);

            // Loại bỏ blur cũ trên tất cả các khối nội dung
            revealElements.forEach(el => el.classList.remove('blur-effect'));

            focusTimer = setTimeout(() => {
                const viewportHeight = window.innerHeight;
                let currentFocus = null;

                // Chỉ focus vào các đoạn văn hoặc quote đang nằm giữa màn hình
                revealElements.forEach(el => {
                    const rect = el.getBoundingClientRect();
                    if (rect.top > viewportHeight * 0.2 && rect.top < viewportHeight * 0.6) {
                        currentFocus = el;
                    }
                });

                if (currentFocus) {
                    revealElements.forEach(el => {
                        if (el !== currentFocus) el.classList.add('blur-effect');
                    });
                }
            }, 3000);
        };

        window.addEventListener('scroll', handleScroll);
    });

    //----------------------------- section 3 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        const galleryItems = document.querySelectorAll('.gallery-item');
        const cursorInfo = document.getElementById('gallery-cursor-info');
        const nightVisionBtn = document.getElementById('night-vision-toggle');

        // 1. Hover Metadata & Cursor Follow
        window.addEventListener('mousemove', (e) => {
            cursorInfo.style.left = e.clientX + 15 + 'px';
            cursorInfo.style.top = e.clientY + 15 + 'px';
        });

        galleryItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                cursorInfo.innerText = item.getAttribute('data-info');
                cursorInfo.style.display = 'block';

                // 2. Sound Experience (Simulated)
                if (item.dataset.sound === 'engine-low') {
                    console.log("Playing low engine sound at 20% volume...");
                    // playSound('engine.mp3', 0.2);
                }
            });

            item.addEventListener('mouseleave', () => {
                cursorInfo.style.display = 'none';
            });

            // 3. Lightbox Expansion (Blackout)
            item.addEventListener('click', () => {
                expandImage(item);
            });
        });

        // 4. Night Vision Toggle
        nightVisionBtn.addEventListener('click', () => {
            document.body.classList.toggle('night-vision-mode');
            const dot = nightVisionBtn.querySelector('.dot');
            dot.classList.toggle('translate-x-6');
            dot.classList.toggle('bg-neon-green');
        });

        // 5. Haptic Feedback for Mobile
        galleryItems.forEach(item => {
            item.addEventListener('touchstart', () => {
                if (window.navigator.vibrate) window.navigator.vibrate(10);
            });
        });
    });

    function expandImage(item) {
        // Tạo overlay blackout và phóng lớn ảnh
        // Logic: Clone element -> Absolute center -> Scale 2x
        console.log("Lightbox activated: Spotlight on detail.");
    }
    document.addEventListener('DOMContentLoaded', () => {
        const nvToggle = document.getElementById('night-vision-toggle');
        const gallerySection = document.querySelector('.multimedia-gallery');
        const nvLabel = nvToggle.previousElementSibling; // Thẻ span "NIGHT VISION"

        nvToggle.addEventListener('click', () => {
            // 1. Chuyển đổi trạng thái nút
            nvToggle.classList.toggle('active');

            // 2. Kích hoạt hiệu ứng lên toàn bộ Section
            gallerySection.classList.toggle('nv-active');

            // 3. Làm sáng nhãn chữ
            nvLabel.classList.toggle('nv-text-active');

            // 4. Hiệu ứng âm thanh giả lập (Tùy chọn)
            if (nvToggle.classList.contains('active')) {
                console.log("Night Vision Engaged: Bíp...");
                // Bạn có thể thêm một tiếng bíp nhẹ tại đây
            }
        });
    });

    //----------------------------- section 4 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        const quoteText = "Sự xa xỉ thực sự không nằm ở những gì người khác thấy, mà ở cảm giác tĩnh lặng tuyệt đối khi bạn làm chủ một cung đường di sản.";
        const quoteElement = document.getElementById('expert-quote');
        let index = 0;
        let hasTyped = false;

        // 1. Hiệu ứng Typewriter khi cuộn tới
        function typeWriter() {
            if (index < quoteText.length) {
                quoteElement.innerHTML += quoteText.charAt(index);
                index++;
                setTimeout(typeWriter, 40); // Tốc độ gõ 40ms/chữ
            }
        }

        // 2. Observer để bắt đầu gõ khi Section hiện ra
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !hasTyped) {
                    typeWriter();
                    hasTyped = true;
                }
            });
        }, {
            threshold: 0.5
        });

        observer.observe(document.getElementById('expert-section'));

        // 3. Multi-layered Parallax (Depth Shift)
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const section = document.getElementById('expert-section');
            const sectionTop = section.offsetTop;

            if (scrolled > sectionTop - window.innerHeight) {
                const relativeScroll = scrolled - sectionTop;

                // Chân dung di chuyển chậm (tốc độ 0.1)
                const portrait = document.querySelector('.expert-portrait-wrap');
                portrait.style.transform = `translateY(${relativeScroll * 0.1}px)`;

                // Khối trích dẫn di chuyển nhanh hơn (tốc độ 0.15)
                const glass = document.querySelector('.quote-glass-container');
                glass.style.transform = `translateY(${relativeScroll * 0.05}px)`;
            }
        });
    });

    //----------------------------- section 5 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        const cursorXem = document.getElementById('custom-cursor-xem');
        const cards = document.querySelectorAll('.masterpiece-card');

        // 1. Theo dõi chuột cho Custom Cursor
        window.addEventListener('mousemove', (e) => {
            cursorXem.style.left = e.clientX + 'px';
            cursorXem.style.top = e.clientY + 'px';
        });

        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                cursorXem.style.transform = 'translate(-50%, -50%) scale(1)';
            });
            card.addEventListener('mouseleave', () => {
                cursorXem.style.transform = 'translate(-50%, -50%) scale(0)';
                card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg)`;
            });
        });
    });

    // 2. Hiệu ứng Magnetic (3D Tilt)
    function handleMagnetic(e, card) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        // Tính toán góc nghiêng (tối đa 10 độ)
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = (y - centerY) / 20;
        const rotateY = (centerX - x) / 20;

        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    }

    //----------------------------- section 6 ----------------------------- //
</script>

</html>