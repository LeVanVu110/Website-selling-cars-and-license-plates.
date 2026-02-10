<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --luxury-gold: #c5a059;
            --sidebar-w: 288px;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: #000;
            margin: 0;
            overflow-x: hidden;
        }

        .font-cinzel {
            font-family: 'Cinzel Decorative', cursive;
        }

        #sidebar {
            width: var(--sidebar-w);
            background: #080808;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1), transform 0.5s ease;
            z-index: 1000;
        }

        #mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
            z-index: 900;
        }

        .clip-octagon {
            clip-path: polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        #active-pill {
            position: absolute;
            left: 0;
            width: 3px;
            background: var(--luxury-gold);
            box-shadow: 0 0 15px var(--luxury-gold);
            border-radius: 0 4px 4px 0;
            z-index: 50;
            pointer-events: none;
        }

        #toggle-sidebar {
            position: absolute;
            right: -12px;
            top: 30px;
            z-index: 999;
            cursor: pointer;
        }

        .menu-item.active i {
            color: var(--luxury-gold) !important;
            filter: drop-shadow(0 0 5px rgba(197, 160, 89, 0.8));
        }

        .menu-item.active .menu-label {
            color: #ffffff !important;
        }

        @media (max-width: 767px) {
            #sidebar {
                transform: translateX(-100%);
                position: fixed;
            }

            #sidebar.mobile-open {
                transform: translateX(0);
                width: 280px !important;
            }

            #toggle-sidebar {
                display: none;
            }
        }
    </style>
</head>

<body>

    <button id="mobile-menu-btn" class="md:hidden fixed top-4 left-4 z-[1100] bg-[#c5a059] p-2 rounded-lg text-black shadow-lg">
        <i class="ri-menu-2-line text-2xl" id="mobile-icon"></i>
    </button>

    <div id="mobile-overlay"></div>

    <aside id="sidebar" class="fixed left-0 top-0 h-screen flex flex-col group">
        <div class="absolute inset-y-0 left-0 w-[1px] bg-gradient-to-b from-[#c5a059]/40 to-transparent"></div>

        <div class="p-6 flex items-center h-20 relative shrink-0">
            <div class="min-w-[32px] flex justify-center items-center">
                <i class="ri-pentagon-line text-2xl text-[#c5a059]"></i>
            </div>
            <span class="font-cinzel text-[#c5a059] tracking-[0.2em] font-bold ml-4 whitespace-nowrap menu-label">INNER CIRCLE</span>

            <div id="toggle-sidebar" class="hidden md:flex bg-[#c5a059] text-black rounded-full w-6 h-6 items-center justify-center shadow-xl hover:scale-110 transition-transform">
                <i class="ri-arrow-left-s-line text-lg transition-transform duration-500" id="desktop-toggle-icon"></i>
            </div>
        </div>

        <div class="flex-1 px-4 py-4 overflow-y-auto no-scrollbar relative" id="menu-container">
            <div id="active-pill"></div>

            <div class="mb-8">
                <p class="text-[9px] text-gray-600 font-bold tracking-[0.3em] uppercase mb-4 px-3 menu-label">The Pulse</p>
                <div class="space-y-1">
                    <a href="Dashboard.php" class="menu-item active flex items-center h-12 px-3 rounded-lg text-gray-400 hover:text-white transition-all group/item">
                        <div class="min-w-[32px] flex justify-center items-center"><i class="ri-dashboard-3-line text-xl"></i></div>
                        <span class="text-[11px] font-medium tracking-widest ml-4 whitespace-nowrap menu-label uppercase">Bảng điều khiển</span>
                    </a>
                    <a href="#" class="menu-item flex items-center h-12 px-3 rounded-lg text-gray-400 hover:text-white transition-all group/item">
                        <div class="min-w-[32px] flex justify-center items-center"><i class="ri-copper-diamond-line text-xl"></i></div>
                        <span class="text-[11px] font-medium tracking-widest ml-4 whitespace-nowrap menu-label uppercase">Doanh thu</span>
                    </a>
                </div>
            </div>

            <div class="mb-8">
                <p class="text-[9px] text-gray-600 font-bold tracking-[0.3em] uppercase mb-4 px-3 menu-label">The Assets</p>
                <div class="space-y-1">
                    <a href="Inventory.php" class="menu-item flex items-center h-12 px-3 rounded-lg text-gray-400 hover:text-white transition-all group/item">
                        <div class="min-w-[32px] flex justify-center items-center"><i class="ri-id-card-line text-xl"></i></div>
                        <span class="text-[11px] font-medium tracking-widest ml-4 whitespace-nowrap menu-label uppercase">Kho biển số</span>
                    </a>
                    <a href="Auction-management.php" class="menu-item flex items-center h-12 px-3 rounded-lg text-gray-400 hover:text-white transition-all group/item">
                        <div class="min-w-[32px] flex justify-center items-center"><i class="ri-hammer-line text-xl"></i></div>
                        <span class="text-[11px] font-medium tracking-widest ml-4 whitespace-nowrap menu-label uppercase">Phiên đấu giá</span>
                    </a>
                    <a href="#" class="menu-item flex items-center h-12 px-3 rounded-lg text-gray-400 hover:text-white transition-all group/item">
                        <div class="min-w-[32px] flex justify-center items-center"><i class="ri-roadster-line text-xl"></i></div>
                        <span class="text-[11px] font-medium tracking-widest ml-4 whitespace-nowrap menu-label uppercase">Quản lý xe</span>
                    </a>
                    <a href="News-management.php" class="menu-item flex items-center h-12 px-3 rounded-lg text-gray-400 hover:text-white transition-all group/item">
                        <div class="min-w-[32px] flex justify-center items-center"><i class="ri-newspaper-line text-xl"></i></div>
                        <span class="text-[11px] font-medium tracking-widest ml-4 whitespace-nowrap menu-label uppercase">Tin tức</span>
                    </a>
                </div>
            </div>

            <div class="mb-8">
                <p class="text-[9px] text-gray-600 font-bold tracking-[0.3em] uppercase mb-4 px-3 menu-label">Inner Circle</p>
                <div class="space-y-1">
                    <a href="#" class="menu-item flex items-center h-12 px-3 rounded-lg text-gray-400 hover:text-white transition-all group/item">
                        <div class="min-w-[32px] flex justify-center items-center"><i class="ri-user-star-line text-xl"></i></div>
                        <span class="text-[11px] font-medium tracking-widest ml-4 whitespace-nowrap menu-label uppercase">Danh sách VIP</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="p-4 border-t border-white/5 bg-black/40 shrink-0">
            <div class="flex items-center p-2 cursor-pointer group/user overflow-hidden">
                <div class="min-w-[40px] h-10 relative shrink-0">
                    <div class="absolute inset-0 bg-[#c5a059] clip-octagon p-[1px]">
                        <div class="w-full h-full bg-[#080808] clip-octagon flex items-center justify-center text-[#c5a059]">
                            <i class="ri-admin-line"></i>
                        </div>
                    </div>
                </div>
                <div class="ml-4 menu-label">
                    <h4 class="text-[10px] font-bold text-white tracking-widest uppercase">GRANDMASTER</h4>
                    <p class="text-[8px] text-[#c5a059] uppercase font-bold">Admin</p>
                </div>
            </div>

            <a href="#" class="flex items-center h-12 px-3 mt-4 rounded-lg text-red-900/40 hover:text-red-500 hover:bg-red-500/5 transition-all group/logout">
                <div class="min-w-[32px] flex justify-center items-center"><i class="ri-logout-box-r-line text-xl"></i></div>
                <span class="text-[10px] font-bold tracking-widest ml-4 menu-label uppercase">Đăng xuất</span>
            </a>
        </div>
    </aside>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggle-sidebar');
            const desktopIcon = document.getElementById('desktop-toggle-icon');
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileOverlay = document.getElementById('mobile-overlay');
            const pill = document.getElementById('active-pill');
            const menuItems = document.querySelectorAll('.menu-item');
            const labels = document.querySelectorAll('.menu-label');

            let isCollapsed = false;
            const offsetCorrection = -15;

            // Hàm cập nhật Pill: Sử dụng offsetTop trực tiếp
            const updatePill = (target) => {
                gsap.to(pill, {
                    y: target.offsetTop + offsetCorrection,
                    height: target.offsetHeight,
                    duration: 0.4,
                    ease: "back.out(1.2)"
                });
            };

            // Mobile Toggle
            const toggleMobile = () => {
                sidebar.classList.toggle('mobile-open');
                const isOpen = sidebar.classList.contains('mobile-open');
                mobileOverlay.style.display = isOpen ? 'block' : 'none';
                document.getElementById('mobile-icon').className = isOpen ? 'ri-close-line text-2xl' : 'ri-menu-2-line text-2xl';
            };

            mobileBtn.addEventListener('click', toggleMobile);
            mobileOverlay.addEventListener('click', toggleMobile);

            // Desktop Toggle
            toggleBtn.addEventListener('click', () => {
                isCollapsed = !isCollapsed;

                // Tìm phần nội dung chính của Dashboard
                const mainContent = document.querySelector('.main-content');

                if (isCollapsed) {
                    sidebar.style.width = '80px';
                    desktopIcon.style.transform = 'rotate(180deg)';

                    // Cập nhật khoảng cách lề của Dashboard
                    if (mainContent) mainContent.style.marginLeft = '80px';

                    gsap.to(labels, {
                        opacity: 0,
                        x: -10,
                        duration: 0.2,
                        display: 'none'
                    });
                } else {
                    sidebar.style.width = '288px';
                    desktopIcon.style.transform = 'rotate(0deg)';

                    // Cập nhật khoảng cách lề của Dashboard
                    if (mainContent) mainContent.style.marginLeft = '288px';

                    gsap.set(labels, {
                        display: 'block'
                    });
                    gsap.to(labels, {
                        opacity: 1,
                        x: 0,
                        duration: 0.3
                    });
                }

                // Đợi hiệu ứng chuyển cảnh hoàn tất (0.5s) rồi cập nhật các thành phần Dashboard
                setTimeout(() => {
                    // 1. Cập nhật lại thanh chỉ thị (Pill)
                    const active = document.querySelector('.menu-item.active');
                    if (active) updatePill(active);

                    // 2. Ép biểu đồ vẽ lại theo kích thước mới của Dashboard
                    if (typeof assetChart !== 'undefined') {
                        assetChart.resize();
                    }
                }, 500);
            });

            // Menu Click
            menuItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    menuItems.forEach(i => i.classList.remove('active'));
                    item.classList.add('active');
                    updatePill(item);
                    if (window.innerWidth < 768) toggleMobile();
                });
            });

            // Khởi tạo
            const currentActive = document.querySelector('.menu-item.active');
            if (currentActive) updatePill(currentActive);
        });
    </script>
</body>

</html>