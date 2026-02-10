<!DOCTYPE html>
<html lang="vi" class="bg-[#000]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Inner Circle | Registration Ritual</title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            cursor: crosshair;
        }

        .font-cinzel {
            font-family: 'Cinzel Decorative', cursive;
        }

        /* Chống giật trang khi load GSAP */
        .gate-door {
            z-index: 100;
        }

        .stardust {
            pointer-events: none;
        }

        /* Hiệu ứng focus input gold line */
        .gold-line {
            transform: scaleX(0);
            transition: transform 0.6s cubic-bezier(0.19, 1, 0.22, 1);
        }

        input:focus~.gold-line {
            transform: scaleX(1);
        }

        /* Hiệu ứng icon phát sáng */
        input:focus~i {
            color: #d4af37;
            filter: drop-shadow(0 0 8px rgba(212, 175, 55, 0.6));
        }

        /* Scanline cho nút bấm */
        @keyframes scanline {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .animate-scan {
            animation: scanline 3s infinite linear;
        }
    </style>
</head>

<body class="overflow-hidden select-none">

    <div id="left-gate" class="fixed inset-y-0 left-0 w-1/2 bg-[#050505] gate-door border-r border-white/5"></div>
    <div id="right-gate" class="fixed inset-y-0 right-0 w-1/2 bg-[#050505] gate-door border-l border-white/5"></div>

    <div class="fixed inset-0 bg-[#050505] bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-[#1a1a1a] via-[#050505] to-[#000000]"></div>

    <div id="stardust-container" class="fixed inset-0 stardust opacity-30"></div>

    <main class="relative min-h-screen flex items-center justify-center p-4">

        <div class="hidden xl:block fixed left-20 opacity-5 text-8xl text-white">
            <i class="ri-ancient-gate-line"></i>
        </div>
        <div class="hidden xl:block fixed right-20 opacity-5 text-8xl text-white">
            <i class="ri-ancient-gate-line"></i>
        </div>

        <div id="monolith" class="w-full max-w-[500px] backdrop-blur-3xl bg-white/[0.02] border border-white/10 p-10 lg:p-14 shadow-[0_0_80px_rgba(0,0,0,1)] relative z-10 opacity-0">

            <header class="text-center mb-12">
                <h1 class="font-cinzel text-[#d4af37] text-2xl lg:text-3xl tracking-[0.25em] mb-4">The Inner Circle</h1>
                <p class="text-gray-500 text-[10px] tracking-[0.3em] uppercase">Khởi đầu của sự độc bản</p>
            </header>

            <form id="ritual-form" class="space-y-8">
                <div class="cascade-item relative group">
                    <i class="ri-user-star-line absolute left-0 top-2 text-gray-600 transition-all duration-500"></i>
                    <input type="text" placeholder="DANH XƯNG CỦA NGÀI"
                        class="w-full bg-transparent border-b border-white/10 pb-2 pl-8 text-white text-xs tracking-widest focus:outline-none placeholder:text-gray-700">
                    <div class="gold-line absolute bottom-[-1px] left-0 w-full h-[1px] bg-[#d4af37] origin-center"></div>
                </div>

                <div class="cascade-item relative group">
                    <i class="ri-mail-send-line absolute left-0 top-2 text-gray-600 transition-all duration-500"></i>
                    <input type="email" placeholder="ĐỊA CHỈ ĐỊNH DANH (EMAIL)"
                        class="w-full bg-transparent border-b border-white/10 pb-2 pl-8 text-white text-xs tracking-widest focus:outline-none placeholder:text-gray-700">
                    <div class="gold-line absolute bottom-[-1px] left-0 w-full h-[1px] bg-[#d4af37] origin-center"></div>
                </div>

                <div class="cascade-item relative group p-4 border border-dashed border-[#d4af37]/20 rounded-sm">
                    <label class="block text-[8px] text-[#d4af37] tracking-[0.4em] mb-3 uppercase">Mã mời (Bespoke Code)</label>
                    <div class="relative">
                        <i class="ri-key-2-line absolute left-0 top-1 text-gray-600"></i>
                        <input type="text" id="invitation-code" placeholder="INV-XXXX-XXXX"
                            class="w-full bg-transparent pl-8 text-white text-sm font-mono tracking-widest focus:outline-none placeholder:text-gray-800">
                    </div>
                </div>
                <div class="cascade-item mt-6 text-center">
                    <p class="text-[9px] tracking-[0.3em] text-gray-600 uppercase">
                        Đã là mảnh ghép của di sản?
                        <a href="login.php" class="ml-2 text-[#d4af37] hover:text-white transition-colors duration-500 underline-offset-4 underline decoration-[#d4af37]/30">
                            Đăng nhập tại đây
                        </a>
                    </p>
                </div>
                <div class="cascade-item pt-6">
                    <button type="submit" class="relative w-full group overflow-hidden bg-transparent border border-[#d4af37]/40 py-4 transition-all duration-700 hover:border-[#d4af37]">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-scan"></div>

                        <span class="relative z-10 text-[#d4af37] text-[10px] font-bold tracking-[0.5em] uppercase group-hover:text-white transition-colors duration-500">
                            Gia Nhập Lãnh Địa
                        </span>


                        <div class="absolute inset-0 bg-[#d4af37] translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out -z-0"></div>
                    </button>
                </div>
            </form>

            <footer class="mt-12 text-center">
                <p class="text-[8px] text-gray-700 tracking-[0.2em] leading-loose">
                    DỰ LIỆU ĐƯỢC MÃ HÓA CẤP ĐỘ QUÂN SỰ <br>
                    LƯU TRỮ TẠI MÁY CHỦ BẢO MẬT RIÊNG BIỆT (SWISS-SHIELD)
                </p>
            </footer>
        </div>
    </main>

    <script>
        // -- Đăng ký ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);

        document.addEventListener('DOMContentLoaded', () => {

            // 1. ANIMATION: The Gate Opening
            const tlEntrance = gsap.timeline();
            tlEntrance
                .to("#left-gate", {
                    xPercent: -100,
                    duration: 1.8,
                    ease: "expo.inOut"
                })
                .to("#right-gate", {
                    xPercent: 100,
                    duration: 1.8,
                    ease: "expo.inOut"
                }, "<")
                .to("#monolith", {
                    opacity: 1,
                    y: 0,
                    duration: 2,
                    ease: "power4.out"
                }, "-=1")
                .from(".cascade-item", {
                    y: 20,
                    opacity: 0,
                    stagger: 0.15,
                    duration: 1.2,
                    ease: "power3.out"
                }, "-=1.2");

            // 2. ANIMATION: Parallax Stardust
            const container = document.getElementById('stardust-container');
            for (let i = 0; i < 50; i++) {
                const star = document.createElement('div');
                star.className = 'absolute bg-white rounded-full';
                const size = Math.random() * 2;
                star.style.width = `${size}px`;
                star.style.height = `${size}px`;
                star.style.left = `${Math.random() * 100}%`;
                star.style.top = `${Math.random() * 100}%`;
                container.appendChild(star);

                // GSAP Floating
                gsap.to(star, {
                    x: "random(-50, 50)",
                    y: "random(-50, 50)",
                    duration: "random(10, 20)",
                    repeat: -1,
                    yoyo: true,
                    ease: "sine.inOut"
                });
            }

            // 3. INTERACTION: 3D Tilt Effect (Desktop)
            if (window.innerWidth > 1024) {
                const monolith = document.getElementById('monolith');
                document.addEventListener('mousemove', (e) => {
                    const x = (e.clientX - window.innerWidth / 2) / 50;
                    const y = (e.clientY - window.innerHeight / 2) / 50;
                    gsap.to(monolith, {
                        rotateY: x,
                        rotateX: -y,
                        duration: 1,
                        ease: "power2.out"
                    });
                });
            }

            // 4. BESPOKE: Invitation Code Correct
            const invInput = document.getElementById('invitation-code');
            invInput.addEventListener('input', (e) => {
                if (e.target.value.toUpperCase() === 'VIP8888') {
                    gsap.to("body", {
                        backgroundColor: "#0a0a0a",
                        duration: 1
                    });
                    gsap.to(".font-cinzel, .label-text, button span", {
                        color: "#e5e4e2",
                        duration: 1
                    });
                    gsap.to(".gold-line", {
                        backgroundColor: "#e5e4e2",
                        duration: 1
                    });
                    alert("Danh tính Bạch Kim đã được xác thực.");
                }
            });

            // 5. Haptic Feedback (Simulated)
            document.querySelector('button').addEventListener('click', () => {
                if (navigator.vibrate) navigator.vibrate(20);
            });
        });
    </script>
</body>

</html>