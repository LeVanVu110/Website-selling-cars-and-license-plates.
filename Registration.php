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

        :root {

            --luxury-gold: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
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

        /* Diamond Strength Meter */
        .strength-diamond {
            width: 8px;
            height: 8px;
            transform: rotate(45deg);
            background: #222;
            /* TẮT */
            border: 1px solid #333;
            transition: all 0.4s ease;
        }

        .strength-diamond.active {
            background: #d4af37;
            /* VÀNG LUXURY */
            width: 8px;
            height: 8px;
            box-shadow: 0 0 8px rgba(212, 175, 55, 0.8);
        }

        .active-diamond {
            background: var(--luxury-gold);
            box-shadow: 0 0 10px var(--luxury-gold);
        }

        .btn-scan::after {
            content: '';
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(197, 160, 89, 0.2), transparent);
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

            <!-- <form action="Login.php" id="ritual-form" class="space-y-8">
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
                <div class="cascade-item  space-y-4">
                    <div class="relative group">
                        <input type="password"
                            id="pass-input"
                            placeholder="MẬT MÃ BẢO MẬT"
                            class="w-full bg-transparent border-b border-white/10 pb-2 text-white text-xs tracking-widest focus:outline-none placeholder:text-white/70">
                        <button type="button" id="toggle-pass" class="absolute right-0 bottom-2 text-gray-600 hover:text-[#c5a059]">
                            <i class="ri-eye-close-line"></i>
                        </button>
                        <div class="gold-line absolute bottom-0 left-0 w-full h-[1px] bg-[#c5a059] origin-center"></div>
                    </div>

                    <div id="strength-meter" class="flex gap-2 items-center justify-end">
                        <span class="text-[8px] text-gray-600 tracking-widest mr-2">ĐỘ BẢO MẬT:</span>
                        <div class="strength-diamond"></div>
                        <div class="strength-diamond"></div>
                        <div class="strength-diamond"></div>
                        <div class="strength-diamond"></div>
                    </div>
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
                        <a href="Login.php" class="ml-2 text-[#d4af37] hover:text-white transition-colors duration-500 underline-offset-4 underline decoration-[#d4af37]/30">
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
            </form> -->
            <form id="ritual-form" class="space-y-8">
                <div class="cascade-item relative group">
                    <i class="ri-user-star-line absolute left-0 top-2 text-gray-600 transition-all duration-500"></i>
                    <input type="text" name="fullname" required placeholder="DANH XƯNG CỦA NGÀI"
                        class="w-full bg-transparent border-b border-white/10 pb-2 pl-8 text-white text-xs tracking-widest focus:outline-none placeholder:text-gray-700">
                    <div class="gold-line absolute bottom-[-1px] left-0 w-full h-[1px] bg-[#d4af37] origin-center"></div>
                </div>

                <input type="hidden" name="username" id="hidden-username">

                <div class="cascade-item relative group">
                    <i class="ri-mail-send-line absolute left-0 top-2 text-gray-600 transition-all duration-500"></i>
                    <input type="email" id="reg-email" name="email" required placeholder="ĐỊA CHỈ ĐỊNH DANH (EMAIL)"
                        class="w-full bg-transparent border-b border-white/10 pb-2 pl-8 text-white text-xs tracking-widest focus:outline-none placeholder:text-gray-700">
                    <div class="gold-line absolute bottom-[-1px] left-0 w-full h-[1px] bg-[#d4af37] origin-center"></div>
                </div>

                <div class="cascade-item  space-y-4">
                    <div class="relative group">
                        <input type="password" name="password" required
                            id="pass-input"
                            placeholder="MẬT MÃ BẢO MẬT"
                            class="w-full bg-transparent border-b border-white/10 pb-2 text-white text-xs tracking-widest focus:outline-none placeholder:text-white/70">
                        <button type="button" id="toggle-pass" class="absolute right-0 bottom-2 text-gray-600 hover:text-[#c5a059]">
                            <i class="ri-eye-close-line"></i>
                        </button>
                        <div class="gold-line absolute bottom-0 left-0 w-full h-[1px] bg-[#c5a059] origin-center"></div>
                    </div>

                    <div id="strength-meter" class="flex gap-2 items-center justify-end">
                        <span class="text-[8px] text-gray-600 tracking-widest mr-2">ĐỘ BẢO MẬT:</span>
                        <div class="strength-diamond"></div>
                        <div class="strength-diamond"></div>
                        <div class="strength-diamond"></div>
                        <div class="strength-diamond"></div>
                    </div>
                </div>

                <div class="cascade-item relative group p-4 border border-dashed border-[#d4af37]/20 rounded-sm">
                    <label class="block text-[8px] text-[#d4af37] tracking-[0.4em] mb-3 uppercase">Mã mời (Bespoke Code)</label>
                    <div class="relative">
                        <i class="ri-key-2-line absolute left-0 top-1 text-gray-600"></i>
                        <input type="text" name="invitation_code" id="invitation-code" placeholder="INV-XXXX-XXXX"
                            class="w-full bg-transparent pl-8 text-white text-sm font-mono tracking-widest focus:outline-none placeholder:text-gray-800">
                    </div>
                </div>

                <div class="cascade-item mt-6 text-center">
                    <p class="text-[9px] tracking-[0.3em] text-gray-600 uppercase">
                        Đã là mảnh ghép của di sản?
                        <a href="Login.php" class="ml-2 text-[#d4af37] hover:text-white transition-colors duration-500 underline-offset-4 underline decoration-[#d4af37]/30">
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
            // Entrance Animation
            const tl = gsap.timeline();
            tl.to("#left-gate", {
                    xPercent: -100,
                    duration: 1.5,
                    ease: "expo.inOut"
                })
                .to("#right-gate", {
                    xPercent: 100,
                    duration: 1.5,
                    ease: "expo.inOut"
                }, "<")
                .to("#reg-card", {
                    opacity: 1,
                    y: 0,
                    duration: 1.5
                }, "-=0.5");

            // Password Toggle
            const passInput = document.getElementById('pass-input');
            const toggleBtn = document.getElementById('toggle-pass');

            // Strength Meter
            const strengthMeter = document.getElementById('strength-meter');
            const diamonds = strengthMeter.querySelectorAll('.strength-diamond');

            toggleBtn.addEventListener('click', () => {
                const isPass = passInput.type === 'password';
                passInput.type = isPass ? 'text' : 'password';
                toggleBtn.innerHTML = isPass ?
                    '<i class="ri-eye-line"></i>' :
                    '<i class="ri-eye-close-line"></i>';
            });

            // Password Strength (4 levels)
            passInput.addEventListener('input', () => {
                const val = passInput.value;
                let level = 0;

                if (val.length > 0) level = 1;
                if (val.length >= 6) level = 2;
                if (/[A-Z]/.test(val) && /[0-9]/.test(val)) level = 3;
                if (val.length >= 10 && /[^A-Za-z0-9]/.test(val)) level = 4;

                diamonds.forEach((diamond, index) => {
                    diamond.classList.toggle('active-diamond', index < level);
                });
            });


        });
        // Gán username bằng email tự động khi người dùng nhập
        document.getElementById('reg-email').addEventListener('input', (e) => {
            document.getElementById('hidden-username').value = e.target.value;
        });

        // Xử lý gửi Form bằng AJAX
        document.getElementById('ritual-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const btnText = this.querySelector('button span');
            btnText.innerText = "ĐANG KHỞI TẠO DI SẢN...";

            try {
                const response = await fetch('register_controller.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.status === 'success') {
                    alert("Chào mừng Ngài gia nhập Inner Circle!");
                    window.location.href = 'Login.php';
                } else {
                    alert(data.message);
                    btnText.innerText = "GIA NHẬP LÃNH ĐỊA";
                }
            } catch (err) {
                alert("Hệ thống trục trặc, vui lòng thử lại sau.");
                btnText.innerText = "GIA NHẬP LÃNH ĐỊA";
            }
        });
    </script>
</body>

</html>