<?php
// At the top of the file, after your requires
$CURRENT_TIME = '2025-04-01 13:26:44';
$CURRENT_USER = 'jarferh';

require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Get database connection
$db = Database::getInstance()->getConnection();

// Get sale details
$saleId = $_GET['id'] ?? 0;
$action = $_GET['action'] ?? 'print';

try {
    // Fetch settings
    $stmt = $db->query("SELECT * FROM settings");
    $settings = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }

    // Fetch sale details with items
    $stmt = $db->prepare("
        SELECT s.*, 
               u.username as created_by_user,
               c.name as customer_name,
               c.phone as customer_phone,
               c.email as customer_email
        FROM sales s
        LEFT JOIN users u ON s.created_by = u.id
        LEFT JOIN customers c ON s.customer_id = c.id
        WHERE s.id = ?
    ");
    $stmt->execute([$saleId]);
    $sale = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$sale) {
        throw new Exception("Sale not found");
    }

    // Fetch sale items
    $stmt = $db->prepare("
        SELECT si.*, p.name as product_name, p.code as product_code, p.unit_type
        FROM sale_items si
        JOIN products p ON si.product_id = p.id
        WHERE si.sale_id = ?
    ");
    $stmt->execute([$saleId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Set content type based on action
if ($action === 'download') {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="invoice-' . $sale['invoice_number'] . '.pdf"');
} else {
    header('Content-Type: text/html');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #<?= $sale['invoice_number'] ?></title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            width: 80mm;
            /* Standard thermal paper width */
            background: white;
            font-size: 12px;
            line-height: 1.4;
        }

        .receipt {
            padding: 5px;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .store-name {
            font-size: 16px;
            font-weight: bold;
        }

        .store-info {
            font-size: 10px;
            margin-bottom: 5px;
        }

        .invoice-details {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
            margin: 5px 0;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .items th {
            text-align: left;
            border-bottom: 1px solid #000;
            font-size: 10px;
        }

        .items td {
            font-size: 10px;
            padding: 2px 0;
        }

        .total-section {
            border-top: 1px dashed #000;
            margin-top: 5px;
            padding-top: 5px;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 10px;
        }

        .qr-code {
            text-align: center;
            margin: 10px 0;
        }

        .qr-code img {
            max-width: 100px;
            height: auto;
        }

        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <!-- Logo -->
        <div class="logo">
            <?php if (!empty($settings['store_logo'])): ?>
                <img src="<?= htmlspecialchars($settings['store_logo']) ?>"
                    alt="<?= htmlspecialchars($settings['store_name']) ?>">
            <?php endif; ?>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="store-name"><?= htmlspecialchars($settings['store_name'] ?? 'SAMAHA AGROVET LIMITED') ?></div>
            <div class="store-info">
                <?= htmlspecialchars($settings['store_address'] ?? '') ?><br>
                Tel: <?= htmlspecialchars($settings['store_phone'] ?? '') ?><br>
                <?php if (!empty($settings['store_email'])): ?>
                    Email: <?= htmlspecialchars($settings['store_email']) ?><br>
                <?php endif; ?>
                <?php if (!empty($settings['store_website'])): ?>
                    Web: <?= htmlspecialchars($settings['store_website']) ?><br>
                <?php endif; ?>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div>Receipt #: <?= htmlspecialchars($sale['invoice_number']) ?></div>
            <div>Date: <?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></div>
            <div>Cashier: <?= htmlspecialchars($sale['created_by_user']) ?></div>
            <?php if ($sale['customer_name']): ?>
                <div>Customer: <?= htmlspecialchars($sale['customer_name']) ?></div>
                <?php if ($sale['customer_phone']): ?>
                    <div>Phone: <?= htmlspecialchars($sale['customer_phone']) ?></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Items -->
        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= number_format($item['quantity'], 2) ?>     <?= htmlspecialchars($item['unit_type']) ?></td>
                        <td><?= $settings['currency_symbol'] ?? '₦' ?><?= number_format($item['selling_price'], 2) ?></td>
                        <td><?= $settings['currency_symbol'] ?? '₦' ?><?= number_format($item['quantity'] * $item['selling_price'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="total-section">
            <div class="total-line">
                <span>Subtotal:</span>
                <span><?= $settings['currency_symbol'] ?? '₦' ?><?= number_format($sale['subtotal'] ?? $sale['total_amount'], 2) ?></span>
            </div>
            <?php if (($settings['receipt_show_tax'] ?? 'true') === 'true' && ($sale['tax_amount'] ?? 0) > 0): ?>
                <div class="total-line">
                    <span>Tax (<?= $settings['tax_rate'] ?? '0' ?>%):</span>
                    <span><?= $settings['currency_symbol'] ?? '₦' ?><?= number_format($sale['tax_amount'] ?? 0, 2) ?></span>
                </div>
            <?php endif; ?>
            <div class="total-line" style="font-weight: bold;">
                <span>Total:</span>
                <span><?= $settings['currency_symbol'] ?? '₦' ?><?= number_format($sale['total_amount'], 2) ?></span>
            </div>
            <div class="total-line">
                <span>Amount Paid:</span>
                <span><?= $settings['currency_symbol'] ?? '₦' ?><?= number_format($sale['amount_paid'], 2) ?></span>
            </div>
            <?php if ($sale['payment_status'] !== 'paid'): ?>
                <div class="total-line">
                    <span>Balance:</span>
                    <span><?= $settings['currency_symbol'] ?? '₦' ?><?= number_format($sale['total_amount'] - $sale['amount_paid'], 2) ?></span>
                </div>
            <?php endif; ?>
        </div>

        <!-- QR Code -->
        <?php if (($settings['receipt_show_qr'] ?? 'true') === 'true'): ?>
            <div class="qr-code">
                <?php
                $qrData = json_encode([
                    'invoice' => $sale['invoice_number'],
                    'amount' => $sale['total_amount'],
                    'date' => $sale['created_at'],
                    'store' => $settings['store_name'] ?? '',
                    'printed_at' => $CURRENT_TIME,
                    'printed_by' => $CURRENT_USER
                ]);
                ?>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= urlencode($qrData) ?>"
                    alt="QR Code">
            </div>
        <?php endif; ?>

        <!-- Footer -->
        <div class="footer">
            <p><?= htmlspecialchars($settings['receipt_thank_you_message'] ?? 'Thank you for your business!') ?></p>
            <p>Payment Status: <?= ucfirst($sale['payment_status']) ?></p>
            <p>Printed: <?= date('d/m/Y H:i:s', strtotime($CURRENT_TIME)) ?></p>
            <p>Printed by: <?= htmlspecialchars($sale['created_by_user']) ?></p>
            <p><?= htmlspecialchars($settings['receipt_footer_message'] ?? 'Powered by ' . ($settings['store_name'] ?? 'Your Store Name')) ?>
            </p>
        </div>
    </div>

    <!-- Print Button (hidden when printing) -->
    <div class="no-print" style="text-align: center; margin: 20px;">
        <button onclick="window.print()">Print Receipt</button>
        <button onclick="window.location.href='sales.php'">Back to Sales</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-print if in print mode
            if ('<?= $action ?>' === 'print') {
                window.print();
            }
        });
    </script>
</body>

</html>