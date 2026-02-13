<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . '/models/News.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newsModel = new NewsModel();

    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $category = $_POST['category'] ?? 'xe-sang';

    // 1. XÁC ĐỊNH 2 VỊ TRÍ LƯU TRỮ KHÁC NHAU
    // Vị trí 1: Ngoài thư mục gốc dự án (Dùng để Website truy cập hiển thị)
    $uploadDirOutside = dirname(__DIR__) . '/uploads/news/';
    // Vị trí 2: Ngay tại thư mục chứa file PHP này (Dùng lưu trữ nội bộ/backup)
    $uploadDirInside = __DIR__ . '/uploads/news/';

    // Tự động tạo cả 2 thư mục nếu chưa tồn tại
    if (!is_dir($uploadDirOutside)) {
        mkdir($uploadDirOutside, 0777, true);
    }
    if (!is_dir($uploadDirInside)) {
        mkdir($uploadDirInside, 0777, true);
    }

    $thumbnailPathInDB = "https://via.placeholder.com/1280x720"; // Mặc định nếu lỗi

    // 2. XỬ LÝ NHÂN BẢN FILE ẢNH
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
        $fileName = $_FILES['thumbnail']['name'];

        // Tạo tên file duy nhất để không bị trùng lặp
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Đường dẫn đầy đủ cho 2 file
        $destPathOutside = $uploadDirOutside . $newFileName;
        $destPathInside = $uploadDirInside . $newFileName;

        // Hành động 1: Di chuyển từ bộ nhớ tạm vào Vị trí 1 (Ngoài gốc)
        if (move_uploaded_file($fileTmpPath, $destPathOutside)) {

            // Hành động 2: Copy từ Vị trí 1 sang Vị trí 2
            copy($destPathOutside, $destPathInside);

            // Lưu đường dẫn của Vị trí 1 vào Database (để các trang News.php load được ảnh)
            $thumbnailPathInDB = 'uploads/news/' . $newFileName;
        }
    }

    // 3. TỰ ĐỘNG BIÊN TẬP NỘI DUNG PHỤ (SUBTITLE & SUMMARY)
    // Tách tiêu đề thành cấu trúc 3 phần phục vụ hiệu ứng nghệ thuật của Ngài
    $subtitle = $title . " | & | Tinh Hoa Heritage";
    $summary = mb_substr(strip_tags($content), 0, 150, "UTF-8") . "...";

    // 4. GHI DANH VÀO CƠ SỞ DỮ LIỆU
    $result = $newsModel->createNews(
        $title,
        $subtitle,
        $summary,
        $content,
        $thumbnailPathInDB,
        $category,
        1 // Trạng thái: 1 - Xuất bản ngay
    );

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Kiệt tác đã được nhân bản và niêm yết tại 2 vị trí.',
            'id' => $result
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi kết nối kho lưu trữ trung tâm.'
        ]);
    }
}
