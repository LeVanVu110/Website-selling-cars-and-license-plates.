<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        /* 1. Opening Animation */
        @keyframes openingZoom {
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .plate-frame {
            animation: openingZoom 1.5s cubic-bezier(0.23, 1, 0.32, 1) forwards;
            transform: scale(0.8) translateY(20px);
        }

        /* 2. Glass Shimmer Effect */
        .glass-shimmer {
            position: absolute;
            top: 0;
            left: -150%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-20deg);
            transition: 0.5s;
            animation: shimmerMove 6s infinite;
        }

        @keyframes shimmerMove {
            0% {
                left: -150%;
            }

            20% {
                left: 150%;
            }

            100% {
                left: 150%;
            }
        }

        /* 3. Breathing Price */
        @keyframes breathing {

            0%,
            100% {
                text-shadow: 0 0 10px rgba(191, 149, 63, 0.2);
                opacity: 0.9;
            }

            50% {
                text-shadow: 0 0 30px rgba(191, 149, 63, 0.6);
                opacity: 1;
            }
        }

        .price-breathing {
            animation: breathing 3s ease-in-out infinite;
        }

        /* 4. Color Buttons (Nút áo cao cấp) */
        .color-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
            position: relative;
        }

        .color-btn.active {
            border-color: #bf953f;
            transform: scale(1.2);
            box-shadow: 0 0 15px rgba(191, 149, 63, 0.5);
        }

        /* 5. Responsive Styles */
        @media (max-width: 768px) {
            .visual-stage {
                padding-top: 10px;
            }

            .plate-surface {
                padding: 20px 30px;
            }

            .plate-surface span {
                font-size: 2.5rem;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Glassmorphism Effect */
        .glass-morphism {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Hiệu ứng tia sáng lóe lên (Sparkle) */
        @keyframes sparkle {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        #destiny-code::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: radial-gradient(circle at var(--x, 50%) var(--y, 50%), rgba(191, 149, 63, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Outline Text cho số phong thủy */
        .gold-text {
            background: linear-gradient(to bottom, #bf953f 22%, #fcf6ba 45%, #b38728 50%, #fcf6ba 55%, #bf953f 78%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            color: #fff;
        }

        @media (max-width: 1024px) {
            .energy-bar {
                height: 4px;
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
    <section class="visual-stage min-h-screen bg-[#050505] relative overflow-hidden pt-24 pb-12">

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[150%] h-[150%] bg-[radial-gradient(circle_at_50%_0%,rgba(191,149,63,0.15)_0%,transparent_50%)] pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row gap-12 lg:items-start">

                <div class="w-full lg:w-3/5 lg:sticky lg:top-32 h-fit">
                    <div class="relative group">

                        <div id="car-preview" class="absolute inset-0 rounded-xl overflow-hidden opacity-40 transition-all duration-1000 scale-105 blur-[2px]">
                            <img id="car-img" src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=2070" class="w-full h-full object-cover" alt="Car Preview">
                        </div>

                        <div class="relative aspect-[16/9] flex items-center justify-center p-12">
                            <div class="absolute bottom-10 w-1/2 h-4 bg-gradient-to-b from-[#1a1a1a] to-[#000] rounded-full blur-md opacity-60"></div>

                            <div id="master-plate" class="plate-frame relative opacity-0 translate-z-20 scale-90">
                                <div class="plate-surface relative bg-white px-12 py-5 rounded-sm shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden">
                                    <div class="glass-shimmer"></div>
                                    <span class="text-black font-bold text-5xl md:text-7xl tracking-tighter font-serif select-none">30K-999.99</span>
                                </div>

                                <div class="absolute -bottom-4 right-4 bg-[#bf953f] text-black text-[8px] font-black px-2 py-1 rounded-full animate-bounce md:hidden">
                                    <i class="ri-zoom-in-line"></i> SOI CHI TIẾT
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center gap-2 mt-4 md:hidden">
                            <div class="w-8 h-1 bg-[#bf953f] rounded-full"></div>
                            <div class="w-2 h-1 bg-white/20 rounded-full"></div>
                            <div class="w-2 h-1 bg-white/20 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-2/5 flex flex-col gap-8">
                    <div>
                        <nav class="flex gap-2 mb-6 text-[10px] text-gray-500 uppercase tracking-widest">
                            <a href="#" class="hover:text-white transition-colors">Kho số</a>
                            <span>/</span>
                            <a href="#" class="text-[#bf953f]">Chi tiết biển số</a>
                        </nav>

                        <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter mb-2">30K-999.99</h1>
                        <div class="flex items-center gap-4">
                            <span class="badge-gold">Ngũ Quý 9</span>
                            <span class="text-gray-500 text-xs font-medium italic">📍 Hà Nội</span>
                        </div>
                    </div>

                    <div class="bg-black/40 border-y border-white/5 py-8">
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-1">Giá trị sở hữu</p>
                        <div class="price-breathing text-4xl md:text-5xl font-black text-[#bf953f]">
                            9,500,000,000 <span class="text-sm text-gray-600 uppercase">vnd</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <p class="text-[10px] text-white font-bold uppercase tracking-widest">Ướm thử màu xe</p>
                        <div class="flex gap-4">
                            <button class="color-btn active" data-img="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=2070" style="background: #ffffff;" title="Trắng Pearl"></button>
                            <button class="color-btn" data-img="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?q=80&w=2070" style="background: #111111;" title="Đen Obsidian"></button>
                            <button class="color-btn" data-img="https://images.unsplash.com/photo-1544636331-e26879cd4d9b?q=80&w=2070" style="background: #8b0000;" title="Đỏ Ruby"></button>
                            <button class="color-btn" data-img="https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=2070" style="background: #002366;" title="Xanh Sapphire"></button>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 pt-6">
                        <button class="w-full py-5 bg-[#bf953f] text-black font-black uppercase tracking-[0.2em] text-xs hover:bg-white transition-all duration-500 shadow-[0_0_30px_rgba(191,149,63,0.2)]">
                            Liên hệ sở hữu ngay
                        </button>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="py-4 border border-white/10 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-white/5 transition-all">
                                Xem phong thủy
                            </button>
                            <button class="py-4 border border-white/10 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-white/5 transition-all">
                                Chia sẻ VIP
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 w-full bg-black/90 backdrop-blur-md border-t border-[#bf953f]/30 p-4 flex gap-4 md:hidden z-[100]">
            <a href="tel:090..." class="flex-1 bg-white text-black py-3 text-center font-black text-[10px] uppercase tracking-widest">Hotline</a>
            <a href="#" class="flex-1 bg-[#bf953f] text-black py-3 text-center font-black text-[10px] uppercase tracking-widest">Mua ngay</a>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="destiny-code" class="py-24 bg-[#030303] relative overflow-hidden border-t border-white/5">

        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] opacity-10 pointer-events-none">
            <svg viewBox="0 0 200 200" class="w-full h-full animate-[spin_60s_linear_infinite]">
                <circle cx="100" cy="100" r="95" fill="none" stroke="#bf953f" stroke-width="0.2" />
                <circle cx="100" cy="100" r="70" fill="none" stroke="#bf953f" stroke-width="0.2" stroke-dasharray="2 2" />
                <path d="M100 5 L100 195 M5 100 L195 100 M33 33 L167 167 M33 167 L167 33" stroke="#bf953f" stroke-width="0.1" />
                <g stroke="#bf953f" stroke-width="1">
                    <line x1="95" y1="15" x2="105" y2="15" />
                    <line x1="95" y1="185" x2="105" y2="185" />
                </g>
            </svg>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-2xl md:text-3xl font-light text-white tracking-[0.4em] uppercase mb-4">
                    The <span class="font-bold gold-text">Destiny Code</span>
                </h2>
                <div class="flex justify-center items-center gap-4">
                    <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-[#bf953f]"></div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest">Giải mã năng lượng con số bởi AI</p>
                    <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-[#bf953f]"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 items-center">

                <div class="order-2 lg:order-1 flex flex-col gap-12">
                    <div class="group cursor-help">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-full border border-[#bf953f]/30 flex items-center justify-center bg-[#bf953f]/5 group-hover:bg-[#bf953f]/20 transition-all">
                                <i class="ri-copper-coin-line text-[#bf953f]"></i>
                            </div>
                            <h4 class="text-white font-bold text-xs uppercase tracking-widest">Bản mệnh Biển số</h4>
                        </div>
                        <div class="glass-morphism p-6 rounded-sm border border-white/5">
                            <span class="text-2xl font-bold gold-text block mb-2">MỆNH KIM</span>
                            <p class="text-[11px] text-gray-400 leading-relaxed italic">
                                Dãy số 999.99 mang năng lượng của sự cứng cáp, bền bỉ và quyền uy tối cao. Tương sinh tuyệt vời cho chủ nhân mệnh Thủy hoặc Kim.
                            </p>
                        </div>
                    </div>

                    <div class="group cursor-help">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-full border border-[#bf953f]/30 flex items-center justify-center bg-[#bf953f]/5">
                                <i class="ri-flashlight-line text-[#bf953f]"></i>
                            </div>
                            <h4 class="text-white font-bold text-xs uppercase tracking-widest">Chỉ số năng lượng</h4>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between text-[9px] text-gray-500 uppercase font-bold">
                                <span>Thịnh vượng</span>
                                <span class="text-[#bf953f] count-up" data-target="99">0</span><span>%</span>
                            </div>
                            <div class="h-[2px] w-full bg-white/5 relative">
                                <div class="energy-bar absolute top-0 left-0 h-full bg-[#bf953f] shadow-[0_0_10px_#bf953f]" style="width: 0%" data-width="99%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2 flex justify-center relative">
                    <div class="relative w-64 h-64 md:w-80 md:h-80 flex items-center justify-center">
                        <div class="absolute inset-0 border border-[#bf953f]/20 rounded-full animate-[pulse_4s_ease-in-out_infinite]"></div>
                        <div class="absolute inset-8 border border-white/5 rounded-full"></div>

                        <div class="text-center z-10">
                            <div class="text-5xl font-black text-white mb-2 tracking-tighter">9.9</div>
                            <div class="text-[10px] text-[#bf953f] font-bold uppercase tracking-[0.3em]">Điểm Cát Tường</div>
                        </div>

                        <div class="absolute top-0 left-1/2 w-2 h-2 bg-[#bf953f] rounded-full blur-sm animate-[ping_2s_infinite]"></div>
                    </div>
                </div>

                <div class="order-3 lg:order-3 flex flex-col gap-12">
                    <div class="group">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-full border border-[#bf953f]/30 flex items-center justify-center bg-[#bf953f]/5">
                                <i class="ri-book-open-line text-[#bf953f]"></i>
                            </div>
                            <h4 class="text-white font-bold text-xs uppercase tracking-widest">Quẻ Dịch Chiêm Đoán</h4>
                        </div>
                        <div class="border-l-2 border-[#bf953f]/50 pl-6 py-2">
                            <span class="text-lg font-bold text-white block mb-2 uppercase italic tracking-tighter">Quẻ Thuần Càn</span>
                            <p class="text-[11px] text-gray-500 leading-relaxed uppercase">
                                "Rồng bay trên trời, vạn sự hanh thông, danh tiếng vang dội, phú quý tự tìm đến."
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 bg-gradient-to-br from-[#111] to-black p-6 border border-[#bf953f]/20 rounded-sm">
                        <p class="text-[10px] text-white font-bold uppercase mb-4 text-center tracking-widest">Kiểm tra mức độ hợp tuổi</p>
                        <div class="flex flex-col gap-3">
                            <input type="text" placeholder="NĂM SINH (VD: 1988)" class="bg-transparent border border-white/10 px-4 py-3 text-[10px] text-white focus:outline-none focus:border-[#bf953f] transition-all text-center">
                            <button class="w-full py-3 bg-[#bf953f] text-black text-[10px] font-black uppercase tracking-widest hover:brightness-110 transition-all">
                                Phân tích ngay
                            </button>
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
        const colorBtns = document.querySelectorAll('.color-btn');
        const carImg = document.getElementById('car-img');
        const carPreview = document.getElementById('car-preview');

        colorBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // 1. Update UI Buttons
                colorBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // 2. Dynamic Swap (Cross-fade)
                const newImgSrc = this.getAttribute('data-img');

                // Hiệu ứng mờ dần trước khi đổi ảnh
                carPreview.style.opacity = '0';

                setTimeout(() => {
                    carImg.src = newImgSrc;
                    carPreview.style.opacity = '0.4';
                    // Nháy nhẹ biển số để tạo cảm giác "lắp ráp"
                    gsap.from("#master-plate", {
                        scale: 1.02,
                        duration: 0.4,
                        ease: "power2.out"
                    });
                }, 500);
            });
        });

        // Hiệu ứng Kính lúp đơn giản cho Mobile (Sparring Partner request)
        const masterPlate = document.getElementById('master-plate');
        masterPlate.addEventListener('touchstart', () => {
            masterPlate.style.transform = 'scale(1.1)';
            masterPlate.style.transition = '0.3s';
        });
        masterPlate.addEventListener('touchend', () => {
            masterPlate.style.transform = 'scale(1)';
        });
    });

    // -----------------------------section 2 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Hiệu ứng Số nhảy & Progress Bar khi cuộn chuột tới
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Chạy Progress Bar
                    const bar = entry.target.querySelector('.energy-bar');
                    if (bar) bar.style.width = bar.getAttribute('data-width');

                    // Chạy số nhảy
                    const counters = entry.target.querySelectorAll('.count-up');
                    counters.forEach(counter => {
                        const target = +counter.getAttribute('data-target');
                        let count = 0;
                        const updateCount = () => {
                            const increment = target / 50;
                            if (count < target) {
                                count += increment;
                                counter.innerText = Math.ceil(count);
                                setTimeout(updateCount, 20);
                            } else {
                                counter.innerText = target;
                            }
                        };
                        updateCount();
                    });
                }
            });
        }, {
            threshold: 0.5
        });

        observer.observe(document.getElementById('destiny-code'));

        // 2. Hiệu ứng tia sáng theo chuột (Mouse Move Glow)
        const section = document.getElementById('destiny-code');
        section.addEventListener('mousemove', e => {
            const rect = section.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            section.style.setProperty('--x', `${x}%`);
            section.style.setProperty('--y', `${y}%`);
        });
    });

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>