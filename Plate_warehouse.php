<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kho Biển Số | Luxury Interface</title>
    <style>
        :root {
            --gold-grad: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
            --pitch-black: #050505;
            --luxury-gold: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
        }

        body {
            background-color: #0a0a0a;
            font-family: 'Montserrat', sans-serif;
            color: white;
            overflow-x: hidden;
            margin-top: 100px;
        }

        /* ----------------------------- section 1 -----------------------------  */
        /* Nền Cockpit với lưới mờ */
        .hero-section {
            background-color: var(--pitch-black);
            background-image:
                linear-gradient(rgba(191, 149, 63, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(191, 149, 63, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            position: relative;
        }

        /* Chữ mạ vàng Gradient */
        .gold-text {
            background: var(--gold-grad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Thanh Search Quyền Lực */
        .search-wrapper {
            width: 0%;
            /* Sẽ mở rộng bằng GSAP */
            opacity: 0;
            overflow: hidden;
            border: 1px solid rgba(191, 149, 63, 0.3);
            transition: box-shadow 0.4s ease, border-color 0.4s ease;
        }

        .search-wrapper:focus-within {
            border-color: #bf953f;
            box-shadow: 0 0 30px rgba(191, 149, 63, 0.15);
        }

        /* Hiệu ứng nảy và đổi màu khi gõ số */
        .luxury-input {
            caret-color: #bf953f;
        }

        .luxury-input:not(:placeholder-shown) {
            color: #d4af37;
            font-weight: 800;
            letter-spacing: 4px;
        }

        .filter-tag {
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            /* Tăng độ sáng nền một chút */
            border: 1px solid rgba(191, 149, 63, 0.4);
            /* Viền vàng rõ hơn */
            color: #e5e7eb !important;
            /* Chữ xám trắng (gray-200) để dễ đọc */
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            /* Tạo bóng đổ để nổi khối */
        }

        /* Vệt sáng chạy ngang khi Hover */
        .filter-tag::after {
            content: "";
            position: absolute;
            top: 0;
            left: -150%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(252, 246, 186, 0.3),
                    /* Tăng độ sáng tia sét */
                    transparent);
            transition: 0.6s;
            z-index: 1;
        }

        .filter-tag:hover::after {
            left: 150%;
        }

        .filter-tag::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(191, 149, 63, 0.2), transparent);
            transition: 0.6s;
        }

        .filter-tag:hover::before {
            left: 100%;
        }

        /* Hiệu ứng khi nhấn giữ: Nút biến thành thỏi vàng đặc */
        .filter-tag:active {
            background: var(--luxury-gold);
            color: #1a1a1a !important;
            transform: scale(0.92);
            box-shadow: 0 0 30px rgba(191, 149, 63, 0.5);
        }

        /* Đảm bảo text luôn nằm trên lớp shimmer */
        .filter-tag span {
            position: relative;
            z-index: 2;
        }

        /* Hiệu ứng khi Hover: Chữ trắng sáng và viền vàng rực */
        .filter-tag:hover {
            color: #ffffff !important;
            border-color: #fcf6ba;
            /* Chuyển sang màu vàng nhạt khi hover */
            background: rgba(191, 149, 63, 0.15);
            box-shadow: 0 0 20px rgba(191, 149, 63, 0.3);
            transform: translateY(-3px);
            /* Nhấc cao hơn một chút */
        }

        /* Custom scroll cho mobile tags */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Hiệu ứng 3D cho biển số nghiêng mồi */
        .plate-mockup {
            transform: perspective(1000px) rotateY(-15deg) rotateX(5deg);
            transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .master-card:hover .plate-mockup {
            transform: perspective(1000px) rotateY(0deg) rotateX(0deg) scale(1.05);
        }

        /* Hiệu ứng Gold Text */
        .gold-text {
            background: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
        }

        .master-card {
            transition: transform 0.4s ease;
        }

        @media (max-width: 768px) {

            /* Mobile: Không nghiêng 3D để tập trung vào số */
            .plate-mockup {
                transform: none;
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
    <section class="hero-section min-h-[80vh] flex flex-col items-center justify-center px-4 pt-20">

        <div class="text-center mb-12" id="hero-title">
            <h2 class="text-gray-500 tracking-[0.6em] text-[10px] md:text-xs font-bold mb-4 uppercase">The Exclusive Collection</h2>
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tighter leading-tight">
                TÌM KIẾM ĐỊNH DANH <br class="md:hidden"> <span class="gold-text">ĐẲNG CẤP</span>
            </h1>
        </div>

        <div id="search-container" class="search-wrapper relative max-w-[800px] w-full bg-black rounded-[4px] flex items-center p-1 md:p-2 mb-8">
            <button class="px-3 text-[#bf953f] hover:scale-110 transition-transform hidden md:block">
                <i class="ri-map-pin-2-fill"></i>
            </button>

            <input type="text"
                inputmode="numeric"
                placeholder="Nhập số mơ ước hoặc ký tự..."
                class="luxury-input w-full bg-transparent border-none outline-none px-4 py-3 md:py-4 text-white text-sm md:text-base placeholder:text-gray-700">

            <button class="bg-transparent px-4 md:px-6 py-2 border-l border-white/10 group">
                <i class="ri-search-2-line text-2xl gold-text group-hover:scale-125 transition-transform duration-300"></i>
            </button>
        </div>

        <div id="filter-container" class="w-full max-w-[900px]">
            <p class="text-[9px] text-gray-600 uppercase tracking-widest text-center mb-4">Gợi ý phân hạng</p>

            <div class="flex overflow-x-auto md:flex-wrap md:justify-center gap-3 md:gap-4 hide-scrollbar pb-4 px-2">
                <button class="filter-tag flex-shrink-0 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 rounded-sm">Tứ Quý</button>
                <button class="filter-tag flex-shrink-0 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 rounded-sm">Phát Lộc (68, 86)</button>
                <button class="filter-tag flex-shrink-0 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 rounded-sm">San Bằng Tất Cả</button>
                <button class="filter-tag flex-shrink-0 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 rounded-sm">Sảnh Tiến</button>
                <button class="filter-tag flex-shrink-0 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 rounded-sm">Thần Tài</button>
            </div>
        </div>

    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section class="royal-gallery py-20 relative bg-[#050505] overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[300px] bg-gradient-to-b from-[#bf953f]/10 to-transparent pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black gold-text tracking-[0.2em] uppercase italic mb-4 drop-shadow-2xl">
                    SIÊU PHẨM TOÀN QUỐC
                </h2>
                <div class="h-[1px] w-24 bg-[#bf953f] mx-auto mb-4"></div>
                <p class="text-[10px] text-gray-500 uppercase tracking-[0.5em]">The Ultimate Digital Assets</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <div class="master-card group">
                    <div class="relative aspect-[16/10] bg-[#0a0a0a] rounded-t-sm border border-white/5 overflow-hidden flex items-center justify-center p-6">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,_#151515_0%,_#050505_100%)]"></div>

                        <div class="absolute top-4 left-4 z-20">
                            <span class="text-[8px] font-bold bg-[#bf953f] text-black px-2 py-1 rounded-full uppercase tracking-tighter">Đang đấu giá</span>
                        </div>

                        <button class="absolute bottom-4 right-4 z-20 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center gap-2 bg-black/60 backdrop-blur-md border border-white/10 px-3 py-1.5 rounded-sm">
                            <i class="ri-camera-lens-line text-[#bf953f] text-xs"></i>
                            <span class="text-[9px] text-gray-300 uppercase font-bold">Xem ảnh thực tế</span>
                        </button>

                        <div class="plate-mockup relative z-10">
                            <div class="plate-base bg-[#f0f0f0] px-8 py-4 rounded-sm shadow-[0_30px_60px_-15px_rgba(0,0,0,0.9)] border-b-[5px] border-gray-400">
                                <span class="text-black font-bold text-4xl tracking-tighter font-serif block">30K - 999.99</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/20 to-transparent pointer-events-none"></div>
                        </div>

                        <div class="absolute bottom-6 w-1/2 h-2 bg-gradient-to-r from-transparent via-gray-800 to-transparent blur-sm"></div>
                    </div>

                    <div class="bg-[#080808] p-6 border-x border-b border-white/5 rounded-b-sm transition-all duration-500 group-hover:border-[#bf953f]/30">
                        <div class="flex items-center gap-2 mb-3 opacity-60 group-hover:opacity-100 transition-opacity">
                            <i class="ri-map-pin-2-fill text-[#bf953f] text-xs"></i>
                            <span class="text-[10px] text-gray-300 uppercase tracking-widest font-bold">TP. Hồ Chí Minh</span>
                        </div>

                        <div class="text-center py-2">
                            <p class="text-2xl md:text-3xl font-bold gold-text tracking-tight counter-price" data-target="9500000000">0</p>
                            <p class="text-[8px] text-gray-600 font-bold uppercase mt-1">Việt Nam Đồng</p>
                        </div>

                        <button class="mt-6 w-full py-3 border border-[#bf953f]/40 hover:bg-[#bf953f] text-[#bf953f] hover:text-black transition-all duration-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                            Liên hệ sở hữu
                        </button>
                    </div>
                </div>

                <div class="master-card group">
                    <div class="relative aspect-[16/10] bg-[#0a0a0a] border border-white/5 overflow-hidden flex items-center justify-center p-6">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,_#151515_0%,_#050505_100%)]"></div>
                        <div class="absolute top-4 left-4 z-20">
                            <span class="text-[8px] font-bold border border-[#bf953f] text-[#bf953f] px-2 py-1 rounded-full uppercase tracking-tighter">Sẵn hàng</span>
                        </div>
                        <div class="plate-mockup relative z-10">
                            <div class="plate-base bg-[#f0f0f0] px-8 py-4 rounded-sm shadow-2xl border-b-[5px] border-gray-400">
                                <span class="text-black font-bold text-4xl tracking-tighter font-serif">51L - 888.88</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#080808] p-6 border-x border-b border-white/5transition-all">
                        <div class="flex items-center gap-2 mb-3 opacity-60 group-hover:opacity-100">
                            <i class="ri-map-pin-2-fill text-[#bf953f] text-xs"></i>
                            <span class="text-[10px] text-gray-300 uppercase tracking-widest font-bold">Hà Nội</span>
                        </div>
                        <div class="text-center py-2">
                            <p class="text-2xl md:text-3xl font-bold gold-text counter-price" data-target="4500000000">0</p>
                            <p class="text-[8px] text-gray-600 font-bold uppercase mt-1">Việt Nam Đồng</p>
                        </div>
                        <button class="mt-6 w-full py-3 border border-[#bf953f]/40 hover:bg-[#bf953f] text-[#bf953f] hover:text-black transition-all text-[10px] font-bold uppercase tracking-[0.2em]">Liên hệ sở hữu</button>
                    </div>
                </div>

                <div class="master-card group">
                    <div class="relative aspect-[16/10] bg-[#0a0a0a] border border-white/5 overflow-hidden flex items-center justify-center p-6">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,_#151515_0%,_#050505_100%)]"></div>
                        <div class="absolute top-4 left-4 z-20">
                            <span class="text-[8px] font-bold bg-white text-black px-2 py-1 rounded-full uppercase tracking-tighter">Hot Sale</span>
                        </div>
                        <div class="plate-mockup relative z-10">
                            <div class="plate-base bg-[#f0f0f0] px-8 py-4 rounded-sm shadow-2xl border-b-[5px] border-gray-400">
                                <span class="text-black font-bold text-4xl tracking-tighter font-serif">15A - 567.89</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#080808] p-6 border-x border-b border-white/5">
                        <div class="flex items-center gap-2 mb-3 opacity-60 group-hover:opacity-100">
                            <i class="ri-map-pin-2-fill text-[#bf953f] text-xs"></i>
                            <span class="text-[10px] text-gray-300 uppercase tracking-widest font-bold">Hải Phòng</span>
                        </div>
                        <div class="text-center py-2">
                            <p class="text-2xl md:text-3xl font-bold gold-text counter-price" data-target="1200000000">0</p>
                            <p class="text-[8px] text-gray-600 font-bold uppercase mt-1">Việt Nam Đồng</p>
                        </div>
                        <button class="mt-6 w-full py-3 border border-[#bf953f]/40 hover:bg-[#bf953f] text-[#bf953f] hover:text-black transition-all text-[10px] font-bold uppercase tracking-[0.2em]">Liên hệ sở hữu</button>
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
    window.addEventListener('load', () => {
        const tl = gsap.timeline();

        // 1. Chữ hiện ra từ từ
        tl.from("#hero-title h2", {
                opacity: 0,
                y: 10,
                duration: 0.8
            })
            .from("#hero-title h1", {
                opacity: 0,
                y: 20,
                duration: 0.8
            }, "-=0.4");

        // 2. Hiệu ứng "Đôi cánh" - Thanh Search mở rộng sang 2 bên
        tl.to("#search-container", {
            width: "100%",
            opacity: 1,
            duration: 1.2,
            ease: "expo.inOut"
        }, "-=0.4");

        // 3. Các Tags hiện ra với stagger (so le)
        tl.from(".filter-tag", {
            y: 20,
            opacity: 0,
            stagger: 0.05,
            duration: 0.5,
            ease: "power2.out"
        }, "-=0.5");
    });

    // 4. Hiệu ứng gõ số: Nảy nhẹ (Visual Feedback)
    const searchInput = document.querySelector('.luxury-input');
    searchInput.addEventListener('input', (e) => {
        gsap.fromTo(searchInput, {
            y: -2
        }, {
            y: 0,
            duration: 0.2,
            ease: "bounce.out"
        });
    });

    // -----------------------------section 2 ----------------------------- //
    // JS Đếm số tương tự Section trước để đồng bộ
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.getAttribute('data-target'));
                let current = 0;
                const duration = 2000;
                const step = target / (duration / 16);

                const animate = () => {
                    if (current < target) {
                        current += step;
                        el.innerText = Math.floor(current).toLocaleString('vi-VN');
                        requestAnimationFrame(animate);
                    } else {
                        el.innerText = target.toLocaleString('vi-VN');
                    }
                };
                animate();
                observer.unobserve(el);
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.counter-price').forEach(n => observer.observe(n));


    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>