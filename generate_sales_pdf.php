<?php
ob_start(); // Start output buffering
session_start(); // Start session if not already started

// Check for any output or errors before including files
if (ob_get_length()) ob_clean();

require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';
require_once 'vendor/autoload.php'; // For TCPDF

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Get database connection
$db = Database::getInstance()->getConnection();

if (!isset($_POST['sale_id'])) {
    die('Sale ID is required');
}

try {
    // Get company settings
    $stmt = $db->query("SELECT * FROM settings WHERE is_active = 1");
    $settings = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }

    // Fetch sale details with customer and user information
    $stmt = $db->prepare("
        SELECT s.*, 
               c.name as customer_name,
               c.phone as customer_phone,
               c.email as customer_email,
               u.full_name as created_by_name
        FROM sales s
        LEFT JOIN customers c ON s.customer_id = c.id
        LEFT JOIN users u ON s.created_by = u.id
        WHERE s.id = ?
    ");
    $stmt->execute([$_POST['sale_id']]);
    $sale = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$sale) {
        die('Sale not found');
    }

    // Fetch sale items with product details
    $stmt = $db->prepare("
        SELECT si.*, p.name as product_name, p.code as product_code,
               p.unit_type, si.quantity * si.selling_price as total_price
        FROM sale_items si
        JOIN products p ON si.product_id = p.id
        WHERE si.sale_id = ?
    ");
    $stmt->execute([$_POST['sale_id']]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Create new PDF document
    $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor($settings['company_name'] ?? 'Company Name');
    $pdf->SetTitle('Sales Invoice #' . $sale['invoice_number']);

    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Set margins
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(TRUE, 15);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', 'B', 16);

    // Company Logo (if exists)
    $logoPath = __DIR__ . '/assets/img/logo.png';
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 15, 15, 30);
        $pdf->Cell(0, 30, '', 0, 1); // Space after logo
    }

    // Company Details
    $pdf->Cell(0, 10, $settings['company_name'] ?? 'Company Name', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 6, $settings['company_address'] ?? '', 0, 1, 'C');
    $pdf->Cell(0, 6, 'Phone: ' . ($settings['contact_phone'] ?? ''), 0, 1, 'C');
    $pdf->Cell(0, 6, 'Email: ' . ($settings['contact_email'] ?? ''), 0, 1, 'C');
    $pdf->Ln(10);

    // Invoice Title
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'SALES INVOICE', 0, 1, 'C');
    $pdf->Ln(5);

    // Invoice & Customer Details
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(95, 6, 'Invoice Number: ' . $sale['invoice_number'], 0, 0);
    $pdf->Cell(95, 6, 'Date: ' . date('Y-m-d H:i', strtotime($sale['created_at'])), 0, 1);
    
    $pdf->Cell(95, 6, 'Customer: ' . ($sale['customer_name'] ?? 'Walk-in Customer'), 0, 0);
    $pdf->Cell(95, 6, 'Payment Status: ' . ucfirst($sale['payment_status']), 0, 1);
    
    if ($sale['customer_phone']) {
        $pdf->Cell(95, 6, 'Phone: ' . $sale['customer_phone'], 0, 1);
    }
    $pdf->Ln(5);

    // Items Table Header
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(15, 8, 'S/N', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Code', 1, 0, 'C', true);
    $pdf->Cell(60, 8, 'Product', 1, 0, 'L', true);
    $pdf->Cell(25, 8, 'Quantity', 1, 0, 'R', true);
    $pdf->Cell(30, 8, 'Unit Price', 1, 0, 'R', true);
    $pdf->Cell(30, 8, 'Total', 1, 1, 'R', true);

    // Items Table Content
    $pdf->SetFont('helvetica', '', 10);
    $total = 0;
    foreach ($items as $i => $item) {
        $pdf->Cell(15, 7, $i + 1, 1, 0, 'C');
        $pdf->Cell(30, 7, $item['product_code'], 1, 0, 'C');
        $pdf->Cell(60, 7, $item['product_name'], 1, 0, 'L');
        $pdf->Cell(25, 7, $item['quantity'] . ' ' . $item['unit_type'], 1, 0, 'R');
        $pdf->Cell(30, 7, number_format($item['selling_price'], 2), 1, 0, 'R');
        $pdf->Cell(30, 7, number_format($item['total_price'], 2), 1, 1, 'R');
        $total += $item['total_price'];
    }

    // Totals
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(160, 7, 'Total Amount:', 1, 0, 'R');
    $pdf->Cell(30, 7, number_format($total, 2), 1, 1, 'R');
    $pdf->Cell(160, 7, 'Amount Paid:', 1, 0, 'R');
    $pdf->Cell(30, 7, number_format($sale['amount_paid'], 2), 1, 1, 'R');
    $pdf->Cell(160, 7, 'Balance:', 1, 0, 'R');
    $pdf->Cell(30, 7, number_format($total - $sale['amount_paid'], 2), 1, 1, 'R');

    // Additional Information
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 6, 'Payment Method: ' . ucfirst($sale['payment_method']), 0, 1);
    $pdf->Cell(0, 6, 'Created By: ' . $sale['created_by_name'], 0, 1);
    
    if ($sale['notes']) {
        $pdf->Ln(5);
        $pdf->Cell(0, 6, 'Notes:', 0, 1);
        $pdf->MultiCell(0, 6, $sale['notes'], 0, 'L');
    }

    // Terms & Conditions (optional)
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 6, 'Terms & Conditions:', 0, 1);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->MultiCell(0, 5, "1. All prices include VAT where applicable.\n2. Goods once sold cannot be returned.\n3. This is a computer generated invoice.", 0, 'L');

    // Clear any output buffers
    if (ob_get_length()) ob_clean();

    // Output PDF
    $pdf->Output('Sale_' . $sale['invoice_number'] . '.pdf', 'D');
    exit;

} catch (Exception $e) {
    if (ob_get_length()) ob_clean();
    die('Error generating PDF: ' . $e->getMessage());
}