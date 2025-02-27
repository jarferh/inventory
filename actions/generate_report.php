<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Get database connection
$db = Database::getInstance()->getConnection();

$reportType = $_GET['report_type'] ?? 'sales';
$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate = $_GET['end_date'] ?? date('Y-m-d');
$format = $_GET['format'] ?? 'csv';

try {
    switch($reportType) {
        case 'sales':
            $query = "
                SELECT 
                    DATE(s.created_at) as date,
                    s.invoice_number,
                    COALESCE(c.name, 'Walk-in Customer') as customer_name,
                    s.total_amount,
                    s.amount_paid,
                    s.payment_status,
                    COUNT(si.id) as items_count,
                    SUM(si.quantity * (si.selling_price - p.buying_price)) as profit
                FROM sales s
                LEFT JOIN customers c ON s.customer_id = c.id
                LEFT JOIN sale_items si ON s.id = si.sale_id
                LEFT JOIN products p ON si.product_id = p.id
                WHERE DATE(s.created_at) BETWEEN ? AND ?
                GROUP BY s.id
                ORDER BY s.created_at DESC
            ";
            $headers = ['Date', 'Invoice', 'Customer', 'Total Amount', 'Amount Paid', 'Status', 'Items', 'Profit'];
            break;

        case 'inventory':
            $query = "
                SELECT 
                    p.code,
                    p.name,
                    c.name as category_name,
                    p.quantity,
                    p.min_stock_level,
                    p.unit_type,
                    p.buying_price,
                    p.selling_price,
                    (p.quantity * p.buying_price) as stock_value,
                    CASE 
                        WHEN p.quantity <= p.min_stock_level THEN 'Low Stock'
                        WHEN p.quantity = 0 THEN 'Out of Stock'
                        ELSE 'In Stock'
                    END as stock_status
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.quantity <= p.min_stock_level DESC, p.name ASC
            ";
            $headers = ['Code', 'Product', 'Category', 'Quantity', 'Min Level', 'Unit Type', 'Buy Price', 'Sell Price', 'Stock Value', 'Status'];
            break;

        case 'financial':
            $query = "
                SELECT 
                    DATE(s.created_at) as date,
                    COUNT(DISTINCT s.id) as transactions,
                    SUM(s.total_amount) as revenue,
                    SUM(s.amount_paid) as collected,
                    SUM(s.total_amount - s.amount_paid) as pending,
                    SUM(si.quantity * (si.selling_price - p.buying_price)) as gross_profit
                FROM sales s
                LEFT JOIN sale_items si ON s.id = si.sale_id
                LEFT JOIN products p ON si.product_id = p.id
                WHERE DATE(s.created_at) BETWEEN ? AND ?
                GROUP BY DATE(s.created_at)
                ORDER BY date DESC
            ";
            $headers = ['Date', 'Transactions', 'Revenue', 'Collected', 'Pending', 'Gross Profit'];
            break;
    }

    $stmt = $db->prepare($query);
    if ($reportType !== 'inventory') {
        $stmt->execute([$startDate, $endDate]);
    } else {
        $stmt->execute();
    }
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($format === 'csv') {
        // Generate CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="' . $reportType . '_report_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Add UTF-8 BOM for Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Write headers
        fputcsv($output, $headers);
        
        // Write data
        foreach ($data as $row) {
            // Format numbers
            foreach ($row as &$value) {
                if (is_numeric($value)) {
                    $value = number_format($value, 2);
                }
            }
            fputcsv($output, $row);
        }
        
        fclose($output);

    } else {
        // Generate PDF (as HTML that can be printed)
        header('Content-Type: text/html');
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title><?= ucfirst($reportType) ?> Report</title>
            <style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f4f4f4; }
                .header { text-align: center; margin-bottom: 20px; }
                @media print {
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1><?= ucfirst($reportType) ?> Report</h1>
                <p>Period: <?= $startDate ?> to <?= $endDate ?></p>
            </div>

            <div class="no-print">
                <button onclick="window.print()">Print Report</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <?php foreach ($headers as $header): ?>
                        <th><?= htmlspecialchars($header) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                        <td><?= is_numeric($value) ? number_format($value, 2) : htmlspecialchars($value) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <script>
                // Auto-print if opened in new window
                if (window.opener) {
                    window.print();
                }
            </script>
        </body>
        </html>
        <?php
    }

} catch(Exception $e) {
    error_log($e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}