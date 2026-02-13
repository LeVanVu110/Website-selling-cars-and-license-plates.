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
    // 1. XUẤT: Lấy danh sách hội viên VIP kèm theo tên quyền (Role)
    // public function getAllVipMembers()
    // {
    //     $db = self::getConnection();
    //     // Join với bảng roles để lấy display_name và màu sắc của phân quyền
    //     $sql = "SELECT users.*, roles.display_name, roles.role_color 
    //             FROM users 
    //             JOIN roles ON users.role_id = roles.id 
    //             ORDER BY users.user_id DESC";

    //     $result = $db->query($sql);
    //     $members = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $members[] = $row;
    //     }
    //     return $members;
    // }
    public function getAllVipMembers()
    {
        $db = self::getConnection();
        // Lấy tất cả user, không lọc theo role_id để hiện cả Admin và VIP
        $sql = "SELECT users.*, roles.role_name, roles.display_name, roles.role_color 
            FROM users 
            LEFT JOIN roles ON users.role_id = roles.id 
            ORDER BY roles.id ASC, users.user_id DESC"; // Sắp xếp theo cấp bậc từ cao xuống thấp

        $result = $db->query($sql);
        $members = [];
        while ($row = $result->fetch_assoc()) {
            $members[] = $row;
        }
        return $members;
    }

    // 2. THÊM: Tạo hội viên mới (Mật khẩu được mã hóa tự động)
    public function addMember($fullname, $username, $email, $password, $role_id, $status = 1)
    {
        $db = self::getConnection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (role_id, fullname, username, email, password, status) VALUES (?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $db->prepare($sql);
            // "issssi": int, string, string, string, string, int
            $stmt->bind_param("issssi", $role_id, $fullname, $username, $email, $hashedPassword, $status);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // 3. SỬA: Cập nhật thông tin hội viên
    public function updateMember($user_id, $fullname, $email, $role_id, $status)
    {
        $db = self::getConnection();
        // Không cập nhật password ở hàm này để tránh mất mật khẩu cũ
        $sql = "UPDATE users SET fullname = ?, email = ?, role_id = ?, status = ? WHERE user_id = ?";

        try {
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ssiii", $fullname, $email, $role_id, $status, $user_id);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // 4. XÓA: Loại bỏ hội viên khỏi hệ thống
    public function deleteMember($user_id)
    {
        $db = self::getConnection();
        $sql = "DELETE FROM users WHERE user_id = ?";

        try {
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $user_id);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // 5. ĐỔI MẬT KHẨU: Hàm riêng để Admin cấp lại mật khẩu cho VIP
    public function resetPassword($user_id, $new_password)
    {
        $db = self::getConnection();
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("si", $hashed, $user_id);
        return $stmt->execute();
    }
}
