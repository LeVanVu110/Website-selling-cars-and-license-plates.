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

        /* ----------------------------- section 2 -----------------------------  */

        /* ----------------------------- section 3 -----------------------------  */

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

    <!-- ----------------------------- section 3 -----------------------------  -->

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

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>