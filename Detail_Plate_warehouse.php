<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */

        /* ----------------------------- section 2 -----------------------------  */

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

    <style>
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
    </style>

    <script>
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
    </script>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include('footer.php'); ?>
</body>
<script>
    //----------------------------- section 1 ----------------------------- //

    // -----------------------------section 2 ----------------------------- //

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>