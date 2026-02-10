<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Plate | Elite Header</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold-grad: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
            --carbon: #0a0a0a;
            --obsidian: #050505;
        }

        body {
            background-color: var(--obsidian);
            font-family: 'Montserrat', sans-serif;
            color: white;
            overflow-x: hidden;
        }

        .font-cinzel {
            font-family: 'Cinzel Decorative', cursive;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        /* Nền Carbon mịn như da xe sang */
        .bg-carbon {
            background-color: var(--carbon);
            background-image: url("https://www.transparenttextures.com/patterns/carbon-fibre.png");
        }

        /* Chữ mạ vàng 3D dập nổi */
        .gold-text {
            background: var(--gold-grad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 2px rgba(0, 0, 0, 0.5));
        }

        .gold-grad-bg {
            background: var(--gold-grad);
        }

        /* Border dải vàng mảnh dưới Header */
        .border-gold-bottom {
            border-image: var(--gold-grad) 1;
            border-bottom-width: 1px;
        }

        /* Nút VIP hiệu ứng kim loại lỏng */
        .vip-card {
            background: var(--gold-grad);
            background-size: 200% auto;
            color: #1a1a1a;
            transition: 0.5s;
            box-shadow: 0 0 15px rgba(179, 135, 40, 0.4);
        }

        /* Hamburger 3 thỏi vàng */
        .gold-bar {
            height: 2px;
            width: 25px;
            background: var(--gold-grad);
            display: block;
            margin: 5px 0;
            transition: 0.4s;
        }

        /* Tia sáng chạy qua Logo */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -100%;
            width: 50%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(30deg);
        }

        /* Hiệu ứng Dropdown Glassmorphism */
        .dropdown-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #e0e0e0;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: 0.3s;
        }

        .dropdown-item a:hover {
            background: linear-gradient(90deg, rgba(191, 149, 63, 0.1) 0%, transparent 100%);
            color: #fff;
            padding-left: 25px;
        }

        /* Vòng xoay Diamond quanh Avatar */
        .avatar-ring {
            animation: spin 10s linear infinite;
            border-style: dashed;
        }

        /* Tạo một vùng đệm phía trên để giữ chuột không bị mất hover */
        #member-dropdown::before {
            content: "";
            position: absolute;
            top: -20px;
            /* Độ cao của khoảng trống */
            left: 0;
            width: 100%;
            height: 20px;
            background: transparent;
        }

        /* Thêm hiệu ứng trỏ chuột để người dùng biết là vùng click được */
        #member-zone {
            padding-bottom: 10px;
            /* Tạo vùng đệm tự nhiên */
            margin-bottom: -10px;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <header id="header" class="fixed top-0 left-0 w-full h-[80px] bg-carbon flex items-center justify-between px-6 md:px-12 z-[1000] border-gold-bottom">

        <div class="logo-container flex items-center cursor-pointer">
            <a href="index.php">
                <h1 id="logo" class="font-cinzel text-xl md:text-2xl gold-text shine-effect uppercase tracking-tighter">
                    Luxury<span class="md:inline hidden"> Plate</span>
                </h1>
            </a>
        </div>

        <nav class="hidden lg:flex items-center gap-10">
            <a href="Plate_warehouse.php" class="nav-item text-gray-400 text-[10px] font-bold tracking-[0.3em] hover:text-white transition-all uppercase">Kho biển số</a>
            <a href="Auction.php" class="nav-item text-gray-400 text-[10px] font-bold tracking-[0.3em] hover:text-white transition-all uppercase">Đấu giá</a>
            <a href="Luxury_Cars.php" class="nav-item text-gray-400 text-[10px] font-bold tracking-[0.3em] hover:text-white transition-all uppercase">Xe sang</a>
            <a href="News.php" class="nav-item text-gray-400 text-[10px] font-bold tracking-[0.3em] hover:text-white transition-all uppercase">Tin Tức</a>
        </nav>

        <div class="flex items-center gap-3 md:gap-6">
            <div class="search-box relative hidden sm:flex items-center bg-white/5 border border-white/10 rounded-full px-4 py-1.5 focus-within:border-[#bf953f]/50 transition-all">
                <i class="ri-search-line text-[#bf953f] mr-2"></i>
                <input type="text" placeholder="Tìm biển số..." class="bg-transparent text-white text-[11px] outline-none w-24 lg:w-32 placeholder:text-gray-700">
            </div>

            <div class="relative" id="member-zone">
                <div class="flex items-center gap-3 cursor-pointer" id="member-trigger">
                    <div class="text-right hidden lg:block">
                        <div class="flex items-center justify-end gap-1">
                            <span class="text-[9px] text-gray-500 italic">Diamond Member</span>
                            <span class="text-[11px] gold-text font-bold uppercase tracking-tight">Mr. Hoàng</span>
                        </div>
                        <div class="h-[1.5px] w-full bg-white/10 mt-1 relative overflow-hidden">
                            <div class="absolute top-0 left-0 h-full w-[80%] gold-grad-bg shadow-[0_0_8px_#bf953f]"></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="avatar-ring absolute -inset-1 border border-[#bf953f]/40 rounded-full"></div>
                        <img src="https://ui-avatars.com/api/?name=H&background=0a0a0a&color=bf953f" class="w-9 h-9 rounded-full border border-[#bf953f]/50 p-[1px] bg-black shadow-lg">
                        <div class="absolute -bottom-1 -right-1 bg-black rounded-full p-[1.5px] border border-[#bf953f]/30">
                            <i class="ri-shield-user-fill text-[8px] text-[#bf953f]"></i>
                        </div>
                    </div>
                </div>

                <div id="member-dropdown" class="absolute right-0 mt-4 w-64 bg-[#0a0a0a]/95 backdrop-blur-2xl border border-[#bf953f]/20 rounded-sm opacity-0 invisible translate-y-4 transition-all z-[1100] shadow-[0_20px_50px_rgba(0,0,0,0.8)]">
                    <div class="px-5 py-3 border-b border-white/5 bg-white/5">
                        <p class="text-[9px] text-gray-500 uppercase tracking-widest">Hạng mức tín nhiệm</p>
                        <p class="text-[11px] gold-text font-bold">1.250.000.000 VNĐ</p>
                    </div>
                    <ul class="py-2">
                        <li class="dropdown-item"><a href="#"><i class="ri-vip-diamond-line"></i> Biển số đã lưu</a></li>
                        <li class="dropdown-item"><a href="#"><i class="ri-auction-line"></i> Lịch sử đấu giá</a></li>
                        <li class="dropdown-item"><a href="#"><i class="ri-user-settings-line"></i> Hồ sơ phong thủy</a></li>
                        <li class="dropdown-item border-t border-white/10 mt-2"><a href="#" class="gold-text"><i class="ri-service-line"></i> Hotline Đặc quyền VIP</a></li>
                        <li class="dropdown-item"><a href="#" class="text-red-900/70"><i class="ri-logout-circle-r-line"></i> Kết thúc phiên làm việc</a></li>
                    </ul>
                </div>
            </div>

            <div id="menu-toggle" class="lg:hidden cursor-pointer pl-2">
                <span class="gold-bar"></span>
                <span class="gold-bar"></span>
                <span class="gold-bar"></span>
            </div>
        </div>
    </header>

    <div id="mobile-drawer" class="fixed top-0 right-0 w-full h-screen bg-[#050505] z-[999] translate-x-full flex flex-col items-center justify-center gap-10">
        <a href="Plate_warehouse.php" class="drawer-item font-playfair text-3xl gold-text italic">Kho Biển Số</a>
        <a href="Auction.php" class="drawer-item font-playfair text-3xl gold-text italic">Đấu Giá</a>
        <a href="Luxury_Cars.php" class="drawer-item font-playfair text-3xl gold-text italic">Xe Sang</a>
        <a href="News.php" class="drawer-item font-playfair text-3xl gold-text italic">Tin Tức</a>
        <button class="vip-card px-10 py-3 rounded-full text-sm font-bold uppercase tracking-widest mt-4">Đặc Quyền VIP</button>
    </div>

    <!-- <main class="pt-[200px] min-h-[200vh] px-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-[#bf953f] uppercase tracking-[1em] text-[10px] mb-6">Welcome to the Inner Circle</h2>
            <h1 class="font-playfair text-4xl md:text-6xl mb-8 italic text-white/90">Trải nghiệm quyền lực số.</h1>
            <p class="text-white/30 font-light max-w-2xl mx-auto leading-relaxed">
                Cuộn trang để cảm nhận hệ thống treo GSAP và hiệu ứng Smart Header.
            </p>
        </div>
    </main> -->

    <script>
        gsap.registerPlugin(ScrollTrigger);

        const header = document.querySelector("#header");
        const memberTrigger = document.querySelector("#member-trigger");
        const memberDropdown = document.querySelector("#member-dropdown");
        const menuToggle = document.querySelector("#menu-toggle");
        const drawer = document.querySelector("#mobile-drawer");
        const bars = document.querySelectorAll(".gold-bar");
        let lastScroll = 0;
        let drawerOpen = false;

        // 1. GSAP: Smart Header (Ẩn/Hiện/Thu nhỏ)
        ScrollTrigger.create({
            start: "top top",
            onUpdate: (self) => {
                const currentScroll = self.scroll();

                // Thu nhỏ và làm mờ nền (Glassmorphism) khi cuộn
                if (currentScroll > 50) {
                    gsap.to(header, {
                        height: 65,
                        backgroundColor: "rgba(10,10,10,0.85)",
                        backdropFilter: "blur(20px)",
                        duration: 0.4
                    });
                } else {
                    gsap.to(header, {
                        height: 80,
                        backgroundColor: "rgba(10,10,10,1)",
                        backdropFilter: "blur(0px)",
                        duration: 0.4
                    });
                }

                // Ẩn khi cuộn xuống, Hiện khi cuộn lên
                if (currentScroll > lastScroll && currentScroll > 200 && !drawerOpen) {
                    gsap.to(header, {
                        yPercent: -100,
                        duration: 0.4,
                        ease: "power2.inOut"
                    });
                } else {
                    gsap.to(header, {
                        yPercent: 0,
                        duration: 0.4,
                        ease: "power2.out"
                    });
                }
                lastScroll = currentScroll;
            }
        });

        // 2. Member Dropdown Logic (Hover)
        function toggleDropdown(show) {
            gsap.to(memberDropdown, {
                autoAlpha: show ? 1 : 0,
                y: show ? 0 : 15,
                duration: 0.4,
                ease: "expo.out"
            });
            if (show) {
                gsap.from(".dropdown-item", {
                    x: 15,
                    opacity: 0,
                    stagger: 0.05,
                    duration: 0.4,
                    ease: "power2.out"
                });
            }
        }

        memberTrigger.addEventListener("mouseenter", () => toggleDropdown(true));
        document.querySelector("#member-zone").addEventListener("mouseleave", () => toggleDropdown(false));

        // 3. Mobile Drawer Logic
        const drawerTl = gsap.timeline({
            paused: true
        });
        drawerTl.to(drawer, {
                x: 0,
                duration: 0.7,
                ease: "expo.inOut"
            })
            .from(".drawer-item", {
                y: 30,
                opacity: 0,
                stagger: 0.1,
                duration: 0.5
            }, "-=0.3");

        menuToggle.addEventListener("click", () => {
            if (!drawerOpen) {
                drawerTl.play();
                gsap.to(bars[0], {
                    rotate: 45,
                    y: 7,
                    duration: 0.3
                });
                gsap.to(bars[1], {
                    opacity: 0,
                    duration: 0.3
                });
                gsap.to(bars[2], {
                    rotate: -45,
                    y: -7,
                    duration: 0.3
                });
            } else {
                drawerTl.reverse();
                gsap.to(bars, {
                    rotate: 0,
                    y: 0,
                    opacity: 1,
                    duration: 0.3
                });
            }
            drawerOpen = !drawerOpen;
        });

        // 4. Logo Shine & VIP Button Liquid Gold Animation
        window.addEventListener("load", () => {
            const style = document.createElement('style');
            style.innerHTML = `
                @keyframes sweep { 0% { left: -100%; } 30% { left: 150%; } 100% { left: 150%; } }
                .shine-effect::after { animation: sweep 6s infinite ease-in-out; }
                @keyframes liquidGold { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
                .vip-card { animation: liquidGold 4s linear infinite; }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>

</html>