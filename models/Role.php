<?php
require_once __DIR__ . "/db.php";

class Role extends Db
{

    /**
     * Lấy toàn bộ danh sách các quyền trong hệ thống
     */


    /**
     * Lấy thông tin chi tiết của một quyền cụ thể theo ID
     */
    public function getRoleById($roleId)
    {
        $db = self::getConnection();
        $sql = "SELECT * FROM roles WHERE id = ? LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $roleId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Kiểm tra xem một Role ID có quyền truy cập Admin hay không
     * (Giả sử Role 1, 2, 3 là các cấp bậc quản trị)
     */
    public function isAdmin($roleId)
    {
        $adminRoles = [1, 2, 3]; // Grandmaster, Elite Keeper, Concierge
        return in_array((int)$roleId, $adminRoles);
    }
    public function getRoleDetails($roleId)
    {
        $db = self::getConnection();
        $sql = "SELECT * FROM roles WHERE id = ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $roleId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Lấy danh sách tất cả các quyền (Dùng cho trang quản lý phân quyền hoặc Select box)
     */
    public function getAllRoles()
    {
        $db = self::getConnection();
        $sql = "SELECT * FROM roles ORDER BY id ASC";
        $result = $db->query($sql);

        $roles = [];
        while ($row = $result->fetch_assoc()) {
            $roles[] = $row;
        }
        return $roles;
    }

    /**
     * Hàm kiểm tra nhanh xem một ID có phải là Admin/Staff không
     * Trả về true/false
     */
    public function canAccessAdmin($roleId)
    {
        // Theo logic của bạn: 1, 2, 3 là quyền vào Admin
        $authorizedRoles = [1, 2, 3];
        return in_array((int)$roleId, $authorizedRoles);
    }
}
