<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";
require_once __DIR__ . "/models/User.php";
require_once __DIR__ . "/models/Role.php"; // Thêm model Role vào

$response = ['status' => 'error', 'message' => 'Truy cập bị từ chối'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $userModel = new User();
    $roleModel = new Role(); // Khởi tạo Role model

    $userData = $userModel->checkLogin($username, $password);

    if (is_array($userData)) {
        // 1. Lưu session
        $_SESSION['user'] = $userData;

        // 2. Cập nhật thời gian đăng nhập
        $userModel->updateLastLogin($userData['user_id']);

        // 3. LOGIC PHÂN QUYỀN SỬ DỤNG MODEL ROLE
        // Thay vì viết cứng (1 || 2 || 3), ta dùng hàm kiểm tra của model
        // Lấy Role ID từ dữ liệu user đã đăng nhập thành công
        $roleId = (int)$userData['role_id'];

        if ($roleId === 1 || $roleId === 2) {
            // Chỉ Role 1 (Master) và 2 (Admin) mới vào Dashboard quản trị
            $redirectUrl = 'Admin/Dashboard.php';
        } else {
            // Role 3 (Staff) và các role khác đều về index.php
            $redirectUrl = 'index.php';
        }

        $response = [
            'status' => 'success',
            'redirect' => $redirectUrl // Biến này sẽ gửi về cho JavaScript
        ];

        $response = [
            'status' => 'success',
            'redirect' => $redirectUrl
        ];
    } elseif ($userData === "account_locked") {
        $response = ['status' => 'error', 'message' => 'Tài khoản của Ngài hiện đang bị phong tỏa.'];
    } else {
        $response = ['status' => 'error', 'message' => 'Danh tính hoặc mật mã không chính xác.'];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
