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
            object-fit: cover;
            /* Giúp ảnh tràn đầy màn hình mà không bị méo */
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

        /* ----------------------------- SECTION 2: THE ELEGANT FILTER ----------------------------- */
        .filter-wrapper {
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 70px;
            background: rgba(10, 10, 10, 0.75);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(191, 149, 63, 0.2);
            display: flex;
            align-items: center;
            transition: all 0.4s ease;
        }

        /* Hiệu ứng Drop Shadow khi Sticky */
        .filter-wrapper.is-sticky {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 4px 15px rgba(191, 149, 63, 0.1);
            height: 60px;
            /* Thu hẹp nhẹ khi cuộn */
        }

        .filter-container {
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            padding: 0 40px;
            display: flex;
            justify-content: 空间-between;
            align-items: center;
            position: relative;
        }

        /* Navigation List */
        .filter-nav {
            display: flex;
            list-style: none;
            gap: 40px;
            position: relative;
            padding: 0;
            margin: 0;
        }

        .filter-item {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            transition: all 0.3s ease;
            cursor: pointer;
            padding: 10px 0;
            white-space: nowrap;
        }

        .filter-item:hover {
            color: #bf953f;
            transform: translateY(-2px);
        }

        .filter-item.active {
            color: #bf953f;
        }

        /* Thanh kẻ vàng trượt mượt mà (The Golden Underline) */
        #golden-line {
            position: absolute;
            bottom: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #bf953f, transparent);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            pointer-events: none;
        }

        /* Hai đầu Icon mạ vàng */
        .nav-icon {
            color: #bf953f;
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .nav-icon:hover {
            transform: scale(1.2);
            filter: drop-shadow(0 0 5px rgba(191, 149, 63, 0.5));
        }

        /* Nút Bespoke */
        .btn-bespoke {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 10px;
            letter-spacing: 0.15em;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-bespoke .dot {
            width: 6px;
            height: 6px;
            background: #bf953f;
            border-radius: 50%;
            box-shadow: 0 0 10px #bf953f;
            animation: pulseGold 2s infinite;
        }

        @keyframes pulseGold {
            0% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.4;
                transform: scale(1.3);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .filter-nav {
                gap: 25px;
                overflow-x: auto;
                padding-bottom: 5px;
                mask-image: linear-gradient(to right, black 85%, transparent 100%);
                -webkit-overflow-scrolling: touch;
            }

            .filter-nav::-webkit-scrollbar {
                display: none;
            }

            .filter-container {
                padding: 0 20px;
            }

            .nav-icon,
            .btn-bespoke {
                display: none;
            }

            /* Tối giản cho mobile */
        }

        /* Trạng thái bị ẩn khi lọc */
        .editorial-card.filtered-out {
            display: none;
            /* Hoặc dùng scale(0) + opacity 0 nếu muốn animation phức tạp hơn */
        }

        /* Hiệu ứng mờ dần khi chuyển đổi */
        .editorial-card {
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        /* Đảm bảo Grid luôn đẹp khi thiếu cột */
        .masonry-layout {
            min-height: 500px;
            /* Tránh nhảy trang khi grid trống */
        }

        /* ----------------------------- SECTION 3: THE EDITORIAL GRID ----------------------------- */
        .editorial-grid {
            background: #000;
            padding: 80px 0;
        }

        /* Lưới Masonry phá cách */
        .masonry-layout {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-auto-flow: dense;
            gap: 50px 30px;
        }

        /* Editorial Card */
        .editorial-card {
            position: relative;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
            cursor: pointer;
        }

        .editorial-card.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Bài viết tiêu điểm (Chiếm 2 cột) */
        .editorial-card.featured {
            grid-column: span 2;
        }

        /* Container Ảnh */
        .card-image-box {
            position: relative;
            width: 100%;
            aspect-ratio: 16/10;
            overflow: hidden;
            margin-bottom: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), 0 5px 15px rgba(191, 149, 63, 0.05);
        }

        .editorial-card.featured .card-image-box {
            aspect-ratio: 21/9;
        }

        .card-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: contrast(1.1) brightness(0.9);
            transition: transform 1.5s cubic-bezier(0.2, 1, 0.3, 1);
        }

        /* Hover Effects */
        .editorial-card:hover .card-image-box img {
            transform: scale(1.1);
        }

        .editorial-card:hover .gold-overlay {
            opacity: 1;
        }

        .gold-overlay {
            position: absolute;
            inset: 0;
            background: rgba(191, 149, 63, 0.1);
            opacity: 0;
            transition: opacity 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Typography */
        .category-tag {
            color: #bf953f;
            font-size: 9px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            margin-bottom: 12px;
            display: block;
        }

        .article-title {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 22px;
            line-height: 1.4;
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }

        .editorial-card:hover .article-title {
            color: #e5c07b;
            /* Metallic Glow */
            text-shadow: 0 0 10px rgba(229, 192, 123, 0.3);
        }

        .article-excerpt {
            color: #a0a0a0;
            font-size: 13px;
            line-height: 1.6;
            font-weight: 300;
        }

        /* Read More Line */
        .read-more-line {
            width: 0;
            height: 1px;
            background: #bf953f;
            margin-top: 20px;
            transition: width 0.5s ease;
        }

        .editorial-card:hover .read-more-line {
            width: 60px;
        }

        /* Native Ad Card (Bespoke) */
        .native-ad-card {
            background: #0a0a0a;
            border: 1px solid rgba(191, 149, 63, 0.3);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* AI Voice Button */
        .ai-voice-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 35px;
            height: 35px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #bf953f;
            z-index: 5;
            transition: 0.3s;
        }

        .ai-voice-btn:hover {
            background: #bf953f;
            color: #000;
        }

        /* Responsive Mobile */
        @media (max-width: 1024px) {
            .masonry-layout {
                grid-template-columns: 1fr;
                gap: 60px;
            }

            .editorial-card.featured {
                grid-column: span 1;
            }

            .article-title {
                font-size: 20px;
            }
        }

        /* ----------------------------- SECTION 4: THE GOLDEN ENVELOPE ----------------------------- */
        .golden-envelope {
            background: #0a0a0a;
            background-image: radial-gradient(circle at center, #1a1a1a 0%, #050505 100%);
            padding: 150px 0;
            position: relative;
            overflow: hidden;
        }

        /* Họa tiết triện sáp chìm */
        .wax-seal-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 500px;
            background: url('https://img.icons8.com/ios/500/ffffff/seal.png');
            /* Thay bằng link icon triện của bạn */
            background-size: contain;
            background-repeat: no-repeat;
            opacity: 0.03;
            pointer-events: none;
        }

        .envelope-container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            padding: 80px 40px;
            text-align: center;
        }

        /* Khung viền vẽ bằng SVG */
        .envelope-border {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            fill: none;
            stroke: #bf953f;
            stroke-width: 1.5;
            stroke-dasharray: 2500;
            stroke-dashoffset: 2500;
            /* Ban đầu ẩn đi */
            transition: stroke-dashoffset 3s ease-in-out;
        }

        .golden-envelope.revealed .envelope-border {
            stroke-dashoffset: 0;
            /* Vẽ viền khi cuộn tới */
        }

        /* Input Styling */
        .invite-form {
            max-width: 500px;
            margin: 40px auto 0;
        }

        .input-group {
            position: relative;
            margin-bottom: 30px;
        }

        .invite-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(191, 149, 63, 0.3);
            padding: 15px 40px;
            color: #fff;
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            text-align: center;
            outline: none;
        }

        .input-glow-line {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: #bf953f;
            box-shadow: 0 0 10px #bf953f;
            transition: width 0.6s ease;
        }

        .invite-input:focus+.input-glow-line {
            width: 100%;
        }

        /* Nút GIA NHẬP - Hiệu ứng Liquid Fill */
        .btn-join {
            position: relative;
            background: transparent;
            border: 1px solid #bf953f;
            color: #bf953f;
            padding: 18px 60px;
            font-size: 11px;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            font-weight: 900;
            cursor: pointer;
            overflow: hidden;
            transition: color 0.4s ease;
            z-index: 1;
        }

        .btn-join::before {
            content: '';
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: #bf953f;
            transition: top 0.4s cubic-bezier(0.19, 1, 0.22, 1);
            z-index: -1;
        }

        .btn-join:hover {
            color: #000;
        }

        .btn-join:hover::before {
            top: 0;
        }

        /* Thành công: Triện sáp vàng */
        #success-seal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(5);
            opacity: 0;
            z-index: 1000;
            pointer-events: none;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        #success-seal.active {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        /* Mobile Customization */
        @media (max-width: 768px) {
            .envelope-container {
                padding: 40px 20px;
            }

            .btn-join {
                width: 100%;
            }
        }

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
    <nav class="filter-wrapper" id="sticky-filter">
        <div class="filter-container">
            <ul class="filter-nav" id="filter-nav">
                <li class="filter-item active" data-filter="all" onclick="filterArticles(this)">Tất cả</li>
                <li class="filter-item" data-filter="xe-sang" onclick="filterArticles(this)">Thế giới xe sang</li>
                <li class="filter-item" data-filter="phong-thuy" onclick="filterArticles(this)">Phong thủy số</li>
                <li class="filter-item" data-filter="thi-truong" onclick="filterArticles(this)">Đấu giá & Thị trường</li>
                <div id="golden-line"></div>
            </ul>
        </div>
    </nav>
    <!-- ----------------------------- section 3 -----------------------------  -->
    <section class="editorial-grid">
        <div class="max-w-7xl mx-auto px-6">

            <div class="masonry-layout">

                <article class="editorial-card featured" data-delay="0" data-category="xe-sang">
                    <a href="Detail_News.php">
                    <div class="ai-voice-btn" title="Nghe tóm tắt bài viết">
                        <i class="ri-voiceprint-line"></i>
                    </div>
                    <div class="card-image-box">
                        <img src="https://images.pexels.com/photos/3311574/pexels-photo-3311574.jpeg?auto=compress&cs=tinysrgb&w=1260" alt="Rolls-Royce Ghost">
                        <div class="gold-overlay">
                            <span class="text-white text-[10px] tracking-[0.5em] uppercase">Khám phá ngay</span>
                        </div>
                    </div>
                    <span class="category-tag">Thế giới xe sang</span>
                    <h3 class="article-title">Rolls-Royce Ghost: Khi sự tĩnh lặng trở thành định nghĩa mới của quyền lực</h3>
                    <p class="article-excerpt">Không còn là những phô trương hào nhoáng, thế hệ Ghost mới tập trung vào trải nghiệm "Post-Opulence" - sự sang trọng thuần khiết và tinh giản tuyệt đối...</p>
                    <div class="read-more-line"></div></a>
                </article>

                <article class="editorial-card" data-delay="200" data-category="thi-truong">
                    <div class="card-image-box">
                        <img src="https://images.pexels.com/photos/1035108/pexels-photo-1035108.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Biển số định danh">
                    </div>
                    <span class="category-tag">Đấu giá & Thị trường</span>
                    <h3 class="article-title">Thị trường biển số định danh: Cuộc chơi của những con số "Biết nói"</h3>
                    <p class="article-excerpt">Tại sao mức giá hàng tỷ đồng vẫn được coi là "món hời" cho những tấm biển ngũ quý?</p>
                    <div class="read-more-line"></div>
                </article>


                <article class="editorial-card" data-delay="600" data-category="phong-thuy">
                    <div class="card-image-box">
                        <img src="https://images.pexels.com/photos/112460/pexels-photo-112460.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Phong thủy xe">
                    </div>
                    <span class="category-tag">Phong thủy số</span>
                    <h3 class="article-title">Màu xe và Biển số: Cách kích hoạt tài lộc theo bản mệnh năm 2026</h3>
                    <div class="read-more-line"></div>
                </article>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section class="golden-envelope" id="invite-section">
        <div class="wax-seal-bg"></div>

        <div class="envelope-container">
            <svg class="envelope-border">
                <rect x="0" y="0" width="100%" height="100%" rx="20" ry="20" />
            </svg>

            <div class="relative z-10" data-aos="fade-up">
                <span class="text-[#bf953f] text-[10px] tracking-[0.5em] uppercase mb-4 block">The Royal Invitation</span>
                <h2 class="text-white text-3xl md:text-5xl font-serif uppercase tracking-widest mb-6">
                    Đặc quyền trong <br> hộp thư của bạn
                </h2>
                <p class="text-white/50 text-sm italic font-light max-w-lg mx-auto leading-relaxed">
                    Nhận danh sách các siêu phẩm biển số và xe sang độc bản trước khi chúng được công bố ra thị trường.
                </p>

                <form class="invite-form" onsubmit="handleSubscribe(event)">
                    <div class="input-group">
                        <i class="ri-lock-2-line absolute left-0 bottom-4 text-[#bf953f] opacity-50"></i>
                        <input type="email" class="invite-input" placeholder="Địa chỉ Email cá nhân..." required>
                        <div class="input-glow-line"></div>
                    </div>

                    <button type="submit" class="btn-join">
                        GIA NHẬP CÂU LẠC BỘ
                    </button>

                    <p class="text-[9px] text-white/20 mt-8 tracking-widest uppercase">
                        Chỉ một đặc quyền duy nhất vào sáng thứ Hai. Bảo mật tuyệt đối.
                    </p>
                </form>
            </div>
        </div>
    </section>

    <div id="success-seal">
        <img src="https://cdn-icons-png.flaticon.com/512/2510/2510484.png"
            alt="Confirmed"
            style="width: 150px; filter: drop-shadow(0 0 20px rgba(191, 149, 63, 0.5));">
    </div>

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
    document.addEventListener('DOMContentLoaded', () => {
        const filterBar = document.getElementById('sticky-filter');
        const underline = document.getElementById('golden-line');
        const firstItem = document.querySelector('.filter-item.active');

        // Khởi tạo vị trí thanh vàng ban đầu
        if (firstItem) {
            setUnderlinePosition(firstItem);
        }

        // Hiệu ứng Sticky Shadow
        window.addEventListener('scroll', () => {
            if (window.scrollY > window.innerHeight) {
                filterBar.classList.add('is-sticky');
            } else {
                filterBar.classList.remove('is-sticky');
            }
        });
    });

    function moveUnderline(element) {
        // Xóa active cũ
        document.querySelectorAll('.filter-item').forEach(item => item.classList.remove('active'));
        // Thêm active mới
        element.classList.add('active');
        // Di chuyển thanh vàng
        setUnderlinePosition(element);

        // Haptic Feedback cho Mobile
        if (window.navigator && window.navigator.vibrate) {
            window.navigator.vibrate(15); // Rung cực ngắn 15ms
        }
    }

    function setUnderlinePosition(element) {
        const underline = document.getElementById('golden-line');
        underline.style.width = `${element.offsetWidth}px`;
        underline.style.left = `${element.offsetLeft}px`;
    }

    function filterArticles(element) {
        const category = element.getAttribute('data-filter');
        const articles = document.querySelectorAll('.editorial-card');

        // 1. Cập nhật Menu (Thanh kẻ vàng & màu chữ)
        document.querySelectorAll('.filter-item').forEach(item => item.classList.remove('active'));
        element.classList.add('active');

        // Gọi lại hàm di chuyển thanh vàng đã viết ở Section 2
        if (typeof setUnderlinePosition === "function") {
            setUnderlinePosition(element);
        }

        // 2. Logic Lọc bài viết
        articles.forEach(article => {
            // Thêm hiệu ứng mờ dần trước khi ẩn
            article.style.opacity = '0';
            article.style.transform = 'scale(0.95)';

            setTimeout(() => {
                const articleCat = article.getAttribute('data-category');

                if (category === 'all' || articleCat === category) {
                    article.classList.remove('filtered-out');
                    // Hiện lại mượt mà
                    setTimeout(() => {
                        article.style.opacity = '1';
                        article.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    article.classList.add('filtered-out');
                }
            }, 300); // Đợi hiệu ứng mờ kết thúc rồi mới ẩn thực tế
        });

        // 3. Rung nhẹ (Haptic) cho Mobile
        if (window.navigator && window.navigator.vibrate) {
            window.navigator.vibrate(10);
        }
    }

    //----------------------------- section 3 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.editorial-card');

        // Intersection Observer để phát hiện khi cuộn tới card
        const revealCallback = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = entry.target.getAttribute('data-delay') || 0;
                    setTimeout(() => {
                        entry.target.classList.add('revealed');
                    }, delay);
                    observer.unobserve(entry.target);
                }
            });
        };

        const revealObserver = new IntersectionObserver(revealCallback, {
            threshold: 0.15
        });

        cards.forEach(card => {
            revealObserver.observe(card);
        });

        // Giả lập Parallax cho Mobile
        if (window.innerWidth < 1024) {
            window.addEventListener('scroll', () => {
                const titles = document.querySelectorAll('.article-title');
                titles.forEach(title => {
                    const pos = title.getBoundingClientRect().top;
                    title.style.transform = `translateY(${pos * 0.05}px)`;
                });
            });
        }
    });

    //----------------------------- section 4 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Hiệu ứng vẽ khung khi cuộn tới
        const inviteSection = document.getElementById('invite-section');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    inviteSection.classList.add('revealed');
                }
            });
        }, {
            threshold: 0.5
        });

        observer.observe(inviteSection);
    });

    // 2. Xử lý đăng ký thành công
    function handleSubscribe(event) {
        event.preventDefault();
        const seal = document.getElementById('success-seal');

        // Hiệu ứng "Đóng triện"
        seal.classList.add('active');

        // Rung điện thoại (Haptic)
        if (window.navigator && window.navigator.vibrate) {
            window.navigator.vibrate([100, 30, 100]);
        }

        // Sau 3 giây ẩn triện và thông báo
        setTimeout(() => {
            seal.classList.remove('active');
            alert("Chào mừng Quý khách gia nhập câu lạc bộ thượng lưu.");
            // Có thể lưu Cookie để ẩn Section này sau khi đăng ký
            localStorage.setItem('isVIPMember', 'true');
        }, 2500);
    }

    // 3. Custom Cursor (Tùy chọn cho Desktop)
    if (window.innerWidth > 1024) {
        const section = document.querySelector('.golden-envelope');
        section.addEventListener('mouseenter', () => {
            document.body.style.cursor = "url('https://cdn-icons-png.flaticon.com/512/1085/1085444.png'), auto";
        });
        section.addEventListener('mouseleave', () => {
            document.body.style.cursor = "default";
        });
    }

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>