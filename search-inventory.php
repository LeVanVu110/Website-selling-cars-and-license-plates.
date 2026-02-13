<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="vi">
<?php
include('header.php');
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";
require_once __DIR__ . "/models/Place.php";

$plateModel = new Place();
$keyword = $_GET['keyword'] ?? '';
$province = $_GET['province'] ?? '';

// Nếu có từ khóa thì search, không thì lấy tất cả
$plates = $plateModel->filterPlates($keyword, $province);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Vault Search | Radar Thượng Lưu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --luxury-gold: #c5a059;
            --obsidian: #080808;
        }

        body {
            background-color: var(--obsidian);
            color: white;
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
            margin-top: 80px;
        }

        .font-cinzel {
            font-family: 'Cinzel Decorative', cursive;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        /* Hiệu ứng mờ ảo cho Radar */
        .radar-glow {
            box-shadow: 0 0 20px rgba(197, 160, 89, 0.1);
        }

        /* Biển số 3D */
        .plate-3d {
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            color: #1a1a1a;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5), inset -2px -2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .plate-gold {
            background: linear-gradient(145deg, #c5a059, #8e6d35);
            color: #fff;
            box-shadow: 0 10px 30px rgba(197, 160, 89, 0.2);
        }

        /* Ripple Effect cho nút Pill */
        .ripple-btn {
            position: relative;
            overflow: hidden;
        }

        /* Custom Slider */
        input[type=range] {
            -webkit-appearance: none;
            background: rgba(255, 255, 255, 0.1);
            height: 2px;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 15px;
            width: 15px;
            border-radius: 50%;
            background: var(--luxury-gold);
            cursor: pointer;
            box-shadow: 0 0 10px var(--luxury-gold);
        }

        /* Loading Bát Quái */
        .bagua-spin {
            animation: spin 10s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <header class="pt-24 pb-12 px-6 border-b border-white/5 bg-gradient-to-b from-black to-[#080808]">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="font-cinzel text-3xl md:text-5xl text-[#c5a059] tracking-[0.2em] mb-4 uppercase">The Vault Search</h1>
                <p class="text-gray-500 text-xs tracking-[0.4em] uppercase">Hệ thống truy xuất định danh di sản</p>
            </div>

            <!-- <div class="max-w-3xl mx-auto relative group">
                <i class="ri-search-eye-line absolute left-6 top-1/2 -translate-y-1/2 text-2xl text-gray-500 group-focus-within:text-[#c5a059] transition-colors"></i>
                <input type="text"
                    placeholder="Nhập con số định mệnh của Ngài..."
                    class="w-full bg-white/5 border border-white/10 rounded-full py-6 px-16 font-cinzel text-xl tracking-widest focus:outline-none focus:border-[#c5a059]/50 focus:bg-white/[0.08] transition-all radar-glow">
            </div> -->

            <!-- <div class="flex flex-wrap justify-center gap-4 mt-8">
                <?php $pills = ['Ngũ Quý', 'Sảnh Tiến', 'Phát Lộc', 'Biển Cặp'];
                foreach ($pills as $pill): ?>
                    <button class="ripple-btn px-8 py-2 rounded-full border border-white/10 bg-white/5 text-[10px] uppercase tracking-[0.2em] hover:text-[#c5a059] hover:border-[#c5a059]/50 transition-all">
                        <?= $pill ?>
                    </button>
                <?php endforeach; ?>
            </div> -->
        </div>
    </header>

    <main class="max-w-[1600px] mx-auto px-6 py-12 flex flex-col md:flex-row gap-12">

        <!-- <aside class="w-full md:w-72 space-y-12 sticky top-24 h-fit hidden md:block">
            <div>
                <h3 class="text-[#c5a059] text-[10px] font-bold tracking-[0.3em] uppercase mb-6">Khu vực</h3>
                <select class="w-full bg-transparent border-b border-white/10 py-2 text-sm focus:outline-none focus:border-[#c5a059]">
                    <option class="bg-black">Tất cả Tỉnh Thành</option>
                    <option class="bg-black">Hà Nội (30-33)</option>
                    <option class="bg-black">TP. Hồ Chí Minh (50-59)</option>
                </select>
            </div>

            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-[#c5a059] text-[10px] font-bold tracking-[0.3em] uppercase">Tổng nút</h3>
                    <span id="sumVal" class="text-xs font-cinzel">9</span>
                </div>
                <input type="range" min="1" max="9" value="9" class="w-full cursor-pointer" oninput="document.getElementById('sumVal').innerText = this.value">
            </div>

            <div>
                <h3 class="text-[#c5a059] text-[10px] font-bold tracking-[0.3em] uppercase mb-6">Ngũ Hành</h3>
                <div class="grid grid-cols-5 gap-2">
                    <button title="Kim" class="p-2 border border-white/5 hover:border-[#c5a059] transition-colors"><i class="ri-shining-line"></i></button>
                    <button title="Mộc" class="p-2 border border-white/5 hover:border-[#c5a059] transition-colors"><i class="ri-leaf-line"></i></button>
                    <button title="Thủy" class="p-2 border border-white/5 hover:border-[#c5a059] transition-colors"><i class="ri-water-flash-line"></i></button>
                    <button title="Hỏa" class="p-2 border border-white/5 hover:border-[#c5a059] transition-colors"><i class="ri-fire-line"></i></button>
                    <button title="Thổ" class="p-2 border border-white/5 hover:border-[#c5a059] transition-colors"><i class="ri-landscape-line"></i></button>
                </div>
            </div>
        </aside> -->
        <aside class="w-full md:w-72 space-y-12 sticky top-24 h-fit hidden md:block">
            <form id="filterForm" action="search-inventory.php" method="GET">
                <input type="hidden" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">

                <div>
                    <h3 class="text-[#c5a059] text-[10px] font-bold tracking-[0.3em] uppercase mb-6">Khu vực</h3>
                    <select name="province"
                        onchange="this.form.submit()"
                        class="w-full bg-transparent border-b border-white/10 py-2 text-sm focus:outline-none focus:border-[#c5a059] cursor-pointer">
                        <?php
                        $provinces = ['Tất cả Tỉnh Thành', 'Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng'];
                        $selectedProv = $_GET['province'] ?? '';
                        foreach ($provinces as $p): ?>
                            <option value="<?= $p ?>" class="bg-black" <?= $selectedProv == $p ? 'selected' : '' ?>>
                                <?= $p ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mt-12">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-[#c5a059] text-[10px] font-bold tracking-[0.3em] uppercase">Tổng nút</h3>
                        <span id="sumVal" class="text-xs font-cinzel">9</span>
                    </div>
                    <input type="range" min="1" max="9" value="9" class="w-full cursor-pointer">
                </div>
            </form>
        </aside>

        <!-- <div class="flex-1">
            <div id="grid-container" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                <?php if (empty($plates)): ?>
                    <script>
                        document.getElementById('not-found').classList.remove('hidden');
                    </script>
                <?php else: ?>
                    <?php foreach ($plates as $plate): ?>
                        <a href="Detail_Plate_warehouse.php?id=<?= $plate['plates_id'] ?>" class="plate-card group block">
                            <div class="aspect-[3/1] rounded-lg mb-6 overflow-hidden plate-3d flex items-center justify-center p-4 cursor-pointer relative transition-transform duration-500 hover:scale-[1.02]">
                                <h2 class="text-4xl md:text-5xl font-bold tracking-tighter font-mono">
                                    <?= htmlspecialchars($plate['plate_number']) ?>
                                </h2>
                            </div>
                            <div class="flex justify-between items-end px-2">
                                <div>
                                    <p class="text-[10px] text-[#c5a059] font-bold uppercase tracking-widest mb-1">
                                        <?= htmlspecialchars($plate['province']) ?>
                                    </p>
                                    <h3 class="font-playfair text-xl italic">$<?= number_format($plate['starting_price']) ?></h3>
                                </div>
                                <div class="text-[#c5a059] opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="ri-arrow-right-up-line text-xl"></i>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div id="not-found" class="hidden text-center py-24">
                <i class="ri-search-2-line text-6xl text-white/10 mb-6 block"></i>
                <p class="font-cinzel text-xl text-gray-400 mb-8">Kiệt tác này hiện chưa xuất hiện</p>
                <button class="px-10 py-4 bg-[#c5a059] text-black font-bold uppercase text-[10px] tracking-[0.2em] hover:bg-[#d4b57a] transition-all">
                    <i class="ri-customer-service-line mr-2"></i> Liên hệ Quản gia
                </button>
            </div>
        </div> -->
        <div class="flex-1">
            <div id="grid-container" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                <?php if (!empty($plates)): ?>
                    <?php foreach ($plates as $plate): ?>
                        <a href="Detail_Plate_warehouse.php?id=<?= $plate['plates_id'] ?>" class="plate-card group block">
                            <div class="aspect-[3/1] rounded-lg mb-6 overflow-hidden plate-3d flex items-center justify-center p-4 cursor-pointer relative transition-transform duration-500 hover:scale-[1.02]">
                                <h2 class="text-4xl md:text-5xl font-bold tracking-tighter font-mono">
                                    <?= htmlspecialchars($plate['plate_number']) ?>
                                </h2>
                            </div>
                            <div class="flex justify-between items-end px-2">
                                <div>
                                    <p class="text-[10px] text-[#c5a059] font-bold uppercase tracking-widest mb-1">
                                        <?= htmlspecialchars($plate['province']) ?>
                                    </p>
                                    <h3 class="font-playfair text-xl italic">$<?= number_format($plate['starting_price']) ?></h3>
                                </div>
                                <div class="text-[#c5a059] opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="ri-arrow-right-up-line text-xl"></i>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div id="not-found" class="<?= empty($plates) ? '' : 'hidden' ?> text-center py-24">
                <i class="ri-search-2-line text-6xl text-white/10 mb-6 block"></i>
                <p class="font-cinzel text-xl text-gray-400 mb-8">Kiệt tác này hiện chưa xuất hiện</p>
            </div>
        </div>
    </main>

    <div id="loader" class="fixed inset-0 bg-black z-[100] flex items-center justify-center pointer-events-none opacity-0">
        <div class="text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/1041/1041926.png" class="w-24 h-24 opacity-20 filter invert bagua-spin mb-4" alt="Bát quái">
            <p class="text-[10px] tracking-[0.5em] text-[#c5a059] uppercase">Đang truy xuất bộ lọc...</p>
        </div>
    </div>

    <button class="md:hidden fixed bottom-8 right-8 w-14 h-14 bg-[#c5a059] rounded-full shadow-2xl flex items-center justify-center text-black text-2xl z-50">
        <i class="ri-filter-fill"></i>
    </button>
    <?php include('footer.php'); ?>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // GSAP: Xuất hiện grid cards staggered
            gsap.to(".plate-card", {
                opacity: 1,
                y: 0,
                stagger: 0.1,
                duration: 1,
                ease: "power4.out"
            });

            // GSAP: 3D Tilt Effect cho biển số
            const cards = document.querySelectorAll('.plate-3d');
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const xc = rect.width / 2;
                    const yc = rect.height / 2;
                    const dx = x - xc;
                    const dy = y - yc;

                    gsap.to(card, {
                        rotateY: dx / 10,
                        rotateX: -dy / 5,
                        duration: 0.5
                    });
                });

                card.addEventListener('mouseleave', () => {
                    gsap.to(card, {
                        rotateX: 0,
                        rotateY: 0,
                        duration: 0.5
                    });
                });
            });

            // Ripple Effect cho các nút Pill
            const rippleBtns = document.querySelectorAll('.ripple-btn');
            rippleBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    let ripple = document.createElement('span');
                    ripple.style.position = 'absolute';
                    ripple.style.background = 'rgba(197, 160, 89, 0.4)';
                    ripple.style.width = '100px';
                    ripple.style.height = '100px';
                    ripple.style.borderRadius = '50%';
                    ripple.style.pointerEvents = 'none';
                    ripple.style.left = e.offsetX - 50 + 'px';
                    ripple.style.top = e.offsetY - 50 + 'px';
                    ripple.style.transform = 'scale(0)';
                    this.appendChild(ripple);

                    gsap.to(ripple, {
                        scale: 4,
                        opacity: 0,
                        duration: 0.8,
                        onComplete: () => ripple.remove()
                    });
                });
            });
        });

        // Giả lập Loading khi lọc
        function simulateFilter() {
            gsap.to("#loader", {
                opacity: 1,
                pointerEvents: "auto",
                duration: 0.3
            });
            setTimeout(() => {
                gsap.to("#loader", {
                    opacity: 0,
                    pointerEvents: "none",
                    duration: 0.3
                });
            }, 1500);
        }
    </script>
</body>

</html>