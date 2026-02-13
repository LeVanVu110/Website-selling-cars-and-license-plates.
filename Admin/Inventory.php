<!DOCTYPE html>
<html lang="vi">
<?php
require_once dirname(__DIR__) . '/check_admin.php';
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Place.php";
$plateModel = new Place();
$action = $_GET['action'] ?? $_POST['action'] ?? '';

// 1. XỬ LÝ XÓA
if ($action == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($plateModel->deletePlate($id)) {
        header("Location: Inventory.php?msg=success");
    } else {
        header("Location: Inventory.php?msg=error");
    }
    exit;
}
// 2. XỬ LÝ THÊM HOẶC SỬA
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $plate_number = $_POST['plate_number'];
    $province = $_POST['province'];
    $price = $_POST['starting_price'];
    $status = $_POST['status'];

    if (!empty($id)) {
        // Thực hiện CẬP NHẬT (Update)
        $result = $plateModel->updatePlate($id, $plate_number, $province, $price, $status);
    } else {
        // Thực hiện THÊM MỚI (Insert)
        $result = $plateModel->addPlate($plate_number, $province, $price, $status);
    }

    if ($result) {
        echo "<script>alert('Thao tác thành công!'); window.location.href='Inventory.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra, vui lòng kiểm tra lại!');</script>";
    }
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management | Inner Circle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --luxury-gold: #c5a059;
            --obsidian: #080808;
            --burgundy: #800020;
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

        /* Custom Scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Input Luxury Effect */
        .input-gold-line {
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: transparent;
            transition: all 0.4s;
        }

        .input-gold-line:focus {
            outline: none;
            border-bottom: 1px solid var(--luxury-gold);
            box-shadow: 0 4px 12px -6px rgba(197, 160, 89, 0.3);
        }

        /* Thẻ biển số 3D */
        .plate-card {
            background: linear-gradient(145deg, #0f0f0f, #050505);
            border: 1px solid rgba(255, 255, 255, 0.03);
            perspective: 1000px;
        }

        .plate-display {
            background: #fff;
            color: #000;
            font-weight: 800;
            letter-spacing: 2px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.2), 0 10px 20px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        /* Particle effect container */
        .particle {
            position: absolute;
            pointer-events: none;
            background: var(--luxury-gold);
            border-radius: 50%;
        }

        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0 !important;
            }
        }

        .filter-tab {
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .filter-tab.active {
            text-shadow: 0 0 10px rgba(197, 160, 89, 0.3);
        }
    </style>
</head>

<body>

    <?php include('Sidebar.php'); ?>

    <main class="main-content md:ml-[288px] min-h-screen transition-all duration-500 p-4 md:p-8 relative z-10">

        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10 mt-12 md:mt-0 p-6 rounded-2xl bg-white/5 backdrop-blur-md border border-white/5">
            <div>
                <h1 class="font-cinzel text-xl text-[#c5a059] tracking-[0.3em]">Kho Tài Sản</h1>
                <p class="text-[9px] text-gray-500 uppercase tracking-widest mt-1">Quản lý kho biển số triệu đô</p>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <div class="relative group">
                    <i class="ri-search-2-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                    <input type="text" placeholder="Tìm kiếm báu vật..."
                        class="bg-black/40 border border-white/10 rounded-full py-2 pl-10 pr-4 text-xs focus:border-[#c5a059]/50 outline-none w-64 transition-all">
                </div>

                <button onclick="openModal('add')" class="bg-[#c5a059] text-black px-6 py-2.5 rounded-full font-bold text-xs flex items-center gap-2 hover:shadow-[0_0_20px_rgba(197,160,89,0.4)] transition-all active:scale-95">
                    <i class="ri-add-circle-line text-lg"></i> THÊM BIỂN SỐ MỚI
                </button>
            </div>
        </header>

        <div class="flex items-center justify-between mb-8 px-2">
           
            <div class="flex gap-8 border-b border-white/5 relative mb-8">
                <button onclick="filterPlates('all', this)" class="filter-tab active font-cinzel text-[10px] pb-2 text-[#c5a059] tracking-widest relative">
                    TẤT CẢ
                    <div class="line-active absolute bottom-0 left-0 w-full h-[1px] bg-[#c5a059] shadow-[0_0_8px_#c5a059]"></div>
                </button>
                <button onclick="filterPlates('1', this)" class="filter-tab font-cinzel text-[10px] pb-2 text-gray-500 tracking-widest hover:text-white transition-colors">SẴN SÀNG</button>
                <button onclick="filterPlates('0', this)" class="filter-tab font-cinzel text-[10px] pb-2 text-gray-500 tracking-widest hover:text-white transition-colors">ĐÃ BÁN</button>
            </div>

            <div class="hidden md:flex items-center gap-3 bg-white/5 px-4 py-2 rounded-xl border border-white/5">
                <?php
                $adminPlates = $plateModel->getAllPlatesAdmin();
                $totalPlates = count($adminPlates);
                $capacity = 1000; // Sức chứa giả định của Ngài
                $fillRate = round(($totalPlates / $capacity) * 100);
                ?>
                <div class="text-right">
                    <p class="text-[8px] text-gray-500 uppercase">Độ lấp đầy kho</p>
                    <p class="text-[10px] font-bold text-white"><?= $fillRate ?>%</p>
                    <div class="w-20 h-[2px] bg-white/10 mt-1 ml-auto">
                        <div class="h-full bg-[#c5a059]" style="width: <?= $fillRate ?>%"></div>
                    </div>
                </div>
                <div class="w-8 h-8 rounded-full border-2 border-[#c5a059] border-t-transparent animate-spin-slow"></div>
            </div>
        </div>

      

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="inventory-grid">
            <?php
            $adminPlates = $plateModel->getAllPlatesAdmin();

            if (!empty($adminPlates)):
                foreach ($adminPlates as $item):
                    $badge = $plateModel->getPlateBadge($item['plate_number']);
                    $statusText = ($item['status'] == 1) ? 'SẴN SÀNG' : 'ĐÃ BÁN';
                    $statusClass = ($item['status'] == 1) ? 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20' : 'text-red-500 bg-red-500/10 border-red-500/20';
            ?>
                    <div class="plate-card group rounded-2xl p-4 relative overflow-hidden h-[380px] flex flex-col justify-between"
                        id="plate-<?= $item['plates_id'] ?>"
                        data-status="<?= $item['status'] ?>">
                        <div class="absolute inset-0 bg-black/80 opacity-0 group-hover:opacity-100 transition-all duration-500 z-20 flex items-center justify-center gap-6 backdrop-blur-sm">
                            <button onclick="openModal('edit', {
                                    id: '<?= $item['plates_id'] ?>', 
                                    plate: '<?= htmlspecialchars($item['plate_number']) ?>', 
                                    price: '<?= $item['starting_price'] ?>', 
                                    province: '<?= htmlspecialchars($item['province']) ?>', 
                                    status: '<?= $item['status'] ?>'
                                })"
                                class="action-icon translate-y-10 group-hover:translate-y-0 transition-transform duration-500 text-white hover:text-[#c5a059]">
                                <i class="ri-edit-box-line text-3xl"></i>
                            </button>
                            <button onclick="confirmDelete(<?= $item['plates_id'] ?>)"
                                class="action-icon translate-y-10 group-hover:translate-y-0 transition-transform duration-500 delay-75 text-white hover:text-[#800020]">
                                <i class="ri-delete-bin-7-line text-3xl"></i>
                            </button>
                        </div>

                        <div class="h-32 flex items-center justify-center">
                            <div class="plate-display w-full h-16 rounded shadow-lg flex items-center justify-center text-2xl font-black group-hover:scale-110 transition-transform duration-700 bg-white text-black relative">
                                <?= htmlspecialchars($item['plate_number']) ?>
                                <div class="absolute top-1 left-1/2 -translate-x-1/2 text-[6px] opacity-30 uppercase tracking-[3px]">Inner Circle Member</div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="font-playfair italic text-[#c5a059] text-lg mb-1"><?= $badge ?></p>

                            <div class="flex items-center gap-2 text-gray-500 uppercase tracking-widest text-[10px]">
                                <i class="ri-map-pin-2-line text-[#c5a059]"></i>
                                <span>Khu vực: <?= htmlspecialchars($item['province'] ?? 'Toàn quốc') ?></span>
                            </div>
                            <div class="mt-6 flex justify-between items-end">
                                <div>
                                    <p class="text-[8px] text-gray-600 uppercase">Giá trị định giá</p>
                                    <p class="text-xl font-bold text-white tracking-tighter"><?= number_format($item['starting_price'], 0, ',', '.') ?> VND</p>
                                </div>
                                <span class="text-[9px] px-2 py-1 rounded border font-bold <?= $statusClass ?>">
                                    <?= $statusText ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
            else:
                ?>
                <p class="text-gray-500 italic">Kho hiện đang trống.</p>
            <?php endif; ?>
        </div>
    </main>

   
    <div id="modal-overlay" class="fixed inset-0 bg-black/90 backdrop-blur-xl z-[2000] hidden items-center justify-center p-4">
        <div id="modal-content" class="bg-[#0f0f0f] border border-white/10 w-full max-w-2xl rounded-3xl overflow-hidden relative">
            <div class="p-8">
                <div class="flex justify-between items-center mb-10">
                    <h2 id="modal-title" class="font-cinzel text-[#c5a059] text-xl tracking-widest">Khai báo báu vật</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-white"><i class="ri-close-line text-2xl"></i></button>
                </div>

                <form id="form-plate" action="Inventory.php" method="POST" class="space-y-8">
                    <input type="hidden" name="id" id="input-id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] text-gray-500 uppercase tracking-widest">Số biển kiểm soát</label>
                            <input type="text" name="plate_number" id="input-plate" class="input-gold-line w-full py-2 text-lg font-bold text-white bg-transparent outline-none" placeholder="30A-888.88">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] text-gray-500 uppercase tracking-widest">Tỉnh thành</label>
                            <input type="text" name="province" id="input-province" class="input-gold-line w-full py-2 text-sm text-white bg-transparent outline-none" placeholder="Hà Nội">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] text-gray-500 uppercase tracking-widest">Giá trị niêm yết (VND)</label>
                            <input type="number" name="starting_price" id="input-price" class="input-gold-line w-full py-2 text-lg text-white bg-transparent outline-none" placeholder="50000000">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] text-gray-500 uppercase tracking-widest">Trạng thái</label>
                            <select name="status" id="input-status" class="input-gold-line w-full py-2 text-sm text-white bg-transparent outline-none appearance-none cursor-pointer">
                                <option value="1">Sẵn sàng</option>
                                <option value="0">Đã bán/Khóa</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6">
                        <button type="submit" class="bg-transparent text-[#c5a059] px-8 py-3 font-cinzel text-xs tracking-[0.2em] border border-[#c5a059]/30 rounded-full hover:bg-[#c5a059] hover:text-black transition-all uppercase">
                            Xác nhận lưu kho
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <button onclick="openModal()" class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-[#c5a059] text-black rounded-full shadow-2xl flex items-center justify-center z-[100] active:scale-90 transition-transform">
        <i class="ri-add-line text-2xl"></i>
    </button>

    <script>
        // Biến lưu trạng thái hiện tại
        let isEditMode = false;

        
        function openModal(mode, data = null) {
            const modal = document.getElementById('modal-overlay');
            const form = document.getElementById('form-plate');
            const title = document.getElementById('modal-title');

            if (mode === 'edit' && data) {
                // --- CHẾ ĐỘ SỬA ---
                title.innerText = "Cập nhật báu vật";
                document.getElementById('input-id').value = data.id;
                document.getElementById('input-plate').value = data.plate;
                document.getElementById('input-price').value = data.price;
                document.getElementById('input-province').value = data.province;
                document.getElementById('input-status').value = data.status;
            } else {
                // --- CHẾ ĐỘ THÊM ---
                title.innerText = "Khai báo báu vật";
                form.reset(); // Xóa sạch dữ liệu cũ trong form
                document.getElementById('input-id').value = ''; // Đảm bảo ID trống để PHP biết là thêm mới
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('modal-overlay');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }




        // Hàm mở Modal để CHỈNH SỬA
        function openEditModal(plate, type, meaning) {
            // 1. Đổ dữ liệu hiện tại vào các ô input
            document.querySelector('input[placeholder="30A-888.88"]').value = plate;
            document.querySelector('select').value = type;
            document.querySelector('input[placeholder="Đại cát đại lợi..."]').value = meaning;

            // 2. Đổi tên tiêu đề cho phù hợp ngữ cảnh Edit
            document.getElementById('modal-title').innerText = "Cập nhật báu vật";
            document.getElementById('submit-btn').innerText = "CẬP NHẬT THAY ĐỔI";

            showModal();
        }
        // Hàm hiển thị Modal (GSAP)
        function showModal() {
            const modal = document.getElementById('modal-overlay');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            gsap.from("#modal-content", {
                scale: 0.9,
                opacity: 0,
                duration: 0.5,
                ease: "back.out(1.2)"
            });
        }

        // Hàm xóa trắng form
        function resetForm() {
            const inputs = document.querySelectorAll('.input-gold-line');
            inputs.forEach(input => input.value = "");
        }

        // Particle Dissolve Effect (Hạt bụi tan biến)
        function confirmDelete(id) {
            if (!confirm("Bạn có chắc chắn muốn xóa tài sản này khỏi kho?")) return;

            const element = document.getElementById(id);
            const rect = element.getBoundingClientRect();

            // Tạo các hạt bụi
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                const size = Math.random() * 4 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';

                document.body.appendChild(particle);

                const destX = rect.left + rect.width / 2 + (Math.random() - 0.5) * 400;
                const destY = rect.top + rect.height / 2 + (Math.random() - 0.5) * 400;

                gsap.fromTo(particle, {
                    x: rect.left + rect.width / 2,
                    y: rect.top + rect.height / 2,
                    opacity: 1
                }, {
                    x: destX,
                    y: destY,
                    opacity: 0,
                    duration: 1.5,
                    delay: Math.random() * 0.2,
                    onComplete: () => particle.remove()
                });
            }

            // Làm biến mất thẻ chính
            gsap.to(element, {
                scale: 0.5,
                opacity: 0,
                duration: 0.8,
                ease: "power2.in",
                onComplete: () => element.remove()
            });
        }

        // Khởi tạo animation các thẻ khi load
        document.addEventListener('DOMContentLoaded', () => {
            gsap.from(".plate-card", {
                y: 50,
                opacity: 0,
                stagger: 0.1,
                duration: 1,
                ease: "power4.out"
            });
        });
        //
        // Hàm xóa biển số
        function confirmDelete(id) {
            if (confirm('Ngài có chắc chắn muốn xóa "siêu phẩm" này khỏi kho không?')) {
                // Gửi yêu cầu xóa đến file xử lý
                window.location.href = `process_plate.php?action=delete&id=${id}`;
            }
        }


        function filterPlates(status, btn) {
            // 1. Cập nhật giao diện Tabs
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.classList.remove('active', 'text-[#c5a059]');
                tab.classList.add('text-gray-500');
                // Xóa vạch vàng cũ
                const line = tab.querySelector('.line-active');
                if (line) line.remove();
            });

            btn.classList.add('active', 'text-[#c5a059]');
            btn.classList.remove('text-gray-500');
            btn.innerHTML += '<div class="line-active absolute bottom-0 left-0 w-full h-[1px] bg-[#c5a059] shadow-[0_0_8px_#c5a059]"></div>';

            // 2. Logic lọc các thẻ Card
            const cards = document.querySelectorAll('.plate-card');

            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');

                if (status === 'all' || cardStatus === status) {
                    // Hiển thị lại
                    card.style.display = 'flex';
                    gsap.to(card, {
                        opacity: 1,
                        scale: 1,
                        duration: 0.4,
                        ease: "power2.out"
                    });
                } else {
                    // Ẩn đi
                    gsap.to(card, {
                        opacity: 0,
                        scale: 0.8,
                        duration: 0.3,
                        onComplete: () => {
                            card.style.display = 'none';
                        }
                    });
                }
            });
        }
    </script>
</body>

</html>