<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Plate | GSAP Enhanced</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@300;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold-grad: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
            --carbon: #0a0a0a;
        }

        body {
            background-color: #050505;
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }

        .font-cinzel { font-family: 'Cinzel Decorative', cursive; }
        .font-playfair { font-family: 'Playfair Display', serif; }

        /* Hiệu ứng hạt mịn trên nền đen */
        .bg-carbon {
            background-color: var(--carbon);
            background-image: url("https://www.transparenttextures.com/patterns/carbon-fibre.png");
        }

        /* Chữ mạ vàng 3D */
        .gold-text {
            background: var(--gold-grad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 2px rgba(0,0,0,0.5));
        }

        /* Border vàng mảnh Gradient */
        .border-gold-bottom {
            border-image: var(--gold-grad) 1;
            border-bottom-width: 1px;
        }

        /* Nút VIP kiểu thẻ ATM */
        .vip-card {
            background: var(--gold-grad);
            background-size: 200% auto;
            transition: 0.5s;
            box-shadow: 0 0 15px rgba(179, 135, 40, 0.4);
        }

        /* Hamburger thỏi vàng */
        .gold-bar {
            height: 2px;
            width: 25px;
            background: var(--gold-grad);
            display: block;
            margin: 5px 0;
            transition: 0.4s;
        }

        /* Hiệu ứng gương loá cho Logo */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }
        .shine-effect::after {
            content: "";
            position: absolute;
            top: -50%; left: -100%;
            width: 50%; height: 200%;
            background: rgba(255,255,255,0.2);
            transform: rotate(30deg);
            transition: none;
        }
    </style>
</head>
<body>

    <header id="header" class="fixed top-0 left-0 w-full h-[80px] bg-carbon flex items-center justify-between px-6 md:px-12 z-[1000] border-gold-bottom">
        
        <div class="logo-container flex items-center cursor-pointer">
            <h1 id="logo" class="font-cinzel text-2xl md:text-3xl gold-text shine-effect uppercase tracking-tighter">
                Luxury<span class="md:inline hidden"> Plate</span>
            </h1>
        </div>

        <nav class="hidden lg:flex items-center gap-10">
            <a href="#" class="nav-item text-gray-300 hover:text-white text-xs font-semibold tracking-widest transition-all">KHO BIỂN SỐ</a>
            <a href="#" class="nav-item text-gray-300 hover:text-white text-xs font-semibold tracking-widest transition-all">ĐẤU GIÁ</a>
            <a href="#" class="nav-item text-gray-300 hover:text-white text-xs font-semibold tracking-widest transition-all">XE SANG</a>
            <a href="#" class="nav-item text-gray-300 hover:text-white text-xs font-semibold tracking-widest transition-all">PHONG THỦY</a>
        </nav>

        <div class="flex items-center gap-4 md:gap-8">
            <div class="search-box relative flex items-center bg-white/5 border border-white/10 rounded-full px-4 py-1.5 focus-within:border-[#bf953f]/50 transition-all">
                <i class="ri-search-line text-[#bf953f] mr-2"></i>
                <input type="text" placeholder="Tìm biển số..." class="bg-transparent text-white text-xs outline-none w-24 md:w-40 placeholder:text-gray-600">
            </div>

            <button class="vip-card hidden md:block px-6 py-2 rounded text-[10px] font-black uppercase text-black tracking-tighter hover:scale-105 active:scale-95 transition-transform">
                Đặc Quyền VIP
            </button>

            <div id="menu-toggle" class="lg:hidden cursor-pointer p-2">
                <span class="gold-bar"></span>
                <span class="gold-bar"></span>
                <span class="gold-bar"></span>
            </div>
        </div>
    </header>

    <div id="mobile-drawer" class="fixed top-0 right-0 w-full h-screen bg-[#0a0a0a] z-[999] translate-x-full flex flex-col items-center justify-center gap-8">
        <a href="#" class="drawer-item font-playfair text-3xl gold-text italic">Kho Biển Số</a>
        <a href="#" class="drawer-item font-playfair text-3xl gold-text italic">Đấu Giá</a>
        <a href="#" class="drawer-item font-playfair text-3xl gold-text italic">Xe Sang</a>
        <a href="#" class="drawer-item font-playfair text-3xl gold-text italic">Phong Thủy</a>
        <button class="vip-card px-8 py-3 rounded text-sm font-bold uppercase text-black">Đặc Quyền VIP</button>
    </div>

    <div class="h-[300vh] pt-[150px] px-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-gray-500 uppercase tracking-[1em] text-sm mb-4">The Pinnacle of Luxury</h2>
            <p class="text-white/30 font-light leading-relaxed">Cuộn xuống để cảm nhận hệ thống treo GSAP của Header.</p>
        </div>
    </div>

    <script>
        gsap.registerPlugin(ScrollTrigger);

        const header = document.querySelector("#header");
        const logo = document.querySelector("#logo");
        const menuToggle = document.querySelector("#menu-toggle");
        const drawer = document.querySelector("#mobile-drawer");
        const bars = document.querySelectorAll(".gold-bar");

        // 1. Hiệu ứng Tia Sáng (Light Streak) trên Logo khi load
        gsap.to(".shine-effect", {
            onStart: () => {
                const style = document.createElement('style');
                style.innerHTML = `
                    @keyframes sweep { 
                        0% { left: -100%; } 
                        50% { left: 150%; } 
                        100% { left: 150%; } 
                    }
                    .shine-effect::after { animation: sweep 4s infinite; }
                `;
                document.head.appendChild(style);
            }
        });

        // 2. Hiệu ứng "Lửa vàng" chảy ngầm trên nút VIP
        gsap.to(".vip-card", {
            backgroundPosition: "200% center",
            duration: 4,
            repeat: -1,
            ease: "linear"
        });

        // 3. GSAP ScrollTrigger: Sticky & Shrink & Glassmorphism
        ScrollTrigger.create({
            start: "top top",
            onUpdate: (self) => {
                if (self.direction === 1 && self.scroll() > 100) {
                    // Cuộn xuống: Thu nhỏ & Ẩn (Smart Header)
                    gsap.to(header, { 
                        yPercent: -100, 
                        duration: 0.4, 
                        ease: "power2.inOut" 
                    });
                } else {
                    // Cuộn lên: Hiện lại & Glassmorphism
                    gsap.to(header, { 
                        yPercent: 0, 
                        height: self.scroll() > 50 ? 65 : 80,
                        backgroundColor: self.scroll() > 50 ? "rgba(10,10,10,0.8)" : "rgba(10,10,10,1)",
                        backdropFilter: "blur(12px)",
                        duration: 0.5, 
                        ease: "expo.out" 
                    });
                }
            }
        });

        // 4. Mobile Drawer Logic (GSAP)
        let menuOpen = false;
        const tl = gsap.timeline({ paused: true });

        tl.to(drawer, { x: 0, duration: 0.8, ease: "expo.inOut" })
          .from(".drawer-item", { y: 30, opacity: 0, stagger: 0.1, duration: 0.4 }, "-=0.4");

        menuToggle.addEventListener("click", () => {
            if (!menuOpen) {
                tl.play();
                gsap.to(bars[0], { rotate: 45, y: 7, duration: 0.3 });
                gsap.to(bars[1], { opacity: 0, duration: 0.3 });
                gsap.to(bars[2], { rotate: -45, y: -7, duration: 0.3 });
            } else {
                tl.reverse();
                gsap.to(bars, { rotate: 0, y: 0, opacity: 1, duration: 0.3 });
            }
            menuOpen = !menuOpen;
        });

        // 5. Hover Effect trên Menu Desktop (GSAP)
        document.querySelectorAll(".nav-item").forEach(item => {
            item.addEventListener("mouseenter", () => {
                gsap.to(item, { color: "#bf953f", scale: 1.1, duration: 0.3 });
            });
            item.addEventListener("mouseleave", () => {
                gsap.to(item, { color: "#d1d5db", scale: 1, duration: 0.3 });
            });
        });
    </script>
</body>
</html>