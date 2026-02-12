<?php
class NewsModel extends Db
{
    // 1. Lấy bài viết nổi bật nhất (cho Hero Section)
    public function getFeaturedNews()
    {
        $db = self::getConnection();
        $sql = "SELECT * FROM news WHERE is_featured = 1 AND status = 1 
                ORDER BY publish_date DESC LIMIT 1";
        $result = $db->query($sql);
        return $result->fetch_assoc();
    }

    // 2. Lấy danh sách tin tức thường (Trừ bài Hero đang hiển thị)
    public function getAllNews($limit = 10, $exclude_id = 0)
    {
        $db = self::getConnection();
        $sql = "SELECT * FROM news WHERE status = 1 AND news_id != ? 
                ORDER BY publish_date DESC LIMIT ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ii", $exclude_id, $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 3. Lấy chi tiết một tin (cho trang Detail_News.php)
    public function getNewsById($id)
    {
        $db = self::getConnection();
        $sql = "SELECT * FROM news WHERE news_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    // --- CÁC HÀM ADMIN ---

    // 4. Thêm tin tức mới (Cập nhật đủ các trường)

    public function createNews($title, $subtitle, $summary, $content, $thumbnail, $category, $status = 1)
    {
        $db = self::getConnection();
        $sql = "INSERT INTO news (title, subtitle, summary, content, thumbnail, category, status, publish_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $db->prepare($sql);
        // Giả định subtitle và summary tạm thời để trống hoặc lấy từ phần đầu content
        $stmt->bind_param("ssssssi", $title, $subtitle, $summary, $content, $thumbnail, $category, $status);

        if ($stmt->execute()) {
            return $db->insert_id;
        }
        return false;
    }

    // 5. Sửa tin tức
    public function updateNews($id, $title, $subtitle, $summary, $content, $thumbnail, $category, $status = 1)
    {
        $db = self::getConnection();
        $sql = "UPDATE news SET 
            title = ?, 
            subtitle = ?, 
            summary = ?, 
            content = ?, 
            thumbnail = ?, 
            category = ?, 
            status = ? 
            WHERE news_id = ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssssssii", $title, $subtitle, $summary, $content, $thumbnail, $category, $status, $id);

        return $stmt->execute();
    }

    // 6. Xóa tin tức
    public function deleteNews($id)
    {
        $db = self::getConnection();
        $sql = "DELETE FROM news WHERE news_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    // Lấy danh sách tin tức cho trang quản trị (Hỗ trợ tìm kiếm và lọc trạng thái)
    public function getAllNewsForAdmin($search = '', $status = null)
    {
        $db = self::getConnection();
        $sql = "SELECT * FROM news WHERE 1=1";
        $params = [];
        $types = "";

        // Lọc theo từ khóa tìm kiếm (Tiêu đề hoặc Tóm tắt)
        if (!empty($search)) {
            $sql .= " AND (title LIKE ? OR summary LIKE ?)";
            $searchParam = "%$search%";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "ss";
        }

        // Lọc theo trạng thái (1: Xuất bản, 0: Bản nháp)
        if ($status !== null && $status !== '') {
            $sql .= " AND status = ?";
            $params[] = (int)$status;
            $types .= "i";
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
