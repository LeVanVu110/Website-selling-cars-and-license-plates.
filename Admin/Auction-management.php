<!DOCTYPE html>
<html lang="vi">
<?php
require_once dirname(__DIR__) . '/check_admin.php';
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Action.php";
$actionModel = new Action();

$status = $_GET['status'] ?? 'ongoing';
$auctions = $actionModel->getAuctionsByStatus($status);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Command Center | Inner Circle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --luxury-gold: #c5a059;
            --emerald: #50c878;
            --burgundy: #800020;
        }

        body {
            background: #080808;
            color: #e5e5e5;
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }

        .font-cinzel {
            font-family: 'Cinzel Decorative', cursive;
        }

        /* Progress Circle cho Countdown */
        .timer-svg {
            transform: rotate(-90deg);
        }

        .timer-circle {
            fill: none;
            stroke: var(--luxury-gold);
            stroke-width: 2;
            stroke-dasharray: 100;
            stroke-dashoffset: 30;
            transition: stroke-dashoffset 1s linear;
        }

        /* Hiệu ứng tia chớp cho thẻ Live */
        .live-flash::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(197, 160, 89, 0.1), transparent);
            transform: rotate(45deg);
            pointer-events: none;
        }

        .auction-card {
            background: #0f0f0f;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            perspective: 1000px;
        }

        .auction-card:hover {
            border-color: var(--luxury-gold);
            box-shadow: 0 0 30px rgba(197, 160, 89, 0.1);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Toggle Switch mạ bạc */
        .toggle-checkbox:checked+.toggle-label {
            background-color: var(--luxury-gold);
        }

        .toggle-checkbox:checked+.toggle-label .toggle-dot {
            transform: translateX(100%);
            background-color: #000;
        }

        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body>

    <?php include('Sidebar.php'); ?>

    <main class="main-content md:ml-[288px] min-h-screen transition-all duration-500 p-4 md:p-8 relative z-10">

        <header class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 mt-12 md:mt-0">
            <div class="relative">
                <div class="flex space-x-8 border-b border-white/10 pb-2 relative" id="tab-container">
                    <button class="tab-item active text-[10px] font-cinzel tracking-[0.2em] text-[#c5a059] relative pb-4" data-status="active">
                        ĐANG DIỄN RA
                    </button>
                    <button class="tab-item text-[10px] font-cinzel tracking-[0.2em] text-gray-500 hover:text-white transition-colors pb-4" data-status="upcoming">
                        SẮP DIỄN RA
                    </button>
                    <button class="tab-item text-[10px] font-cinzel tracking-[0.2em] text-gray-500 hover:text-white transition-colors pb-4" data-status="ended">
                        ĐÃ KẾT THÚC
                    </button>
                    <div id="tab-indicator" class="absolute bottom-[-1px] left-0 h-[1px] bg-[#c5a059] shadow-[0_0_10px_#c5a059]" style="margin-left: 0;"></div>
                </div>
            </div>

            <button onclick="openAuctionModal()" class="bg-[#c5a059] text-black px-6 py-3 rounded-lg font-bold text-xs flex items-center gap-2 hover:shadow-[0_0_20px_rgba(197,160,89,0.3)] transition-all active:scale-95">
                <i class="ri-hammer-fill text-lg"></i> TẠO PHIÊN MỚI
            </button>
        </header>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6" id="auction-grid">
                <?php
                // Lấy dữ liệu (Ví dụ mặc định lấy ongoing nếu chưa click tab)
                $currentStatus = isset($_GET['status']) ? $_GET['status'] : 'active';
                $auctions = $actionModel->getAuctionsByStatus($currentStatus);
                if (empty($auctions)) {
                    echo '<div class="col-span-full py-20 text-center text-gray-500 font-cinzel tracking-widest uppercase">Không có phiên đấu giá nào</div>';
                } else {
                    foreach ($auctions as $index => $item):
                        $now = time();
                        $endTime = strtotime($item['end_time']);
                        $secondsLeft = $endTime - $now;
                        if ($secondsLeft < 0) $secondsLeft = 0;

                        // Cấu hình màu sắc theo status của card
                        $statusUI = [
                            'active' => ['color' => 'red-600', 'label' => 'Live'],
                            'upcoming' => ['color' => 'blue-500', 'label' => 'Sắp tới'],
                            'completed' => ['color' => 'gray-500', 'label' => 'Kết thúc'],
                            'settled' => ['color' => 'emerald-500', 'label' => 'Đã thu tiền']
                        ];

                        $currentUI = $statusUI[$item['status']] ?? $statusUI['active'];
                ?>
                        <div class="auction-card rounded-2xl p-6 relative overflow-hidden group"
                            data-card-status="<?php echo $currentStatus; ?>">

                            <div class="flex justify-between items-start mb-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-<?php echo $currentUI['color']; ?> <?php echo ($item['status'] == 'active') ? 'animate-pulse' : ''; ?>"></span>
                                    <span class="text-[9px] font-bold tracking-widest text-<?php echo $currentUI['color']; ?> uppercase">
                                        <?php echo $currentUI['label']; ?>
                                    </span>
                                </div>

                                <div class="relative w-12 h-12 flex items-center justify-center">
                                    <svg class="timer-svg w-12 h-12">
                                        <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                        <circle class="timer-circle transition-all duration-1000"
                                            cx="24" cy="24" r="20"
                                            style="stroke: var(--luxury-gold); stroke-dasharray: 126; stroke-dashoffset: <?php echo (1 - ($secondsLeft / 3600)) * 126; ?>" />
                                    </svg>
                                    <span class="absolute text-[10px] font-bold auction-timer-display"
                                        data-seconds="<?php echo $secondsLeft; ?>">
                                        <?php echo ($secondsLeft > 60) ? floor($secondsLeft / 60) . 'm' : $secondsLeft . 's'; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                                    <span class="text-black font-black text-sm tracking-tighter">
                                        <?php echo htmlspecialchars($item['plate_number']); ?>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">VIP Plate</h3>
                                    <p class="text-[9px] text-gray-500 italic">Giá khởi điểm: <?php echo number_format($item['starting_price']); ?>đ</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="flex justify-between items-end">
                                    <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                                    <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price">
                                        <?php echo number_format($item['current_price']); ?>đ
                                    </h4>
                                </div>
                                <div class="h-[1px] bg-white/5"></div>

                                <div class="flex justify-between items-center">
                                    <div class="flex -space-x-2">
                                        <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px] text-gray-400">
                                            <?php echo $item['total_bids']; ?>+
                                        </div>
                                    </div>
                                    <button onclick="openDetailPanel(<?= $item['auctions_id']; ?>, '<?= $item['plate_number']; ?>')"
                                        class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                        CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                <?php endforeach;
                } ?>

            </div>

            <aside class="lg:w-1/3 space-y-6">
                <div class="bg-[#0f0f0f] rounded-2xl border border-white/5 p-6 h-[600px] flex flex-col">
                    <div class="flex items-center gap-2 mb-6">
                        <i class="ri-auction-line text-[#c5a059]"></i>
                        <h2 class="text-xs font-bold tracking-[0.2em] uppercase">Dòng tiền trực tiếp</h2>
                    </div>

                    <div class="flex-1 overflow-y-auto no-scrollbar space-y-4" id="bid-logs">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-white/[0.02] border border-white/5 group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-zinc-900 border border-[#c5a059]/30 flex items-center justify-center text-[10px] italic font-playfair text-[#c5a059]">A</div>
                                <div>
                                    <p class="text-[10px] font-bold text-white">Alex Ferguson</p>
                                    <p class="text-[8px] text-gray-500 italic">vừa trả giá Pentagon-01</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-bold text-emerald-500">+$2,000</p>
                                <p class="text-[8px] text-gray-600 uppercase">2s trước</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-white/5">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[9px] text-gray-500 uppercase tracking-widest">Độ nóng phiên</span>
                            <span class="text-[9px] text-[#c5a059] font-bold">CAOO</span>
                        </div>
                        <div class="w-full h-1 bg-zinc-900 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-[#c5a059] to-red-600 w-[75%]"></div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <div id="auction-modal" class="fixed inset-0 bg-black/95 backdrop-blur-md z-[2000] hidden items-center justify-center p-4">
        <div id="modal-content-auction" class="bg-[#0f0f0f] border border-white/10 w-full max-w-4xl rounded-3xl overflow-hidden shadow-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-8 border-r border-white/5">
                    <h2 class="font-cinzel text-[#c5a059] text-lg tracking-[0.2em] mb-8">Thiết lập phiên</h2>
                    <form class="space-y-6">
                        <!-- <input type="hidden" id="modal-plates-id" value=""> -->
                        <div class="space-y-1">
                            <label class="text-[9px] text-gray-500 uppercase tracking-widest">Giá khởi điểm (Cột current_price)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-xs">₫</span>
                                <input type="number" id="modal-current-price"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg p-3 pl-7 text-sm focus:border-[#c5a059] outline-none transition-all text-white"
                                    placeholder="50.000.000">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[9px] text-gray-500 uppercase tracking-widest">Chọn Biển Số Niêm Yết</label>
                            <div class="relative">
                                <select id="modal-plates-id"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg p-3 text-sm focus:border-[#c5a059] outline-none transition-all text-white appearance-none cursor-pointer">

                                    <option value="" class="bg-[#0f0f0f] text-gray-500">-- Chọn biển số trống --</option>

                                    <?php
                                    $availablePlates = $actionModel->getAvailablePlates();
                                    foreach ($availablePlates as $plate):
                                    ?>
                                        <option value="<?= $plate['plates_id'] ?>" class="bg-[#0f0f0f] text-white py-2">
                                            <?= htmlspecialchars($plate['plate_number']) ?>
                                            (Gốc: <?= number_format($plate['starting_price']) ?>đ)
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <i class="ri-arrow-down-s-line absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[9px] text-gray-500 uppercase tracking-widest">Thời gian bắt đầu</label>
                                <input type="datetime-local" id="modal-start-time"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg p-3 text-sm focus:border-[#c5a059] outline-none invert text-black font-bold">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] text-gray-500 uppercase tracking-widest">Thời gian kết thúc</label>
                                <input type="datetime-local" id="modal-end-time"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg p-3 text-sm focus:border-[#c5a059] outline-none invert text-black font-bold">
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl">
                            <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Kích hoạt Live ngay</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="modal-status-toggle" class="sr-only toggle-checkbox">
                                <div class="w-10 h-5 bg-zinc-800 rounded-full toggle-label transition-all">
                                    <div class="toggle-dot absolute left-1 top-1 bg-zinc-500 w-3 h-3 rounded-full transition-all"></div>
                                </div>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="p-8 bg-black/40 flex flex-col justify-center items-center text-center">
                    <div class="w-24 h-24 rounded-full border border-[#c5a059]/20 flex items-center justify-center mb-6">
                        <i class="ri-hammer-line text-4xl text-[#c5a059]"></i>
                    </div>
                    <p class="text-xs text-gray-400 mb-8 max-w-[200px]">Xác nhận phiên đấu giá sẽ được đẩy lên hệ thống Inner Circle ngay lập tức.</p>
                    <div class="flex gap-4 w-full">
                        <button onclick="closeAuctionModal()" class="flex-1 py-3 text-[10px] font-bold border border-white/10 rounded-lg hover:bg-white/5 transition-all">HỦY BỎ</button>
                        <button onclick="submitAuctionForm()"
                            class="flex-1 py-3 text-[10px] font-bold bg-[#c5a059] text-black rounded-lg">
                            PHÊ DUYỆT
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="side-panel-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[2500] hidden opacity-0 transition-opacity duration-500">
        <div id="side-panel" class="absolute right-0 top-0 h-full w-full max-w-md bg-[#0f0f0f] border-l border-white/10 shadow-[-20px_0_50px_rgba(0,0,0,0.5)] translate-x-full">
            <div class="p-8 h-full flex flex-col">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h2 id="panel-plate" class="text-xl font-bold font-cinzel text-[#c5a059]">888.88</h2>
                        <p class="text-[9px] text-gray-500 uppercase tracking-[0.2em] mt-1">Lịch sử đấu giá chi tiết</p>
                    </div>
                    <button onclick="closeDetailPanel_detail()" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-white/10 transition-all">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>

                <div class="mb-8 p-4 bg-black/40 rounded-2xl border border-white/5">
                    <p class="text-[9px] text-gray-500 uppercase mb-4 tracking-widest">Biến động giá trị (24h)</p>
                    <div class="h-32 w-full relative">
                        <svg viewBox="0 0 200 60" class="w-full h-full">
                            <path d="M0 50 Q 25 45, 50 30 T 100 25 T 150 15 T 200 5" fill="none" stroke="#c5a059" stroke-width="2" class="path-anim" />
                        </svg>
                    </div>
                </div>

                <!-- <div class="flex-1 overflow-y-auto no-scrollbar space-y-4">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Danh sách trả giá</h3>
                    <div class="flex items-center justify-between p-4 rounded-xl bg-white/[0.03] border border-white/5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#c5a059] text-black flex items-center justify-center font-bold text-[10px]">TH</div>
                            <div>
                                <p class="text-xs font-bold">Trần Hoàng</p>
                                <p class="text-[9px] text-gray-500 italic">10:45:22 AM</p>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-[#c5a059]">$127,400</p>
                    </div>
                </div> -->
                <div class="flex-1 overflow-y-auto no-scrollbar space-y-4">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Danh sách trả giá</h3>
                    <div id="bids-list-container" class="space-y-4">
                    </div>
                </div>

                <div class="mt-auto pt-6 border-t border-white/5 grid grid-cols-2 gap-4">
                    <button id="btn-toggle-auction" onclick="handleToggleAuction()"
                        class="py-3 text-[10px] font-bold bg-white/5 rounded-lg transition-all uppercase tracking-widest">
                        Dừng Phiên
                    </button>

                    <button onclick="handleExtendAuction()"
                        class="py-3 text-[10px] font-bold bg-[#c5a059] text-black rounded-lg uppercase tracking-widest hover:bg-[#d4b57a] transition-all">
                        Gia hạn
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. GSAP Tab Indicator
        const tabs = document.querySelectorAll('.tab-item');
        const indicator = document.getElementById('tab-indicator');
        const cards = document.querySelectorAll('.auction-card');

        function updateTab(target) {
            tabs.forEach(t => t.classList.remove('text-[#c5a059]'));
            target.classList.add('text-[#c5a059]');
            gsap.to(indicator, {
                left: target.offsetLeft,
                width: target.offsetWidth,
                duration: 0.4,
                ease: "power2.out"
            });
        }

        function filterAuctions(status) {
            // Hiệu ứng ẩn các card không thuộc status được chọn
            cards.forEach(card => {
                if (status === 'all' || card.dataset.cardStatus === status) {
                    // Hiện card
                    card.style.display = 'block';
                    gsap.to(card, {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.4,
                        ease: "power2.out"
                    });
                } else {
                    // Ẩn card
                    gsap.to(card, {
                        opacity: 0,
                        y: 20,
                        scale: 0.95,
                        duration: 0.3,
                        onComplete: () => card.style.display = 'none'
                    });
                }
            });
        }

        function moveIndicator(target) {
            // Đổi màu text
            tabs.forEach(tab => tab.classList.remove('text-[#c5a059]', 'active'));
            tabs.forEach(tab => tab.classList.add('text-gray-500'));

            target.classList.add('text-[#c5a059]', 'active');
            target.classList.remove('text-gray-500');

            // Di chuyển thanh trượt vàng
            gsap.to(indicator, {
                left: target.offsetLeft,
                width: target.offsetWidth,
                duration: 0.5,
                ease: "power3.out"
            });

            // Gọi hàm lọc dữ liệu
            filterAuctions(target.dataset.status);
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                moveIndicator(e.currentTarget);
            });
        });

        // Khởi tạo vị trí tab đầu tiên
        const firstTab = document.querySelector('.tab-item.active');
        if (firstTab) {
            setTimeout(() => {
                gsap.set(indicator, {
                    left: firstTab.offsetLeft,
                    width: firstTab.offsetWidth
                });
                filterAuctions(firstTab.dataset.status);
            }, 100);
        }

        tabs.forEach(tab => tab.addEventListener('click', (e) => updateTab(e.target)));
        window.onload = () => updateTab(tabs[0]);

        // 2. Bid Scale Effect (Giả lập có người trả giá)
        function simulateBid() {
            const price = document.getElementById('price-1');
            gsap.to(price, {
                scale: 1.15,
                color: '#50c878',
                duration: 0.2,
                yoyo: true,
                repeat: 1,
                onComplete: () => gsap.to(price, {
                    color: '#c5a059'
                })
            });
        }
        setInterval(simulateBid, 5000);

        // 3. Modal Controls
        function openAuctionModal() {
            const modal = document.getElementById('auction-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            gsap.from(modal.querySelector('.bg-[#0f0f0f]'), {
                y: 50,
                opacity: 0,
                duration: 0.6,
                ease: "expo.out"
            });
        }

        function closeAuctionModal() {
            const modal = document.getElementById('auction-modal');
            const content = document.getElementById('modal-content-auction');

            // Hiệu ứng nội dung trượt xuống và mờ đi
            gsap.to(content, {
                y: 30,
                opacity: 0,
                duration: 0.3,
                ease: "power2.in"
            });

            // Hiệu ứng overlay mờ dần rồi ẩn hẳn
            gsap.to(modal, {
                opacity: 0,
                duration: 0.3,
                delay: 0.1,
                onComplete: () => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');

                    // Trả lại trạng thái gốc để không bị lỗi cho lần mở sau
                    gsap.set(content, {
                        y: 0,
                        opacity: 1
                    });
                    gsap.set(modal, {
                        opacity: 1
                    });
                }
            });
        }

        // 4. Scroll Reveal Flip
        gsap.registerPlugin(ScrollTrigger);
        gsap.from(".auction-card", {
            scrollTrigger: {
                trigger: "#auction-grid",
                start: "top 80%"
            },
            rotateX: -15,
            y: 50,
            opacity: 0.5,
            stagger: 0.2,
            duration: 1,
            ease: "power4.out"
        });

        let currentAuctionId = null;
        let currentAuctionStatus = '';

        function openDetailPanel(auctionId, plateNumber) {
            const overlay = document.getElementById('side-panel-overlay');
            const panel = document.getElementById('side-panel');
            const plateDisplay = document.getElementById('panel-plate');
            const bidsContainer = panel.querySelector('.overflow-y-auto');
            currentAuctionId = auctionId;


            // 1. Hiển thị số biển số ngay lập tức vào thẻ h2
            plateDisplay.innerText = plateNumber;

            // 2. Kích hoạt hiệu ứng mở Panel
            overlay.classList.remove('hidden');
            gsap.to(overlay, {
                opacity: 1,
                duration: 0.3
            });
            gsap.to(panel, {
                x: 0,
                duration: 0.5,
                ease: "expo.out"
            });

            // 3. Xóa danh sách cũ và hiện trạng thái đang tải
            const titleH3 = bidsContainer.querySelector('h3');
            bidsContainer.innerHTML = '';
            bidsContainer.appendChild(titleH3);

            // 4. Lấy dữ liệu bid từ server
            fetch(`ajax_get_bids.php?id=${auctionId}`)
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    // 1. Cập nhật trạng thái nút bấm (Dừng/Mở)
                    currentAuctionStatus = data.status;
                    const btnToggle = document.getElementById('btn-toggle-auction');

                    if (btnToggle) {
                        if (currentAuctionStatus === 'completed') {
                            btnToggle.innerText = "Mở lại phiên";
                            btnToggle.classList.add('text-green-500');
                        } else {
                            btnToggle.innerText = "Dừng Phiên";
                            btnToggle.classList.remove('text-green-500');
                        }
                    }

                    // 2. Xử lý danh sách bids
                    // Chú ý: Phải dùng data.bids thay vì data
                    if (!data.bids || data.bids.length === 0) {
                        bidsContainer.insertAdjacentHTML('beforeend', '<p class="text-[10px] text-gray-500 text-center mt-10">Chưa có lượt trả giá nào</p>');
                        return;
                    }

                    // ĐÂY LÀ CHỖ SỬA QUAN TRỌNG: data.bids.forEach
                    data.bids.forEach(bid => {
                        const initials = bid.fullname.split(' ').map(n => n[0]).join('').slice(0, 2).toUpperCase();

                        const bidHtml = `
                <div class="flex items-center justify-between p-4 rounded-xl bg-white/[0.03] border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#c5a059] text-black flex items-center justify-center font-bold text-[10px]">${initials}</div>
                        <div>
                            <p class="text-xs font-bold text-white">${bid.fullname}</p>
                            <p class="text-[9px] text-gray-500 italic">${bid.bid_time}</p>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-[#c5a059]">${new Intl.NumberFormat('vi-VN').format(bid.bid_amount)}đ</p>
                </div>
            `;
                        bidsContainer.insertAdjacentHTML('beforeend', bidHtml);
                    });
                })
                .catch(err => {
                    console.error("Lỗi parse JSON hoặc kết nối:", err);
                });
        }



        function handleToggleAuction() {
            if (!currentAuctionId) return;

            const nextStatus = (currentAuctionStatus === 'completed') ? 'active' : 'completed';
            const confirmMsg = (nextStatus === 'active') ? "Ngài muốn kích hoạt lại phiên này?" : "Ngài muốn dừng phiên này?";

            if (!confirm(confirmMsg)) return;

            const fd = new FormData();
            fd.append('action', 'update_status'); // Phải có dòng này
            fd.append('id', currentAuctionId);
            fd.append('status', nextStatus);

            fetch('ajax_update_auction.php', {
                    method: 'POST',
                    body: fd
                })
                .then(res => {
                    // Kiểm tra xem server có trả về rỗng không
                    if (!res.ok) throw new Error("Server error " + res.status);
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        alert("Thao tác thành công!");
                        location.reload();
                    } else {
                        alert("Lỗi: " + data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Lỗi hệ thống: Có thể file ajax_update_auction.php chưa tồn tại hoặc bị lỗi.");
                });
        }

        // Hàm xử lý Gia hạn
        function handleExtendAuction() {
            if (!currentAuctionId) return;

            const fd = new FormData();
            fd.append('action', 'extend');
            fd.append('id', currentAuctionId);

            fetch('ajax_update_auction.php', {
                    method: 'POST',
                    body: fd
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Đã gia hạn thêm 30 phút cho phiên này!");
                        // Có thể cập nhật lại UI tại đây mà không cần load trang
                        closeDetailPanel();
                    }
                });
        }

        function closeDetailPanel() {
            const overlay = document.getElementById('side-panel-overlay');
            const panel = document.getElementById('side-panel');

            gsap.to(panel, {
                x: '100%',
                duration: 0.4,
                ease: "power2.in"
            });
            gsap.to(overlay, {
                opacity: 0,
                duration: 0.4,
                onComplete: () => overlay.classList.add('hidden')
            });
        }

        function closeDetailPanel_detail() {
            const overlay = document.getElementById('side-panel-overlay');
            const panel = document.getElementById('side-panel');

            overlay.classList.remove('opacity-100');
            panel.classList.add('translate-x-full');
            gsap.to(panel, {
                x: '100%',
                duration: 0.5,
                ease: "expo.in"
            });
            gsap.to(overlay, {
                opacity: 0,
                duration: 0.4,
                delay: 0.1,
                onComplete: () => overlay.classList.add('hidden')
            });
        }

        function closeDetailPanel() {
            const overlay = document.getElementById('side-panel-overlay');
            const panel = document.getElementById('side-panel');

            gsap.to(panel, {
                x: '100%',
                duration: 0.5,
                ease: "expo.in"
            });
            gsap.to(overlay, {
                opacity: 0,
                duration: 0.4,
                delay: 0.1,
                onComplete: () => overlay.classList.add('hidden')
            });
        }

        // Đóng khi click ra ngoài vùng panel
        document.getElementById('side-panel-overlay').addEventListener('click', (e) => {
            if (e.target.id === 'side-panel-overlay') closeDetailPanel();
        });
        document.querySelectorAll('.tab-item').forEach(tab => {
            tab.addEventListener('click', function() {
                // 1. Đổi giao diện Active
                document.querySelectorAll('.tab-item').forEach(t => {
                    t.classList.remove('active', 'text-[#c5a059]');
                    t.classList.add('text-gray-500');
                });
                this.classList.add('active', 'text-[#c5a059]');
                this.classList.remove('text-gray-500');

                // 2. Lấy status và gọi AJAX
                const status = this.getAttribute('data-status');
                fetchAuctions(status);
            });
        });

        // 1. Hàm fetch dữ liệu (giữ nguyên nhưng đảm bảo xóa opacity khi load xong)
        function fetchAuctions(status) {
            const gridContainer = document.getElementById('auction-grid');
            gridContainer.style.opacity = '0.5';

            fetch(`ajax_filter_auctions.php?status=${status}`)
                .then(response => response.text())
                .then(html => {
                    gridContainer.innerHTML = html;
                    gridContainer.style.opacity = '1';
                });
        }

        // 2. Logic khi trang đã sẵn sàng
        document.addEventListener('DOMContentLoaded', () => {
            // KHÔNG gọi fetchAuctions ở đây nữa vì PHP đã render sẵn dữ liệu 'active' rồi

            // Đảm bảo Tab "Đang diễn ra" (active) có màu vàng lúc khởi tạo
            const activeTab = document.querySelector('.tab-item[data-status="active"]');
            if (activeTab) {
                activeTab.classList.add('active', 'text-[#c5a059]');
                activeTab.classList.remove('text-gray-500');
            }
        });

        // 3. Sự kiện click Tab (giữ nguyên logic chuyển đổi màu sắc)
        document.querySelectorAll('.tab-item').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab-item').forEach(t => {
                    t.classList.remove('active', 'text-[#c5a059]');
                    t.classList.add('text-gray-500');
                });
                this.classList.add('active', 'text-[#c5a059]');
                this.classList.remove('text-gray-500');

                const status = this.getAttribute('data-status');
                fetchAuctions(status);
            });
        });

        function submitAuctionForm() {
            // Phải đảm bảo các ID này có trong HTML Modal
            const plateIdElement = document.getElementById('modal-plates-id');
            const priceElement = document.getElementById('modal-current-price');
            const startTimeElement = document.getElementById('modal-start-time');
            const endTimeElement = document.getElementById('modal-end-time');
            const statusElement = document.getElementById('modal-status-toggle');

            // Kiểm tra xem có phần tử nào bị null không trước khi lấy .value
            if (!plateIdElement || !priceElement || !startTimeElement || !endTimeElement) {
                console.error("Lỗi: Một số ô nhập liệu không tìm thấy ID trong HTML!");
                return;
            }

            const plates_id = plateIdElement.value;
            const current_price = priceElement.value;
            const start_time = startTimeElement.value;
            const end_time = endTimeElement.value;
            const is_active = statusElement ? statusElement.checked : false;

            if (!plates_id || !current_price || !start_time || !end_time) {
                alert("Ngài vui lòng điền đầy đủ thông tin trước khi Phê Duyệt.");
                return;
            }

            const formData = new FormData();
            formData.append('plates_id', plates_id);
            formData.append('current_price', current_price);
            formData.append('start_time', start_time);
            formData.append('end_time', end_time);
            formData.append('status', is_active ? 'active' : 'upcoming');
            formData.append('total_bids', 0);

            const btn = event.currentTarget;
            const originalText = btn.innerText;
            btn.innerText = "ĐANG XỬ LÝ...";
            btn.disabled = true;

            fetch('ajax_create_auction.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Đã thêm phiên đấu giá vào hệ thống!");
                        location.reload();
                    } else {
                        alert("Lỗi: " + data.message);
                        btn.innerText = originalText;
                        btn.disabled = false;
                    }
                })
                .catch(err => {
                    alert("Lỗi kết nối!");
                    btn.disabled = false;
                });
        }
    </script>
</body>

</html>