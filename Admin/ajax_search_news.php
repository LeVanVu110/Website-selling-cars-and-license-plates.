<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . '/models/News.php';

$newsModel = new NewsModel();
$search = $_GET['search'] ?? '';

// Gọi hàm model mà chúng ta đã viết trước đó
$listNews = $newsModel->getAllNewsForAdmin($search);

if (!empty($listNews)) {
    foreach ($listNews as $news): ?>
        <div class="news-row p-6 flex items-center justify-between group" id="post-<?= $news['news_id'] ?>">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-xl overflow-hidden bg-zinc-900 border border-white/5">
                    <img src="<?= $news['thumbnail'] ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="thumbnail">
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-[8px] <?= $news['status'] == 1 ? 'bg-[#c5a059]/10 text-[#c5a059] border-[#c5a059]/20' : 'bg-zinc-500/20 text-zinc-500 border-white/5' ?> px-2 py-0.5 rounded border font-bold uppercase">
                            <?= $news['status'] == 1 ? 'Xuất bản' : 'Bản nháp' ?>
                        </span>
                        <span class="text-[10px] text-gray-600"><i class="ri-time-line"></i> <?= date('d/m/Y', strtotime($news['publish_date'])) ?></span>
                    </div>
                    <h3 class="font-playfair text-lg text-white group-hover:text-[#c5a059] transition-colors"><?= htmlspecialchars($news['title']) ?></h3>
                    <p class="text-[11px] text-gray-500 mt-1 max-w-md line-clamp-1 italic"><?= htmlspecialchars($news['summary']) ?></p>
                </div>
            </div>
            <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-10 group-hover:translate-x-0">
                <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5"><i class="ri-eye-line text-gray-400"></i></button>
                <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5"><i class="ri-edit-line text-gray-400"></i></button>
                <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-red-900/20"><i class="ri-delete-bin-line text-gray-400"></i></button>
            </div>
        </div>
<?php endforeach;
} else {
    echo '<p class="p-10 text-center text-gray-600 italic">Không tìm thấy bản tin nào phù hợp.</p>';
}
?>