<?php
// require_once __DIR__ . "/db.php";

class Action extends Db
{
    // Hàm lấy chi tiết phiên đấu giá
    function getAuctionDetail($auction_id)
    {
        $db = self::getConnection();

        $sql = "SELECT a.*, p.plate_number, p.starting_price, p.bid_step, 
                (SELECT fullname FROM users WHERE user_id = (SELECT users_id FROM bids WHERE auctions_id = a.auctions_id ORDER BY bid_amount DESC LIMIT 1)) as highest_bidder_name
                FROM auctions a
                JOIN plates p ON a.plates_id = p.plates_id
                WHERE a.auctions_id = ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $auction_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Hàm lấy lịch sử đấu giá (Dòng 24 đã bỏ tham số $conn)
    function getBidHistory($auction_id)
    {
        $db = self::getConnection();

        $sql = "SELECT b.bid_amount, b.created_at, u.fullname 
                FROM bids b 
                JOIN users u ON b.users_id = u.user_id 
                WHERE b.auctions_id = ? 
                ORDER BY b.bid_amount DESC LIMIT 5";

        $stmt = $db->prepare($sql);

        // Kiểm tra nếu SQL lỗi
        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("i", $auction_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $history = [];
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
        return $history;
    }
    // Trong class Action extends Db
    public function getWinner($auction_id)
    {
        $db = self::getConnection();
        // Tìm người có mức giá cao nhất trong bảng bids
        $sql = "SELECT b.users_id, b.bid_amount, u.fullname, u.balance 
            FROM bids b 
            JOIN users u ON b.users_id = u.user_id 
            WHERE b.auctions_id = ? 
            ORDER BY b.bid_amount DESC LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $auction_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function processWinner($auction_id)
    {
        $db = self::getConnection();
        $winner = $this->getWinner($auction_id);

        if ($winner) {
            $userId = $winner['users_id'];
            $amount = $winner['bid_amount'];
            $currentBalance = $winner['balance'];

            if ($currentBalance >= $amount) {
                // Trừ tiền user
                $newBalance = $currentBalance - $amount;
                $updateSql = "UPDATE users SET balance = ? WHERE user_id = ?";
                $updateStmt = $db->prepare($updateSql);
                $updateStmt->bind_param("di", $newBalance, $userId);
                return $updateStmt->execute();
            }
        }
        return false;
    }
    // Lấy tổng số người tham gia duy nhất trong một phiên đấu giá
    public function getParticipantCount($auction_id)
    {
        $db = self::getConnection();
        $sql = "SELECT COUNT(DISTINCT users_id) as total_users FROM bids WHERE auctions_id = ?";

        $stmt = $db->prepare($sql);
        if (!$stmt) return 0;

        $stmt->bind_param("i", $auction_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total_users'] ?? 0;
    }
}
