<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/User.php";

$userModel = new User();

// --- XỬ LÝ ACTIONS QUA GET (Xóa, Đổi trạng thái) ---
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'] ?? '';
    $id = (int)($_GET['id'] ?? 0);

    if ($action == 'toggle_status' && $id) {
        $db = new Db();
        $conn = $db->getConnection();
        $res = $conn->query("SELECT status FROM users WHERE user_id = $id");
        $row = $res->fetch_assoc();
        $newStatus = ($row['status'] == 1) ? 0 : 1;

        $conn->query("UPDATE users SET status = $newStatus WHERE user_id = $id");
        header("Location: List_vip.php?msg=updated");
        exit;
    }

    if ($action == 'delete' && $id) {
        $userModel->deleteMember($id); // Sử dụng hàm từ model cho sạch code
        header("Location: List_vip.php?msg=deleted");
        exit;
    }
}

// --- XỬ LÝ ACTIONS QUA POST (Thêm hội viên mới từ Modal) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'add_member') {
        $fullname = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $role_id = (int)($_POST['role_id'] ?? 3);

        // Tạo username tự động từ email (ví dụ: alex@gmail.com -> alex8921)
        $username = explode('@', $email)[0] . rand(1000, 9999);
        // Mật khẩu mặc định cho thượng khách
        $password = "Welcome123";

        // Gọi hàm register từ User.php
        // Lưu ý: Tôi đã bổ sung logic để nhận role_id (Xem bước 2 bên dưới)
        $result = $userModel->register($fullname, $username, $email, $password, $role_id);

        if ($result === true) {
            header("Location: List_vip.php?status=success&name=" . urlencode($fullname));
        } else {
            // Nếu có lỗi (trùng email...) trả về thông báo lỗi
            header("Location: List_vip.php?status=error&msg=" . urlencode($result));
        }
        exit;
    }
    if ($action == 'edit_member') {
        $user_id = (int)$_POST['user_id'];
        $fullname = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $role_id = (int)$_POST['role_id'];
        $status = (int)$_POST['status'];

        // Gọi hàm updateMember đã có sẵn trong model User.php của bạn
        $result = $userModel->updateMember($user_id, $fullname, $email, $role_id, $status);

        if ($result) {
            header("Location: List_vip.php?status=success&msg=Đã cập nhật hồ sơ thượng khách");
        } else {
            header("Location: List_vip.php?status=error&msg=Cập nhật thất bại");
        }
        exit;
    }
}

exit;
