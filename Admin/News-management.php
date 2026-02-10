<!DOCTYPE html>
<html lang="vi">
<?php
require_once dirname(__DIR__) . '/check_admin.php';
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

        /* Custom Scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Glassmorphism Sidebar */
        .editor-sidebar {
            background: rgba(8, 8, 8, 0.8);
            backdrop-filter: blur(20px);
            border-left: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body>

    <?php include('Sidebar.php'); ?>

    <main class="main-content md:ml-[288px] min-h-screen p-4 md:p-10 transition-all duration-500">

        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 mb-12 mt-10 md:mt-0">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full lg:w-auto">
                <div class="bg-white/5 border border-white/5 p-5 rounded-2xl min-w-[200px]">
                    <p class="text-[9px] text-gray-500 uppercase tracking-widest mb-1">Tổng bài viết</p>
                    <h3 class="text-2xl font-cinzel text-white">128</h3>
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
            <!-- <div class="p-6 border-b border-white/5 flex justify-between items-center">
                <h2 class="font-cinzel text-xs tracking-[0.4em] text-gray-400">Feed Bản Tin Thượng Lưu</h2>
                <div class="flex gap-4">
                    <i class="ri-filter-3-line text-gray-500 cursor-pointer hover:text-white"></i>
                    <i class="ri-search-line text-gray-500 cursor-pointer hover:text-white"></i>
                </div>
            </div> -->
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
                                <button class="w-full text-left px-4 py-2 text-[10px] text-gray-400 hover:bg-[#c5a059] hover:text-black transition-all">Tất cả bài viết</button>
                                <button class="w-full text-left px-4 py-2 text-[10px] text-gray-400 hover:bg-[#c5a059] hover:text-black transition-all">Đã xuất bản</button>
                                <button class="w-full text-left px-4 py-2 text-[10px] text-gray-400 hover:bg-[#c5a059] hover:text-black transition-all">Bản nháp</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-white/5 relative z-10">
                <div class="news-row p-6 flex items-center justify-between group" id="post-1">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-zinc-900 border border-white/5">
                            <img src="https://images.pexels.com/photos/3311574/pexels-photo-3311574.jpeg?auto=compress&cs=tinysrgb&w=1260" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" alt="thumbnail">
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-[8px] bg-[#c5a059]/10 text-[#c5a059] px-2 py-0.5 rounded border border-[#c5a059]/20 font-bold uppercase">Xuất bản</span>
                                <span class="text-[10px] text-gray-600"><i class="ri-time-line"></i> 5 phút đọc</span>
                                <i class="ri-vip-crown-2-line text-[#c5a059] text-xs shadow-glow"></i>
                            </div>
                            <h3 class="font-playfair text-lg text-white group-hover:text-[#c5a059] transition-colors">Nghệ thuật thưởng lãm đồng hồ xa xỉ</h3>
                            <p class="text-[11px] text-gray-500 mt-1 max-w-md line-clamp-1 italic">Khám phá những cỗ máy thời gian triệu đô tại triển lãm Inner Circle...</p>
                        </div>
                    </div>

                    <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-10 group-hover:translate-x-0">
                        <button onclick="openPreview('post-1')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5 transition-all active:scale-90">
                            <i class="ri-eye-line text-gray-400 hover:text-[#c5a059]"></i>
                        </button>
                        <button onclick="openEditor('Nghệ thuật thưởng lãm đồng hồ xa xỉ')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5"><i class="ri-edit-line text-gray-400"></i></button>
                        <button onclick="deletePost('post-1')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-red-900/20 group/del"><i class="ri-delete-bin-line text-gray-400 group-hover/del:text-red-500"></i></button>
                    </div>
                </div>
                <div class="news-row p-6 flex items-center justify-between group" id="post-2">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-zinc-900 border border-white/5">
                            <img src="https://images.pexels.com/photos/3752169/pexels-photo-3752169.jpeg?auto=compress&cs=tinysrgb&w=1260" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" alt="thumbnail">
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-[8px] bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded border border-blue-500/20 font-bold uppercase">Lên lịch</span>
                                <span class="text-[10px] text-gray-600"><i class="ri-time-line"></i> 8 phút đọc</span>
                            </div>
                            <h3 class="font-playfair text-lg text-white group-hover:text-[#c5a059] transition-colors">Đường đua của những vị thần: Pagani Utopia</h3>
                            <p class="text-[11px] text-gray-500 mt-1 max-w-md line-clamp-1 italic">Phân tích chi tiết về tuyệt phẩm cơ khí mới nhất từ vùng Modena nước Ý...</p>
                        </div>
                    </div>

                    <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-10 group-hover:translate-x-0">
                        <button onclick="openPreview('post-2')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5 transition-all active:scale-90">
                            <i class="ri-eye-line text-gray-400 hover:text-[#c5a059]"></i>
                        </button>
                        <button onclick="openEditor('Pagani Utopia')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5"><i class="ri-edit-line text-gray-400"></i></button>
                        <button onclick="deletePost('post-2')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-red-900/20 group/del"><i class="ri-delete-bin-line text-gray-400 group-hover/del:text-red-500"></i></button>
                    </div>
                </div>

                <div class="news-row p-6 flex items-center justify-between group" id="post-3">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-zinc-900 border border-white/5">
                            <img src="https://images.pexels.com/photos/258154/pexels-photo-258154.jpeg?auto=compress&cs=tinysrgb&w=1260" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" alt="thumbnail">
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-[8px] bg-[#c5a059]/10 text-[#c5a059] px-2 py-0.5 rounded border border-[#c5a059]/20 font-bold uppercase">Xuất bản</span>
                                <span class="text-[10px] text-gray-600"><i class="ri-time-line"></i> 12 phút đọc</span>
                                <i class="ri-vip-crown-2-line text-[#c5a059] text-xs animate-pulse"></i>
                            </div>
                            <h3 class="font-playfair text-lg text-white group-hover:text-[#c5a059] transition-colors">Dinh thự ven hồ: Khi thiên nhiên là trang sức</h3>
                            <p class="text-[11px] text-gray-500 mt-1 max-w-md line-clamp-1 italic">Top 5 căn Penhouse có tầm nhìn vô cực tại khu vực trung tâm tài chính...</p>
                        </div>
                    </div>

                    <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-10 group-hover:translate-x-0">
                        <button onclick="openPreview('post-3')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5 transition-all active:scale-90">
                            <i class="ri-eye-line text-gray-400 hover:text-[#c5a059]"></i>
                        </button>
                        <button onclick="openEditor('Dinh thự ven hồ')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5"><i class="ri-edit-line text-gray-400"></i></button>
                        <button onclick="deletePost('post-3')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-red-900/20 group/del"><i class="ri-delete-bin-line text-gray-400 group-hover/del:text-red-500"></i></button>
                    </div>
                </div>

                <div class="news-row p-6 flex items-center justify-between group" id="post-4">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-zinc-900 border border-white/5">
                            <img src="https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=1260" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" alt="thumbnail">
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-[8px] bg-zinc-500/20 text-zinc-500 px-2 py-0.5 rounded border border-white/5 font-bold uppercase">Bản nháp</span>
                                <span class="text-[10px] text-gray-600"><i class="ri-time-line"></i> 4 phút đọc</span>
                            </div>
                            <h3 class="font-playfair text-lg text-white group-hover:text-[#c5a059] transition-colors">Văn hóa Cigar: Đỉnh cao của sự tĩnh lặng</h3>
                            <p class="text-[11px] text-gray-500 mt-1 max-w-md line-clamp-1 italic">Câu chuyện về những điếu thuốc được cuốn thủ công từ vùng Vuelta Abajo...</p>
                        </div>
                    </div>

                    <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-10 group-hover:translate-x-0">
                        <button onclick="openPreview('post-4')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5 transition-all active:scale-90">
                            <i class="ri-eye-line text-gray-400 hover:text-[#c5a059]"></i>
                        </button>
                        <button onclick="openEditor('Văn hóa Cigar')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5"><i class="ri-edit-line text-gray-400"></i></button>
                        <button onclick="deletePost('post-4')" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-red-900/20 group/del"><i class="ri-delete-bin-line text-gray-400 group-hover/del:text-red-500"></i></button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div id="master-editor" class="fixed inset-0 z-[3000] bg-[#000] hidden flex-col">
        <nav class="h-20 border-b border-white/5 px-8 flex items-center justify-between bg-black/50 backdrop-blur-md">
            <div class="flex items-center gap-6">
                <button onclick="closeEditor()" class="text-gray-500 hover:text-white flex items-center gap-2 text-xs tracking-widest">
                    <i class="ri-arrow-left-s-line text-xl"></i> THOÁT
                </button>
                <div class="h-4 w-[1px] bg-white/10"></div>
                <p class="text-[10px] text-gray-600 italic"><i class="ri-save-3-line animate-pulse"></i> Đang tự động lưu nháp...</p>
            </div>
            <div class="flex items-center gap-4">
                <button class="text-[10px] font-bold tracking-widest px-6 py-2 border border-white/10 rounded-full hover:bg-white/5 transition-all">XEM TRƯỚC</button>
                <button onclick="publishPost()" class="text-[10px] font-bold tracking-widest px-8 py-2 bg-[#c5a059] text-black rounded-full hover:shadow-[0_0_20px_#c5a059] transition-all">PHÁT HÀNH</button>
            </div>
        </nav>

        <div class="flex flex-1 overflow-hidden">
            <div class="flex-1 overflow-y-auto no-scrollbar p-12 lg:p-24 max-w-5xl mx-auto w-full">
                <input type="text" id="editor-title" placeholder="Tiêu Đề Kiệt Tác..." class="w-full bg-transparent border-none outline-none font-cinzel text-4xl lg:text-6xl text-white placeholder:text-zinc-800 mb-12">

                <div class="w-full aspect-video rounded-3xl border-2 border-dashed border-white/10 flex flex-col items-center justify-center group/upload hover:border-[#c5a059]/30 transition-all mb-12 cursor-pointer relative overflow-hidden">
                    <div class="upload-glow absolute inset-0 bg-[#c5a059]/5 opacity-0 group-hover/upload:opacity-100 transition-opacity"></div>
                    <i class="ri-image-add-line text-4xl text-zinc-700 group-hover/upload:text-[#c5a059] transition-colors"></i>
                    <p class="text-[10px] text-zinc-600 uppercase tracking-[0.3em] mt-4">Tải lên hình ảnh bìa Obsidian</p>
                </div>

                <textarea placeholder="Bắt đầu câu chuyện thượng lưu của bạn tại đây..." class="w-full bg-transparent border-none outline-none font-playfair italic text-xl text-zinc-400 placeholder:text-zinc-800 min-h-[400px] leading-relaxed resize-none"></textarea>
            </div>

            <aside class="w-80 editor-sidebar p-8 hidden xl:flex flex-col gap-8">
                <div>
                    <h4 class="text-[10px] font-bold text-[#c5a059] uppercase tracking-widest mb-6 border-b border-[#c5a059]/20 pb-2">Phân loại bài viết</h4>
                    <select class="w-full bg-white/5 border border-white/10 rounded-lg p-3 text-xs outline-none focus:border-[#c5a059]">
                        <option>Đời Sống & Phong Cách</option>
                        <option>Siêu Xe & Biển Số</option>
                        <option>Bất Động Sản Nghỉ Dưỡng</option>
                    </select>
                </div>

                <div class="p-6 bg-[#c5a059]/5 border border-[#c5a059]/20 rounded-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-white">VIP Access</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-9 h-5 bg-zinc-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-zinc-500 after:border-zinc-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:bg-[#c5a059] peer-checked:bg-[#c5a059]/20"></div>
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

                <div class="w-full aspect-video rounded-3xl border-2 border-dashed border-white/5 flex flex-col items-center justify-center group/new-upload hover:border-[#c5a059]/50 transition-all mb-12 cursor-pointer relative bg-zinc-900/20">
                    <i class="ri-image-add-line text-5xl text-zinc-800 group-hover/new-upload:text-[#c5a059] transition-colors"></i>
                    <p class="text-[10px] text-zinc-600 uppercase tracking-[0.3em] mt-6">Thêm hình ảnh đại diện kiệt tác</p>
                </div>

                <textarea id="new-post-content" placeholder="Bắt đầu viết những dòng cảm hứng thượng lưu..."
                    class="w-full bg-transparent border-none outline-none font-playfair italic text-2xl text-zinc-400 placeholder:text-zinc-900 min-h-[500px] leading-relaxed resize-none"></textarea>
            </div>

            <aside class="w-80 bg-white/[0.01] border-l border-white/5 p-8 hidden xl:block">
                <h4 class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.3em] mb-8">Thiết lập bài viết</h4>

                <div class="space-y-8">
                    <div>
                        <label class="text-[9px] text-gray-600 uppercase mb-3 block">Chuyên mục</label>
                        <select class="w-full bg-black border border-white/10 rounded-lg p-3 text-[11px] text-white outline-none focus:border-[#c5a059]">
                            <option>Lifestyle</option>
                            <option>Siêu Xe</option>
                            <option>Đấu Giá</option>
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
        function openEditor(title = "") {
            const editor = document.getElementById('master-editor');
            if (title) document.getElementById('editor-title').value = title;

            editor.classList.remove('hidden');
            editor.classList.add('flex');

            gsap.fromTo(editor, {
                opacity: 0,
                scale: 1.1
            }, {
                opacity: 1,
                scale: 1,
                duration: 0.8,
                ease: "expo.out"
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
        function deletePost(id) {
            if (!confirm("Bạn muốn tiêu hủy kiệt tác này?")) return;

            const post = document.getElementById(id);
            gsap.to(post, {
                height: 0,
                opacity: 0,
                x: -50,
                duration: 0.7,
                ease: "power3.inOut",
                onComplete: () => post.remove()
            });
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

        function publishNewPost() {
            // Hiệu ứng lướt dải sáng khi phát hành thành công
            const btn = event.currentTarget;
            btn.innerHTML = '<i class="ri-loader-2-line animate-spin"></i> ĐANG KHAI BÚT...';

            setTimeout(() => {
                alert("Kiệt tác mới đã được phát hành lên hệ thống!");
                closeCreateEditor();
                btn.innerHTML = 'Khai bút & Phát hành';
            }, 2000);
        }

        // Publish Animation
        function publishPost() {
            const btn = event.target;
            btn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> ĐANG ĐẨY LÊN...';

            setTimeout(() => {
                // Flash Effect
                const flash = document.createElement('div');
                flash.className = 'fixed inset-0 bg-white z-[4000] opacity-0';
                document.body.appendChild(flash);

                gsap.to(flash, {
                    opacity: 0.2,
                    duration: 0.1,
                    yoyo: true,
                    repeat: 1,
                    onComplete: () => {
                        flash.remove();
                        alert("Kiệt tác đã được phát hành thành công!");
                        closeEditor();
                    }
                });
            }, 1500);
        }

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
    </script>
</body>

</html>