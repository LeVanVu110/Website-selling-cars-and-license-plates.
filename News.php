<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        .news-hero {
            position: relative;
            width: 100%;
            height: 100vh;
            background: #000;
            overflow: hidden;
        }

        /* Khung chứa ảnh */
.hero-cinemagraph {
    position: absolute;
    inset: 0;
    z-index: 0;
}
/* Thẻ ảnh thực tế */
.hero-img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Giúp ảnh tràn đầy màn hình mà không bị méo */
    object-position: center;
    transform: scale(1);
    animation: slowZoom 20s linear infinite alternate;
}

        @keyframes slowZoom {
            to {
                transform: scale(1.1);
            }
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 40%, rgba(0, 0, 0, 0.8) 100%);
            z-index: 1;
        }

        /* Typography Reveal */
        .hero-content {
            position: absolute;
            bottom: 15%;
            left: 8%;
            z-index: 10;
            max-width: 800px;
        }

        .editorial-label {
            display: inline-block;
            padding: 4px 12px;
            border: 1px solid #bf953f;
            color: #bf953f;
            font-size: 10px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            margin-bottom: 24px;
            opacity: 0;
            transform: translateY(20px);
        }

        .hero-headline {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 4rem);
            /* Giảm nhẹ size để an toàn trên nhiều màn hình */
            color: #fff;
            line-height: 1.3;
            /* Tăng line-height để các dòng không chạm nhau */
            letter-spacing: 0.02em;
            margin: 0;
            padding: 0;
        }

        /* Sửa lỗi hiển thị cho từng dòng */
        .hero-headline .line-wrapper {
            display: block;
            position: relative;
            overflow: hidden;
            /* Giữ hiệu ứng reveal */
            margin-bottom: 5px;
            /* Tạo khoảng cách an toàn giữa các dòng */
        }

        .hero-headline .line-content {
            display: inline-block;
            /* Chuyển về inline-block để tính toán chiều rộng chuẩn */
            transform: translateY(100%);
            transition: transform 1.2s cubic-bezier(0.19, 1, 0.22, 1);
            white-space: nowrap;
            /* Ngăn chữ tự xuống dòng làm đè chữ */
        }

        .hero-headline span {
            display: block;
            transform: translateY(100%);
            transition: transform 1.2s cubic-bezier(0.19, 1, 0.22, 1);
        }

        .hero-headline .highlight {
            color: #e5c07b;
            font-style: italic;
            margin-right: 10px;
            /* Tạo khoảng cách riêng cho chữ Bentley */
        }

        /* Progress Bar & Scroll Icon */
        .hero-progress-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
            z-index: 20;
        }

        .hero-progress-bar {
            width: 0%;
            height: 100%;
            background: #bf953f;
            transition: width 5s linear;
        }

        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            right: 8%;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            cursor: pointer;
        }

        .diamond-icon {
            width: 12px;
            height: 12px;
            border: 1px solid #bf953f;
            transform: rotate(45deg);
            animation: diamondPulse 2s infinite;
        }

        @keyframes diamondPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(191, 149, 63, 0.7);
            }

            70% {
                box-shadow: 0 0 15px 10px rgba(191, 149, 63, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(191, 149, 63, 0);
            }
        }

        /* Spotlight Cursor */
        .spotlight {
            position: fixed;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(191, 149, 63, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 5;
            transform: translate(-50%, -50%);
            display: none;
        }

        @media (min-width: 1024px) {
            .spotlight {
                display: block;
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            /* .hero-cinemagraph {
                background-image: url('https://images.pexels.com/photos/3802510/pexels-photo-3802510.jpeg?auto=compress&cs=tinysrgb&w=1920');
            } */

            .hero-content {
                left: 5%;
                bottom: 20%;
                width: 90%;
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
    <div class="spotlight" id="spotlight"></div>

    <section class="news-hero">
        <!-- <div class="hero-cinemagraph"></div> -->
        <div class="hero-cinemagraph">
            <img src="https://images.pexels.com/photos/3802510/pexels-photo-3802510.jpeg?auto=compress&cs=tinysrgb&w=1920"
                alt="Bentley in Paris"
                class="hero-img">
        </div>
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <div class="editorial-label" id="hero-label">
                EDITORIAL | 10 FEB 2026
            </div>

            <h1 class="hero-headline">
                <span id="line-1">Sự Giao Thoa Của</span>
                <span id="line-2"><span class="highlight">Bentley</span> <span>& Nghệ Thuật</span><span>
                        <span id="line-3">Đương Đại Paris.</span>
            </h1>
        </div>

        <div class="scroll-indicator" onclick="scrollToContent()">
            <span class="text-[10px] text-white/40 tracking-[0.4em] uppercase rotate-90 mb-8">Scroll</span>
            <div class="diamond-icon"></div>
        </div>

        <div class="hero-progress-container">
            <div class="hero-progress-bar" id="progress-bar"></div>
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
    document.addEventListener('DOMContentLoaded', () => {
        const spotlight = document.getElementById('spotlight');
        const label = document.getElementById('hero-label');
        // Mảng này phải khớp với ID trong các thẻ span .line-content
        const lines = [
            document.getElementById('line-1'),
            document.getElementById('line-2'),
            document.getElementById('line-3')
        ];
        const progressBar = document.getElementById('progress-bar');

        // 1. Entrance Animation (Hiệu ứng xuất hiện)
        setTimeout(() => {
            // Hiện nhãn label (EDITORIAL...)
            if (label) {
                label.style.opacity = '1';
                label.style.transform = 'translateY(0)';
                label.style.transition = 'all 1s cubic-bezier(0.19, 1, 0.22, 1)';
            }

            // Reveal Text từng dòng (Trồi lên từ Mask)
            lines.forEach((line, index) => {
                if (line) {
                    setTimeout(() => {
                        // Chỉ thay đổi translateY để không làm mất các thuộc tính CSS khác
                        line.style.transform = 'translateY(0)';
                    }, 250 * (index + 1)); // Tăng độ trễ một chút để mượt hơn
                }
            });

            // Chạy thanh tiến trình mượt mà
            if (progressBar) {
                progressBar.style.transition = 'width 5s linear';
                progressBar.style.width = '100%';
            }
        }, 600);

        // 2. Mouse Move Spotlight (Chỉ chạy khi có spotlight element)
        if (spotlight) {
            window.addEventListener('mousemove', (e) => {
                // Sử dụng requestAnimationFrame để hiệu ứng mượt và đỡ tốn CPU hơn
                requestAnimationFrame(() => {
                    spotlight.style.left = e.clientX + 'px';
                    spotlight.style.top = e.clientY + 'px';
                });
            });
        }

        // 3. Parallax Effect on Scroll
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroContent = document.querySelector('.hero-content');

            if (heroContent) {
                // Sử dụng translate3d để tận dụng card đồ họa (GPU) giúp cuộn mượt hơn
                // Giữ nguyên vị trí X, thay đổi Y theo tỷ lệ cuộn
                heroContent.style.transform = `translate3d(0, ${scrolled * -0.3}px, 0)`;

                // Làm mờ dần tiêu đề khi cuộn xuống
                const opacityValue = 1 - (scrolled / 800);
                heroContent.style.opacity = opacityValue > 0 ? opacityValue : 0;
            }
        });
    });

    // Hàm cuộn xuống mượt mà
    function scrollToContent() {
        window.scrollTo({
            top: window.innerHeight,
            behavior: 'smooth'
        });
    }

    // -----------------------------section 2 ----------------------------- //

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>