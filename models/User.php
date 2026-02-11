<?php
// Sử dụng đường dẫn tuyệt đối dựa trên thư mục hiện tại của file User.php
require_once __DIR__ . "/db.php";

class User extends Db
{

    /**
     * Hàm đăng ký hội viên mới
     * @param string $fullname Họ và tên
     * @param string $username Tên đăng nhập
     * @param string $email Email
     * @param string $password Mật khẩu thuần
     * @return bool|string Trả về true nếu thành công, hoặc thông báo lỗi
     */
    public function checkLogin($username, $password)
    {
        $db = self::getConnection();

        // Truy vấn lấy user theo username hoặc email
        $sql = "SELECT users.*, roles.role_name, roles.display_name, roles.role_color 
                FROM users 
                JOIN roles ON users.role_id = roles.id 
                WHERE users.username = ? OR users.email = ? 
                LIMIT 1";

        try {
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // 1. Kiểm tra trạng thái (status = 1 là hoạt động)
                if ($user['status'] == 0) {
                    return "account_locked";
                }

                // 2. Kiểm tra mật khẩu (Sử dụng password_verify)
                if (password_verify($password, $user['password'])) {
                    unset($user['password']); // Xóa pass trước khi lưu session
                    return $user;
                }
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function updateLastLogin($userId)
    {
        $db = self::getConnection();
        $sql = "UPDATE users SET created_at = NOW() WHERE user_id = ?"; // Hoặc cột last_login nếu bạn có
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }
    public function register($fullname, $username, $email, $password)
    {
        $db = self::getConnection();

        // 1. Kiểm tra xem username hoặc email đã tồn tại chưa
        $checkSql = "SELECT user_id FROM users WHERE username = ? OR email = ?";
        $stmtCheck = $db->prepare($checkSql);
        $stmtCheck->bind_param("ss", $username, $email);
        $stmtCheck->execute();
        if ($stmtCheck->get_result()->num_rows > 0) {
            return "Tên đăng nhập hoặc Email đã được sử dụng trong hệ thống.";
        }

        // 2. Mã hóa mật khẩu (Bắt buộc để đăng nhập được bằng password_verify)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 3. Thiết lập Role mặc định (Ví dụ: ID 3 là 'staff/concierge' hoặc 2 là 'admin')
        $defaultRoleId = 3;

        // 4. Thực hiện chèn dữ liệu
        $sql = "INSERT INTO users (role_id, fullname, username, email, password, status) VALUES (?, ?, ?, ?, ?, 1)";

        try {
            $stmt = $db->prepare($sql);
            $stmt->bind_param("issss", $defaultRoleId, $fullname, $username, $email, $hashedPassword);

            if ($stmt->execute()) {
                return true;
            }
            return "Lỗi thực thi hệ thống.";
        } catch (Exception $e) {
            return "Lỗi kết nối hầm chứa: " . $e->getMessage();
        }
    }
}
