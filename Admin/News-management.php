<!DOCTYPE html>
<html lang="vi">
<?php
require_once dirname(__DIR__) . '/check_admin.php';
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . '/models/db.php';
require_once dirname(__DIR__) . '/models/News.php';

$newsModel = new NewsModel();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3; // Mỗi trang 10 bài
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? null;

// Lấy dữ liệu
$listNews = $newsModel->getAllNewsForAdmin($search, $status, $page, $limit);
$totalNews = $newsModel->countAllNewsForAdmin($search, $status);
$totalPages = ceil($totalNews / $limit);
$totalNewsCount = $newsModel->countTotalNews();
// $listNews = $newsModel->getAllNewsForAdmin($search, $status);

// Tính toán hiển thị "Hiển thị 1-10 trên 45"
$start = ($page - 1) * $limit + 1;
$end = min($page * $limit, $totalNews);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editorial Manager | Inner Circle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <style>
        :root {
            --luxury-gold: #c5a059;
            --obsidian: #080808;
        }

        body {
            background: var(--obsidian);
            color: #e5e5e5;
            font-family: 'Montserrat', sans-serif;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        .font-cinzel {
            font-family: 'Cinzel Decorative', cursive;
        }

        /* Editorial Card Hover */
        .news-row {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .news-row:hover {
            background: rgba(255, 255, 255, 0.02);
            transform: translateX(10px);
            border-bottom-color: var(--luxury-gold);
        }

        /* Quill Pen Animation */
        @keyframes write {

            0%,
            100% {
                transform: rotate(0deg) translateY(0);
            }

            50% {
                transform: rotate(-15deg) translateY(-5px);
            }
        }

        .group:hover .ri-quill-pen-line {
            animation: write 1s ease-in-out infinite;
        }

        /* Shredder Effect */
        .shredder-anim {
            transform: translateY(100px) scaleY(0);
            opacity: 0;
            transition: all 0.7s ease-in;
        }


        /* Glassmorphism Sidebar */
        .editor-sidebar {
            background: rgba(8, 8, 8, 0.8);
            backdrop-filter: blur(20px);
            border-left: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Ẩn thanh cuộn nhưng vẫn cho phép cuộn bằng chuột/vê tay */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
            scroll-behavior: smooth;
        }

        #master-editor {
            height: 100vh;
            /* Bắt buộc phải có chiều cao cố định */
            overflow: hidden;
        }

        /* Custom scrollbar cho Master Editor */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c5a059;
            border-radius: 10px;
        }

        .luxury-toast {
            background: rgba(20, 20, 20, 0.9);
            backdrop-filter: blur(10px);
            border-left: 3px solid #c5a059;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            transform: translateX(150%);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            min-width: 280px;
            border-left: 4px solid #c5a059 !important;
            will-change: transform, opacity;
        }

        .luxury-toast.show {
            transform: translateX(0);
        }

        @media (max-width: 768px) {
            .mobite-w {
                /* width: 45% !important; */
            }
        }
    </style>
</head>

<body>

    <?php include('Sidebar.php'); ?>

    <main class="main-content md:ml-[288px] min-h-screen p-4 md:p-10 transition-all duration-500">
        <div id="toast-container" class="fixed top-8 right-8 z-[9999] flex flex-col gap-4"></div>

        <div id="delete-modal" class="fixed inset-0 z-[9000] flex items-center justify-center hidden">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeDeleteModal()"></div>

            <div id="modal-content" class="relative bg-zinc-900 border border-white/10 p-8 rounded-3xl max-w-sm w-full mx-4 shadow-2xl transform scale-90 opacity-0">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mb-6">
                        <i class="ri-delete-bin-7-line text-red-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-cinzel text-white mb-2">Tiêu hủy kiệt tác?</h3>
                    <p class="text-gray-500 text-[11px] leading-relaxed mb-8 italic uppercase tracking-wider">Hành động này không thể hoàn tác. Ngài chắc chắn muốn loại bỏ nội dung này?</p>

                    <div class="flex gap-4 w-full">
                        <button id="confirm-btn" class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold uppercase tracking-[0.2em] rounded-xl transition-all active:scale-95">
                            Xác nhận
                        </button>
                        <button onclick="closeDeleteModal()" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em] rounded-xl transition-all">
                            Hủy bỏ
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 mb-12 mt-10 md:mt-0">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full lg:w-auto">
                <div class="bg-white/5 border border-white/5 p-5 rounded-2xl min-w-[200px]">
                    <p class="text-[9px] text-gray-500 uppercase tracking-widest mb-1">Tổng bài viết</p>
                    <h3 class="text-2xl font-cinzel text-white">
                        <?= number_format($totalNewsCount) ?>
                    </h3>
                </div>
                <div class="bg-white/5 border border-white/5 p-5 rounded-2xl min-w-[200px]">
                    <p class="text-[9px] text-[#c5a059] uppercase tracking-widest mb-1">Lượt đọc VIP</p>
                    <h3 class="text-2xl font-cinzel text-[#c5a059]">12.4K</h3>
                </div>
                <div class="bg-white/5 border border-white/5 p-5 rounded-2xl min-w-[200px]">
                    <p class="text-[9px] text-emerald-500 uppercase tracking-widest mb-1">Trending</p>
                    <h3 class="text-2xl font-cinzel text-white">#Lifestyle</h3>
                </div>
            </div>

            <button onclick="openCreateEditor()" class="group bg-[#c5a059] text-black px-8 py-4 rounded-full font-bold text-xs flex items-center gap-3 shadow-[0_10px_30px_rgba(197,160,89,0.2)] hover:shadow-[0_15px_40px_rgba(197,160,89,0.4)] transition-all active:scale-95">
                <i class="ri-quill-pen-line text-lg"></i> SOẠN BÀI MỚI
            </button>
        </header>

        <section class="bg-white/[0.02] border border-white/5 rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-white/5 flex justify-between items-center relative z-50">
                <h2 class="font-cinzel text-xs tracking-[0.4em] text-gray-400">Feed Bản Tin Thượng Lưu</h2>

                <div class="flex items-center gap-6">
                    <div id="search-container" class="flex items-center bg-white/10 rounded-full px-0 w-0 overflow-hidden transition-all duration-500 border border-white/5 h-10">
                        <input type="text" id="search-input" placeholder="TÌM KIẾM KIỆT TÁC..."
                            class="bg-transparent border-none outline-none text-[11px] text-white px-5 w-72 tracking-[0.1em] placeholder:text-gray-500 font-medium">
                    </div>

                    <div class="flex gap-4 items-center relative">
                        <button onclick="toggleSearch()" class="text-gray-500 hover:text-[#c5a059] transition-colors">
                            <i class="ri-search-line text-lg"></i>
                        </button>

                        <div class="relative"> <button onclick="toggleFilter()" class="text-gray-500 hover:text-[#c5a059] transition-colors relative z-50">
                                <i class="ri-filter-3-line text-lg"></i>
                            </button>

                            <div id="filter-dropdown" class="absolute right-0 mt-4 w-48 bg-[#0f0f0f] border border-white/10 rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] z-[100] py-2 hidden opacity-0 translate-y-2">
                                <div class="px-4 py-2 text-[9px] text-gray-600 font-bold tracking-widest border-b border-white/5 mb-1">TRẠNG THÁI</div>
                                <a href="News-management.php" class="block px-4 py-2 text-[10px] text-gray-400 hover:bg-[#c5a059] hover:text-black">Tất cả bài viết</a>
                                <a href="News-management.php?status=1" class="block px-4 py-2 text-[10px] text-gray-400 hover:bg-[#c5a059] hover:text-black">Đã xuất bản</a>
                                <a href="News-management.php?status=0" class="block px-4 py-2 text-[10px] text-gray-400 hover:bg-[#c5a059] hover:text-black">Bản nháp</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="divide-y divide-white/5 relative z-10">
                <?php if (!empty($listNews)): ?>
                    <?php foreach ($listNews as $news): ?>
                        <div class="news-row p-6 flex items-center justify-between group" id="post-<?= $news['news_id'] ?>">
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-20 rounded-xl overflow-hidden bg-zinc-900 border border-white/5">
                                    <img src="<?= $news['thumbnail'] ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="thumbnail">
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <?php if ($news['status'] == 1): ?>
                                            <span class="text-[8px] bg-[#c5a059]/10 text-[#c5a059] px-2 py-0.5 rounded border border-[#c5a059]/20 font-bold uppercase">Xuất bản</span>
                                        <?php else: ?>
                                            <span class="text-[8px] bg-zinc-500/20 text-zinc-500 px-2 py-0.5 rounded border border-white/5 font-bold uppercase">Bản nháp</span>
                                        <?php endif; ?>

                                        <span class="text-[10px] text-gray-600"><i class="ri-time-line"></i> <?= date('d/m/Y', strtotime($news['publish_date'])) ?></span>
                                        <?php if ($news['is_featured']): ?>
                                            <i class="ri-vip-crown-2-line text-[#c5a059] text-xs shadow-glow"></i>
                                        <?php endif; ?>
                                    </div>
                                    <h3 class="font-playfair text-lg text-white group-hover:text-[#c5a059] transition-colors"><?= htmlspecialchars($news['title']) ?></h3>
                                    <p class="text-[11px] text-gray-500 mt-1 max-w-md line-clamp-1 italic"><?= htmlspecialchars($news['summary']) ?></p>
                                </div>
                            </div>

                            <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-10 group-hover:translate-x-0">
                                <!-- <a href="../Detail_News.php?id=<?= $news['news_id'] ?>" target="_blank" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5 transition-all">
                                    <i class="ri-eye-line text-gray-400 hover:text-[#c5a059]"></i>
                                </a> -->
                                <button onclick="openPreview('post-<?= $news['news_id'] ?>')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5 transition-all active:scale-90">
                                    <i class="ri-eye-line text-gray-400 hover:text-[#c5a059]"></i>
                                </button>
                                <button onclick="openEditor(<?= $news['news_id'] ?>)" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5">
                                    <i class="ri-edit-line text-gray-400"></i>
                                </button>
                                <button id="post-<?= $news['news_id'] ?>" onclick="deletePost(<?= $news['news_id'] ?>)" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-red-900/20 group/del">
                                    <i class="ri-delete-bin-line text-gray-400 group-hover/del:text-red-500"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="p-10 text-center text-gray-600 italic">Không tìm thấy bản tin nào trong kho lưu trữ.</p>
                <?php endif; ?>
            </div>
            <div class="p-6 border-t border-white/5 flex items-center justify-between">
                <p class="text-[10px] text-gray-500 uppercase tracking-widest">
                    Hiển thị <span class="text-white font-bold"><?= $start ?>-<?= $end ?></span> trên <span class="text-white"><?= $totalNews ?></span> bản tin
                </p>

                <div class="flex items-center gap-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&status=<?= $status ?>"
                            class="w-8 h-8 rounded border border-white/5 flex items-center justify-center text-gray-500 hover:border-[#c5a059] hover:text-[#c5a059] transition-all">
                            <i class="ri-arrow-left-s-line"></i>
                        </a>
                    <?php endif; ?>

                    <div class="flex items-center gap-1">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($i == $page): ?>
                                <span class="w-8 h-8 rounded bg-[#c5a059] text-black text-[10px] font-bold flex items-center justify-center shadow-[0_0_15px_rgba(197,160,89,0.2)]">
                                    <?= $i ?>
                                </span>
                            <?php else: ?>
                                <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&status=<?= $status ?>"
                                    class="w-8 h-8 rounded border border-white/5 text-gray-500 text-[10px] flex items-center justify-center hover:bg-white/5 transition-all">
                                    <?= $i ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&status=<?= $status ?>"
                            class="w-8 h-8 rounded border border-white/5 flex items-center justify-center text-gray-500 hover:border-[#c5a059] hover:text-[#c5a059] transition-all">
                            <i class="ri-arrow-right-s-line"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    <div id="master-editor" class="fixed inset-0 z-[3000] bg-[#000] hidden flex-col">
        <nav class="h-20 border-b border-white/5 px-8 flex items-center justify-between bg-black/50 backdrop-blur-md shrink-0">
            <div class="flex items-center gap-6">
                <button onclick="closeEditor()" class="text-gray-500 hover:text-white flex items-center gap-2 text-xs tracking-widest transition-colors">
                    <i class="ri-arrow-left-s-line text-xl"></i> THOÁT
                </button>
                <div class="h-4 w-[1px] bg-white/10"></div>
                <p class="text-[10px] text-gray-600 italic uppercase tracking-wider">
                    <i class="ri-save-3-line animate-pulse"></i> Chế độ hiệu chỉnh kiệt tác...
                </p>
            </div>
            <div class="flex items-center gap-4">
                <button onclick="publishPost()" class="text-[10px] font-bold tracking-widest px-8 py-2 bg-[#c5a059] text-black rounded-full hover:shadow-[0_0_20px_#c5a059] transition-all uppercase">
                    Cập nhật kiệt tác
                </button>
            </div>
        </nav>

        <div class="flex flex-1 overflow-hidden min-h-0">

            <div class="flex-1 overflow-y-auto scroll-smooth p-12 lg:p-24 max-w-5xl mx-auto w-full custom-scrollbar">
                <input type="text" id="editor-title" placeholder="Tiêu đề kiệt tác..."
                    class="w-full bg-transparent border-none outline-none font-cinzel text-4xl lg:text-6xl text-white placeholder:text-zinc-900 mb-12">

                <input type="file" id="editor-file-input" class="hidden" accept="image/*" onchange="previewEditImage(this)">
                <div onclick="document.getElementById('editor-file-input').click()"
                    class="w-full aspect-video rounded-3xl border-2 border-dashed border-white/10 flex flex-col items-center justify-center group/upload hover:border-[#c5a059]/30 transition-all mb-12 cursor-pointer relative overflow-hidden bg-zinc-900/20">
                    <img id="editor-image-preview" class="absolute inset-0 w-full h-full object-cover z-10" src="">
                    <div class="z-20 flex flex-col items-center group-hover/upload:scale-110 transition-transform">
                        <i class="ri-image-add-line text-4xl text-white/50"></i>
                        <p class="text-[10px] text-white/30 uppercase tracking-[0.3em] mt-4 font-bold">Thay đổi hình ảnh Obsidian</p>
                    </div>
                </div>

                <textarea id="editor-content"
                    oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'
                    placeholder="Bắt đầu câu chuyện thượng lưu..."
                    class="w-full bg-transparent border-none outline-none font-playfair italic text-xl text-zinc-400 placeholder:text-zinc-900 min-h-[500px] leading-relaxed resize-none overflow-hidden"></textarea>

                <div class="h-48"></div>
            </div>

            <aside class="w-80 editor-sidebar p-8 hidden xl:flex flex-col gap-8 bg-white/[0.01] border-l border-white/5 shrink-0 h-full overflow-y-auto">
                <div>
                    <h4 class="text-[10px] font-bold text-[#c5a059] uppercase tracking-widest mb-6 border-b border-[#c5a059]/20 pb-2">Phân loại</h4>
                    <select id="editor-category" class="w-full bg-black border border-white/10 rounded-lg p-3 text-xs text-white outline-none focus:border-[#c5a059] cursor-pointer">
                        <option value="xe-sang">Siêu Xe & Biển Số</option>
                        <option value="phong-thuy">Phong Thủy Tài Lộc</option>
                        <option value="thi-truong">Thị Trường Đấu Giá</option>
                    </select>
                </div>

                <div class="p-6 bg-[#c5a059]/5 border border-[#c5a059]/20 rounded-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-white">VIP Access</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="editor-vip" class="sr-only peer">
                            <div class="w-9 h-5 bg-zinc-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-zinc-500 after:border-zinc-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:bg-[#c5a059] peer-checked:bg-[#c5a059]/20"></div>
                        </label>
                    </div>
                    <p class="text-[9px] text-gray-500 leading-relaxed italic">Khi bật, chỉ hội viên Kim Cương mới có quyền thưởng lãm nội dung này.</p>
                </div>
            </aside>
        </div>
    </div>
    <div id="create-masterpiece-overlay" class="fixed inset-0 z-[4000] bg-[#000] hidden flex-col opacity-0">
        <nav class="h-20 border-b border-white/5 px-8 flex items-center justify-between bg-black/50 backdrop-blur-md">
            <div class="flex items-center gap-6">
                <button onclick="closeCreateEditor()" class="text-gray-500 hover:text-white flex items-center gap-2 text-xs tracking-[0.3em] font-bold">
                    <i class="ri-close-line text-xl"></i> HỦY BỎ
                </button>
                <div class="h-4 w-[1px] bg-white/10"></div>
                <p class="text-[9px] text-[#c5a059] uppercase tracking-[0.2em] font-bold italic">Chế độ: Bản thảo mới</p>
            </div>

            <div class="flex items-center gap-4">
                <button onclick="publishNewPost()" class="text-[10px] font-bold tracking-[0.2em] px-10 py-3 bg-[#c5a059] text-black rounded-full hover:shadow-[0_0_30px_rgba(197,160,89,0.5)] transition-all uppercase">
                    Khai bút & Phát hành
                </button>
            </div>
        </nav>

        <div class="flex flex-1 overflow-hidden">
            <div class="flex-1 overflow-y-auto no-scrollbar p-12 lg:p-24 max-w-5xl mx-auto w-full">
                <input type="text" id="new-post-title" placeholder="Tiêu Đề Bản Tin VIP..."
                    class="w-full bg-transparent border-none outline-none font-cinzel text-5xl text-white placeholder:text-zinc-900 mb-12 py-4 border-b border-white/5 focus:border-[#c5a059]/30 transition-all">

                <input type="file" id="new-post-thumbnail-input" class="hidden" accept="image/*" onchange="previewImage(this)">

                <div id="upload-container" onclick="document.getElementById('new-post-thumbnail-input').click()"
                    class="w-full aspect-video rounded-3xl border-2 border-dashed border-white/5 flex flex-col items-center justify-center group/new-upload hover:border-[#c5a059]/50 transition-all mb-12 cursor-pointer relative bg-zinc-900/20 overflow-hidden">

                    <div id="upload-placeholder" class="flex flex-col items-center justify-center">
                        <i class="ri-image-add-line text-5xl text-zinc-800 group-hover/new-upload:text-[#c5a059] transition-colors"></i>
                        <p class="text-[10px] text-zinc-600 uppercase tracking-[0.3em] mt-6">Thêm hình ảnh đại diện kiệt tác</p>
                    </div>

                    <img id="image-preview" class="absolute inset-0 w-full h-full object-cover hidden" alt="Preview">

                    <div id="upload-overlay" class="absolute inset-0 bg-black/60 opacity-0 group-hover/new-upload:opacity-100 transition-opacity flex items-center justify-center hidden">
                        <p class="text-[10px] text-white uppercase tracking-[0.2em] font-bold">Thay đổi kiệt tác khác</p>
                    </div>
                </div>

                    
                <textarea id="new-post-content" placeholder="Bắt đầu viết những dòng cảm hứng thượng lưu..."
                    class="w-full bg-transparent border-none outline-none font-playfair italic text-2xl text-zinc-400 placeholder:text-zinc-900 min-h-[500px] leading-relaxed resize-none"></textarea>
            </div>

            <aside class="w-80 bg-white/[0.01] border-l border-white/5 p-8 hidden xl:block">
                <h4 class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.3em] mb-8">Thiết lập bài viết</h4>

                <div class="space-y-8">
                    <div>
                        <label class="text-[9px] text-gray-600 uppercase mb-3 block">Chuyên mục</label>
                        <select id="new-post-category" class="w-full bg-black border border-white/10 rounded-lg p-3 text-[11px] text-white outline-none focus:border-[#c5a059]">
                            <?php
                            // Danh sách ánh xạ từ Database Slug sang Tên hiển thị Thượng lưu
                            $categories = [
                                'xe-sang'    => 'Siêu Xe & Kiệt Tác',
                                'phong-thuy' => 'Phong Thủy Tài Lộc',
                                'thi-truong' => 'Thị Trường Đấu Giá'
                            ];

                            foreach ($categories as $slug => $display_name): ?>
                                <option value="<?= $slug ?>"><?= $display_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="pt-6 border-t border-white/5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-bold text-[#c5a059]">VIP ONLY</span>
                            <i class="ri-vip-crown-fill text-[#c5a059]"></i>
                        </div>
                        <p class="text-[9px] text-gray-600 italic">Nội dung này sẽ được bảo mật, chỉ dành cho hội viên hạng Diamond.</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <div id="preview-room" class="fixed inset-0 z-[5000] bg-[#080808] hidden overflow-y-auto no-scrollbar">
        <button onclick="closePreview()" class="fixed top-8 right-8 z-[5001] w-12 h-12 rounded-full bg-white/5 flex items-center justify-center hover:rotate-90 transition-all duration-500">
            <i class="ri-close-line text-2xl text-white"></i>
        </button>

        <div class="max-w-3xl mx-auto py-24 px-6">
            <div class="text-center mb-16">
                <span id="preview-category" class="text-[10px] text-[#c5a059] tracking-[0.5em] uppercase font-bold">LIFESTYLE</span>
                <h1 id="preview-title" class="font-cinzel text-3xl md:text-5xl text-white mt-6 mb-8 leading-tight"></h1>
                <div class="flex justify-center items-center gap-4 text-gray-500 text-[10px] tracking-widest uppercase">
                    <span>By Editorial Team</span>
                    <span class="w-1 h-1 rounded-full bg-gray-800"></span>
                    <span id="preview-time">5 MINS READ</span>
                </div>
            </div>

            <div class="w-full aspect-video rounded-2xl overflow-hidden mb-16 shadow-2xl">
                <img id="preview-img" src="" class="w-full h-full object-cover" alt="Cover">
            </div>

            <div id="preview-body" class="font-playfair text-xl text-gray-300 leading-relaxed italic space-y-8">
                <p>Nội dung đang được tải từ kho lưu trữ của Inner Circle...</p>
            </div>

            <div class="mt-20 pt-10 border-t border-white/5 text-center">
                <i class="ri-vip-crown-2-line text-[#c5a059] text-2xl"></i>
                <p class="text-[10px] text-gray-600 tracking-[0.3em] uppercase mt-4">Nội dung đặc quyền của Hội Viên</p>
            </div>
        </div>
    </div>

    <script>
        // Open Editor Logic
        // function openEditor(title = "") {
        //     const editor = document.getElementById('master-editor');
        //     if (title) document.getElementById('editor-title').value = title;

        //     editor.classList.remove('hidden');
        //     editor.classList.add('flex');

        //     gsap.fromTo(editor, {
        //         opacity: 0,
        //         scale: 1.1
        //     }, {
        //         opacity: 1,
        //         scale: 1,
        //         duration: 0.8,
        //         ease: "expo.out"
        //     });
        // }
        let currentEditingId = null;

        function openEditor(id) {
            // 1. Gọi API lấy chi tiết bài viết (hoặc lấy từ mảng JS có sẵn)
            fetch(`api_get_news_detail.php?id=${id}`)
                .then(res => res.json())
                .then(news => {
                    currentEditingId = id;

                    // 2. Đổ dữ liệu vào Master Editor
                    document.getElementById('editor-title').value = news.title;
                    document.getElementById('editor-content').value = news.content;
                    document.getElementById('editor-category').value = news.category;

                    // Hiển thị ảnh cũ vào preview
                    const preview = document.getElementById('editor-image-preview'); // Ngài thêm ID này vào thẻ img preview
                    preview.src = news.thumbnail;
                    preview.classList.remove('hidden');

                    // 3. Hiển thị Overlay Editor
                    const editor = document.getElementById('master-editor');
                    editor.classList.remove('hidden');

                    // Đảm bảo body không cuộn để tránh cuộn kép, nhưng editor phải cuộn được
                    document.body.style.overflow = 'hidden';
                    editor.classList.remove('hidden');
                    editor.classList.add('flex');

                    // Hiệu ứng GSAP mở tràn màn hình
                    gsap.fromTo(editor, {
                        opacity: 0,
                        y: 100
                    }, {
                        opacity: 1,
                        y: 0,
                        duration: 0.7,
                        ease: "expo.out"
                    });

                });
        }

        function publishPost() {
            const formData = new FormData();
            formData.append('news_id', currentEditingId);
            formData.append('title', document.getElementById('editor-title').value);
            formData.append('content', document.getElementById('editor-content').value);
            formData.append('category', document.getElementById('editor-category').value);

            const fileInput = document.getElementById('editor-file-input');
            if (fileInput.files[0]) {
                formData.append('thumbnail', fileInput.files[0]);
            }

            fetch('api_edit_news.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Bản tin đã được cập nhật.");
                        location.reload();
                    }
                });
        }

        function closeEditor() {
            gsap.to("#master-editor", {
                opacity: 0,
                y: 50,
                duration: 0.5,
                ease: "power2.in",
                onComplete: () => {
                    document.getElementById('master-editor').classList.add('hidden');
                    document.getElementById('master-editor').classList.remove('flex');
                }
            });
        }

        // Shredder Delete Effect
        // function deletePost(id) {
        //     if (!confirm("Bạn muốn tiêu hủy kiệt tác này?")) return;

        //     const post = document.getElementById(id);
        //     gsap.to(post, {
        //         height: 0,
        //         opacity: 0,
        //         x: -50,
        //         duration: 0.7,
        //         ease: "power3.inOut",
        //         onComplete: () => post.remove()
        //     });
        // }
        // Shredder Delete Effect & Logic
        // Hàm tạo thông báo nhanh (Toast)
        let currentDeleteId = null;

        // 1. Hàm hiện Toast (Góc phải trên)
        function showToast(message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `luxury-toast flex items-center gap-4 bg-zinc-900/90 backdrop-blur-md border border-[#c5a059]/30 p-4 rounded-xl shadow-2xl`;

            toast.innerHTML = `
        <i class="ri-checkbox-circle-fill text-[#c5a059] text-xl"></i>
        <div>
            <p class="text-[9px] uppercase tracking-widest font-bold text-white">Hệ thống</p>
            <p class="text-[11px] text-gray-400 mt-0.5">${message}</p>
        </div>
    `;

            container.appendChild(toast);

            // GSAP cho Toast trượt từ phải vào
            gsap.fromTo(toast, {
                x: 100,
                opacity: 0
            }, {
                x: 0,
                opacity: 1,
                duration: 0.5,
                ease: "back.out(1.7)"
            });

            // Tự biến mất
            setTimeout(() => {
                gsap.to(toast, {
                    x: 100,
                    opacity: 0,
                    duration: 0.5,
                    onComplete: () => toast.remove()
                });
            }, 3000);
        }

        // 2. Hàm mở Modal xác nhận (Giữa màn hình)
        function deletePost(id) {
            currentDeleteId = id;
            const modal = document.getElementById('delete-modal');
            const content = document.getElementById('modal-content');

            modal.classList.remove('hidden');
            gsap.to(content, {
                scale: 1,
                opacity: 1,
                duration: 0.4,
                ease: "back.out(1.7)"
            });
        }

        // 3. Hàm đóng Modal
        function closeDeleteModal() {
            const content = document.getElementById('modal-content');
            gsap.to(content, {
                scale: 0.9,
                opacity: 0,
                duration: 0.3,
                onComplete: () => {
                    document.getElementById('delete-modal').classList.add('hidden');
                }
            });
        }

        // 4. Sự kiện bấm nút "Xác nhận" trong Modal
        document.getElementById('confirm-btn').addEventListener('click', function() {
            if (!currentDeleteId) return;

            const id = currentDeleteId;
            closeDeleteModal();

            // Gọi API xóa
            fetch(`api_delete_news.php?id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // 1. Hiện thông báo góc phải
                        showToast("Kiệt tác đã được tiêu hủy khỏi kho lưu trữ.");

                        // 2. Hiệu ứng xóa hàng bài viết
                        const row = document.getElementById('post-' + id);
                        gsap.to(row, {
                            x: -50,
                            opacity: 0,
                            height: 0,
                            margin: 0,
                            padding: 0,
                            duration: 0.6,
                            ease: "power2.inOut",
                            onComplete: () => {
                                row.remove();
                                if (typeof updatePostCount === 'function') updatePostCount();
                            }
                        });
                    }
                })
                .catch(err => console.error("Lỗi xóa:", err));
        });
        // function deletePost(id) {
        //     if (!confirm("Ngài có chắc chắn muốn tiêu hủy kiệt tác này khỏi kho lưu trữ?")) return;

        //     // 1. Gọi API xóa dữ liệu trong Database
        //     fetch(`api_delete_news.php?id=${id}`, {
        //             method: 'GET'
        //         })
        //         .then(res => res.json())
        //         .then(data => {
        //             if (data.success) {
        //                 // 2. Nếu xóa DB thành công, chạy hiệu ứng Shredder trên giao diện
        //                 const postElement = document.getElementById('post-' + id);

        //                 const tl = gsap.timeline({
        //                     onComplete: () => {
        //                         postElement.remove();
        //                         // Cập nhật lại con số tổng bài viết trên Dashboard (nếu cần)
        //                         updatePostCount();
        //                     }
        //                 });

        //                 tl.to(postElement, {
        //                         scaleScale: 0.95,
        //                         opacity: 0.5,
        //                         duration: 0.2
        //                     })
        //                     .to(postElement, {
        //                         height: 0,
        //                         paddingTop: 0,
        //                         paddingBottom: 0,
        //                         marginTop: 0,
        //                         marginBottom: 0,
        //                         x: -100, // Kéo sang trái như bị cuốn vào máy hủy
        //                         opacity: 0,
        //                         duration: 0.6,
        //                         ease: "power3.in"
        //                     });
        //             } else {
        //                 alert("Lỗi: " + data.message);
        //             }
        //         })
        //         .catch(err => alert("Hệ thống trục trặc, không thể tiêu hủy bài viết."));
        // }

        function updatePostCount() {
            const countElement = document.querySelector('.font-cinzel.text-white');
            if (countElement) {
                let currentCount = parseInt(countElement.innerText);
                countElement.innerText = currentCount - 1;
            }
        }
        // --- LOGIC CHO SOẠN BÀI MỚI (RIÊNG BIỆT) ---

        function openCreateEditor() {
            const overlay = document.getElementById('create-masterpiece-overlay');

            // Reset Form trước khi mở để đảm bảo trống rỗng
            document.getElementById('new-post-title').value = "";
            document.getElementById('new-post-content').value = "";

            overlay.classList.remove('hidden');
            overlay.classList.add('flex');

            // Hiệu ứng GSAP mở tràn màn hình
            gsap.fromTo(overlay, {
                opacity: 0,
                y: 100
            }, {
                opacity: 1,
                y: 0,
                duration: 0.7,
                ease: "expo.out"
            });
        }

        function closeCreateEditor() {
            const overlay = document.getElementById('create-masterpiece-overlay');

            gsap.to(overlay, {
                opacity: 0,
                y: 100,
                duration: 0.5,
                ease: "power2.in",
                onComplete: () => {
                    overlay.classList.add('hidden');
                    overlay.classList.remove('flex');
                }
            });
        }

        // function publishNewPost() {
        //     // Hiệu ứng lướt dải sáng khi phát hành thành công
        //     const btn = event.currentTarget;
        //     btn.innerHTML = '<i class="ri-loader-2-line animate-spin"></i> ĐANG KHAI BÚT...';

        //     setTimeout(() => {
        //         alert("Kiệt tác mới đã được phát hành lên hệ thống!");
        //         closeCreateEditor();
        //         btn.innerHTML = 'Khai bút & Phát hành';
        //     }, 2000);
        // }
        function publishNewPost() {
            const title = document.getElementById('new-post-title').value;
            const content = document.getElementById('new-post-content').value;
            const thumbnailFile = document.getElementById('new-post-thumbnail-input').files[0];
            // const category = document.querySelector('select').value;
            const category = document.getElementById('new-post-category').value;

            // Thay alert bằng showToast với type 'error' (nếu Ngài đã chỉnh hàm showToast hỗ trợ type)
            if (!title || !content) {
                showToast("Thưa Ngài, vui lòng điền đầy đủ tiêu đề và nội dung.", "gold");
                return;
            }

            // Tạo FormData để gửi dữ liệu
            const formData = new FormData();
            formData.append('title', title);
            formData.append('content', content);
            formData.append('category', category);
            formData.append('thumbnail', thumbnailFile);
            formData.append('category', category);

            // Hiệu ứng chờ đợi sang trọng
            const btn = event.target;
            const originalText = btn.innerText;
            btn.innerText = "ĐANG LƯU BẢN THẢO...";
            btn.disabled = true;

            fetch('api_create_news.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Thông báo thành công sang trọng ở góc phải
                        showToast("Tuyệt tác đã được phát hành thành công vào kho lưu trữ.");

                        // Đợi 2 giây để người dùng kịp nhìn thấy thông báo rồi mới reload
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast("Lỗi: " + data.message, "gold");
                        btn.innerText = originalText;
                        btn.disabled = false;
                        btn.style.opacity = "1";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast("Hệ thống trục trặc, không thể phát hành.", "gold");
                    btn.innerText = originalText;
                    btn.disabled = false;
                    btn.style.opacity = "1";
                });
        }

        // Publish Animation
        // function publishPost() {
        //     const btn = event.target;
        //     btn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> ĐANG ĐẨY LÊN...';

        //     setTimeout(() => {
        //         // Flash Effect
        //         const flash = document.createElement('div');
        //         flash.className = 'fixed inset-0 bg-white z-[4000] opacity-0';
        //         document.body.appendChild(flash);

        //         gsap.to(flash, {
        //             opacity: 0.2,
        //             duration: 0.1,
        //             yoyo: true,
        //             repeat: 1,
        //             onComplete: () => {
        //                 flash.remove();
        //                 alert("Kiệt tác đã được phát hành thành công!");
        //                 closeEditor();
        //             }
        //         });
        //     }, 1500);
        // }

        function openPreview(postId) {
            const previewRoom = document.getElementById('preview-room');
            const postElement = document.getElementById(postId);

            // Lấy dữ liệu từ thẻ card bài viết
            const title = postElement.querySelector('h3').innerText;
            const imgSource = postElement.querySelector('img').src;
            const category = postElement.querySelector('span').innerText;

            // Đổ dữ liệu vào Modal Preview
            document.getElementById('preview-title').innerText = title;
            document.getElementById('preview-img').src = imgSource;
            document.getElementById('preview-category').innerText = category;

            // Hiển thị và diễn hoạt
            previewRoom.classList.remove('hidden');
            gsap.fromTo(previewRoom, {
                opacity: 0,
                scale: 1.1
            }, {
                opacity: 1,
                scale: 1,
                duration: 0.8,
                ease: "expo.out"
            });

            // Hiệu ứng chữ hiện ra dần dần (Stagger)
            gsap.from("#preview-title, #preview-img, #preview-body", {
                y: 30,
                opacity: 0,
                stagger: 0.2,
                duration: 1,
                delay: 0.3,
                ease: "power3.out"
            });
        }

        function closePreview() {
            gsap.to("#preview-room", {
                opacity: 0,
                duration: 0.5,
                ease: "power2.in",
                onComplete: () => {
                    document.getElementById('preview-room').classList.add('hidden');
                }
            });
        }

        // GSAP Scroll reveal
        document.addEventListener('DOMContentLoaded', () => {
            gsap.from(".news-row", {
                opacity: 1,
                x: 0,
                stagger: 0.1,
                duration: 1,
                ease: "power4.out"
            });
        });
        let isSearchOpen = false;
        let isFilterOpen = false;

        // Hàm điều khiển thanh Search
        function toggleSearch() {
            const container = document.getElementById('search-container');
            const input = document.getElementById('search-input');

            if (!isSearchOpen) {
                // Bung rộng và thêm hiệu ứng viền vàng mờ
                gsap.to(container, {
                    width: '300px', // Tăng độ rộng khi mở
                    paddingLeft: '5px',
                    paddingRight: '5px',
                    borderColor: 'rgba(197, 160, 89, 0.3)', // Viền vàng mờ đặc trưng
                    backgroundColor: 'rgba(255, 255, 255, 0.08)',
                    duration: 0.6,
                    ease: "expo.out",
                    onComplete: () => input.focus()
                });
            } else {
                // Thu nhỏ lại
                gsap.to(container, {
                    width: '0px',
                    paddingLeft: '0px',
                    paddingRight: '0px',
                    borderColor: 'transparent',
                    backgroundColor: 'rgba(255, 255, 255, 0.05)',
                    duration: 0.5,
                    ease: "expo.in"
                });
            }
            isSearchOpen = !isSearchOpen;
        }

        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('upload-placeholder');
            const overlay = document.getElementById('upload-overlay');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    overlay.classList.remove('hidden');

                    // Hiệu ứng hiện ảnh sang trọng với GSAP
                    gsap.fromTo(preview, {
                        opacity: 0,
                        scale: 1.1
                    }, {
                        opacity: 1,
                        scale: 1,
                        duration: 1
                    });
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Hàm điều khiển menu Filter
        function toggleFilter() {
            const dropdown = document.getElementById('filter-dropdown');

            if (!isFilterOpen) {
                dropdown.classList.remove('hidden');
                gsap.to(dropdown, {
                    opacity: 1,
                    y: 0,
                    duration: 0.4,
                    ease: "back.out(1.7)"
                });
            } else {
                gsap.to(dropdown, {
                    opacity: 0,
                    y: 10,
                    duration: 0.3,
                    onComplete: () => dropdown.classList.add('hidden')
                });
            }
            isFilterOpen = !isFilterOpen;
        }

        // Đóng các menu khi click ra ngoài
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.group') && !e.target.closest('button')) {
                if (isFilterOpen) toggleFilter();
            }
        });
        let debounceTimer;
        const searchInput = document.getElementById('search-input');
        const newsContainer = document.querySelector('.divide-y'); // Container chứa danh sách bài viết

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value;

            debounceTimer = setTimeout(() => {
                // Hiệu ứng mờ dần trước khi tải dữ liệu mới
                gsap.to(newsContainer, {
                    opacity: 0.5,
                    duration: 0.2
                });

                fetch(`ajax_search_news.php?search=${encodeURIComponent(query)}`)
                    .then(response => response.text())
                    .then(data => {
                        newsContainer.innerHTML = data;
                        // Hiện thị lại với hiệu ứng mượt mà
                        gsap.to(newsContainer, {
                            opacity: 1,
                            duration: 0.3
                        });

                        // Quan trọng: Sau khi load dữ liệu mới bằng AJAX, 
                        // Ngài cần gọi lại các hàm khởi tạo hiệu ứng nếu có (như GSAP hover)
                    })
                    .catch(error => console.error('Error:', error));
            }, 300);
        });

        function changePage(pageNum) {
            const newsContainer = document.querySelector('.divide-y');

            // Hiệu ứng biến mất sang trọng
            gsap.to(".news-row", {
                x: -20,
                opacity: 0,
                stagger: 0.05,
                duration: 0.4,
                onComplete: () => {
                    // Gọi AJAX lấy trang mới
                    fetch(`ajax_get_news.php?page=${pageNum}`)
                        .then(res => res.text())
                        .then(html => {
                            newsContainer.innerHTML = html;

                            // Hiệu ứng xuất hiện trở lại
                            gsap.from(".news-row", {
                                x: 20,
                                opacity: 0,
                                stagger: 0.05,
                                duration: 0.4
                            });
                        });
                }
            });
        }
    </script>
</body>

</html>