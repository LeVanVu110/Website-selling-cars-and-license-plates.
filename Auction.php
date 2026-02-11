<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php
// Gọi các file theo đúng yêu cầu của Ngài
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";
require_once __DIR__ . "/models/User.php";
require_once __DIR__ . "/models/Role.php";
require_once __DIR__ . "/models/Action.php"; // Đảm bảo đã sửa Action.php sang MySQLi

// 1. Khởi tạo Model
$actionModel = new Action();

// 2. Lấy ID phiên đấu giá (Ví dụ lấy từ ?id=1, nếu không có mặc định là 1)
$auction_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// 3. Lấy dữ liệu chi tiết và lịch sử
// Dòng này trong Auction.php của Ngài đã đúng nếu Action.php sửa như trên
$auction = $actionModel->getAuctionDetail($auction_id);
$history = $actionModel->getBidHistory($auction_id);
$userName = isset($_SESSION['user']['fullname']) ? $_SESSION['user']['fullname'] : "Khách";
$total_participants = $actionModel->getParticipantCount($auction_id);

// Kiểm tra nếu không có dữ liệu
if (!$auction) {
    echo "Phiên đấu giá không tồn tại hoặc đã kết thúc.";
    exit;
}
$allAuctions = $actionModel->getAllAuctions();


// 4. Tính toán thời gian đếm ngược cho JavaScript
$endTime = strtotime($auction['end_time']);
$secondsLeft = $endTime - time();
$secondsLeft = ($secondsLeft > 0) ? $secondsLeft : 0;
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        .gold-text {
            background: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 2px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #bf953f;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hiệu ứng búa gõ */
        .gavel-swing {
            animation: gavelSwing 0.4s ease-out;
            opacity: 1 !important;
        }

        @keyframes gavelSwing {
            0% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(-45deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        /* ----------------------------- section 2 -----------------------------  */

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section class="min-h-screen bg-[#020202] text-white pt-20 pb-12 overflow-hidden">

        <div class="container mx-auto px-6 py-2 flex justify-between items-center border-b border-white/5">
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-[9px] uppercase tracking-[0.2em] text-green-500">Live Sync: 0.02s</span>
            </div>
            <div class="text-[9px] uppercase tracking-[0.2em] text-[#bf953f]">
                <i class="ri-vip-crown-fill mr-1"></i> Chế độ: Đấu giá VIP (Đã đặt cọc)
            </div>
        </div>

        <div class="container mx-auto px-6 mt-8">
            <div class="flex flex-col lg:flex-row gap-12">

                <div class="w-full lg:w-3/5 space-y-8">
                    <div class="relative bg-[#050505] border border-white/5 rounded-sm p-12 flex flex-col items-center justify-center min-h-[450px]">
                        <div class="absolute inset-0 border border-[#bf953f]/20 rounded-sm animate-[pulse_2s_infinite]"></div>

                        <div class="absolute top-6 flex gap-4 font-mono">
                            <div class="text-center">
                                <span id="hours" class="text-3xl font-black text-white">00</span>
                                <p class="text-[8px] text-gray-500 uppercase">Giờ</p>
                            </div>
                            <span class="text-3xl text-[#bf953f]">:</span>
                            <div class="text-center">
                                <span id="minutes" class="text-3xl font-black text-white">15</span>
                                <p class="text-[8px] text-gray-500 uppercase">Phút</p>
                            </div>
                            <span class="text-3xl text-[#bf953f]">:</span>
                            <div class="text-center">
                                <span id="seconds" class="text-3xl font-black text-red-600 animate-pulse">42</span>
                                <p class="text-[8px] text-gray-500 uppercase">Giây</p>
                            </div>
                        </div>

                        <div class="relative z-10 transform scale-125 md:scale-150 transition-transform duration-700 hover:scale-[1.55]">
                            <div class="bg-white px-8 py-3 rounded-sm shadow-[0_0_50px_rgba(191,149,63,0.15)]">
                                <span class="text-black text-5xl font-bold tracking-tighter">
                                    <?php echo htmlspecialchars($auction['plate_number']); ?>
                                </span>
                            </div>
                            <div id="gavel-icon" class="absolute -right-12 -top-12 opacity-0 transition-all duration-300">
                                <i class="ri-gavel-fill text-4xl text-[#bf953f]"></i>
                            </div>
                        </div>

                        <div class="absolute bottom-6 flex gap-8">
                            <div class="text-center">
                                <p class="text-[9px] text-gray-500 uppercase tracking-widest">Lượt đấu</p>
                                <p class="font-bold"><?php echo number_format($auction['total_bids']); ?></p>
                            </div>

                            <div class="text-center border-x border-white/10 px-8">
                                <p class="text-[9px] text-gray-500 uppercase tracking-widest">Người tham gia</p>
                                <p class="font-bold"><?php echo number_format($total_participants); ?></p>
                            </div>

                            <div class="text-center">
                                <p class="text-[9px] text-gray-500 uppercase tracking-widest">Giá khởi điểm</p>
                                <p class="font-bold">
                                    <?php echo number_format($auction['starting_price'] / 1000000, 0); ?> Tr
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-2/5 flex flex-col gap-6">
                    <div class="bg-[#0a0a0a] border border-[#bf953f]/30 p-8 text-center relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-1 h-full bg-[#bf953f]"></div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-[0.3em] mb-2">Giá hiện tại (VNĐ)</p>
                        <div id="current-price" class="text-5xl font-black gold-text tracking-tighter transition-all">
                            850,000,000
                        </div>
                        <p id="highest-bidder" class="text-[10px] text-[#bf953f] mt-4 font-bold uppercase tracking-widest">
                            Dẫn đầu: Mr. Hoang (H***8)
                        </p>
                    </div>

                    <div class="bg-[#050505] border border-white/5 flex-1 min-h-[250px] p-6">
                        <h3 class="text-[10px] font-bold uppercase tracking-widest mb-4 border-b border-white/5 pb-2">Diễn biến phiên đấu</h3>
                        <div id="bid-history" class="space-y-3 overflow-y-auto max-h-[200px] pr-2 custom-scrollbar">
                            <!-- <div class="flex justify-between text-[11px] animate-[fadeIn_0.5s_ease-out]">
                                <span class="text-white">Mr. Hoang</span>
                                <span class="text-[#bf953f] font-bold">850.000.000đ</span>
                                <span class="text-gray-600 italic">vừa xong</span>
                            </div>
                            <div class="flex justify-between text-[11px] opacity-60">
                                <span class="text-white">A*n_VIP</span>
                                <span class="text-white">840.000.000đ</span>
                                <span class="text-gray-600 italic">1 phút trước</span>
                            </div>
                            <div class="flex justify-between text-[11px] opacity-40">
                                <span class="text-white">Gia_Cat</span>
                                <span class="text-white">830.000.000đ</span>
                                <span class="text-gray-600 italic">3 phút trước</span>
                            </div> -->
                            <?php if (!empty($history)): ?>
                                <?php foreach ($history as $index => $bid): ?>
                                    <div class="flex justify-between text-[11px] <?php echo $index === 0 ? 'animate-[fadeIn_0.5s_ease-out]' : 'opacity-60'; ?>">
                                        <span class="text-white"><?php echo htmlspecialchars($bid['fullname']); ?></span>
                                        <span class="<?php echo $index === 0 ? 'text-[#bf953f]' : 'text-white'; ?> font-bold">
                                            <?php echo number_format($bid['bid_amount'], 0, ',', '.'); ?>đ
                                        </span>
                                        <span class="text-gray-600 italic">
                                            <?php echo isset($bid['created_at']) ? date('H:i:s', strtotime($bid['created_at'])) : 'Vừa xong'; ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-[10px] text-gray-500 italic">Chưa có lượt đặt giá nào.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-2">
                            <button onclick="addBid(5000000)" class="py-3 border border-white/10 text-[10px] font-bold hover:bg-[#bf953f] hover:text-black transition-all">+5 Tr</button>
                            <button onclick="addBid(10000000)" class="py-3 border border-white/10 text-[10px] font-bold hover:bg-[#bf953f] hover:text-black transition-all">+10 Tr</button>
                            <button onclick="addBid(50000000)" class="py-3 border border-white/10 text-[10px] font-bold hover:bg-[#bf953f] hover:text-black transition-all">+50 Tr</button>
                        </div>
                        <button id="btn-bid" class="w-full py-5 bg-[#bf953f] text-black font-black uppercase tracking-[0.3em] text-xs relative overflow-hidden group">
                            <span class="relative z-10">ĐẶT GIÁ NGAY</span>
                            <div id="spark-effect" class="absolute inset-0 bg-white/40 scale-0 rounded-full group-active:scale-150 transition-transform duration-500"></div>
                        </button>
                        <div class="flex justify-between items-center px-2">
                            <span class="text-[9px] text-gray-500 uppercase tracking-widest">Giá trần tự động:</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-7 h-4 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-[#bf953f]"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section class="py-24 bg-[#020202] border-t border-white/5">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-tighter">Sắp lên sàn</h2>
                    <p class="text-gray-500 text-[10px] uppercase tracking-widest mt-2">Đừng bỏ lỡ các siêu phẩm tiếp theo</p>
                </div>
                <a href="#" class="text-[10px] font-bold text-[#bf953f] border-b border-[#bf953f] pb-1 uppercase tracking-widest">Xem tất cả</a>
            </div>

            <!-- <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-[#080808] border border-white/5 p-6 group hover:border-[#bf953f]/50 transition-all">
                    <div class="bg-white p-4 rounded-sm mb-4 text-center">
                        <span class="text-black font-bold text-xl tracking-tighter">51K-888.88</span>
                    </div>
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <p class="text-[8px] text-gray-500 uppercase">Khởi điểm</p>
                            <p class="text-sm font-bold">500,000,000đ</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[8px] text-[#bf953f] uppercase">Bắt đầu sau</p>
                            <p class="text-xs font-bold text-white italic">02:15:00</p>
                        </div>
                    </div>
                    <button class="w-full py-3 border border-white/10 text-[9px] font-black uppercase tracking-widest group-hover:bg-white group-hover:text-black transition-all">
                        <i class="ri-notification-3-line mr-2"></i> Nhắc tôi
                    </button>
                </div>
                <div class="bg-[#080808] border border-[#bf953f]/60 p-6 group transition-all relative">

                    <span class="absolute top-3 right-3 text-[8px] px-2 py-1 border border-[#bf953f] text-[#bf953f] uppercase tracking-widest">
                        Đã lên sàn
                    </span>
                    <div class="bg-white p-4 rounded-sm mb-4 text-center">
                        <span class="text-black font-bold text-xl tracking-tighter">51K-888.88</span>
                    </div>
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <p class="text-[8px] text-gray-500 uppercase">Giá hiện tại</p>
                            <p class="text-sm font-bold text-[#bf953f]">720,000,000đ</p>
                        </div>

                        <div class="text-right">
                            <p class="text-[8px] text-red-400 uppercase">Thời gian còn lại</p>
                            <p class="text-xs font-bold text-red-400 italic">
                                01:42:18
                            </p>
                        </div>
                    </div>
                    <button
                        class="w-full py-3 bg-[#bf953f] text-black text-[9px] font-black uppercase tracking-widest hover:opacity-90 transition-all">
                        <i class="ri-auction-line mr-2"></i> Tham gia đấu giá
                    </button>
                </div>

            </div> -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <?php foreach ($allAuctions as $item):
                    $now = time();
                    $startTime = strtotime($item['start_time']);
                    $endTime = strtotime($item['end_time']);

                    // Lấy status từ DB
                    $status = $item['status'];

                    // Tự động chuyển trạng thái hiển thị dựa trên thời gian thực nếu cần
                    if ($status == 'upcoming' && $now >= $startTime && $now <= $endTime) $status = 'active';
                    if (($status == 'active' || $status == 'upcoming') && $now > $endTime) $status = 'completed';

                    // Thiết lập các biến cờ để hiển thị giao diện
                    $isUpcoming = ($status == 'upcoming');
                    $isActive = ($status == 'active');
                    $isClosed = ($status == 'completed' || $status == 'settled');
                ?>

                    <div class="bg-[#080808] border <?php echo $isActive ? 'border-[#bf953f]/60' : 'border-white/5'; ?> p-6 group hover:border-[#bf953f]/50 transition-all relative">

                        <?php if ($isActive): ?>
                            <span class="absolute top-3 right-3 text-[8px] px-2 py-1 border border-[#bf953f] text-[#bf953f] uppercase tracking-widest animate-pulse">
                                Đã lên sàn
                            </span>
                        <?php elseif ($isClosed): ?>
                            <span class="absolute top-3 right-3 text-[8px] px-2 py-1 border border-red-500 text-red-500 uppercase tracking-widest">
                                Đã kết thúc
                            </span>
                        <?php endif; ?>

                        <div class="bg-white p-4 rounded-sm mb-4 text-center">
                            <span class="text-black font-bold text-xl tracking-tighter">
                                <?php echo htmlspecialchars($item['plate_number']); ?>
                            </span>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <p class="text-[8px] text-gray-500 uppercase">
                                    <?php echo $isUpcoming ? 'Khởi điểm' : 'Giá hiện tại'; ?>
                                </p>
                                <p class="text-sm font-bold <?php echo $isActive ? 'text-[#bf953f]' : 'text-white'; ?>">
                                    <?php echo number_format($item['current_price'], 0, ',', '.'); ?>đ
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-[8px] <?php echo $isActive ? 'text-red-400' : 'text-[#bf953f]'; ?> uppercase">
                                    <?php echo $isActive ? 'Còn lại' : ($isUpcoming ? 'Bắt đầu sau' : 'Trạng thái'); ?>
                                </p>
                                <p class="text-xs font-bold <?php echo $isActive ? 'text-red-400' : 'text-white'; ?> italic auction-timer"
                                    data-seconds="<?php echo ($isUpcoming) ? ($startTime - $now) : (($isActive) ? ($endTime - $now) : 0); ?>"
                                    data-status="<?php echo $status; ?>">
                                    <?php
                                    if ($isUpcoming) {
                                        echo gmdate("H:i:s", $startTime - $now);
                                    } elseif ($isActive) {
                                        echo gmdate("H:i:s", $endTime - $now);
                                    } else {
                                        echo "Đóng phiên";
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>

                        <?php if ($isUpcoming): ?>
                            <button class="w-full py-3 border border-white/10 text-[9px] font-black uppercase tracking-widest group-hover:bg-white group-hover:text-black transition-all">
                                <i class="ri-notification-3-line mr-2"></i> Nhắc tôi
                            </button>
                        <?php elseif ($isActive): ?>
                            <a href="Auction.php?id=<?php echo $item['auctions_id']; ?>"
                                class="block w-full py-3 text-center bg-[#bf953f] text-black text-[9px] font-black uppercase tracking-widest hover:opacity-90 transition-all">
                                <i class="ri-auction-line mr-2"></i> Tham gia đấu giá
                            </a>
                        <?php else: ?>
                            <button disabled class="w-full py-3 border border-white/5 text-gray-600 text-[9px] font-black uppercase tracking-widest cursor-not-allowed">
                                Đã hoàn thành
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include('footer.php'); ?>
</body>
<script>
    //----------------------------- section 1 ----------------------------- //
    // Giả lập giá nhảy (Real-time Effect)
    let currentPrice = 850000000;
    const priceDisplay = document.getElementById('current-price');
    const gavelIcon = document.getElementById('gavel-icon');
    const bidHistory = document.getElementById('bid-history');

    // function addBid(amount) {
    //     currentPrice += amount;

    //     // 1. Hiệu ứng số nhảy (Slot machine style)
    //     priceDisplay.classList.add('scale-110', 'brightness-150');
    //     setTimeout(() => {
    //         priceDisplay.innerText = currentPrice.toLocaleString('vi-VN');
    //         priceDisplay.classList.remove('scale-110', 'brightness-150');
    //     }, 100);

    //     // 2. Hiệu ứng búa gõ
    //     gavelIcon.classList.add('gavel-swing');
    //     setTimeout(() => gavelIcon.classList.remove('gavel-swing'), 400);

    //     // 3. Rung phản hồi (Haptic)
    //     if (window.navigator.vibrate) window.navigator.vibrate(50);

    //     // 4. Cập nhật lịch sử
    //     const newBid = document.createElement('div');
    //     newBid.className = 'flex justify-between text-[11px] animate-[fadeIn_0.5s_ease-out]';
    //     newBid.innerHTML = `
    //         <span class="text-[#bf953f]">Bạn (You)</span>
    //         <span class="text-[#bf953f] font-bold">${currentPrice.toLocaleString('vi-VN')}đ</span>
    //         <span class="text-gray-600 italic">vừa xong</span>
    //     `;
    //     bidHistory.prepend(newBid);
    // }
    // 2. Cập nhật hàm addBid để sử dụng bước giá thực tế
    function addBid(customAmount = 0) {
        // Nếu nhấn nút +5tr, +10tr thì dùng customAmount, nếu nhấn nút chính thì dùng bidStep
        let amountToAdd = customAmount > 0 ? customAmount : auctionState.bidStep;

        // Lưu ý: Đây mới chỉ là hiệu ứng giao diện (Frontend)
        // Để lưu vào DB, Ngài cần dùng AJAX gọi đến Place.php
        auctionState.currentPrice += amountToAdd;

        // Hiệu ứng nhảy số
        const priceDisplay = document.getElementById('current-price');
        priceDisplay.innerText = auctionState.currentPrice.toLocaleString('vi-VN');

        // Hiệu ứng búa
        const gavelIcon = document.getElementById('gavel-icon');
        gavelIcon.classList.add('gavel-swing');
        setTimeout(() => gavelIcon.classList.remove('gavel-swing'), 400);

        // Cập nhật lịch sử tạm thời trên giao diện
        updateBidHistoryLocal();
    }

    function maskName(name) {
        if (!name || name === "Khách") return name;
        let words = name.split(' ');
        if (words.length === 1) return name.substring(0, 1) + "**";

        // Giữ lại các từ đầu, từ cuối cùng chỉ lấy chữ cái đầu và thêm **
        let lastWord = words[words.length - 1];
        words[words.length - 1] = lastWord.charAt(0) + "**";

        return words.join(' ');
    }

    function updateBidHistoryLocal() {
        const historyContainer = document.getElementById('bid-history');
        if (!historyContainer) return;

        const newEntry = document.createElement('div');
        newEntry.className = 'flex justify-between text-[11px] animate-[fadeIn_0.5s_ease-out] border-l-2 border-[#bf953f] pl-2 mb-1';

        // Áp dụng che tên tại đây
        let displayUser = maskName(auctionState.currentUser);

        newEntry.innerHTML = `
        <span class="text-[#bf953f] font-medium">${displayUser} (Vừa đặt)</span>
        <span class="text-[#bf953f] font-bold">${auctionState.currentPrice.toLocaleString('vi-VN')}đ</span>
        <span class="text-gray-500 italic text-[9px]">vừa xong</span>
    `;

        historyContainer.prepend(newEntry);
    }

    function startGlobalTimers() {
        setInterval(() => {
            // Tìm tất cả các phần tử có class auction-timer
            document.querySelectorAll('.auction-timer').forEach(timer => {
                let seconds = parseInt(timer.getAttribute('data-seconds'));
                let status = timer.getAttribute('data-status');

                // Nếu là phiên đã kết thúc hoặc hết thời gian thì bỏ qua
                if (seconds <= 0 || status === 'completed' || status === 'settled') {
                    if (status === 'active') {
                        timer.innerText = "Đang kết thúc...";
                        // Ngài có thể reload trang tại đây nếu muốn cập nhật trạng thái mới
                        // location.reload(); 
                    }
                    return;
                }

                // Trừ 1 giây
                seconds--;
                timer.setAttribute('data-seconds', seconds);

                // Chuyển đổi giây thành định dạng H:i:s
                let h = Math.floor(seconds / 3600);
                let m = Math.floor((seconds % 3600) / 60);
                let s = seconds % 60;

                timer.innerText =
                    String(h).padStart(2, '0') + ":" +
                    String(m).padStart(2, '0') + ":" +
                    String(s).padStart(2, '0');
            });
        }, 1000);
    }

    // Gọi hàm chạy ngay khi trang load xong
    document.addEventListener('DOMContentLoaded', () => {
        startGlobalTimers();
    });


    // --- Auction Logic Configuration ---
    // let auctionState = {
    //     currentPrice: 850000000,
    //     timeLeft: 942, // Giây (15p 42s)
    //     highestBidder: "Mr. Hoang (H***8)"
    // };
    // 1. Đồng bộ dữ liệu từ Server vào Client
    let auctionState = {
        auctionId: <?php echo $auction_id; ?>,
        currentPrice: <?php echo (float)$auction['current_price']; ?>,
        timeLeft: <?php echo $secondsLeft; ?>,
        bidStep: <?php echo (float)$auction['bid_step']; ?>,
        highestBidder: "<?php echo addslashes($auction['highest_bidder_name'] ?? 'Chưa có'); ?>",
        currentUser: "<?php echo addslashes($userName); ?>"
    };

    // // 2. Cập nhật danh sách lịch sử
    // function updateBidHistory(amount) {
    //     const historyContainer = document.getElementById('bid-history');
    //     const newEntry = document.createElement('div');
    //     newEntry.className = 'flex justify-between text-[11px] animate-[fadeIn_0.5s_ease-out] border-l border-[#bf953f] pl-2';
    //     newEntry.innerHTML = `
    //     <span class="text-[#bf953f]">Bạn (You)</span>
    //     <span class="text-[#bf953f] font-bold">${auctionState.currentPrice.toLocaleString('vi-VN')}đ</span>
    //     <span class="text-gray-600 italic text-[9px]">vừa xong</span>
    // `;
    //     historyContainer.prepend(newEntry);
    // }

    const startCountdown = () => {
        // Lấy các element để tránh việc tìm kiếm nhiều lần trong setInterval
        const hEl = document.getElementById('hours');
        const mEl = document.getElementById('minutes');
        const sEl = document.getElementById('seconds');

        const timer = setInterval(() => {
            // 1. Kiểm tra nếu thời gian đã hết
            if (auctionState.timeLeft <= 0) {
                clearInterval(timer);
                auctionState.timeLeft = 0;

                hEl.innerText = '00';
                mEl.innerText = '00';
                sEl.innerText = '00';

                handleAuctionEnd();
                return;
            }

            // 2. Giảm thời gian sau mỗi giây
            auctionState.timeLeft--;

            // 3. Tính toán Giờ, Phút, Giây
            const hours = Math.floor(auctionState.timeLeft / 3600);
            const minutes = Math.floor((auctionState.timeLeft % 3600) / 60);
            const seconds = Math.floor(auctionState.timeLeft % 60);

            // 4. Hiển thị lên giao diện (Sử dụng padStart để luôn có 2 chữ số)
            hEl.innerText = String(hours).padStart(2, '0');
            mEl.innerText = String(minutes).padStart(2, '0');
            sEl.innerText = String(seconds).padStart(2, '0');

            // 5. Hiệu ứng kịch tính cho 10 giây cuối
            if (auctionState.timeLeft < 10) {
                sEl.classList.add('text-red-500', 'scale-110');
            } else {
                sEl.classList.remove('text-red-500', 'scale-110');
            }
        }, 1000); // Chạy chính xác mỗi 1000ms (1 giây)
    };

    // 4. Xử lý khi kết thúc
    function handleAuctionEnd() {
        // 1. Vô hiệu hóa tất cả các nút đặt giá
        const bidButtons = document.querySelectorAll('button[onclick*="addBid"], #btn-bid');
        bidButtons.forEach(btn => {
            btn.disabled = true;
            btn.style.backgroundColor = '#4b5563'; // Màu xám (gray-600)
            btn.innerText = "ĐÃ KẾT THÚC";
            btn.style.cursor = 'not-allowed';
        });

        // 2. Thông báo người thắng (Gửi yêu cầu về server để xử lý trừ tiền)

        // Ngài có thể dùng fetch để gọi một file PHP xử lý trừ tiền ở đây
        // fetch('process_winner.php?auction_id=' + auctionState.auctionId);
    }

    // Khởi tạo khi trang sẵn sàng
    document.addEventListener('DOMContentLoaded', () => {
        startCountdown();

        // Gán sự kiện cho nút "Đặt giá ngay" chính
        document.getElementById('btn-bid').addEventListener('click', () => {
            addBid(10000000); // Mặc định cộng 10tr khi nhấn nút chính
        });
    });
    // -----------------------------section 2 ----------------------------- //

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>