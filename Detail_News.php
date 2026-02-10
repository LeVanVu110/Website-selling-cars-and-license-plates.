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

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>