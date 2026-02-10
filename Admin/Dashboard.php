<!DOCTYPE html>
<html lang="vi">
<?php
require_once dirname(__DIR__) . '/check_admin.php';
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

        /* Hiệu ứng Spotlight theo con trỏ chuột */
        #spotlight {
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(197, 160, 89, 0.05) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
            transform: translate(-50%, -50%);
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

        /* Tùy chỉnh thanh cuộn cho Luxury */
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
    </style>
</head>

<body>
    <div id="spotlight"></div>

    <?php include('Sidebar.php'); ?>

    <main class="main-content md:ml-[288px] transition-all duration-500 relative z-10 p-4 md:p-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mt-12 md:mt-0 ">
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
                    <i class="ri- trophy-line text-2xl text-[#c5a059] opacity-50"></i>
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
                    <div class="p-4 rounded-xl bg-white/5 backdrop-blur-md border border-white/5 flex items-center justify-between group cursor-pointer hover:bg-white/10 transition-all">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg overflow-hidden bg-black flex items-center justify-center border border-white/10 mr-4">
                                <span class="text-[10px] text-[#c5a059] font-bold">999.99</span>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white tracking-widest uppercase">PENTAGON-01</h4>
                                <p class="text-[9px] text-gray-500">Giá hiện tại: <span class="text-white">$25,000</span></p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="relative flex h-2 w-2 mb-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            <div class="text-[9px] text-gray-400"><i class="ri-timer-flash-line"></i> 02:45</div>
                        </div>
                    </div>
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
                        <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                            <td class="py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full border border-[#c5a059]/30 p-[1px] mr-3">
                                        <div class="w-full h-full rounded-full bg-zinc-800 flex items-center justify-center italic font-playfair text-[#c5a059]">JL</div>
                                    </div>
                                    <span class="font-playfair text-sm italic">Jonathan Leffington</span>
                                </div>
                            </td>
                            <td class="text-gray-400">Đặt cọc biển số <span class="text-white">"KING-88"</span></td>
                            <td class="text-[#c5a059] font-bold tracking-wider">$5,000</td>
                            <td class="text-gray-500 uppercase text-[10px]">2 phút trước</td>
                            <td><span class="px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-[9px] font-bold uppercase tracking-tighter border border-emerald-500/20">Hoàn tất</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <button class="fixed bottom-8 right-8 z-[100] w-14 h-14 bg-[#c5a059] text-black rounded-full shadow-[0_0_20px_rgba(197,160,89,0.5)] flex items-center justify-center hover:scale-110 active:scale-95 transition-all group">
        <i class="ri-add-line text-2xl group-hover:rotate-90 transition-transform duration-300"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Hiệu ứng Spotlight theo chuột
            const spotlight = document.getElementById('spotlight');
            window.addEventListener('mousemove', (e) => {
                gsap.to(spotlight, {
                    x: e.clientX,
                    y: e.clientY,
                    duration: 1,
                    ease: "power2.out"
                });
            });

            // 2. CountUp Animation cho các chỉ số
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const duration = 2;
                gsap.to(counter, {
                    innerText: target,
                    duration: duration,
                    ease: "power4.out",
                    snap: {
                        innerText: 1
                    },
                    scrollTrigger: {
                        trigger: counter,
                        start: "top 90%"
                    },
                    onUpdate: function() {
                        if (target > 1000) {
                            counter.innerText = Math.ceil(this.targets()[0].innerText).toLocaleString();
                        }
                    }
                });
            });

            // 3. GSAP Stagger cho các Card
            gsap.from(".stat-card", {
                opacity: 1,
                duration: 1,
                stagger: 0.15,
                ease: "expo.out",
                delay: 0.2
            });

            // 4. Cấu hình Chart.js (Luxury Style)
            const ctx = document.getElementById('assetChart').getContext('2d');
            const goldGradient = ctx.createLinearGradient(0, 0, 0, 400);
            goldGradient.addColorStop(0, 'rgba(197, 160, 89, 0.2)');
            goldGradient.addColorStop(1, 'rgba(197, 160, 89, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Doanh thu',
                        data: [45000, 52000, 48000, 70000, 65000, 88000, 95000],
                        borderColor: '#c5a059',
                        borderWidth: 2,
                        pointBackgroundColor: '#c5a059',
                        pointBorderColor: '#000',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: goldGradient
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Cho phép biểu đồ lấp đầy container h-[300px]
                    resizeDelay: 200, // Trì hoãn một chút khi resize để ổn định khung hình
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>