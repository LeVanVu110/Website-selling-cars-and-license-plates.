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

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

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

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

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
        const hoverSound = new Audio('https://www.soundjay.com/buttons/button-20.mp3');
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

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>