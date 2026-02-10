<!DOCTYPE html>
<html lang="vi">
<?php
require_once dirname(__DIR__) . '/check_admin.php';
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
                    <button class="tab-item active text-[10px] font-cinzel tracking-[0.2em] text-[#c5a059] relative" data-status="ongoing">ĐANG DIỄN RA</button>
                    <button class="tab-item text-[10px] font-cinzel tracking-[0.2em] text-gray-500 hover:text-white transition-colors" data-status="upcoming">SẮP DIỄN RA</button>
                    <button class="tab-item text-[10px] font-cinzel tracking-[0.2em] text-gray-500 hover:text-white transition-colors" data-status="ended">ĐÃ KẾT THÚC</button>
                    <div id="tab-indicator" class="absolute bottom-[-1px] left-0 h-[1px] bg-[#c5a059] shadow-[0_0_10px_#c5a059]" style="margin-left: 0;"></div>
                </div>
            </div>

            <button onclick="openAuctionModal()" class="bg-[#c5a059] text-black px-6 py-3 rounded-lg font-bold text-xs flex items-center gap-2 hover:shadow-[0_0_20px_rgba(197,160,89,0.3)] transition-all active:scale-95">
                <i class="ri-hammer-fill text-lg"></i> TẠO PHIÊN MỚI
            </button>
        </header>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6" id="auction-grid">

                <div class="auction-card rounded-2xl p-6 relative overflow-hidden group" data-card-status="ongoing">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-[9px] font-bold tracking-widest text-red-500 uppercase">Live</span>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <svg class="timer-svg w-12 h-12">
                                <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                <circle class="timer-circle" cx="24" cy="24" r="20" id="circle-1" />
                            </svg>
                            <span class="absolute text-[10px] font-bold" id="time-1">45s</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                            <span class="text-black font-black text-sm tracking-tighter">888.88</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pentagon VIP Plate</h3>
                            <p class="text-[9px] text-gray-500 italic">Dòng xe: Maybach S680</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                            <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price" id="price-1">$125,400</h4>
                        </div>
                        <div class="h-[1px] bg-white/5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px]">JD</div>
                                <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px]">AM</div>
                            </div>
                            <button onclick="openDetailPanel('888.88')" class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="auction-card rounded-2xl p-6 relative overflow-hidden group" data-card-status="ongoing">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-[9px] font-bold tracking-widest text-red-500 uppercase">Live</span>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <svg class="timer-svg w-12 h-12">
                                <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                <circle class="timer-circle" cx="24" cy="24" r="20" id="circle-1" />
                            </svg>
                            <span class="absolute text-[10px] font-bold" id="time-1">45s</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                            <span class="text-black font-black text-sm tracking-tighter">888.88</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pentagon VIP Plate</h3>
                            <p class="text-[9px] text-gray-500 italic">Dòng xe: Maybach S680</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                            <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price" id="price-1">$125,400</h4>
                        </div>
                        <div class="h-[1px] bg-white/5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px]">JD</div>
                                <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px]">AM</div>
                            </div>
                            <button onclick="openDetailPanel('888.88')" class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="auction-card rounded-2xl p-6 relative overflow-hidden group" data-card-status="ongoing">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-[9px] font-bold tracking-widest text-red-500 uppercase">Live</span>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <svg class="timer-svg w-12 h-12">
                                <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                <circle class="timer-circle" cx="24" cy="24" r="20" id="circle-1" />
                            </svg>
                            <span class="absolute text-[10px] font-bold" id="time-1">45s</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                            <span class="text-black font-black text-sm tracking-tighter">888.88</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pentagon VIP Plate</h3>
                            <p class="text-[9px] text-gray-500 italic">Dòng xe: Maybach S680</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                            <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price" id="price-1">$125,400</h4>
                        </div>
                        <div class="h-[1px] bg-white/5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px]">JD</div>
                                <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px]">AM</div>
                            </div>
                            <button onclick="openDetailPanel('888.88')" class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="auction-card rounded-2xl p-6 relative overflow-hidden group" data-card-status="ongoing">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-[9px] font-bold tracking-widest text-red-500 uppercase">Live</span>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <svg class="timer-svg w-12 h-12">
                                <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                <circle class="timer-circle" cx="24" cy="24" r="20" id="circle-1" />
                            </svg>
                            <span class="absolute text-[10px] font-bold" id="time-1">45s</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                            <span class="text-black font-black text-sm tracking-tighter">888.88</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pentagon VIP Plate</h3>
                            <p class="text-[9px] text-gray-500 italic">Dòng xe: Maybach S680</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                            <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price" id="price-1">$125,400</h4>
                        </div>
                        <div class="h-[1px] bg-white/5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px]">JD</div>
                                <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px]">AM</div>
                            </div>
                            <button onclick="openDetailPanel('888.88')" class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="auction-card rounded-2xl p-6 relative overflow-hidden group" data-card-status="upcoming">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-[9px] font-bold tracking-widest text-red-500 uppercase">Live</span>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <svg class="timer-svg w-12 h-12">
                                <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                <circle class="timer-circle" cx="24" cy="24" r="20" id="circle-1" />
                            </svg>
                            <span class="absolute text-[10px] font-bold" id="time-1">45s</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                            <span class="text-black font-black text-sm tracking-tighter">888.88</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pentagon VIP Plate</h3>
                            <p class="text-[9px] text-gray-500 italic">Dòng xe: Maybach S680</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                            <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price" id="price-1">$125,400</h4>
                        </div>
                        <div class="h-[1px] bg-white/5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px]">JD</div>
                                <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px]">AM</div>
                            </div>
                            <button onclick="openDetailPanel('888.88')" class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="auction-card rounded-2xl p-6 relative overflow-hidden group" data-card-status="upcoming">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-[9px] font-bold tracking-widest text-red-500 uppercase">Live</span>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <svg class="timer-svg w-12 h-12">
                                <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                <circle class="timer-circle" cx="24" cy="24" r="20" id="circle-1" />
                            </svg>
                            <span class="absolute text-[10px] font-bold" id="time-1">45s</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                            <span class="text-black font-black text-sm tracking-tighter">888.88</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pentagon VIP Plate</h3>
                            <p class="text-[9px] text-gray-500 italic">Dòng xe: Maybach S680</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                            <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price" id="price-1">$125,400</h4>
                        </div>
                        <div class="h-[1px] bg-white/5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px]">JD</div>
                                <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px]">AM</div>
                            </div>
                            <button onclick="openDetailPanel('888.88')" class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="auction-card rounded-2xl p-6 relative overflow-hidden group" data-card-status="upcoming">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-[9px] font-bold tracking-widest text-red-500 uppercase">Live</span>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <svg class="timer-svg w-12 h-12">
                                <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                <circle class="timer-circle" cx="24" cy="24" r="20" id="circle-1" />
                            </svg>
                            <span class="absolute text-[10px] font-bold" id="time-1">45s</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                            <span class="text-black font-black text-sm tracking-tighter">888.88</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pentagon VIP Plate</h3>
                            <p class="text-[9px] text-gray-500 italic">Dòng xe: Maybach S680</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                            <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price" id="price-1">$125,400</h4>
                        </div>
                        <div class="h-[1px] bg-white/5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px]">JD</div>
                                <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px]">AM</div>
                            </div>
                            <button onclick="openDetailPanel('888.88')" class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="auction-card rounded-2xl p-6 relative overflow-hidden group" data-card-status="ended">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-[9px] font-bold tracking-widest text-red-500 uppercase">Live</span>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <svg class="timer-svg w-12 h-12">
                                <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                <circle class="timer-circle" cx="24" cy="24" r="20" id="circle-1" />
                            </svg>
                            <span class="absolute text-[10px] font-bold" id="time-1">45s</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                            <span class="text-black font-black text-sm tracking-tighter">888.88</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pentagon VIP Plate</h3>
                            <p class="text-[9px] text-gray-500 italic">Dòng xe: Maybach S680</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                            <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price" id="price-1">$125,400</h4>
                        </div>
                        <div class="h-[1px] bg-white/5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px]">JD</div>
                                <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px]">AM</div>
                            </div>
                            <button onclick="openDetailPanel('888.88')" class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="auction-card rounded-2xl p-6 relative overflow-hidden group" data-card-status="ended">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-[9px] font-bold tracking-widest text-red-500 uppercase">Live</span>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <svg class="timer-svg w-12 h-12">
                                <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                <circle class="timer-circle" cx="24" cy="24" r="20" id="circle-1" />
                            </svg>
                            <span class="absolute text-[10px] font-bold" id="time-1">45s</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                            <span class="text-black font-black text-sm tracking-tighter">888.88</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pentagon VIP Plate</h3>
                            <p class="text-[9px] text-gray-500 italic">Dòng xe: Maybach S680</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                            <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price" id="price-1">$125,400</h4>
                        </div>
                        <div class="h-[1px] bg-white/5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px]">JD</div>
                                <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px]">AM</div>
                            </div>
                            <button onclick="openDetailPanel('888.88')" class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="auction-card rounded-2xl p-6 relative overflow-hidden group" data-card-status="ended">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-[9px] font-bold tracking-widest text-red-500 uppercase">Live</span>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <svg class="timer-svg w-12 h-12">
                                <circle class="stroke-white/10 fill-none" cx="24" cy="24" r="20" stroke-width="2" />
                                <circle class="timer-circle" cx="24" cy="24" r="20" id="circle-1" />
                            </svg>
                            <span class="absolute text-[10px] font-bold" id="time-1">45s</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-12 bg-white rounded flex items-center justify-center shadow-2xl border border-white/20">
                            <span class="text-black font-black text-sm tracking-tighter">888.88</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pentagon VIP Plate</h3>
                            <p class="text-[9px] text-gray-500 italic">Dòng xe: Maybach S680</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase">Giá hiện tại</p>
                            <h4 class="text-xl font-bold text-[#c5a059] tracking-tighter bid-price" id="price-1">$125,400</h4>
                        </div>
                        <div class="h-[1px] bg-white/5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full bg-zinc-800 border border-white/10 flex items-center justify-center text-[8px]">JD</div>
                                <div class="w-6 h-6 rounded-full bg-zinc-700 border border-white/10 flex items-center justify-center text-[8px]">AM</div>
                            </div>
                            <button onclick="openDetailPanel('888.88')" class="text-[9px] font-bold text-white/40 hover:text-white transition-colors">
                                CHI TIẾT <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>




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
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[9px] text-gray-500 uppercase tracking-widest">Giá khởi điểm</label>
                                <input type="text" class="w-full bg-white/5 border border-white/10 rounded-lg p-3 text-sm focus:border-[#c5a059] outline-none transition-all" placeholder="$50,000">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] text-gray-500 uppercase tracking-widest">Bước giá (Min)</label>
                                <input type="text" class="w-full bg-white/5 border border-white/10 rounded-lg p-3 text-sm focus:border-[#c5a059] outline-none transition-all" placeholder="$500">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[9px] text-gray-500 uppercase tracking-widest">Thời gian bắt đầu</label>
                            <input type="datetime-local" class="w-full bg-white/5 border border-white/10 rounded-lg p-3 text-sm focus:border-[#c5a059] outline-none invert">
                        </div>
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl">
                            <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Kích hoạt Live ngay</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only toggle-checkbox">
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
                        <button class="flex-1 py-3 text-[10px] font-bold bg-[#c5a059] text-black rounded-lg">PHÊ DUYỆT</button>
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
                    <button onclick="closeDetailPanel()" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-white/10 transition-all">
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

                <div class="flex-1 overflow-y-auto no-scrollbar space-y-4">
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
                </div>

                <div class="mt-auto pt-6 border-t border-white/5 grid grid-cols-2 gap-4">
                    <button class="py-3 text-[10px] font-bold bg-white/5 rounded-lg hover:bg-red-900/20 hover:text-red-500 transition-all uppercase tracking-widest">Dừng phiên</button>
                    <button class="py-3 text-[10px] font-bold bg-[#c5a059] text-black rounded-lg uppercase tracking-widest">Gia hạn</button>
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

        function openDetailPanel(plateNumber) {
            const overlay = document.getElementById('side-panel-overlay');
            const panel = document.getElementById('side-panel');
            const plateDisplay = document.getElementById('panel-plate');

            // Cập nhật tên biển số
            plateDisplay.innerText = plateNumber;

            // Hiển thị Overlay
            overlay.classList.remove('hidden');

            // GSAP Animation
            gsap.to(overlay, {
                opacity: 1,
                duration: 0.4
            });
            gsap.to(panel, {
                x: 0,
                duration: 0.6,
                ease: "expo.out"
            });

            // Hiệu ứng vẽ đường biểu đồ trong Panel
            gsap.from(".path-anim", {
                strokeDasharray: 300,
                strokeDashoffset: 300,
                duration: 2,
                ease: "power2.out",
                delay: 0.3
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
    </script>
</body>

</html>