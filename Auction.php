<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

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
                                <span class="text-black text-5xl font-bold tracking-tighter">30K-999.99</span>
                            </div>
                            <div id="gavel-icon" class="absolute -right-12 -top-12 opacity-0 transition-all duration-300">
                                <i class="ri-gavel-fill text-4xl text-[#bf953f]"></i>
                            </div>
                        </div>

                        <div class="absolute bottom-6 flex gap-8">
                            <div class="text-center">
                                <p class="text-[9px] text-gray-500 uppercase tracking-widest">Lượt đấu</p>
                                <p class="font-bold">1,248</p>
                            </div>
                            <div class="text-center border-x border-white/10 px-8">
                                <p class="text-[9px] text-gray-500 uppercase tracking-widest">Người tham gia</p>
                                <p class="font-bold">86</p>
                            </div>
                            <div class="text-center">
                                <p class="text-[9px] text-gray-500 uppercase tracking-widest">Giá khởi điểm</p>
                                <p class="font-bold">100 Tr</p>
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
                            <div class="flex justify-between text-[11px] animate-[fadeIn_0.5s_ease-out]">
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
                            </div>
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

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
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

    function addBid(amount) {
        currentPrice += amount;

        // 1. Hiệu ứng số nhảy (Slot machine style)
        priceDisplay.classList.add('scale-110', 'brightness-150');
        setTimeout(() => {
            priceDisplay.innerText = currentPrice.toLocaleString('vi-VN');
            priceDisplay.classList.remove('scale-110', 'brightness-150');
        }, 100);

        // 2. Hiệu ứng búa gõ
        gavelIcon.classList.add('gavel-swing');
        setTimeout(() => gavelIcon.classList.remove('gavel-swing'), 400);

        // 3. Rung phản hồi (Haptic)
        if (window.navigator.vibrate) window.navigator.vibrate(50);

        // 4. Cập nhật lịch sử
        const newBid = document.createElement('div');
        newBid.className = 'flex justify-between text-[11px] animate-[fadeIn_0.5s_ease-out]';
        newBid.innerHTML = `
            <span class="text-[#bf953f]">Bạn (You)</span>
            <span class="text-[#bf953f] font-bold">${currentPrice.toLocaleString('vi-VN')}đ</span>
            <span class="text-gray-600 italic">vừa xong</span>
        `;
        bidHistory.prepend(newBid);
    }

    // Countdown Logic
    let timeLeft = 942; // 15 phút 42 giây
    setInterval(() => {
        if (timeLeft <= 0) return;
        timeLeft--;
        const h = Math.floor(timeLeft / 3600);
        const m = Math.floor((timeLeft % 3600) / 60);
        const s = timeLeft % 60;
        document.getElementById('hours').innerText = String(h).padStart(2, '0');
        document.getElementById('minutes').innerText = String(m).padStart(2, '0');
        document.getElementById('seconds').innerText = String(s).padStart(2, '0');

        // Kịch tính hóa 10 giây cuối
        if (timeLeft < 10) {
            document.body.classList.add('border-4', 'border-red-600/30');
            document.getElementById('seconds').classList.add('text-red-500', 'scale-150');
        }
    }, 1000);
    // --- Auction Logic Configuration ---
    let auctionState = {
        currentPrice: 850000000,
        timeLeft: 942, // Giây (15p 42s)
        highestBidder: "Mr. Hoang (H***8)"
    };

    // 2. Cập nhật danh sách lịch sử
    function updateBidHistory(amount) {
        const historyContainer = document.getElementById('bid-history');
        const newEntry = document.createElement('div');
        newEntry.className = 'flex justify-between text-[11px] animate-[fadeIn_0.5s_ease-out] border-l border-[#bf953f] pl-2';
        newEntry.innerHTML = `
        <span class="text-[#bf953f]">Bạn (You)</span>
        <span class="text-[#bf953f] font-bold">${auctionState.currentPrice.toLocaleString('vi-VN')}đ</span>
        <span class="text-gray-600 italic text-[9px]">vừa xong</span>
    `;
        historyContainer.prepend(newEntry);
    }

    // 3. Logic Đồng hồ đếm ngược (Countdown)
    const startCountdown = () => {
        const timer = setInterval(() => {
            if (auctionState.timeLeft <= 0) {
                clearInterval(timer);
                handleAuctionEnd();
                return;
            }

            auctionState.timeLeft--;

            const h = Math.floor(auctionState.timeLeft / 3600);
            const m = Math.floor((auctionState.timeLeft % 3600) / 60);
            const s = auctionState.timeLeft % 60;

            document.getElementById('hours').innerText = String(h).padStart(2, '0');
            document.getElementById('minutes').innerText = String(m).padStart(2, '0');
            document.getElementById('seconds').innerText = String(s).padStart(2, '0');

            // Kịch tính hóa 10 giây cuối
            if (auctionState.timeLeft < 10) {
                document.getElementById('auction-container').classList.add('last-seconds-active');
                document.getElementById('seconds').style.color = '#ef4444';
                document.getElementById('seconds').classList.add('animate-pulse');
            }
        }, 1000);
    };

    // 4. Xử lý khi kết thúc
    function handleAuctionEnd() {
        alert("PHIÊN ĐẤU GIÁ KẾT THÚC!");
        // Chuyển hướng hoặc hiện Modal chúc mừng tại đây
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