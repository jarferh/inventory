<?php
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';
require_once 'vendor/autoload.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Get database connection
$db = Database::getInstance()->getConnection();

// Get sale ID from URL
$saleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // Fetch sale details
    $query = "
        SELECT 
            s.*,
            u.username as created_by_user,
            c.name as customer_name,
            c.phone as customer_phone,
            c.email as customer_email,
            c.address as customer_address
        FROM sales s
        LEFT JOIN users u ON s.created_by = u.id
        LEFT JOIN customers c ON s.customer_id = c.id
        WHERE s.id = ?
    ";
    
    $stmt = $db->prepare($query);
    $stmt->execute([$saleId]);
    $sale = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$sale) {
        throw new Exception('Sale not found');
    }

    // Fetch sale items
    $query = "
        SELECT 
            si.*,
            p.name as product_name,
            p.unit_type
        FROM sale_items si
        JOIN products p ON si.product_id = p.id
        WHERE si.sale_id = ?
    ";
    
    $stmt = $db->prepare($query);
    $stmt->execute([$saleId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('Inventory System');
    $pdf->SetAuthor('Your Company');
    $pdf->SetTitle('Invoice #' . $sale['invoice_number']);

    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Set margins
    $pdf->SetMargins(15, 15, 15);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 15);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', 'B', 20);

    // Title
    $pdf->Cell(0, 15, 'INVOICE', 0, 1, 'C');
    $pdf->SetFont('helvetica', 'B', 15);
    $pdf->Cell(0, 10, '#' . $sale['invoice_number'], 0, 1, 'C');

    // Company Information
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Your Company Name', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 5, "Company Address\nPhone: +123456789\nEmail: contact@company.com", 0, 'L');

    // Invoice Details
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 5, 'Date: ' . date('Y-m-d H:i', strtotime($sale['created_at'])), 0, 1, 'R');

    // Customer Information
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell(0, 7, 'Bill To:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 5, 
        ($sale['customer_name'] ?? 'Walk-in Customer') . "\n" .
        ($sale['customer_address'] ?? '') . "\n" .
        ($sale['customer_phone'] ? 'Phone: ' . $sale['customer_phone'] : '') . "\n" .
        ($sale['customer_email'] ? 'Email: ' . $sale['customer_email'] : ''),
        0, 'L');

    // Items Table
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetFillColor(240, 240, 240);

    // Table Header
    $pdf->Cell(80, 7, 'Product', 1, 0, 'L', true);
    $pdf->Cell(25, 7, 'Quantity', 1, 0, 'R', true);
    $pdf->Cell(35, 7, 'Unit Price', 1, 0, 'R', true);
    $pdf->Cell(35, 7, 'Total', 1, 1, 'R', true);

    // Table Content
    $pdf->SetFont('helvetica', '', 10);
    $subtotal = 0;

    foreach ($items as $item) {
        $total = $item['quantity'] * $item['selling_price'];
        $subtotal += $total;

        $pdf->Cell(80, 7, $item['product_name'], 1, 0, 'L');
        $pdf->Cell(25, 7, $item['quantity'] . ' ' . $item['unit_type'], 1, 0, 'R');
        $pdf->Cell(35, 7, number_format($item['selling_price'], 2), 1, 0, 'R');
        $pdf->Cell(35, 7, number_format($total, 2), 1, 1, 'R');
    }

    // Totals
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(140, 7, 'Subtotal:', 1, 0, 'R');
    $pdf->Cell(35, 7, number_format($subtotal, 2), 1, 1, 'R');
    
    $pdf->Cell(140, 7, 'Tax (0%):', 1, 0, 'R');
    $pdf->Cell(35, 7, '0.00', 1, 1, 'R');
    
    $pdf->Cell(140, 7, 'Total:', 1, 0, 'R');
    $pdf->Cell(35, 7, number_format($sale['total_amount'], 2), 1, 1, 'R');
    
    $pdf->Cell(140, 7, 'Amount Paid:', 1, 0, 'R');
    $pdf->Cell(35, 7, number_format($sale['amount_paid'], 2), 1, 1, 'R');
    
    $balance = $sale['total_amount'] - $sale['amount_paid'];
    $pdf->Cell(140, 7, 'Balance:', 1, 0, 'R');
    $pdf->Cell(35, 7, number_format($balance, 2), 1, 1, 'R');

    // Payment Information
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 7, 'Payment Information:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 7, 'Status: ' . ucfirst($sale['payment_status']), 0, 1, 'L');
    $pdf->Cell(0, 7, 'Method: ' . ucfirst($sale['payment_method']), 0, 1, 'L');

    // Notes
    if (!empty($sale['notes'])) {
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 7, 'Notes:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(0, 5, $sale['notes'], 0, 'L');
    }

    // Footer
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->MultiCell(0, 5, 
        "Thank you for your business!\n" .
        "Terms and Conditions:\n" .
        "1. All prices are in Nigerian Naira (₦)\n" .
        "2. Payment is due upon receipt of invoice\n" .
        "3. Goods once sold cannot be returned",
        0, 'L');

    // Output the PDF
    $pdf->Output('Invoice_' . $sale['invoice_number'] . '.pdf', 'I');

} catch (Exception $e) {
    error_log("PDF Generation Error: " . $e->getMessage());
    header('Location: sales.php?error=Could not generate invoice');
    exit;
}