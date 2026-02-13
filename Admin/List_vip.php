<!DOCTYPE html>
<html lang="vi">
<?php
require_once dirname(__DIR__) . '/check_admin.php';
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/User.php";
$userModel = new User();
$members = $userModel->getAllVipMembers();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP CRM | Inner Circle Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Montserrat:wght@300;400;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #c5a059;
            --platinum: #e5e7eb;
            --diamond: #ffffff;
        }

        body {
            background: #080808;
            color: #d1d1d1;
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        .font-cinzel {
            font-family: 'Cinzel Decorative', cursive;
        }

        /* 3D Card Effect */
        .tier-card {
            perspective: 1000px;
            transition: transform 0.1s;
        }

        /* Shine Animation */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            transition: 0.8s;
        }

        .shine-effect:hover::after {
            left: 120%;
        }

        /* Custom Scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* VIP Wealth Indicator */
        .wealth-bar {
            height: 1px;
            background: rgba(197, 160, 89, 0.2);
            position: relative;
        }

        .wealth-progress {
            height: 100%;
            background: var(--gold);
            box-shadow: 0 0 10px var(--gold);
        }

        /* Privacy Overlay */
        #security-blur {
            backdrop-filter: blur(20px);
            background: rgba(8, 8, 8, 0.4);
            pointer-events: none;
            display: none;
        }
    </style>
</head>

<body>

    <?php include('Sidebar.php'); ?>

    <div id="security-blur" class="fixed inset-0 z-[9999]"></div>

    <main class="main-content md:ml-[288px] min-h-screen p-6 md:p-10">

        <header class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="tier-card shine-effect bg-gradient-to-br from-[#1a1a1a] to-[#000] border border-white/10 p-6 rounded-2xl relative group cursor-pointer">
                <div class="flex justify-between items-start mb-10">
                    <i class="ri-vip-crown-fill text-2xl text-white group-hover:scale-125 transition-transform duration-700"></i>
                    <span class="text-[9px] tracking-[0.3em] text-white/40 uppercase">Hạng tối cao</span>
                </div>
                <h3 class="text-xl font-cinzel text-white mb-1">Black Diamond</h3>
                <p class="text-[10px] text-gray-500 tracking-widest">12 THÀNH VIÊN</p>
            </div>

            <div class="tier-card shine-effect bg-gradient-to-br from-[#222] to-[#0a0a0a] border border-white/5 p-6 rounded-2xl group cursor-pointer">
                <div class="flex justify-between items-start mb-10">
                    <i class="ri-medal-fill text-2xl text-slate-300"></i>
                    <span class="text-[9px] tracking-[0.3em] text-white/40 uppercase">Hạng ưu tú</span>
                </div>
                <h3 class="text-xl font-cinzel text-slate-300 mb-1">Platinum Elite</h3>
                <p class="text-[10px] text-gray-500 tracking-widest">48 THÀNH VIÊN</p>
            </div>

            <div onclick="openInviteModal()" class="border-2 border-dashed border-white/10 p-6 rounded-2xl flex flex-col items-center justify-center group hover:border-[#c5a059]/50 transition-all cursor-pointer bg-white/[0.02]">
                <i class="ri-mail-send-line text-3xl text-gray-600 group-hover:text-[#c5a059] group-hover:scale-110 transition-all"></i>
                <p class="text-[10px] font-bold tracking-[0.3em] text-gray-500 mt-4 uppercase group-hover:text-white">Gửi thẻ mời VIP</p>
            </div>
        </header>

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div class="relative w-full md:w-96 group">
                <i class="ri-search-eye-line absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-hover:text-[#c5a059]"></i>
                <input type="text" placeholder="TÌM KIẾM THƯỢNG KHÁCH..." class="w-full bg-white/5 border border-white/5 rounded-full py-3 px-12 text-[10px] tracking-widest outline-none focus:border-[#c5a059]/30 transition-all">
            </div>

            <div class="flex gap-4">
                <div class="relative group-filter">
                    <button onclick="toggleFilterMenu('spending-menu')" class="flex items-center gap-2 px-5 py-3 bg-white/5 rounded-full text-[10px] tracking-widest hover:bg-white/10 transition-all text-gray-400 hover:text-[#c5a059]">
                        <i class="ri-filter-3-line"></i> CHI TIÊU
                    </button>

                    <div id="spending-menu" class="filter-dropdown absolute left-0 mt-3 w-48 bg-[#0f0f0f]/90 backdrop-blur-xl border border-white/10 rounded-xl shadow-2xl z-[100] hidden opacity-0 translate-y-2">
                        <div class="p-4 space-y-3">
                            <button onclick="applyEliteFilter('spending', 'high')" class="w-full text-left text-[9px] tracking-widest text-gray-400 hover:text-[#c5a059] transition-all uppercase">Trị giá > $1M</button>
                            <button onclick="applyEliteFilter('spending', 'mid')" class="w-full text-left text-[9px] tracking-widest text-gray-400 hover:text-[#c5a059] transition-all uppercase">Trị giá $500K - $1M</button>
                            <button onclick="applyEliteFilter('spending', 'low')" class="w-full text-left text-[9px] tracking-widest text-gray-400 hover:text-[#c5a059] transition-all uppercase">Dưới $500K</button>
                        </div>
                    </div>
                </div>

                <div class="relative group-filter">
                    <button onclick="toggleFilterMenu('fengshui-menu')" class="flex items-center gap-2 px-5 py-3 bg-white/5 rounded-full text-[10px] tracking-widest hover:bg-white/10 transition-all text-gray-400 hover:text-[#c5a059]">
                        <i class="ri-compass-3-line"></i> PHONG THỦY
                    </button>

                    <div id="fengshui-menu" class="filter-dropdown absolute right-0 mt-3 w-48 bg-[#0f0f0f]/90 backdrop-blur-xl border border-white/10 rounded-xl shadow-2xl z-[100] hidden opacity-0 translate-y-2">
                        <div class="p-4 space-y-3">
                            <button onclick="applyEliteFilter('fengshui', 'kim')" class="w-full text-left text-[9px] tracking-widest text-gray-400 hover:text-[#c5a059] transition-all uppercase">Mệnh Kim (Trắng/Vàng)</button>
                            <button onclick="applyEliteFilter('fengshui', 'thuy')" class="w-full text-left text-[9px] tracking-widest text-gray-400 hover:text-[#c5a059] transition-all uppercase">Mệnh Thủy (Đen/Xanh)</button>
                            <button onclick="applyEliteFilter('fengshui', 'hoa')" class="w-full text-left text-[9px] tracking-widest text-gray-400 hover:text-[#c5a059] transition-all uppercase">Mệnh Hỏa (Đỏ/Tím)</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
        <section class="bg-white/[0.01] border border-white/5 rounded-3xl overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-white/[0.02] border-b border-white/5">
                    <tr>
                        <th class="p-6 text-[9px] tracking-[0.3em] text-gray-500 uppercase">Định danh thượng khách</th>
                        <th class="p-6 text-[9px] tracking-[0.3em] text-gray-500 uppercase text-center">Cấp bậc</th>
                        <th class="p-6 text-[9px] tracking-[0.3em] text-gray-500 uppercase text-right">Trạng thái</th>
                        <th class="p-6 text-[9px] tracking-[0.3em] text-gray-500 uppercase text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.03]">
                    <?php
                    $userModel = new User();
                    $vipMembers = $userModel->getAllVipMembers();

                    if (!empty($vipMembers)):
                        foreach ($vipMembers as $vip):
                            // Logic hiển thị trạng thái
                            $statusText = ($vip['status'] == 1) ? 'Online' : 'Đình chỉ';
                            $statusClass = ($vip['status'] == 1) ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20';
                    ?>
                            <tr class="ledger-row hover:bg-white/[0.02] transition-all group">
                                <td class="p-6">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <div class="w-12 h-12 rounded-full border-2 border-[#c5a059] p-0.5">
                                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($vip['fullname']) ?>&background=random&color=fff"
                                                    class="w-full h-full rounded-full object-cover grayscale group-hover:grayscale-0 transition-all" alt="VIP">
                                            </div>
                                            <?php if ($vip['status'] == 1): ?>
                                                <div class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-[#080808] rounded-full"></div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h4 onclick="openUserProfile(<?= htmlspecialchars(json_encode($vip)) ?>)"
                                                class="font-playfair text-white text-base cursor-pointer hover:text-[#c5a059] transition-colors">
                                                <?= htmlspecialchars($vip['fullname']) ?>
                                            </h4>
                                            <p class="text-[9px] text-gray-500 tracking-tighter"><?= htmlspecialchars($vip['email']) ?></p>
                                            <div class="wealth-bar w-32 mt-2">
                                                <div class="wealth-progress w-[<?= rand(40, 95) ?>%]"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6 text-center">
                                    <span class="font-cinzel text-[10px] tracking-widest" style="color: <?= $vip['role_color'] ?>">
                                        <?= $vip['display_name'] ?>
                                    </span>
                                </td>
                                <td class="p-6 text-right">
                                    <span class="text-[9px] px-3 py-1 rounded-full border font-bold uppercase <?= $statusClass ?>">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td class="p-6">
                                    <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all">
                                        <button onclick="openUserProfile(<?= htmlspecialchars(json_encode($vip)) ?>)" title="Thiết lập đặc quyền" class="text-gray-400 hover:text-white transition-colors">
                                            <i class="ri-settings-5-line text-lg"></i>
                                        </button>

                                        <button onclick="toggleMemberStatus(<?= $vip['user_id'] ?>, <?= $vip['status'] ?>)"
                                            title="<?= ($vip['status'] == 1) ? 'Đình chỉ' : 'Kích hoạt' ?>"
                                            class="text-gray-400 hover:text-red-500 transition-colors">
                                            <i class="ri-forbid-line text-lg"></i>
                                        </button>

                                        <button onclick="confirmDeleteVip(<?= $vip['user_id'] ?>)" title="Xóa hội viên" class="text-gray-400 hover:text-red-700 transition-colors">
                                            <i class="ri-delete-bin-line text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                    else:
                        ?>
                        <tr>
                            <td colspan="4" class="p-10 text-center text-gray-500 italic">Chưa có thượng khách nào gia nhập Inner Circle.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <div id="user-panel-overlay" class="fixed inset-0 z-[2000] bg-black/60 backdrop-blur-sm hidden opacity-0">
        <form id="edit-user-form" action="process_user.php" method="POST" class="absolute right-0 top-0 h-full w-full max-w-xl bg-[#0f0f0f] border-l border-white/10 shadow-2xl p-10 translate-x-full overflow-y-auto no-scrollbar">
            <input type="hidden" name="action" value="edit_member">
            <input type="hidden" name="user_id" id="edit-user-id">

            <div class="flex justify-between items-center mb-12">
                <button type="button" onclick="closeUserProfile()" class="text-gray-500 hover:text-white flex items-center gap-2 text-[10px] tracking-widest">
                    <i class="ri-arrow-right-s-line text-xl"></i> ĐÓNG HỒ SƠ
                </button>
                <i class="ri-vip-crown-fill text-[#c5a059] text-2xl"></i>
            </div>

            <div class="text-center mb-12">
                <div class="w-24 h-24 rounded-full border-2 border-[#c5a059] p-1 mx-auto mb-4">
                    <img id="panel-avatar" src="https://i.pravatar.cc/150?u=vip1" class="w-full h-full rounded-full object-cover shadow-2xl" alt="Avatar">
                </div>
                <input type="text" name="fullname" id="panel-name-input" class="bg-transparent text-center font-cinzel text-2xl text-white outline-none border-b border-transparent focus:border-[#c5a059] w-full" value="Alexander Wong">

                <select name="role_id" id="panel-role-select" class="bg-transparent text-[10px] text-[#c5a059] tracking-[0.4em] uppercase mt-4 font-bold outline-none text-center w-full appearance-none cursor-pointer">
                    <option value="1" class="bg-[#0f0f0f]">Black Diamond Member</option>
                    <option value="3" class="bg-[#0f0f0f]">Platinum Member</option>
                </select>
            </div>

            <div class="space-y-8">
                <div>
                    <h3 class="text-[9px] text-gray-500 uppercase tracking-widest mb-4 border-b border-white/5 pb-2">Thông tin liên lạc</h3>
                    <div class="space-y-4">
                        <div class="relative">
                            <label class="text-[8px] text-gray-600 uppercase absolute -top-2 left-3 bg-[#0f0f0f] px-1">Email Hệ Thống</label>
                            <input type="email" name="email" id="panel-email-input" class="w-full bg-white/5 p-4 rounded-xl text-xs text-white outline-none border border-transparent focus:border-[#c5a059]/50">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-[9px] text-gray-500 uppercase tracking-widest mb-4 border-b border-white/5 pb-2">Trạng thái tài khoản</h3>
                    <select name="status" id="panel-status-select" class="w-full bg-white/5 p-4 rounded-xl text-xs text-white outline-none border border-transparent focus:border-[#c5a059]/50">
                        <option value="1" class="bg-[#0f0f0f]">Hoạt động (Active)</option>
                        <option value="0" class="bg-[#0f0f0f]">Đình chỉ (Suspended)</option>
                    </select>
                </div>
            </div>

            <div class="mt-12 grid grid-cols-2 gap-4">
                <button type="button" onclick="confirmDeleteVip(document.getElementById('edit-user-id').value)" class="py-4 bg-white/5 text-[10px] font-bold tracking-widest rounded-xl hover:bg-red-900/20 hover:text-red-500 transition-all uppercase">Xóa Hội Viên</button>
                <button type="submit" class="py-4 bg-[#c5a059] text-black text-[10px] font-bold tracking-widest rounded-xl overflow-hidden relative group">
                    <span class="relative z-10 uppercase">Lưu thay đổi</span>
                    <div class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </button>
            </div>
        </form>
    </div>

    <div id="invite-modal" class="fixed inset-0 z-[5000] bg-black/80 backdrop-blur-md hidden items-center justify-center p-4">
        <div id="invite-card" class="bg-[#0f0f0f] border border-[#c5a059]/30 w-full max-w-md rounded-2xl overflow-hidden shadow-[0_0_50px_rgba(197,160,89,0.1)] opacity-0 scale-90">
            <div class="h-2 bg-[#c5a059] shadow-[0_0_15px_#c5a059]"></div>

            <div class="p-8">
                <div class="flex justify-between items-start mb-8">
                    <div class="font-cinzel text-[#c5a059] text-xs tracking-[0.3em]">The Inner Circle</div>
                    <button type="button" onclick="closeInviteModal()" class="text-gray-600 hover:text-white transition-colors">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>

                <div class="text-center mb-10">
                    <i class="ri-mail-open-line text-4xl text-[#c5a059] mb-4 inline-block"></i>
                    <h2 class="font-playfair text-2xl text-white italic">Gửi Thẻ Mời Đặc Quyền</h2>
                    <p class="text-[10px] text-gray-500 tracking-widest mt-2 uppercase">Chỉ dành cho những cá nhân xuất chúng</p>
                </div>

                <form action="process_user.php" method="POST" id="invite-form">
                    <input type="hidden" name="action" value="add_member">
                    <input type="hidden" name="role_id" id="selected-role" value="3">
                    <div class="space-y-6">
                        <div class="relative group">
                            <label class="text-[9px] text-gray-600 uppercase tracking-widest absolute -top-2 left-3 bg-[#0f0f0f] px-2 z-10">Họ và tên Thượng khách</label>
                            <input type="text" name="fullname" required placeholder="Vd: Lord Alexander"
                                class="w-full bg-transparent border border-white/10 rounded-lg py-4 px-4 text-xs text-white outline-none focus:border-[#c5a059] transition-all">
                        </div>

                        <div class="relative group">
                            <label class="text-[9px] text-gray-600 uppercase tracking-widest absolute -top-2 left-3 bg-[#0f0f0f] px-2 z-10">Email nhận thư</label>
                            <input type="email" name="email" required placeholder="vip-contact@domain.com"
                                class="w-full bg-transparent border border-white/10 rounded-lg py-4 px-4 text-xs text-white outline-none focus:border-[#c5a059] transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" onclick="selectInviteRole(this, 1)"
                                class="role-btn py-3 border border-white/10 rounded-lg text-[9px] font-bold text-gray-500 hover:border-[#c5a059] transition-all">
                                BLACK DIAMOND
                            </button>
                            <button type="button" onclick="selectInviteRole(this, 3)"
                                class="role-btn py-3 border border-[#c5a059] bg-[#c5a059]/10 rounded-lg text-[9px] font-bold text-[#c5a059] transition-all">
                                PLATINUM
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-10 py-4 bg-[#c5a059] text-black font-bold text-[10px] tracking-[0.3em] rounded-lg shadow-[0_10px_20px_rgba(197,160,89,0.2)] hover:shadow-[0_15px_30px_rgba(197,160,89,0.4)] transition-all uppercase">
                        Xác nhận gửi thư mời
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div id="concierge-chat" class="fixed bottom-6 right-6 z-[6000] w-80 bg-[#0f0f0f] border border-white/10 rounded-2xl shadow-2xl hidden flex-col overflow-hidden opacity-0 translate-y-10">
        <div class="p-4 bg-white/5 border-b border-white/5 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                <span id="chat-target" class="text-[10px] font-bold tracking-widest text-white uppercase">Alexander Wong</span>
            </div>
            <button onclick="closePrivateChat()" class="text-gray-500 hover:text-white"><i class="ri-close-line"></i></button>
        </div>
        <div class="h-64 p-4 overflow-y-auto no-scrollbar flex flex-col gap-3" id="chat-content">
            <div class="bg-white/5 p-3 rounded-lg text-[11px] text-gray-400 self-start max-w-[80%] italic">
                Hệ thống Concierge đã sẵn sàng. Bạn muốn gửi tin nhắn bảo mật cho thượng khách?
            </div>
        </div>
        <div class="p-4 border-t border-white/5 flex gap-2">
            <input type="text" placeholder="Nhập tin nhắn..." class="flex-1 bg-black border border-white/5 rounded-lg px-3 py-2 text-[10px] text-white outline-none focus:border-[#c5a059]">
            <button class="text-[#c5a059]"><i class="ri-send-plane-2-line"></i></button>
        </div>
    </div>

    <script>
        function openInviteModal() {
            const modal = document.getElementById('invite-modal');
            const card = document.getElementById('invite-card');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Hiệu ứng GSAP: Modal hiện ra và thẻ thiệp mời bay nhẹ lên
            gsap.to(modal, {
                opacity: 1,
                duration: 0.4
            });
            gsap.fromTo(card, {
                opacity: 0,
                y: 50,
                scale: 0.9,
                rotationX: -15
            }, {
                opacity: 1,
                y: 0,
                scale: 1,
                rotationX: 0,
                duration: 0.8,
                ease: "expo.out"
            });
        }

        function closeInviteModal() {
            const modal = document.getElementById('invite-modal');
            const card = document.getElementById('invite-card');

            gsap.to(card, {
                opacity: 0,
                y: 30,
                scale: 0.95,
                duration: 0.4,
                ease: "power2.in"
            });

            gsap.to(modal, {
                opacity: 0,
                duration: 0.4,
                delay: 0.1,
                onComplete: () => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        }
        // 1. Chức năng Chat bảo mật
        function openPrivateChat(name) {
            const chatBox = document.getElementById('concierge-chat');
            document.getElementById('chat-target').innerText = name;

            chatBox.classList.remove('hidden');
            chatBox.classList.add('flex');

            gsap.to(chatBox, {
                opacity: 1,
                y: 0,
                duration: 0.5,
                ease: "back.out(1.7)"
            });
        }

        function closePrivateChat() {
            gsap.to("#concierge-chat", {
                opacity: 0,
                y: 20,
                duration: 0.3,
                onComplete: () => {
                    document.getElementById('concierge-chat').classList.add('hidden');
                }
            });
        }

        // 2. Chức năng Đình chỉ (Suspending)
        function suspendMember(name, btn) {
            // Hiệu ứng cảnh báo bằng Modal mặc định hoặc Custom
            const confirmSuspension = confirm(`Bạn có chắc chắn muốn đình chỉ tư cách hội viên của ${name}? Hành động này sẽ được ghi nhật ký hệ thống.`);

            if (confirmSuspension) {
                // Tìm dòng (Row) chứa nút bấm này
                const row = btn.closest('.ledger-row');

                // Hiệu ứng "Tắt đèn" dòng đó
                gsap.to(row, {
                    filter: "grayscale(100%) blur(1px)",
                    opacity: 0.5,
                    backgroundColor: "rgba(153, 27, 27, 0.05)", // Màu đỏ Burgundy rất mờ
                    duration: 1
                });

                // Thay đổi badge trạng thái trong dòng đó (nếu có)
                const statusBadge = row.querySelector('span.bg-emerald-500\\/10');
                if (statusBadge) {
                    statusBadge.className = "text-[9px] px-3 py-1 bg-red-500/10 text-red-500 rounded-full border border-red-500/20 font-bold uppercase";
                    statusBadge.innerText = "Bị đình chỉ";
                }

                alert(`Hồ sơ của ${name} đã được chuyển vào trạng thái tạm khóa.`);
            }
        }

        // 3. Chức năng Thiết lập đặc quyền
        // (Đã sử dụng hàm openUserProfile có sẵn trong code trước của bạn)
        // Hàm đóng/mở menu lọc
        // function toggleFilterMenu(menuId) {
        //     const allMenus = document.querySelectorAll('.filter-dropdown');
        //     const targetMenu = document.getElementById(menuId);

        //     // Đóng các menu khác
        //     allMenus.forEach(menu => {
        //         if (menu.id !== menuId && !menu.classList.contains('hidden')) {
        //             gsap.to(menu, {
        //                 opacity: 0,
        //                 y: 10,
        //                 duration: 0.3,
        //                 onComplete: () => menu.classList.add('hidden')
        //             });
        //         }
        //     });

        //     if (targetMenu.classList.contains('hidden')) {
        //         targetMenu.classList.remove('hidden');
        //         gsap.to(targetMenu, {
        //             opacity: 1,
        //             y: 0,
        //             duration: 0.4,
        //             ease: "back.out(1.7)"
        //         });
        //     } else {
        //         gsap.to(targetMenu, {
        //             opacity: 0,
        //             y: 10,
        //             duration: 0.3,
        //             onComplete: () => targetMenu.classList.add('hidden')
        //         });
        //     }
        // }
        function toggleFilterMenu(menuId) {
            const menu = document.getElementById(menuId);
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                gsap.to(menu, {
                    opacity: 1,
                    y: 0,
                    duration: 0.3
                });
            } else {
                gsap.to(menu, {
                    opacity: 0,
                    y: 10,
                    duration: 0.2,
                    onComplete: () => menu.classList.add('hidden')
                });
            }
        }

        // Hàm áp dụng bộ lọc (Logic lọc giả lập với hiệu ứng GSAP)
        function applyEliteFilter(type, value) {
            const rows = document.querySelectorAll('.ledger-row');

            // 1. Hiệu ứng tan biến danh sách cũ
            gsap.to(rows, {
                opacity: 0,
                x: -20,
                stagger: 0.05,
                duration: 0.4,
                onComplete: () => {
                    // 2. Logic lọc thực tế (Bạn có thể thay bằng AJAX gọi DB ở đây)
                    console.log(`Đang lọc ${type} theo giá trị: ${value}`);

                    // 3. Hiệu ứng trượt danh sách mới lên (Ở đây ta cho hiện lại toàn bộ để minh họa)
                    gsap.to(rows, {
                        opacity: 1,
                        x: 0,
                        stagger: 0.1,
                        duration: 0.8,
                        delay: 0.2,
                        ease: "expo.out"
                    });
                }
            });

            // Đóng menu sau khi chọn
            toggleFilterMenu(type === 'spending' ? 'spending-menu' : 'fengshui-menu');
        }

        // Đóng menu khi click ra ngoài
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.group-filter')) {
                const allMenus = document.querySelectorAll('.filter-dropdown');
                allMenus.forEach(menu => {
                    if (!menu.classList.contains('hidden')) {
                        gsap.to(menu, {
                            opacity: 0,
                            y: 10,
                            duration: 0.3,
                            onComplete: () => menu.classList.add('hidden')
                        });
                    }
                });
            }
        });

        function sendInvitation() {
            const btn = event.currentTarget;
            const originalText = btn.innerHTML;

            // Hiệu ứng gửi thư mượt mà
            btn.innerHTML = '<i class="ri-loader-4-line animate-spin text-lg"></i>';
            btn.disabled = true;

            setTimeout(() => {
                // Hiệu ứng lóe sáng khi gửi thành công
                gsap.to("#invite-card", {
                    boxShadow: "0 0 100px rgba(197, 160, 89, 0.8)",
                    duration: 0.2,
                    yoyo: true,
                    repeat: 1
                });

                setTimeout(() => {
                    alert("Thẻ mời đã được mã hóa và gửi tới thượng khách.");
                    closeInviteModal();
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 300);
            }, 1500);
        }
        // 3D Tilt Effect for Tier Cards
        document.querySelectorAll('.tier-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const xc = rect.width / 2;
                const yc = rect.height / 2;
                const dx = x - xc;
                const dy = y - yc;
                gsap.to(card, {
                    rotationY: dx / 10,
                    rotationX: -dy / 10,
                    duration: 0.5
                });
            });
            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    rotationY: 0,
                    rotationX: 0,
                    duration: 0.5
                });
            });
        });

        
        function openUserProfile(vipData) {
            const overlay = document.getElementById('user-panel-overlay');
            const panel = document.getElementById('edit-user-form'); // ID form mới

            // 1. Đổ dữ liệu vào các ô Input (để có thể sửa)
            document.getElementById('edit-user-id').value = vipData.user_id;
            document.getElementById('panel-name-input').value = vipData.fullname;
            document.getElementById('panel-email-input').value = vipData.email;
            document.getElementById('panel-role-select').value = vipData.role_id;
            document.getElementById('panel-status-select').value = vipData.status;

            // 2. Cập nhật ảnh đại diện (giữ nguyên logic của bạn hoặc dùng avatar từ DB)
            document.getElementById('panel-avatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(vipData.fullname)}&background=c5a059&color=fff`;

            // 3. Hiệu ứng hiển thị (GSAP)
            overlay.classList.remove('hidden');
            gsap.to(overlay, {
                opacity: 1,
                duration: 0.4
            });
            gsap.to(panel, {
                x: 0,
                duration: 0.7,
                ease: "expo.out"
            });
        }

        function closeUserProfile() {
            const overlay = document.getElementById('user-panel-overlay');
            const panel = document.getElementById('user-panel');

            gsap.to(panel, {
                x: '100%',
                duration: 0.5,
                ease: "power2.in"
            });
            gsap.to(overlay, {
                opacity: 0,
                duration: 0.4,
                onComplete: () => overlay.classList.add('hidden')
            });
        }


        
        // Security Blur Logic
        let idleTimer;

        function resetTimer() {
            document.getElementById('security-blur').style.display = 'none';
            clearTimeout(idleTimer);
            idleTimer = setTimeout(() => {
                document.getElementById('security-blur').style.display = 'block';
            }, 30000);
        }
        window.onmousemove = resetTimer;
        window.onkeypress = resetTimer;

        // Initial Animate Rows
        gsap.from(".ledger-row", {
            y: 20,
            stagger: 0.1,
            duration: 0.8,
            ease: "power3.out"
        });
        // Hàm thay đổi trạng thái (Kích hoạt/Đình chỉ)
        function toggleMemberStatus(userId, currentStatus) {
            const action = currentStatus == 1 ? 'đình chỉ' : 'kích hoạt';
            if (confirm(`Ngài có chắc muốn ${action} thượng khách này?`)) {
                window.location.href = `process_user.php?action=toggle_status&id=${userId}`;
            }
        }

        // Hàm xóa hội viên
        function confirmDeleteVip(userId) {
            if (confirm('CẢNH BÁO: Xóa thượng khách sẽ mất toàn bộ lịch sử giao dịch. Ngài vẫn muốn tiếp tục?')) {
                window.location.href = `process_user.php?action=delete&id=${userId}`;
            }
        }

        // Hiệu ứng hàng bảng khi load
        document.addEventListener('DOMContentLoaded', () => {
            gsap.from(".ledger-row", {
                opacity: 1,
                y: 20,
                stagger: 0.1,
                duration: 0.8,
                ease: "power2.out"
            });
        });
        // Hàm xử lý chọn Rank trong Modal
        function selectInviteRole(btn, roleId) {
            // Reset tất cả các nút về trạng thái chưa chọn
            document.querySelectorAll('.role-btn').forEach(el => {
                el.classList.remove('border-[#c5a059]', 'bg-[#c5a059]/10', 'text-[#c5a059]');
                el.classList.add('border-white/10', 'text-gray-500');
            });

            // Active nút được nhấn
            btn.classList.remove('border-white/10', 'text-gray-500');
            btn.classList.add('border-[#c5a059]', 'bg-[#c5a059]/10', 'text-[#c5a059]');

            // Cập nhật giá trị vào input ẩn
            document.getElementById('selected-role').value = roleId;
        }

        // Mở modal với hiệu ứng GSAP (nếu bạn dùng GSAP như trong Inventory.php)
        function openInviteModal() {
            const modal = document.getElementById('invite-modal');
            const card = document.getElementById('invite-card');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            gsap.to(card, {
                opacity: 1,
                scale: 1,
                duration: 0.5,
                ease: "back.out(1.7)"
            });
        }

        
    </script>
</body>

</html>