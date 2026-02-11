<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Action.php";
$actionModel = new Action();
$status = $_GET['status'] ?? 'active';

$auctions = $actionModel->getAuctionsByStatus($status);


foreach ($auctions as $item):
    // 1. Xác định màu sắc và nhãn theo trạng thái
    $color = ($item['status'] == 'active') ? 'red-500' : (($item['status'] == 'upcoming') ? 'blue-400' : 'gray-500');
    $label = ($item['status'] == 'active') ? 'Live' : (($item['status'] == 'upcoming') ? 'Sắp tới' : 'Kết thúc');

    // 2. Tính toán thời gian đếm ngược
    $now = time();
    $targetTime = ($item['status'] == 'upcoming') ? strtotime($item['start_time']) : strtotime($item['end_time']);
    $secondsLeft = max(0, $targetTime - $now);
?>
    <div class="auction-card rounded-2xl p-6 relative overflow-hidden group border border-white/5 bg-[#0f0f0f]"
        data-card-status="<?php echo $item['status']; ?>">

        <div class="flex justify-between items-start mb-6">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-<?php echo $color; ?> <?php echo ($item['status'] == 'active') ? 'animate-pulse' : ''; ?>"></span>
                <span class="text-[9px] font-bold tracking-widest text-<?php echo $color; ?> uppercase"><?php echo $label; ?></span>
            </div>

            <div class="relative w-12 h-12 flex items-center justify-center">
                <svg class="timer-svg w-12 h-12">
                    <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                    <circle class="timer-circle transition-all duration-1000"
                        cx="24" cy="24" r="20"
                        style="stroke: <?php echo ($item['status'] == 'active') ? '#ef4444' : '#c5a059'; ?>; 
                                       stroke-dasharray: 126; 
                                       stroke-dashoffset: <?php echo (1 - min(1, $secondsLeft / 3600)) * 126; ?>;" />
                </svg>
                <span class="absolute text-[10px] font-bold auction-timer-display text-white"
                    data-seconds="<?php echo $secondsLeft; ?>">
                    <?php
                    if ($secondsLeft >= 3600) echo floor($secondsLeft / 3600) . 'h';
                    elseif ($secondsLeft >= 60) echo floor($secondsLeft / 60) . 'm';
                    else echo $secondsLeft . 's';
                    ?>
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
                <h3 class="text-xs font-bold text-white uppercase tracking-wider">Phiên đấu giá VIP</h3>
                <p class="text-[9px] text-gray-500 italic">Giá sàn: <?php echo number_format($item['starting_price']); ?>đ</p>
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
                        <i class="ri-user-line"></i>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px] text-white">
                        +<?php echo rand(5, 15); ?>
                    </div>
                </div>

                <button onclick="openDetailPanel('<?php echo $item['plate_number']; ?>')"
                    class="text-[9px] font-bold text-white/40 hover:text-white transition-colors flex items-center gap-1">
                    CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                </button>
            </div>
        </div>
    </div>
<?php endforeach; ?>