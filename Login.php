<!DOCTYPE html>
<html lang="vi" class="bg-[#030303]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Vault Access | Hội Viên Đăng Nhập</title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .font-cinzel {
            font-family: 'Cinzel Decorative', cursive;
        }

        /* Hiệu ứng hạt đá Obsidian */
        .obsidian-grain {
            background-image: url('https://www.transparenttextures.com/patterns/stardust.png');
        }

        /* Floating Label Logic */
        .input-box input:placeholder-shown~label {
            top: 50%;
            font-size: 10px;
            color: #666;
        }

        .input-box input:focus~label,
        .input-box input:not(:placeholder-shown)~label {
            top: -12px;
            font-size: 8px;
            color: #e5e5e5;
            letter-spacing: 0.2em;
        }

        /* Scan Line Animation */
        .scan-line {
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
            z-index: 50;
        }

        /* Custom Cursor cho Fingerprint */
        .fingerprint-cursor {
            pointer-events: none;
            position: fixed;
            width: 40px;
            height: 40px;
            border: 1px solid rgba(229, 229, 229, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e5e5e5;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s;
        }

        /* Nút Truy Cập - Shine Effect */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }

        .btn-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: skewX(-25deg);
        }

        .btn-shine:hover::after {
            animation: shine 1.2s ease-in-out;
        }

        @keyframes shine {
            100% {
                left: 150%;
            }
        }
    </style>
</head>

<body class="overflow-hidden bg-[#030303]">

    <div class="fingerprint-cursor" id="custom-cursor">
        <i class="ri-fingerprint-line text-xl"></i>
    </div>

    <div class="fixed inset-0 z-0 opacity-10 pointer-events-none flex justify-around">
        <div class="scroll-column space-y-20 pt-10">
            <h2 class="text-6xl font-cinzel text-white">30K-999.99</h2>
            <h2 class="text-6xl font-cinzel text-white">51L-888.88</h2>
            <h2 class="text-6xl font-cinzel text-white">30K-777.77</h2>
        </div>
        <div class="scroll-column space-y-20 pt-40 hidden md:block">
            <h2 class="text-6xl font-cinzel text-white">99-999.99</h2>
            <h2 class="text-6xl font-cinzel text-white">11-111.11</h2>
            <h2 class="text-6xl font-cinzel text-white">66-666.66</h2>
        </div>
    </div>

    <main class="relative z-10 min-h-screen flex items-center justify-center p-6 obsidian-grain">

        <div class="access-card max-w-md w-full backdrop-blur-3xl bg-black/40 border-l-[1px] border-t-[1px] border-white/20 p-10 lg:p-12 shadow-[0_0_100px_rgba(0,0,0,1)] relative overflow-hidden">

            <div id="laser-scan" class="absolute left-0 w-full scan-line"></div>

            <header class="text-center mb-16">
                <h2 class="font-cinzel text-[#e5e5e5] tracking-[0.4em] uppercase text-2xl mb-2">The Vault Access</h2>
                <div class="w-10 h-[1px] bg-white/30 mx-auto"></div>
                <p class="text-[9px] text-gray-500 tracking-[0.3em] mt-4 uppercase">Nhập mật mã định danh của Ngài</p>
                <div id="error-message" class="text-[9px] text-red-500 tracking-[0.2em] uppercase mb-4 hidden text-center">
                    Mật mã định danh không chính xác
                </div>
            </header>


            <form id="login-form" class="space-y-12">
                <div class="input-box relative flex items-center border-b border-white/10 pb-2">
                    <i class="ri-shield-user-line text-[#e5e5e5] mr-4 text-lg"></i>
                    <div class="relative w-full">
                        <input type="text" name="username" placeholder=" " id="username"
                            class="w-full bg-transparent text-white text-xs tracking-widest focus:outline-none">
                        <label class="absolute left-0 -translate-y-1/2 pointer-events-none transition-all duration-300 uppercase">Danh tính</label>
                    </div>
                </div>

                <div class="input-box relative flex items-center border-b border-white/10 pb-2">
                    <i class="ri-key-line text-[#e5e5e5] mr-4 text-lg"></i>
                    <div class="relative w-full">
                        <input type="password" placeholder=" " id="password" name="password"
                            class="w-full bg-transparent text-white text-xs tracking-widest focus:outline-none">
                        <label class="absolute left-0 -translate-y-1/2 pointer-events-none transition-all duration-300 uppercase">Mật mã</label>
                    </div>
                    <!-- <button type="button" class="text-[8px] tracking-tighter text-gray-500 hover:text-white transition-colors uppercase">Quên?</button> -->
                </div>

                <div class="flex justify-center opacity-30 hover:opacity-100 transition-opacity cursor-pointer">
                    <i class="ri-face-recognize-line text-2xl text-white"></i>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-shine w-full py-5 bg-transparent border border-[#e5e5e5] text-[#e5e5e5] text-[10px] font-bold uppercase tracking-[0.5em] hover:bg-white hover:text-black transition-all duration-700">
                        Truy Cập Tuyệt Mật
                    </button>
                </div>
            </form>

            <footer class="mt-16 flex justify-between items-center">
                <a href="Registration.php" class="text-[9px] text-gray-600 hover:text-[#e5e5e5] tracking-widest uppercase transition-colors">Gia nhập mới?</a>
                <div class="h-8 w-px bg-white/10"></div>
                <div class="flex items-center gap-2 group cursor-pointer">
                    <span class="text-[9px] text-gray-600 group-hover:text-white transition-colors uppercase">Hỗ trợ quản gia</span>
                    <i class="ri-customer-service-2-line text-gray-600 group-hover:text-white"></i>
                </div>
            </footer>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 1. GSAP: Entrance Animation
            const tl = gsap.timeline();
            tl.from(".access-card", {
                    scale: 1.1,
                    opacity: 0,
                    duration: 2,
                    ease: "power4.out"
                })
                .from("#laser-scan", {
                    top: "-10%",
                    duration: 1.5,
                    ease: "power2.inOut"
                }, "-=1.5")
                .to("#laser-scan", {
                    top: "110%",
                    duration: 1.5,
                    ease: "power2.inOut"
                })
                .to("#laser-scan", {
                    opacity: 0,
                    duration: 0.5
                });

            // 2. Parallax Infinite Scroll Background
            gsap.to(".scroll-column", {
                y: -500,
                duration: 30,
                repeat: -1,
                ease: "none"
            });

            // 3. Custom Fingerprint Cursor (Desktop)
            const cursor = document.getElementById('custom-cursor');
            const card = document.querySelector('.access-card');

            card.addEventListener('mouseenter', () => {
                gsap.to(cursor, {
                    opacity: 1,
                    duration: 0.3
                });
            });
            card.addEventListener('mouseleave', () => {
                gsap.to(cursor, {
                    opacity: 0,
                    duration: 0.3
                });
            });

            window.addEventListener('mousemove', (e) => {
                gsap.to(cursor, {
                    x: e.clientX - 20,
                    y: e.clientY - 20,
                    duration: 0.1
                });
            });

            // 4. Vault Access Animation (Submit)
            // 4. Vault Access Animation & Authentication
            const form = document.getElementById('login-form');
            const errorMsg = document.getElementById('error-message');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Lấy dữ liệu từ input
                const formData = new FormData();
                formData.append('username', document.getElementById('username').value);
                formData.append('password', document.getElementById('password').value);

                // Hiệu ứng rung nhẹ khi bắt đầu kiểm tra (Gear crunching effect)
                gsap.to(".access-card", {
                    x: 2,
                    repeat: 3,
                    duration: 0.05,
                    yoyo: true
                });

                try {
                    // Gửi dữ liệu đến file xử lý (Controller)
                    const response = await fetch('auth_controller.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.status === 'success') {
                        // Nếu thành công: Chạy hiệu ứng biến mất đẳng cấp
                        errorMsg.classList.add('hidden');
                        gsap.to(".access-card", {
                            scale: 0.95,
                            opacity: 0,
                            duration: 0.8,
                            ease: "power4.in",
                            onComplete: () => {
                                window.location.href = result.redirect;// Chuyển vào Dashboard
                            }
                        });
                    } else {
                        // Nếu thất bại: Hiện lỗi và rung mạnh hơn
                        errorMsg.innerText = result.message;
                        errorMsg.classList.remove('hidden');
                        gsap.fromTo(".access-card", {
                            x: -10
                        }, {
                            x: 0,
                            duration: 0.5,
                            ease: "elastic.out(1, 0.3)"
                        });
                    }
                } catch (error) {
                    console.error("Lỗi hệ thống Vault:", error);
                }
            });
        });
    </script>
</body>

</html>