<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Set error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');

try {
    // Get JSON data
    $jsonData = file_get_contents('php://input');
    if (!$jsonData) {
        throw new Exception('No data received');
    }

    $data = json_decode($jsonData, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data: ' . json_last_error_msg());
    }

    // Validate required data
    if (empty($data['customer']['name'])) {
        throw new Exception('Customer name is required');
    }

    if (empty($data['items'])) {
        throw new Exception('No items added to proforma');
    }

    // Generate proforma number
    $proformaNumber = 'PRF' . date('Ymd') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

    // Start output buffering
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proforma Invoice #<?= $proformaNumber ?></title>
    <style>
         @page {
            margin: 2.5cm;
        }
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .proforma {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 20px;
        }
        .company-info {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        .invoice-details {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }
        .customer-info, .invoice-info {
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .grand-total {
            font-size: 1.2em;
            font-weight: bold;
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 10px;
        }
        .notes {
            clear: both;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 0.9em;
        }
        .validity {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="proforma">
        <!-- Header -->
        <div class="header">
            <img src="../assets/img/logo.png" alt="Company Logo" class="logo">
            <h1>PROFORMA INVOICE</h1>
        </div>

        <!-- Company Info -->
        <div class="company-info">
            <h2>YOUR COMPANY NAME</h2>
            <p>
                123 Business Street<br>
                City, State, Country<br>
                Phone: +1234567890<br>
                Email: info@yourcompany.com
            </p>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="customer-info">
                <h3>Bill To:</h3>
                <p>
                    <?= htmlspecialchars($data['customer']['name']) ?><br>
                    <?= htmlspecialchars($data['customer']['address']) ?><br>
                    <?php if ($data['customer']['phone']): ?>
                    Phone: <?= htmlspecialchars($data['customer']['phone']) ?><br>
                    <?php endif; ?>
                    <?php if ($data['customer']['email']): ?>
                    Email: <?= htmlspecialchars($data['customer']['email']) ?>
                    <?php endif; ?>
                </p>
            </div>
            <div class="invoice-info">
                <h3>Proforma Details:</h3>
                <p>
                    Number: <?= $proformaNumber ?><br>
                    Date: <?= date('d/m/Y', strtotime($data['created_at'])) ?><br>
                    Valid Until: <?= date('d/m/Y', strtotime($data['created_at'] . " + {$data['validity']} days")) ?>
                </p>
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['items'] as $item): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($item['product_name']) ?><br>
                        <small>Code: <?= htmlspecialchars($item['product_code']) ?></small>
                    </td>
                    <td><?= number_format($item['quantity']) ?></td>
                    <td>₦<?= number_format($item['price'], 2) ?></td>
                    <td>₦<?= number_format($item['total'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>₦<?= number_format($data['totals']['subtotal'], 2) ?></span>
            </div>
            <div class="total-row">
                <span>VAT (7.5%):</span>
                <span>₦<?= number_format($data['totals']['vat'], 2) ?></span>
            </div>
            <div class="total-row grand-total">
                <span>Total:</span>
                <span>₦<?= number_format($data['totals']['total'], 2) ?></span>
            </div>
        </div>

        <!-- Notes -->
        <?php if (!empty($data['notes'])): ?>
        <div class="notes">
            <h3>Notes:</h3>
            <p><?= nl2br(htmlspecialchars($data['notes'])) ?></p>
        </div>
        <?php endif; ?>

        <!-- Validity -->
        <div class="validity">
            <strong>Validity:</strong> This proforma invoice is valid for <?= $data['validity'] ?> days from the date of issue.
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>Generated by <?= htmlspecialchars($data['created_by']) ?> on <?= date('d/m/Y H:i:s', strtotime($data['created_at'])) ?></p>
        </div>
    </div>
</body>
</html>
<?php
    $html = ob_get_clean();
    echo $html;

} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>