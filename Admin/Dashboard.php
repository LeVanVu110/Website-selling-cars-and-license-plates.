<!DOCTYPE html>
<html lang="vi">
<?php
require_once dirname(__DIR__) . '/check_admin.php';
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Action.php";
$actionModel = new Action();
$allAuctions = $actionModel->getAllAuctions();
// Giả lập dữ liệu doanh thu 7 ngày qua
$days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'];
$revenueData = [450000000, 520000000, 480000000, 700000000, 650000000, 880000000, 950000000];
$recentActions = $actionModel->getRecentActions(5);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inner Circle - Command Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --luxury-gold: #c5a059;
            --obsidian: #080808;
            --card-bg: #0f0f0f;
        }

        body {
            background: var(--obsidian);
            color: #e5e5e5;
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        .font-cinzel {
            font-family: 'Cinzel Decorative', cursive;
        }

        /* Hiệu ứng Spotlight */
        #spotlight {
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(197, 160, 89, 0.05) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
            transform: translate(-50%, -50%);
            top: 0;
            left: 0;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.03);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            border-color: rgba(197, 160, 89, 0.4);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        .chart-container {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #080808;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--luxury-gold);
            border-radius: 10px;
        }

        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0 !important;
                padding-top: 80px;
            }
        }

        .main-content {
            transition: margin-left 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body>
    <div id="spotlight"></div>

    <?php include('Sidebar.php'); ?>

    <main class="main-content md:ml-[288px] transition-all duration-500 relative z-10 p-4 md:p-8">

        <header class="flex justify-between items-end mb-12 mt-12 md:mt-0">
            <div>
                <p class="text-[10px] tracking-[0.8em] text-gray-500 uppercase mb-2">System Status: Online</p>
                <h1 class="text-4xl font-light tracking-tighter italic font-playfair">Command <span class="text-[#c5a059]">Center</span></h1>
            </div>
            <div class="text-right">
                <div id="real-time-clock" class="text-xl font-bold tracking-widest text-[#c5a059]">00:00:00</div>
                <p class="text-[9px] text-gray-500 uppercase tracking-widest">Sài Gòn, Việt Nam</p>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card p-6 rounded-xl relative overflow-hidden group ">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-1">Doanh thu tháng</p>
                        <h3 class="text-2xl font-bold text-white tracking-tight italic font-playfair">
                            $<span class="counter" data-target="128450">0</span>
                        </h3>
                    </div>
                    <i class="ri-money-dollar-circle-line text-2xl text-[#c5a059] opacity-50"></i>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-emerald-500 font-bold tracking-widest">
                    <i class="ri-arrow-right-up-line mr-1"></i> +12.5%
                </div>
            </div>

            <div class="stat-card p-6 rounded-xl relative overflow-hidden group ">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-1">Hội viên VIP mới</p>
                        <h3 class="text-2xl font-bold text-white italic font-playfair">
                            +<span class="counter" data-target="42">0</span>
                        </h3>
                    </div>
                    <i class="ri-user-star-line text-2xl text-[#c5a059] opacity-50"></i>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-emerald-500 font-bold tracking-widest">
                    <i class="ri-arrow-right-up-line mr-1"></i> +5.2%
                </div>
            </div>

            <div class="stat-card p-6 rounded-xl relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-1">Phiên đấu giá</p>
                        <h3 class="text-2xl font-bold text-white italic font-playfair">
                            <span class="counter" data-target="156">0</span>
                        </h3>
                    </div>
                    <i class="ri-hammer-line text-2xl text-[#c5a059] opacity-50"></i>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-gray-400 font-bold tracking-widest uppercase">
                    8 phiên live
                </div>
            </div>

            <div class="stat-card p-6 rounded-xl relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-1">Tỷ lệ chốt đơn</p>
                        <h3 class="text-2xl font-bold text-white italic font-playfair">
                            <span class="counter" data-target="89">0</span>%
                        </h3>
                    </div>
                    <i class="ri-trophy-line text-2xl text-[#c5a059] opacity-50"></i>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-emerald-500 font-bold tracking-widest">
                    <i class="ri-arrow-right-up-line mr-1"></i> +2.1%
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 chart-container p-6 rounded-2xl relative overflow-hidden flex flex-col">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xs uppercase tracking-[0.4em] font-bold text-[#c5a059]">Dòng chảy tài sản</h2>
                    <select class="bg-transparent border-none text-[10px] uppercase tracking-widest text-gray-500 focus:ring-0 cursor-pointer">
                        <option>7 ngày qua</option>
                        <option>30 ngày qua</option>
                    </select>
                </div>
                <div class="relative w-full h-[300px]">
                    <canvas id="assetChart"></canvas>
                </div>
            </div>

            <div class="chart-container p-6 rounded-2xl h-full">
                <h2 class="text-xs uppercase tracking-[0.4em] font-bold text-[#c5a059] mb-6">Đấu giá trực tiếp</h2>
                <div class="space-y-4 max-h-[300px] overflow-y-auto no-scrollbar">
                    <?php if (!empty($allAuctions)): ?>
                        <?php foreach ($allAuctions as $auc):
                            if ($auc['status'] === 'completed') continue;
                            $statusColor = ($auc['status'] === 'active') ? 'bg-green-500' : 'bg-blue-500';
                            $statusPing = ($auc['status'] === 'active') ? 'bg-green-400' : 'bg-blue-400';
                        ?>
                            <div class="p-4 rounded-xl bg-white/5 backdrop-blur-md border border-white/5 flex items-center justify-between group cursor-pointer hover:bg-white/10 transition-all">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-black flex items-center justify-center border border-white/10 mr-4">
                                        <span class="text-[8px] text-[#c5a059] font-bold text-center px-1">
                                            <?= htmlspecialchars($auc['plate_number']) ?>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-white tracking-widest uppercase">
                                            <?= htmlspecialchars($auc['plate_number']) ?>
                                        </h4>
                                        <p class="text-[9px] text-gray-500">Giá hiện tại:
                                            <span class="text-white"><?= number_format($auc['current_price'], 0, ',', '.') ?>₫</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="relative flex h-2 w-2 mb-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full <?= $statusPing ?> opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 <?= $statusColor ?>"></span>
                                    </span>
                                    <div class="text-[9px] text-gray-400">
                                        <i class="ri-map-pin-line"></i> <?= htmlspecialchars($auc['province'] ?? 'VN') ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-gray-500 text-xs text-center py-10 italic">Không có phiên đấu giá nào.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="mt-8 chart-container p-6 rounded-2xl overflow-hidden">
            <h2 class="text-xs uppercase tracking-[0.4em] font-bold text-[#c5a059] mb-8">Hành động gần đây</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-600 text-[10px] uppercase tracking-[0.2em] border-b border-white/5">
                            <th class="pb-4 font-medium">Khách hàng VIP</th>
                            <th class="pb-4 font-medium">Hành động</th>
                            <th class="pb-4 font-medium">Giá trị</th>
                            <th class="pb-4 font-medium">Thời gian</th>
                            <th class="pb-4 font-medium">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
                        <?php foreach ($recentActions as $action):
                            // Tạo Avatar chữ cái đầu từ tên
                            $nameParts = explode(' ', $action['fullname']);
                            $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                        ?>
                            <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full border border-[#c5a059]/30 p-[1px] mr-3">
                                            <div class="w-full h-full rounded-full bg-zinc-800 flex items-center justify-center italic font-playfair text-[#c5a059]">
                                                <?= $initials ?>
                                            </div>
                                        </div>
                                        <span class="font-playfair text-sm italic"><?= htmlspecialchars($action['fullname']) ?></span>
                                    </div>
                                </td>
                                <td class="text-gray-400">
                                    Đặt giá biển số <span class="text-white">"<?= htmlspecialchars($action['plate_number']) ?>"</span>
                                </td>
                                <td class="text-[#c5a059] font-bold tracking-wider">
                                    $<?= number_format($action['bid_amount']) ?>
                                </td>
                                <td class="text-gray-500 uppercase text-[10px]">
                                    <?= date('H:i - d/m', strtotime($action['created_at'])) ?>
                                </td>
                                <td>
                                    <span class="px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-[9px] font-bold uppercase tracking-tighter border border-emerald-500/20">
                                        Thành công
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            // 1. Hiệu ứng Spotlight theo chuột (Đã sửa lỗi bù trừ tọa độ)
            const spotlight = document.getElementById('spotlight');
            window.addEventListener('mousemove', (e) => {
                gsap.to(spotlight, {
                    x: e.clientX,
                    y: e.clientY,
                    duration: 0.8,
                    ease: "power2.out"
                });
            });

            // 2. CountUp Animation cho các chỉ số
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                gsap.to(counter, {
                    innerText: target,
                    duration: 2.5,
                    ease: "power4.out",
                    snap: {
                        innerText: 1
                    },
                    scrollTrigger: {
                        trigger: counter,
                        start: "top 90%"
                    },
                    onUpdate: function() {
                        counter.innerText = Math.ceil(this.targets()[0].innerText).toLocaleString();
                    }
                });
            });

            // 3. GSAP Stagger cho các Card
            gsap.from(".stat-card, .chart-container", {
                y: 30,
                opacity: 0,
                duration: 1.2,
                stagger: 0.1,
                ease: "expo.out"
            });

            // 4. Đồng hồ thời gian thực (Đã thêm kiểm tra IF để tránh lỗi Null)
            setInterval(() => {
                const clockEl = document.getElementById('real-time-clock');
                if (clockEl) {
                    clockEl.innerText = new Date().toLocaleTimeString('en-GB');
                }
            }, 1000);

            // 5. Cấu hình Chart.js
            const chartEl = document.getElementById('assetChart');
            if (chartEl) {
                const ctx = chartEl.getContext('2d');
                const goldGradient = ctx.createLinearGradient(0, 0, 0, 400);
                goldGradient.addColorStop(0, 'rgba(197, 160, 89, 0.2)');
                goldGradient.addColorStop(1, 'rgba(197, 160, 89, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?= json_encode($days) ?>,
                        datasets: [{
                            label: 'Doanh thu',
                            data: <?= json_encode($revenueData) ?>,
                            borderColor: '#c5a059',
                            borderWidth: 3,
                            pointBackgroundColor: '#c5a059',
                            pointBorderColor: '#080808',
                            pointRadius: 5,
                            tension: 0.4,
                            fill: true,
                            backgroundColor: goldGradient
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                grid: {
                                    color: 'rgba(255,255,255,0.05)'
                                },
                                ticks: {
                                    color: '#555',
                                    callback: value => (value / 1000000) + 'M'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#555'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>