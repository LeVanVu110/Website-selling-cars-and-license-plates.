<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";
require_once __DIR__ . "/models/Place.php";

$plateModel = new Place();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$plate = $plateModel->getPlateById($id);

// Nếu không có biển số hợp lệ, quay về kho
if (!$plate) {
    header("Location: Plate_warehouse.php");
    exit;
}

$price = (int)$plate['starting_price'];
$tax = $price * 0.1; // VAT 10%
$totalPrice = $price + $tax;
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        /* Tùy chỉnh để nút PayPal tiệp màu với giao diện tối */
        #paypal-button-container {
            filter: grayscale(0.2) contrast(1.1);
            margin-top: 20px;
        }

        .gold-text-static {
            background: linear-gradient(to right, #bf953f, #fcf6ba, #b38728);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            filter: drop-shadow(0 0 10px rgba(191, 149, 63, 0.3));
        }

        /* ----------------------------- section 2 -----------------------------  */

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section class="min-h-screen bg-[#050505] text-white pt-20 pb-12 overflow-hidden">

        <script src="https://www.paypal.com/sdk/js?client-id=AUClETzi-Xvgbaa6W6gEug5ASmvOahIADGicngATbjfsyQAtfVPAmGcBfvbGAiuq5T24O_NTzkiBVL2t"></script>

        <div class="container mx-auto px-6 mt-10">
            <div class="flex flex-col lg:flex-row gap-16">

                <div class="w-full lg:w-3/5 space-y-16">
                    <div class="checkout-step">
                        <div class="flex items-center gap-4 mb-8">
                            <span class="text-4xl font-light italic text-[#bf953f]/30">01</span>
                            <h2 class="text-xl font-bold uppercase tracking-widest">Xác nhận thanh toán</h2>
                        </div>

                        <div class="space-y-4">
                            <div class="p-6 border border-[#bf953f]/30 bg-white/[0.02] relative group">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <span class="block text-xs font-bold uppercase tracking-widest text-[#bf953f]">Thanh toán quốc tế qua PayPal</span>
                                        <span class="text-[10px] text-gray-500 italic">An toàn, bảo mật, hỗ trợ thẻ Visa/Mastercard.</span>
                                    </div>
                                    <i class="ri-paypal-fill text-2xl text-[#003087]"></i>
                                </div>

                                <div id="paypal-button-container" class="relative z-10"></div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-[#0a0a0a] border-l-2 border-[#bf953f] flex items-start gap-4">
                        <i class="ri-shield-check-line text-2xl text-[#bf953f]"></i>
                        <p class="text-[10px] text-gray-400 leading-relaxed italic">
                            <span class="text-white font-bold">GIAO DỊCH ĐƯỢC MÃ HÓA:</span> Mọi thông tin thanh toán của bạn được xử lý trực tiếp bởi cổng PayPal theo tiêu chuẩn PCI DSS toàn cầu. Chúng tôi không lưu giữ thông tin thẻ của quý khách.
                        </p>
                    </div>
                </div>

                <div class="w-full lg:w-2/5">
                    <!-- <div class="lg:sticky lg:top-24 bg-[#0a0a0a] border border-white/5 p-8 shadow-2xl">
                        <h3 class="text-sm font-bold uppercase tracking-[0.3em] mb-8 border-b border-white/5 pb-4">Đơn hàng của bạn</h3>

                        <div class="bg-white p-4 rounded-sm mb-8 text-center">
                            <p class="text-black text-3xl font-bold tracking-tighter font-serif">30K-999.99</p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between text-[11px] uppercase">
                                <span class="text-gray-500">Giá trị niêm yết</span>
                                <span class="text-white">10,000,000 VND</span>
                            </div>
                            <div class="flex justify-between text-[11px] uppercase">
                                <span class="text-gray-500">Tỷ giá quy đổi</span>
                                <span class="text-white">1 USD ≈ 26,000 VND</span>
                            </div>
                            <div class="h-[1px] bg-white/5 my-4"></div>
                            <div class="flex justify-between items-end">
                                <span class="text-xs font-bold uppercase tracking-widest text-[#bf953f]">Tổng cộng (USD)</span>
                                <div class="text-right">
                                    <span id="display-usd" class="text-3xl font-black text-white">0.00</span>
                                    <span class="text-xs text-gray-500 ml-1">USD</span>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="lg:sticky lg:top-24 bg-[#0a0a0a] border border-white/5 p-8 shadow-2xl">
                        <h3 class="text-sm font-bold uppercase tracking-[0.3em] mb-8 border-b border-white/5 pb-4">Đơn hàng của bạn</h3>

                        <div class="bg-white p-4 rounded-sm mb-8 text-center">
                            <p class="text-black text-3xl font-bold tracking-tighter font-serif">
                                <?= htmlspecialchars($plate['plate_number']) ?>
                            </p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between text-[11px] uppercase">
                                <span class="text-gray-500">Giá trị niêm yết</span>
                                <span class="text-white"><?= number_format($price, 0, ',', '.') ?> VND</span>
                            </div>
                            <div class="flex justify-between text-[11px] uppercase">
                                <span class="text-gray-500">Thuế VAT (10%)</span>
                                <span class="text-white"><?= number_format($tax, 0, ',', '.') ?> VND</span>
                            </div>
                            <div class="flex justify-between text-[11px] uppercase">
                                <span class="text-gray-500">Tỷ giá quy đổi</span>
                                <span class="text-white">1 USD ≈ 25,000 VND</span>
                            </div>
                            <div class="h-[1px] bg-white/5 my-4"></div>
                            <div class="flex justify-between items-end">
                                <span class="text-xs font-bold uppercase tracking-widest text-[#bf953f]">Tổng cộng (USD)</span>
                                <div class="text-right">
                                    <span id="display-usd" class="text-3xl font-black text-white">0.00</span>
                                    <span class="text-xs text-gray-500 ml-1">USD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="success-modal" class="fixed inset-0 z-[300] hidden items-center justify-center bg-black/95 backdrop-blur-xl">
        <div class="absolute w-[500px] h-[500px] bg-[#bf953f]/10 rounded-full blur-[120px] animate-pulse"></div>

        <div class="relative z-10 text-center px-6 max-w-2xl">
            <div class="w-24 h-24 border-2 border-[#bf953f] rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                <i class="ri-check-line text-5xl text-[#bf953f]"></i>
            </div>

            <h2 class="text-[10px] text-[#bf953f] font-black uppercase tracking-[0.5em] mb-4">Giao dịch hoàn tất</h2>

            <h1 class="text-3xl md:text-5xl font-black text-white tracking-tighter mb-6 uppercase">
                Chúc mừng chủ nhân mới của <br>
                <span class="gold-text-static text-4xl md:text-6xl">30K-999.99</span>
            </h1>

            <p class="text-gray-400 text-xs leading-relaxed mb-12 max-w-md mx-auto italic">
                Mã định danh của bạn đã được xác lập trên hệ thống. Chuyên viên pháp lý VIP sẽ liên hệ trực tiếp trong ít phút để hoàn tất thủ tục bàn giao tận nơi.
            </p>

            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <button onclick="window.location.href='index.php'" class="px-8 py-4 bg-[#bf953f] text-black font-black text-[10px] uppercase tracking-widest hover:bg-white transition-all">
                    Về trang chủ
                </button>
                <button class="px-8 py-4 border border-white/10 text-white font-black text-[10px] uppercase tracking-widest hover:bg-white/5 transition-all">
                    In hóa đơn điện tử
                </button>
            </div>
        </div>
    </div>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include('footer.php'); ?>
</body>
<script>
    // 1. Lấy tổng tiền từ PHP truyền vào JS (Giá + Thuế)
    const totalPriceVND = <?= $totalPrice ?>;
    const rateUSD = 25000; // Tỷ giá quy đổi cố định
    const totalUSD = (totalPriceVND / rateUSD).toFixed(2);

    // Hiển thị số tiền USD lên giao diện ngay khi load trang
    document.getElementById('display-usd').innerText = totalUSD;

    // 2. Khởi tạo PayPal Buttons
    paypal.Buttons({
        style: {
            layout: 'vertical',
            color: 'gold',
            shape: 'rect',
            label: 'checkout'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: totalUSD
                    },
                    description: "Thanh toán sở hữu biển số: <?= htmlspecialchars($plate['plate_number']) ?>"
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // GỌI API CẬP NHẬT TRẠNG THÁI BIỂN SỐ SANG 'ĐÃ BÁN' (status = 0)
                updatePlateStatus(<?= $plate['plates_id'] ?>);

                // Hiển thị thông báo thành công
                document.querySelector('.checkout-step').classList.add('opacity-0');
                const successOverlay = document.getElementById('success-modal');
                successOverlay.classList.remove('hidden');
                successOverlay.classList.add('flex');
            });
        },
        onCancel: function(data) {
            alert('Giao dịch đã bị hủy. Ngài có thể thử lại bất cứ lúc nào.');
        }
    }).render('#paypal-button-container');

    // Hàm gọi API ẩn (Ngài cần tạo file xử lý này để khóa biển số sau khi khách trả tiền)
    function updatePlateStatus(plateId) {
        fetch('api_update_plate.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: plateId,
                    status: 0
                })
            })
            .then(response => response.json())
            .then(data => console.log('Đã cập nhật trạng thái biển số:', data));
    }
</script>

</html>