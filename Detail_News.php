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

        /* ----------------------------- section 2 -----------------------------  */

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

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

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

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

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>