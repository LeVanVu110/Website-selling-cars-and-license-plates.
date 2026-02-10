<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://player.vimeo.com/api/player.js"></script>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        /* --- Typography & Masking --- */
        .hero-title {
            font-family: 'Playfair Display', serif;
            /* Serif cổ điển */
            font-size: clamp(3rem, 8vw, 7rem);
            font-weight: 300;
            letter-spacing: 0.15em;
            color: #fff;
            /* Kỹ thuật Text-Masking: Video chạy trong lòng chữ */
            background: url('https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExNHJqZ3R5Nnp6Ync0eG00bmJ4Z3R5Nnp6Ync0eG00bmJ4Z3R5Nnp6Ync0eG00bmJ4JmVwPXYxX2ludGVybmFsX2dpZl9ieV9pZCZjdD1n/3o7TKMGpxV72F0G9qM/giphy.gif');
            background-size: cover;
            background-position: center;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.2));
        }

        /* --- Liquid Gold Button --- */
        .liquid-btn {
            position: relative;
            padding: 20px 60px;
            background: transparent;
            border: 1px solid rgba(191, 149, 63, 0.4);
            color: white;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.4em;
            overflow: hidden;
            transition: all 0.5s ease;
        }

        .liquid-bg {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, #bf953f, #fcf6ba, #b38728);
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            z-index: 1;
        }

        .liquid-btn:hover {
            color: #000;
            border-color: #fcf6ba;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(191, 149, 63, 0.3);
        }

        .liquid-btn:hover .liquid-bg {
            top: 0;
        }

        /* --- Mobile Optimization --- */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
                letter-spacing: 0.1em;
            }

            #hero-video {
                display: none;
            }

            /* Mobile dùng cinemagraph nền */
            .absolute.inset-0.z-0 {
                background: url('https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExNHJqZ3R5Nnp6Ync0eG00bmJ4Z3R5Nnp6Ync0eG00bmJ4Z3R5Nnp6Ync0eG00bmJ4JmVwPXYxX2ludGVybmFsX2dpZl9ieV9pZCZjdD1n/3o7TKMGpxV72F0G9qM/giphy.gif') center/cover;
            }
        }

        /* ----------------------------- section 2 ----------------------------- */
        .hall-of-icons {
            background: #0a0a0a;
            background-image:
                linear-gradient(30deg, #0f0f0f 12%, transparent 12.5%, transparent 87%, #0f0f0f 87.5%, #0f0f0f),
                linear-gradient(150deg, #0f0f0f 12%, transparent 12.5%, transparent 87%, #0f0f0f 87.5%, #0f0f0f),
                linear-gradient(30deg, #0f0f0f 12%, transparent 12.5%, transparent 87%, #0f0f0f 87.5%, #0f0f0f),
                linear-gradient(150deg, #0f0f0f 12%, transparent 12.5%, transparent 87%, #0f0f0f 87.5%, #0f0f0f),
                linear-gradient(60deg, #151515 25%, transparent 25.5%, transparent 75%, #151515 75%, #151515),
                linear-gradient(60deg, #151515 25%, transparent 25.5%, transparent 75%, #151515 75%, #151515);
            background-size: 80px 140px;
            /* Vân kim cương chìm */
            position: relative;
            padding: 100px 0;
        }

        /* Hiệu ứng Floating cho Logo */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .brand-card {
            perspective: 1000px;
            animation: float 4s ease-in-out infinite;
        }

        .brand-logo-container {
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            filter: grayscale(1) brightness(1.5) contrast(1.2);
            /* Đưa về Monochrome Silver */
            opacity: 0.6;
        }

        .brand-card:hover .brand-logo-container {
            filter: grayscale(0) brightness(1);
            opacity: 1;
            transform: scale(1.1) rotateY(10deg);
            drop-shadow: 0 0 25px rgba(191, 149, 63, 0.6);
        }

        /* Line-art Gold Effect */
        .gold-line-art {
            fill: none;
            stroke: #bf953f;
            stroke-width: 1;
            transition: all 0.5s ease;
        }

        .brand-card:hover .gold-line-art {
            stroke: #fcf6ba;
            filter: drop-shadow(0 0 8px #bf953f);
        }

        /* Mobile Infinite Scroll */
        @media (max-width: 768px) {
            .marquee-container {
                display: flex;
                overflow-x: auto;
                white-space: nowrap;
                scrollbar-width: none;
                gap: 40px;
                padding: 20px;
            }

            .marquee-container::-webkit-scrollbar {
                display: none;
            }

            .brand-card {
                flex: 0 0 150px;
            }
        }

        /* ----------------------------- section 3 ----------------------------- */
        .collection-grid {
            background: #000;
            padding: 100px 0;
        }

        /* Masonry Grid Setup */
        .luxury-masonry {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }

        /* Luxury Card Frame */
        .luxury-frame {
            position: relative;
            background: #050505;
            border: 1px solid #1a1a1a;
            overflow: hidden;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            cursor: none;
            /* Sẽ dùng Custom Cursor Gold */
        }

        /* Viền Piano Black & Gold Line */
        .luxury-frame::before {
            content: '';
            position: absolute;
            inset: 0;
            border: 1px solid transparent;
            transition: all 0.4s;
            z-index: 10;
            pointer-events: none;
        }

        .luxury-frame:hover::before {
            border: 1px solid #bf953f;
            box-shadow: inset 0 0 20px rgba(191, 149, 63, 0.2);
        }

        /* Hiệu ứng Pan/Perspective cho ảnh */
        .car-image-wrapper {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
            transition: transform 0.5s ease-out;
        }

        .car-image-wrapper img {
            width: 110%;
            /* Phóng lớn nhẹ để có không gian Pan */
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.2, 0, 0.2, 1);
        }

        .luxury-frame:hover .car-image-wrapper img {
            transform: scale(1.05) translateX(-20px);
        }

        /* Info Overlay */
        .luxury-info {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 40px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            transform: translateY(100px);
            opacity: 0;
            backdrop-filter: blur(0px);
            transition: all 0.5s ease;
            z-index: 20;
        }

        .luxury-frame:hover .luxury-info {
            transform: translateY(0);
            opacity: 1;
            backdrop-filter: blur(10px);
        }

        /* Biển số "bay" vào */
        .matching-plate {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(2);
            opacity: 0;
            transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            padding: 2px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            font-weight: bold;
            color: black;
            font-family: sans-serif;
            z-index: 15;
        }

        .luxury-frame.plate-active .matching-plate {
            top: 75%;
            /* Vị trí hốc biển số */
            transform: translate(-50%, -50%) scale(0.6);
            opacity: 1;
        }

        /* Mobile Tweak */
        @media (max-width: 1024px) {
            .luxury-masonry {
                grid-template-columns: 1fr;
            }

            .car-image-wrapper {
                height: 400px;
            }
        }

        /* ----------------------------- section 4 ----------------------------- */
        .bespoke-experience {
            background: #0d0d0d;
            padding: 80px 0;
            overflow: hidden;
        }

        /* Sân khấu trung tâm */
        .config-stage {
            position: relative;
            min-height: 450px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Các lớp xe chồng lên nhau */
        .car-layer {
            position: absolute;
            width: 100%;
            max-width: 800px;
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
            filter: drop-shadow(0 20px 50px rgba(0, 0, 0, 0.8));
        }

        .car-layer.active {
            opacity: 1;
        }

        /* Vị trí biển số trên xe */
        .plate-on-car {
            position: absolute;
            bottom: 22%;
            /* Căn chỉnh theo ảnh xe Maybach */
            left: 50%;
            transform: translateX(-50%) scale(0.4);
            z-index: 50;
            background: white;
            padding: 5px 15px;
            border-radius: 4px;
            font-weight: bold;
            color: #333;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
            border: 1px solid #999;
            display: none;
            /* Hiện khi đã chọn */
        }

        .plate-on-car.glow {
            animation: plateSnap 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: block;
        }

        @keyframes plateSnap {
            0% {
                transform: translateX(-50%) scale(1.5);
                opacity: 0;
                filter: brightness(3);
            }

            100% {
                transform: translateX(-50%) scale(0.4);
                opacity: 1;
                filter: brightness(1);
            }
        }

        /* Bảng điều khiển */
        .config-panel {
            background: rgba(20, 20, 20, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(191, 149, 63, 0.2);
            border-radius: 20px;
        }

        .color-dot {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s;
        }

        .color-dot.active {
            border-color: #bf953f;
            transform: scale(1.2);
        }

        /* Danh sách biển số VIP */
        .plate-item {
            background: linear-gradient(135deg, #fff 0%, #eee 100%);
            color: #000;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 10px;
            cursor: grab;
            transition: all 0.3s;
            border-left: 4px solid #bf953f;
            user-select: none;
        }

        .plate-item:hover {
            transform: translateX(10px);
            background: #fff;
        }

        /* Nút Shimmer */
        .btn-shimmer {
            background: linear-gradient(90deg, #bf953f, #fcf6ba, #bf953f);
            background-size: 200% auto;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            to {
                background-position: 200% center;
            }
        }

        /* ----------------------------- section 5 ----------------------------- */
        .vip-concierge {
            background: #080808;
            position: relative;
            padding: 120px 0;
            border-top: 1px solid rgba(191, 149, 63, 0.15);
        }

        /* Map Container Refinement */
        .map-digital-canvas {
            position: relative;
            background: radial-gradient(circle at center, #151515 0%, #080808 100%);
            border: 1px solid rgba(255, 255, 255, 0.03);
            border-radius: 24px;
            height: 500px;
            overflow: hidden;
            box-shadow: inset 0 0 50px rgba(0, 0, 0, 0.5);
        }

        /* Hiệu ứng vẽ bản đồ khi cuộn tới */
        .vietnam-svg {
            height: 90%;
            width: auto;
            opacity: 0.15;
            filter: drop-shadow(0 0 15px rgba(191, 149, 63, 0.2));
            transition: opacity 1s ease;
        }

        .vip-concierge:hover .vietnam-svg {
            opacity: 0.25;
        }

        /* Điểm Showroom Pulse - Cải tiến độ sáng */
        .dot-pulse {
            position: absolute;
            width: 14px;
            height: 14px;
            background: #bf953f;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            box-shadow: 0 0 20px rgba(191, 149, 63, 0.8);
        }

        .dot-pulse::after {
            content: '';
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            border: 1px solid #bf953f;
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        /* Showroom Card Glassmorphism */
        .showroom-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .showroom-card:hover {
            background: rgba(30, 30, 30, 0.8);
            border-color: #bf953f;
            transform: translateX(10px);
        }

        /* Priority Button - Hiệu ứng ánh kim xoay quanh */
        .priority-border-wrap {
            position: relative;
            padding: 2px;
            background: linear-gradient(90deg, #bf953f, transparent, #fcf6ba, transparent);
            background-size: 300% 300%;
            border-radius: 50px;
            animation: gradient-move 4s linear infinite;
        }

        @keyframes gradient-move {
            0% {
                background-position: 0% 50%;
            }

            100% {
                background-position: 100% 50%;
            }
        }

        .priority-inner {
            background: #080808;
            color: white;
            padding: 14px 28px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        /* Human Touch Info */
        .concierge-info {
            border-left: 2px solid #bf953f;
            background: linear-gradient(90deg, rgba(191, 149, 63, 0.05), transparent);
        }

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="hero-showroom" class="relative w-full h-screen overflow-hidden bg-black">

        <div class="absolute inset-0 z-0 overflow-hidden">
            <div id="video-placeholder" class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
                style="background-image: url('https://images.pexels.com/photos/3311574/pexels-photo-3311574.jpeg?auto=compress&cs=tinysrgb&w=1920');">
            </div>

            <div id="vimeo-wrapper" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[115%] h-[115%] pointer-events-none">
                <iframe
                    id="vimeo-player"
                    src="https://player.vimeo.com/video/396260528?h=8586a613a2&autoplay=1&loop=1&background=1&muted=1"
                    class="w-full h-full object-cover"
                    frameborder="0"
                    allow="autoplay; fullscreen; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>

            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-transparent to-black"></div>
        </div>

        <div class="relative z-10 h-full flex flex-col items-center justify-between py-20 px-6">
            <div class="text-center mt-10">
                <h1 class="hero-title opacity-0 translate-y-10">KIỆT TÁC DI ĐỘNG</h1>
                <p class="text-[10px] text-[#bf953f] tracking-[0.6em] uppercase mt-4 opacity-0 transition-all duration-1000 delay-500" id="sub-headline">
                    The Pinnacle of Automotive Art
                </p>
            </div>

            <div id="lens-flare" class="absolute top-1/2 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-[#bf953f] to-transparent -translate-y-1/2 scale-x-0 opacity-0 pointer-events-none"></div>

            <div class="flex flex-col items-center gap-8">
                <button id="btn-showroom" class="liquid-btn group">
                    <span class="relative z-10">VÀO SHOWROOM</span>
                    <div class="liquid-bg"></div>
                </button>

                <div class="flex items-center gap-6">
                    <button id="toggle-sound" class="text-white/40 hover:text-[#bf953f] transition-colors">
                        <i class="ri-volume-mute-line text-xl"></i>
                    </button>
                    <div class="w-[1px] h-12 bg-gradient-to-b from-[#bf953f] to-transparent animate-bounce"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section class="hall-of-icons overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20 opacity-0 translate-y-10 transition-all duration-1000" id="brand-header">
                <span class="text-[#bf953f] italic font-serif tracking-widest text-sm block mb-2">Đối tác của những huyền thoại</span>
                <h2 class="text-white text-3xl font-light tracking-[0.4em] uppercase">The Hall of Icons</h2>
            </div>

            <div class="marquee-container flex flex-wrap justify-center gap-12 md:gap-20">
                <div class="brand-card group cursor-pointer" onclick="filterBrand('Rolls-Royce')" style="animation-delay: 0s;">
                    <div class="brand-logo-container flex flex-col items-center">
                        <img src="https://www.carlogos.org/car-logos/rolls-royce-logo.png" alt="Rolls Royce" class="h-20 object-contain mb-4">
                        <div class="text-center">
                            <span class="text-[10px] text-[#bf953f] tracking-widest block opacity-0 group-hover:opacity-100 transition-opacity">12 CHIẾC SẴN CÓ</span>
                            <p class="text-[9px] text-white/40 tracking-tighter uppercase mt-1">Biển ngũ quý gợi ý</p>
                        </div>
                    </div>
                </div>

                <div class="brand-card group cursor-pointer" onclick="filterBrand('Bentley')" style="animation-delay: 0.5s;">
                    <div class="brand-logo-container flex flex-col items-center">
                        <img src="https://www.carlogos.org/car-logos/bentley-logo.png" alt="Bentley" class="h-20 object-contain mb-4">
                        <div class="text-center">
                            <span class="text-[10px] text-[#bf953f] tracking-widest block opacity-0 group-hover:opacity-100 transition-opacity">08 CHIẾC SẴN CÓ</span>
                            <p class="text-[9px] text-white/40 tracking-tighter uppercase mt-1">Lộc phát (68-86)</p>
                        </div>
                    </div>
                </div>

                <div class="brand-card group cursor-pointer" onclick="filterBrand('Porsche')" style="animation-delay: 1s;">
                    <div class="brand-logo-container flex flex-col items-center">
                        <img src="https://www.carlogos.org/car-logos/porsche-logo.png" alt="Porsche" class="h-20 object-contain mb-4">
                        <div class="text-center">
                            <span class="text-[10px] text-[#bf953f] tracking-widest block opacity-0 group-hover:opacity-100 transition-opacity">15 CHIẾC SẴN CÓ</span>
                            <p class="text-[9px] text-white/40 tracking-tighter uppercase mt-1">Biển thần tài</p>
                        </div>
                    </div>
                </div>

                <div class="brand-card group cursor-pointer" onclick="filterBrand('Lamborghini')" style="animation-delay: 1.5s;">
                    <div class="brand-logo-container flex flex-col items-center">
                        <img src="https://www.carlogos.org/car-logos/lamborghini-logo.png" alt="Lamborghini" class="h-20 object-contain mb-4">
                        <div class="text-center">
                            <span class="text-[10px] text-[#bf953f] tracking-widest block opacity-0 group-hover:opacity-100 transition-opacity">05 CHIẾC SẴN CÓ</span>
                            <p class="text-[9px] text-white/40 tracking-tighter uppercase mt-1">Biển sảnh tiến</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section class="collection-grid">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-16">
                <h2 class="text-white text-4xl font-light tracking-[0.3em] uppercase mb-4">Phòng Trưng Bày Tuyệt Phẩm</h2>
                <div class="w-24 h-[1px] bg-[#bf953f]"></div>
            </div>

            <div class="luxury-masonry">

                <div class="luxury-frame group" data-plate="51K-888.88">
                    <div class="car-image-wrapper">
                        <img src="https://images.pexels.com/photos/6894429/pexels-photo-6894429.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            alt="Bentley Flying Spur"
                            class="progressive-load blur-lg">

                        <div class="absolute top-6 left-6 z-30 flex items-center gap-4">
                            <i class="ri-vip-crown-fill text-[#bf953f] text-xl" title="Full Option"></i>
                            <div class="bg-black/50 backdrop-blur-md border border-[#bf953f]/30 px-3 py-1 rounded-full">
                                <span class="text-[10px] text-[#bf953f] tracking-widest">360° VIEW</span>
                            </div>
                        </div>

                        <button class="md:hidden absolute top-6 right-6 w-12 h-12 bg-[#bf953f] rounded-full flex items-center justify-center text-black shadow-lg shadow-[#bf953f]/40 z-30">
                            <i class="ri-phone-line text-xl font-bold"></i>
                        </button>

                        <div class="matching-plate">51K-888.88</div>
                    </div>

                    <div class="luxury-info">
                        <div class="flex justify-between items-end mb-6">
                            <div>
                                <p class="text-[#bf953f] text-xs tracking-[0.2em] uppercase mb-2">Độc bản duy nhất</p>
                                <h3 class="text-white text-2xl font-light tracking-wider">Bentley Flying Spur</h3>
                            </div>
                            <div class="text-right">
                                <p class="text-white/40 text-[10px] uppercase mb-1">Giá trị định danh</p>
                                <p class="text-[#bf953f] text-lg">Liên hệ nhận đặc quyền</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-6 border-t border-white/10">
                            <button class="bg-white text-black px-8 py-3 text-[10px] font-bold tracking-[0.2em] hover:bg-[#bf953f] hover:text-white transition-colors">
                                XEM ĐẶC QUYỀN
                            </button>
                            <span class="text-white/30 text-[9px] italic">Gợi ý kết hợp cùng biển số 51K-888.88</span>
                        </div>
                    </div>
                </div>

                <div class="luxury-frame group mt-20" data-plate="30H-999.99">
                    <div class="car-image-wrapper">
                        <img src="https://images.pexels.com/photos/3764984/pexels-photo-3764984.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            alt="Rolls-Royce Ghost">
                        <div class="matching-plate">30H-999.99</div>
                    </div>
                    <div class="luxury-info">
                        <div class="flex justify-between items-end mb-6">
                            <div>
                                <p class="text-[#bf953f] text-xs tracking-[0.2em] uppercase mb-2">Sẵn sàng bàn giao</p>
                                <h3 class="text-white text-2xl font-light tracking-wider">Rolls-Royce Ghost</h3>
                            </div>
                            <p class="text-[#bf953f] text-lg">Tầm vóc đế vương</p>
                        </div>
                        <button class="w-full border border-[#bf953f] text-[#bf953f] py-4 text-[10px] font-bold tracking-[0.4em] hover:bg-[#bf953f] hover:text-black transition-all">
                            KHÁM PHÁ CHI TIẾT
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section class="bespoke-experience">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex flex-col md:flex-row gap-12 items-center">

                <div class="w-full md:w-2/3">
                    <div class="text-left mb-8">
                        <span class="text-[#bf953f] text-xs tracking-[0.4em] uppercase">The Configurator Lab</span>
                        <h2 class="text-white text-3xl font-light mt-2">THIẾT KẾ ĐỘC BẢN</h2>
                    </div>

                    <img src="https://images.remote.com/images/car-back-black.png"
                        class="car-layer active" id="car-black">

                    <div class="config-stage" id="capture-area">
                        <img src="https://images.pexels.com/photos/20562635/pexels-photo-20562635.png"
                            class="car-layer" id="car-white" style="opacity: 0;">

                        <img src="https://images.pexels.com/photos/112460/pexels-photo-112460.jpeg?auto=compress&cs=tinysrgb&w=1260"
                            class="car-layer active" id="car-black">

                        <div class="plate-on-car" id="target-plate">888.88</div>
                    </div>
                </div>

                <div class="w-full md:w-1/3">
                    <div class="config-panel p-8">
                        <div class="mb-10">
                            <h4 class="text-white text-xs tracking-widest uppercase mb-6">1. Chọn sắc diện (Color)</h4>
                            <div class="flex gap-4">
                                <div class="color-dot active" style="background: #000;" onclick="changeColor('black', this)"></div>
                                <div class="color-dot" style="background: #1a4d3c;" onclick="changeColor('emerald', this)"></div>
                                <div class="color-dot" style="background: #4a0e0e;" onclick="changeColor('ruby', this)"></div>
                                <div class="color-dot" style="background: #bf953f;" onclick="changeColor('gold', this)"></div>
                            </div>
                        </div>

                        <div class="mb-10">
                            <h4 class="text-white text-xs tracking-widest uppercase mb-6">2. Định danh cá nhân (Plate)</h4>
                            <div class="max-h-[200px] overflow-y-auto pr-2 custom-scrollbar">
                                <div class="plate-item" draggable="true" ondragstart="drag(event)">51K-999.99</div>
                                <div class="plate-item" draggable="true" ondragstart="drag(event)">30H-888.88</div>
                                <div class="plate-item" draggable="true" ondragstart="drag(event)">66A-666.66</div>
                                <div class="plate-item" draggable="true" ondragstart="drag(event)">51L-777.77</div>
                            </div>
                            <p class="text-white/40 text-[9px] mt-4 italic">* Kéo và thả biển số trực tiếp lên xe</p>
                        </div>

                        <button class="w-full py-4 text-[10px] font-bold tracking-[0.2em] text-white border border-white/20 hover:border-[#bf953f] transition-all flex items-center justify-center gap-3">
                            <i class="ri-camera-lens-line"></i> CHỤP ẢNH TÁC PHẨM
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-20 p-10 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="text-center md:text-left">
                    <p class="text-white/60 text-sm mb-2">Combo định danh độc bản của bạn:</p>
                    <h3 class="text-[#bf953f] text-2xl font-light italic">
                        <span id="res-car">Mercedes-Maybach</span> + <span id="res-plate">Chưa chọn biển</span>
                    </h3>
                </div>
                <button class="btn-shimmer px-12 py-5 text-black font-black text-xs tracking-[0.3em] uppercase rounded-sm shadow-2xl shadow-[#bf953f]/20">
                    NHẬN BÁO GIÁ TRỌN GÓI
                </button>
            </div>

        </div>
    </section>

    <!-- ----------------------------- section 5 -----------------------------  -->
    <!-- <section class="vip-concierge">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex flex-col lg:flex-row gap-16">

                <div class="w-full lg:w-1/2">
                    <div class="mb-10">
                        <span class="text-[#bf953f] text-xs tracking-[0.5em] uppercase">Global Network</span>
                        <h2 class="text-white text-3xl font-light mt-2 uppercase tracking-widest">Hệ thống Showroom</h2>
                    </div>

                    <div class="relative bg-[#111] rounded-2xl p-4 border border-white/5 mb-10 overflow-hidden flex items-center justify-center" style="height: 450px;">

                        <svg viewBox="0 0 400 600" class="h-full w-auto opacity-20 filter drop-shadow-[0_0_10px_rgba(191,149,63,0.3)]">
                            <path d="M180,50 L190,45 L210,60 L205,80 L190,100 L170,120 L160,150 L175,180 L185,220 L195,250 L220,280 L250,320 L260,360 L270,420 L265,480 L240,520 L210,540 L180,550 L150,545 L120,530 L100,500 L110,470 L140,460 L160,455 L180,440 L200,410 L210,380 L200,340 L180,310 L160,280 L140,250 L130,220 L145,180 L150,140 L140,100 L155,70 Z"
                                fill="none" stroke="#bf953f" stroke-width="1.5" />
                            <circle cx="300" cy="350" r="3" fill="#bf953f" />
                            <circle cx="310" cy="360" r="2" fill="#bf953f" />
                            <circle cx="280" cy="450" r="4" fill="#bf953f" />
                        </svg>

                        <div class="dot-pulse" style="top: 18%; left: 47%;" onclick="focusShowroom('hanoi')" title="Hà Nội"></div>
                        <div class="dot-pulse" style="top: 52%; left: 63%;" onclick="focusShowroom('danang')" title="Đà Nẵng"></div>
                        <div class="dot-pulse" style="top: 82%; left: 54%;" onclick="focusShowroom('hcm')" title="TP.HCM"></div>

                        <div class="absolute bottom-6 left-6 text-white/40 text-[10px]">
                            <i class="ri-information-line"></i> Chạm vào các điểm để xem chi tiết chi nhánh
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="showroom-card p-4 flex gap-6 items-center rounded-lg" id="sr-hanoi">
                            <div class="showroom-thumb w-32 rounded flex-shrink-0">
                                <img src="https://images.pexels.com/photos/15720760/pexels-photo-15720760/free-photo-of-thanh-ph-den-toa-nha-kinh.jpeg?auto=compress&cs=tinysrgb&w=150" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow">
                                <h4 class="text-white font-medium mb-1">Elite Showroom Hà Nội</h4>
                                <p class="text-white/40 text-[11px] mb-3">Tòa nhà Heritage, Tây Hồ, Hà Nội</p>
                                <a href="#" class="text-[#bf953f] text-[10px] tracking-widest uppercase hover:underline">Google Maps <i class="ri-arrow-right-up-line"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 flex flex-col justify-between">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-[#bf953f]/20 to-transparent blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                        <div class="relative bg-[#0a0a0a] border border-white/10 p-10 rounded-2xl">
                            <div class="mb-10">
                                <h3 class="text-white text-2xl font-serif italic mb-4">Đặc quyền Trợ lý riêng 24/7</h3>
                                <p class="text-white/50 text-sm leading-relaxed">
                                    Chúng tôi không chỉ bán xe, chúng tôi bàn giao một phong cách sống cao thượng. Mỗi khách hàng là một chủ thể duy nhất với đội ngũ quản gia phục vụ riêng biệt.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                                <div class="service-pillar">
                                    <div class="pillar-icon"><i class="ri-truck-line text-[#bf953f]"></i></div>
                                    <h5 class="text-white text-sm uppercase tracking-widest mb-2">Giao xe tận phủ</h5>
                                    <p class="text-white/30 text-[11px]">Vận chuyển chuyên dụng, bảo mật tuyệt đối.</p>
                                </div>
                                <div class="service-pillar">
                                    <div class="pillar-icon"><i class="ri-customer-service-2-line text-[#bf953f]"></i></div>
                                    <h5 class="text-white text-sm uppercase tracking-widest mb-2">Thủ tục thần tốc</h5>
                                    <p class="text-white/30 text-[11px]">Định danh, đăng ký biển số VIP trong 24h.</p>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 items-center">
                                <div class="priority-line w-full sm:w-auto h-16 rounded-full flex items-center justify-center p-[2px]">
                                    <span class="rounded-full flex items-center px-10 gap-4 cursor-pointer">
                                        <i class="ri-phone-fill text-[#bf953f] animate-pulse"></i>
                                        <span class="text-white font-bold tracking-[0.2em] text-sm">HOTLINE: 1900 XXXX</span>
                                    </span>
                                </div>
                                <button class="bg-[#bf953f] text-black px-8 py-4 rounded-full text-[11px] font-black tracking-widest hover:bg-white transition-colors">
                                    ĐẶT LỊCH HẸN RIÊNG
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex items-center gap-6 p-6 bg-white/5 rounded-xl border-l-4 border-[#bf953f]">
                        <img src="https://images.pexels.com/photos/3778603/pexels-photo-3778603.jpeg?auto=compress&cs=tinysrgb&w=100"
                            class="w-16 h-16 rounded-full object-cover grayscale hover:grayscale-0 transition-all cursor-pointer" alt="VIP Concierge">
                        <div>
                            <p class="text-white text-xs italic">"Sự hài lòng của Quý khách là sứ mệnh của chúng tôi."</p>
                            <p class="text-[#bf953f] text-[10px] uppercase tracking-widest mt-2">Mr. Alexander Nguyen - Trưởng bộ phận Đặc quyền</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> -->
    <section class="vip-concierge">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-16">

                <div class="w-full lg:w-1/2">
                    <div class="mb-12">
                        <span class="text-[#bf953f] text-xs tracking-[0.5em] uppercase block mb-2">Heritage Network</span>
                        <h2 class="text-white text-4xl font-light tracking-widest uppercase">Mạng lưới Showroom</h2>
                    </div>

                    <div class="map-digital-canvas flex items-center justify-center mb-10">
                        <svg viewBox="0 0 400 600" class="vietnam-svg">
                            <path d="M180,50 L190,45 L210,60 L205,80 L190,100 L170,120 L160,150 L175,180 L185,220 L195,250 L220,280 L250,320 L260,360 L270,420 L265,480 L240,520 L210,540 L180,550 L150,545 L120,530 L100,500 L110,470 L140,460 L160,455 L180,440 L200,410 L210,380 L200,340 L180,310 L160,280 L140,250 L130,220 L145,180 L150,140 L140,100 L155,70 Z"
                                fill="none" stroke="#bf953f" stroke-width="2" />
                            <circle cx="310" cy="360" r="4" fill="#bf953f" opacity="0.5" />
                            <circle cx="290" cy="450" r="5" fill="#bf953f" opacity="0.5" />
                        </svg>

                        <div class="dot-pulse" style="top: 15%; left: 47%;" onclick="focusSR('hanoi')"></div>
                        <div class="dot-pulse" style="top: 48%; left: 63%;" onclick="focusSR('danang')"></div>
                        <div class="dot-pulse" style="top: 82%; left: 54%;" onclick="focusSR('hcm')"></div>
                    </div>

                    <div class="space-y-4">
                        <div class="showroom-card p-6 flex gap-6 items-center" id="sr-hanoi">
                            <div class="w-2 bg-[#bf953f] h-12 rounded-full"></div>
                            <div>
                                <h4 class="text-white tracking-widest uppercase text-sm">Elite Hanoi Central</h4>
                                <p class="text-white/40 text-[11px] mt-1 italic">Tòa nhà Heritage, Tây Hồ, Hà Nội</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 flex flex-col justify-center">
                    <div class="bg-[#111] border border-white/5 p-12 rounded-3xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#bf953f]/5 blur-3xl rounded-full"></div>

                        <h3 class="text-white text-3xl font-serif italic mb-8">Đặc quyền Quản gia 24/7</h3>
                        <p class="text-white/50 leading-relaxed mb-12">Chúng tôi không chỉ bàn giao xe, chúng tôi bàn giao sự an tâm tuyệt đối. Mọi yêu cầu của Quý khách sẽ được xử lý bởi đội ngũ quản gia chuyên biệt.</p>

                        <div class="grid grid-cols-2 gap-10 mb-12">
                            <div class="group">
                                <i class="ri-shield-flash-line text-[#bf953f] text-3xl mb-4 block"></i>
                                <h5 class="text-white text-xs tracking-widest uppercase mb-2">Bảo mật 6 sao</h5>
                                <p class="text-white/30 text-[10px]">Giao xe kín đáo bằng xe chuyên dụng.</p>
                            </div>
                            <div class="group">
                                <i class="ri-seedling-line text-[#bf953f] text-3xl mb-4 block"></i>
                                <h5 class="text-white text-xs tracking-widest uppercase mb-2">Hậu mãi trọn đời</h5>
                                <p class="text-white/30 text-[10px]">Bảo dưỡng tận nơi theo yêu cầu cá nhân.</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-6 items-center">
                            <div class="priority-border-wrap">
                                <div class="priority-inner">
                                    <i class="ri-phone-fill text-[#bf953f]"></i>
                                    <span>HOTLINE VIP: 1900.XXXX</span>
                                </div>
                            </div>
                            <button class="bg-[#bf953f] text-black font-black px-10 py-4 rounded-full text-[10px] tracking-[0.2em] hover:bg-white transition-all">
                                ĐẶT LỊCH HẸN
                            </button>
                        </div>
                    </div>

                    <div class="concierge-info mt-12 p-8 flex items-center gap-6">
                        <div class="w-16 h-16 rounded-full border border-[#bf953f] p-1">
                            <img src="https://images.pexels.com/photos/3778603/pexels-photo-3778603.jpeg?auto=compress&cs=tinysrgb&w=100" class="w-full h-full rounded-full object-cover grayscale">
                        </div>
                        <div>
                            <p class="text-white/80 text-xs italic">"Sứ mệnh của chúng tôi là phục vụ những tiêu chuẩn khắt khe nhất."</p>
                            <p class="text-[#bf953f] text-[10px] uppercase tracking-[0.3em] mt-2 font-bold">Alexander Nguyen — Director of VIP Services</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include('footer.php'); ?>
</body>
<script>
    //----------------------------- section 1 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Khai báo các phần tử
        const placeholder = document.getElementById('video-placeholder');
        const title = document.querySelector('.hero-title');
        const subHeadline = document.getElementById('sub-headline');
        const flare = document.getElementById('lens-flare');
        const heroContent = document.querySelector('.relative.z-10');
        const soundBtn = document.getElementById('toggle-sound');

        // Đã sửa: Sử dụng ID để tránh lỗi selector với ký tự "/" của Tailwind
        const vimeoWrapper = document.getElementById('vimeo-wrapper');
        const vimeoIframe = document.getElementById('vimeo-player');

        // Khởi tạo Vimeo Player từ SDK
        const player = new Vimeo.Player(vimeoIframe);

        /**
         * 1. XỬ LÝ HIỆU ỨNG KHAI MÀN (ENTRANCE)
         */
        const triggerEntrance = () => {
            if (placeholder) placeholder.style.opacity = '0';

            if (flare) {
                flare.style.transition = 'all 1.2s cubic-bezier(0.23, 1, 0.32, 1)';
                flare.style.opacity = '1';
                flare.style.transform = 'translateY(-50%) scaleX(1)';

                setTimeout(() => {
                    flare.style.opacity = '0';
                    if (title) {
                        title.style.transition = 'all 2.5s cubic-bezier(0.19, 1, 0.22, 1)';
                        title.style.opacity = '1';
                        title.style.transform = 'translateY(0)';
                    }
                    if (subHeadline) {
                        subHeadline.style.transition = 'all 2s ease-out 0.5s';
                        subHeadline.style.opacity = '1';
                    }
                }, 800);
            }
        };

        // Kích hoạt sau 2s khi video đã buffer ổn định
        setTimeout(triggerEntrance, 2000);

        /**
         * 2. HIỆU ỨNG PARALLAX KHI CUỘN TRANG
         */
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;

            // Video Wrapper Parallax
            if (vimeoWrapper) {
                vimeoWrapper.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.3}px))`;
            }

            // Content Parallax (Chữ bay lên và mờ dần)
            if (heroContent) {
                heroContent.style.transform = `translateY(${scrolled * -0.15}px)`;
                heroContent.style.opacity = `${1 - scrolled / 800}`;
            }
        });

        /**
         * 3. XỬ LÝ ÂM THANH
         */
        let isMuted = true;
        if (soundBtn) {
            soundBtn.addEventListener('click', () => {
                isMuted = !isMuted;

                // Cập nhật giao diện nút bấm
                soundBtn.innerHTML = isMuted ?
                    '<i class="ri-volume-mute-line text-xl"></i>' :
                    '<i class="ri-volume-up-line text-xl text-[#bf953f]"></i>';

                if (isMuted) {
                    player.setVolume(0);
                } else {
                    player.setVolume(1);
                    // Một số trình duyệt tự động pause video khi bật tiếng, nên cần ép Play lại
                    player.play();
                }
            });
        }
    });

    //----------------------------- section 2 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        const brandHeader = document.getElementById('brand-header');
        const brandCards = document.querySelectorAll('.brand-card');

        // 1. Intersection Observer để kích hoạt hiệu ứng Entrance
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Hiện Header
                    brandHeader.classList.remove('opacity-0', 'translate-y-10');

                    // Hiện Logo kiểu Domino
                    brandCards.forEach((card, index) => {
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0) rotateX(0)';
                        }, index * 200);
                    });
                }
            });
        }, {
            threshold: 0.3
        });

        observer.observe(document.querySelector('.hall-of-icons'));

        // 2. Âm thanh khi Hover (Hành động thực tế cần file audio cực ngắn)
        const hoverSound = new Audio('');
        hoverSound.volume = 0.1;

        brandCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                hoverSound.currentTime = 0;
                hoverSound.play().catch(() => {}); // Tránh lỗi autoplay trình duyệt
            });
        });
    });

    /**
     * 4. Điểm chạm chuyển đổi (Brand Link)
     */
    function filterBrand(brandName) {
        console.log(`Đang lọc xe hãng: ${brandName}`);

        // Tạo hiệu ứng chuyển cảnh mờ dần trước khi điều hướng
        // document.body.style.opacity = '0.5';
        // document.body.style.transition = '0.5s';

        setTimeout(() => {
            // Chuyển hướng đến trang showroom với tham số hãng
            // window.location.href = `showroom.php?brand=${brandName}&suggest_plate=true`;// bật lại khi chuyển trang
        }, 500);
    }

    //----------------------------- section 3 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        const carCards = document.querySelectorAll('.luxury-frame');

        carCards.forEach(card => {
            let plateTimer;

            // 1. Mouse Follow Effect (3D Tilt)
            card.addEventListener('mousemove', (e) => {
                if (window.innerWidth < 1024) return;

                const {
                    left,
                    top,
                    width,
                    height
                } = card.getBoundingClientRect();
                const x = (e.clientX - left) / width - 0.5;
                const y = (e.clientY - top) / height - 0.5;

                const img = card.querySelector('.car-image-wrapper img');
                img.style.transform = `scale(1.1) translate(${x * 30}px, ${y * 30}px) rotateX(${-y * 5}deg) rotateY(${x * 5}deg)`;
            });

            card.addEventListener('mouseleave', () => {
                const img = card.querySelector('.car-image-wrapper img');
                img.style.transform = `scale(1) translate(0, 0)`;

                // Reset biển số
                card.classList.remove('plate-active');
                clearTimeout(plateTimer);
            });

            // 2. Matching Plate Animation (Sau 2 giây dừng chuột)
            card.addEventListener('mouseenter', () => {
                plateTimer = setTimeout(() => {
                    card.classList.add('plate-active');
                }, 2000);
            });

            // 3. Progressive Loading (Xử lý ảnh mờ sang nét)
            const img = card.querySelector('.progressive-load');
            if (img) {
                const highRes = new Image();
                highRes.src = img.src.replace('&w=10', '&w=1260'); // Giả lập load ảnh chất lượng cao
                highRes.onload = () => {
                    img.classList.remove('blur-lg');
                }
            }
        });

        // 4. Mobile: Double Tap to Like
        let lastTap = 0;
        carCards.forEach(card => {
            card.addEventListener('touchend', (e) => {
                const currentTime = new Date().getTime();
                const tapLength = currentTime - lastTap;
                if (tapLength < 300 && tapLength > 0) {
                    showHeartEffect(e, card);
                }
                lastTap = currentTime;
            });
        });

        function showHeartEffect(e, card) {
            const heart = document.createElement('i');
            heart.className = 'ri-heart-fill absolute text-[#bf953f] text-6xl z-50 transition-all duration-700 opacity-0';
            heart.style.top = '50%';
            heart.style.left = '50%';
            heart.style.transform = 'translate(-50%, -50%) scale(0)';

            card.appendChild(heart);

            setTimeout(() => {
                heart.style.transform = 'translate(-50%, -50%) scale(1.5)';
                heart.style.opacity = '1';
            }, 10);

            setTimeout(() => {
                heart.style.transform = 'translate(-50%, -50%) scale(2)';
                heart.style.opacity = '0';
                setTimeout(() => heart.remove(), 700);
            }, 800);
        }
    });

    //----------------------------- section 4 ----------------------------- //
    function changeColor(color, element) {
        // 1. Update UI dot
        document.querySelectorAll('.color-dot').forEach(dot => dot.classList.remove('active'));
        element.classList.add('active');

        // 2. Logic đổi màu (Thực tế sẽ thay đổi source ảnh hoặc lớp PNG)
        console.log(`Đang nhuộm màu: ${color}`);

        // Hiệu ứng luồng sáng quét qua khi đổi màu
        const stage = document.querySelector('.config-stage');
        stage.style.filter = 'brightness(1.5) contrast(1.2)';
        setTimeout(() => {
            stage.style.filter = 'none';
        }, 400);
    }

    // Logic Kéo - Thả (Drag & Drop)
    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.innerText);
    }

    // Cho phép thả vào Stage
    const stage = document.getElementById('capture-area');
    stage.addEventListener('dragover', (ev) => {
        ev.preventDefault();
    });

    stage.addEventListener('drop', (ev) => {
        ev.preventDefault();
        const plateNumber = ev.dataTransfer.getData("text");
        applyPlate(plateNumber);
    });

    // Click chọn cho Mobile
    document.querySelectorAll('.plate-item').forEach(item => {
        item.addEventListener('click', () => {
            applyPlate(item.innerText);
        });
    });

    function applyPlate(number) {
        const plateDisplay = document.getElementById('target-plate');
        const plateRes = document.getElementById('res-plate');

        // Tiếng Click cơ khí
        const clickSound = new Audio('./assets/mp3/buttont-cokhi.mp3');
        clickSound.volume = 0.2;
        clickSound.play();

        // Hiệu ứng Snap
        plateDisplay.innerText = number;
        plateDisplay.classList.remove('glow');
        void plateDisplay.offsetWidth; // Trigger reflow
        plateDisplay.classList.add('glow');

        // Cập nhật bảng giá
        plateRes.innerText = number;
        plateRes.style.color = '#bf953f';
    }

    //----------------------------- section 5 ----------------------------- //
    function focusShowroom(id) {
        // 1. Logic giả lập focus chi nhánh
        const showroomList = {
            'hanoi': 'Elite Showroom Hà Nội - Tây Hồ',
            'danang': 'Elite Showroom Đà Nẵng - Hải Châu',
            'hcm': 'Elite Showroom TP.HCM - Quận 1'
        };

        console.log(`Đang lấy dữ liệu chi nhánh: ${showroomList[id]}`);

        // Hiệu ứng nháy sáng cho card chi tiết (nếu có)
        const card = document.getElementById(`sr-${id}`);
        if (card) {
            card.style.borderColor = '#bf953f';
            card.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            setTimeout(() => card.style.borderColor = 'rgba(255, 255, 255, 0.05)', 2000);
        }
    }

    // Thêm tương tác cho Mobile Swipe (Sử dụng Intersection Observer để biết thẻ nào đang active)
    const showroomCards = document.querySelectorAll('.showroom-card');
    const observerOptions = {
        root: null,
        threshold: 0.6
    };

    const srObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('border-[#bf953f]');
            } else {
                entry.target.classList.remove('border-[#bf953f]');
            }
        });
    }, observerOptions);

    showroomCards.forEach(card => srObserver.observe(card));

    function focusSR(city) {
        const card = document.getElementById(`sr-${city}`);
        if (card) {
            card.classList.add('scale-105', 'bg-[#1a1a1a]');
            card.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            setTimeout(() => card.classList.remove('scale-105', 'bg-[#1a1a1a]'), 2000);
        }
    }

    //----------------------------- section 6 ----------------------------- //
</script>

</html>