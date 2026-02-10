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

        /* ----------------------------- section 2 -----------------------------  */

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <!-- <section id="hero-showroom" class="relative w-full h-screen overflow-hidden bg-black">

        <div class="absolute inset-0 z-0 overflow-hidden">
            <div id="video-placeholder" class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
                style="background-image: url('https://images.pexels.com/photos/3311574/pexels-photo-3311574.jpeg?auto=compress&cs=tinysrgb&w=1920');">
            </div>

            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[115%] h-[115%] pointer-events-none">
                <iframe title="vimeo-player" src="https://player.vimeo.com/video/396260528?h=8586a613a2"
                    width="640" height="360" frameborder="0" referrerpolicy="strict-origin-when-cross-origin"="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
                    allowfullscreen></iframe>
            </div>

            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-transparent to-black"></div>
        </div>
        <div class="relative z-10 h-full flex flex-col items-center justify-between py-20 px-6">

            <div class="text-center mt-10">
                <h1 class="hero-title opacity-0 translate-y-10">
                    KIỆT TÁC DI ĐỘNG
                </h1>
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
    </section> -->
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

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include('footer.php'); ?>
</body>
<script>
    //----------------------------- section 1 ----------------------------- //
    // document.addEventListener('DOMContentLoaded', () => {
    //     // 1. Khai báo các phần tử giao diện
    //     const placeholder = document.getElementById('video-placeholder');
    //     const title = document.querySelector('.hero-title');
    //     const subHeadline = document.getElementById('sub-headline');
    //     const flare = document.getElementById('lens-flare');
    //     const heroContent = document.querySelector('.relative.z-10');
    //     const soundBtn = document.getElementById('toggle-sound');
    //     const vimeoIframe = document.getElementById('vimeo-player');
    //     const vimeoWrapper = document.querySelector('.absolute.top-1/2.left-1/2');

    //     // Khởi tạo Vimeo Player API
    //     const player = new Vimeo.Player(vimeoIframe);

    //     /**
    //      * 1. XỬ LÝ KHAI MÀN (ENTRANCE)
    //      */
    //     const triggerEntrance = () => {
    //         if (placeholder) {
    //             placeholder.style.opacity = '0';
    //         }

    //         if (flare) {
    //             flare.style.transition = 'all 1.2s cubic-bezier(0.23, 1, 0.32, 1)';
    //             flare.style.opacity = '1';
    //             flare.style.transform = 'translateY(-50%) scaleX(1)';

    //             setTimeout(() => {
    //                 flare.style.opacity = '0';

    //                 if (title) {
    //                     title.style.transition = 'all 2.5s cubic-bezier(0.19, 1, 0.22, 1)';
    //                     title.style.opacity = '1';
    //                     title.style.transform = 'translateY(0)';
    //                 }

    //                 if (subHeadline) {
    //                     subHeadline.style.transition = 'all 2s ease-out 0.5s';
    //                     subHeadline.style.opacity = '1';
    //                 }
    //             }, 800);
    //         }
    //     };

    //     // Kích hoạt Entrance sau 2 giây
    //     setTimeout(triggerEntrance, 2000);

    //     /**
    //      * 2. HIỆU ỨNG PARALLAX KHI CUỘN
    //      */
    //     window.addEventListener('scroll', () => {
    //         const scrolled = window.pageYOffset;

    //         if (vimeoWrapper) {
    //             vimeoWrapper.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.3}px))`;
    //         }

    //         if (heroContent) {
    //             heroContent.style.transform = `translateY(${scrolled * -0.15}px)`;
    //             heroContent.style.opacity = `${1 - scrolled / 800}`;
    //         }
    //     });

    //     /**
    //      * 3. CẢM BIẾN NGHIÊNG (GYROSCOPE) CHO MOBILE
    //      */
    //     if (window.DeviceOrientationEvent) {
    //         window.addEventListener('deviceorientation', (event) => {
    //             if (window.innerWidth < 768 && vimeoWrapper) {
    //                 const tiltX = event.gamma / 15;
    //                 const tiltY = event.beta / 15;
    //                 vimeoWrapper.style.transform = `translate(calc(-50% + ${tiltX}px), calc(-50% + ${tiltY}px)) scale(1.1)`;
    //             }
    //         });
    //     }

    //     /**
    //      * 4. XỬ LÝ ÂM THANH (SỬ DỤNG VIMEO SDK)
    //      */
    //     let isMuted = true;

    //     if (soundBtn) {
    //         soundBtn.addEventListener('click', () => {
    //             isMuted = !isMuted;

    //             // Cập nhật Icon giao diện
    //             soundBtn.innerHTML = isMuted ?
    //                 '<i class="ri-volume-mute-line text-xl"></i>' :
    //                 '<i class="ri-volume-up-line text-xl text-[#bf953f]"></i>';

    //             if (isMuted) {
    //                 player.setVolume(0); // Tắt tiếng
    //             } else {
    //                 player.setVolume(1); // Bật tiếng tối đa
    //                 player.play(); // Đảm bảo video đang chạy
    //             }
    //         });
    //     }
    // });
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

    // -----------------------------section 2 ----------------------------- //

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>