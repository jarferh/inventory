<?php
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

class ThermalPrinter {
    private $connector;
    private $printer;
    private $printerType;
    
    public function __construct($config = []) {
        // Load printer configuration
        $this->printerType = $config['printer_type'] ?? 'usb';
        $printerName = $config['printer_name'] ?? 'USB_THERMAL_PRINTER';
        $printerIP = $config['printer_ip'] ?? '192.168.1.100';
        $printerPort = $config['printer_port'] ?? 9100;
        
        try {
            switch ($this->printerType) {
                case 'windows':
                    $this->connector = new WindowsPrintConnector($printerName);
                    break;
                case 'network':
                    $this->connector = new NetworkPrintConnector($printerIP, $printerPort);
                    break;
                case 'usb':
                default:
                    if (PHP_OS_FAMILY === 'Windows') {
                        $this->connector = new WindowsPrintConnector($printerName);
                    } else {
                        $this->connector = new FilePrintConnector("/dev/usb/lp0");
                    }
                    break;
            }
            
            $this->printer = new Printer($this->connector);
        } catch (Exception $e) {
            error_log("Printer Connection Error: " . $e->getMessage());
            throw new Exception("Failed to connect to printer: " . $e->getMessage());
        }
    }
    
    public function printReceipt($sale, $items, $settings) {
        try {
            // Initialize
            $this->printer->initialize();
            
            // Print Logo if exists
            if (!empty($settings['store_logo']) && file_exists($settings['store_logo'])) {
                try {
                    $logo = EscposImage::load($settings['store_logo']);
                    $this->printer->bitImage($logo);
                } catch (Exception $e) {
                    error_log("Logo print error: " . $e->getMessage());
                }
            }
            
            // Print Header
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->setTextSize(2, 2);
            $this->printer->text($settings['store_name'] . "\n");
            $this->printer->setTextSize(1, 1);
            $this->printer->text($settings['store_address'] . "\n");
            $this->printer->text("Tel: " . $settings['store_phone'] . "\n");
            $this->printer->feed();
            
            // Receipt Details
            $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->printer->text("Receipt #: " . $sale['invoice_number'] . "\n");
            $this->printer->text("Date: " . date('Y-m-d H:i', strtotime($sale['created_at'])) . "\n");
            $this->printer->text("Cashier: " . $sale['created_by_user'] . "\n");
            if (!empty($sale['customer_name'])) {
                $this->printer->text("Customer: " . $sale['customer_name'] . "\n");
            }
            $this->printer->feed();
            
            // Items Header
            $this->printer->text(str_repeat("-", 48) . "\n");
            $this->printer->setEmphasis(true);
            $this->printer->text(str_pad("ITEM", 24) . str_pad("QTY", 8) . str_pad("PRICE", 8) . str_pad("TOTAL", 8) . "\n");
            $this->printer->setEmphasis(false);
            $this->printer->text(str_repeat("-", 48) . "\n");
            
            // Items
            foreach ($items as $item) {
                // Item name - wrapped if longer than 24 chars
                $name = wordwrap($item['product_name'], 23, "\n", true);
                $lines = explode("\n", $name);
                
                foreach ($lines as $i => $line) {
                    if ($i === 0) {
                        $this->printer->text(
                            str_pad(substr($line, 0, 23), 24) .
                            str_pad(number_format($item['quantity'], 2), 8) .
                            str_pad(number_format($item['selling_price'], 2), 8) .
                            str_pad(number_format($item['quantity'] * $item['selling_price'], 2), 8) . "\n"
                        );
                    } else {
                        $this->printer->text(str_pad(substr($line, 0, 23), 24) . "\n");
                    }
                }
            }
            
            $this->printer->text(str_repeat("-", 48) . "\n");
            
            // Totals
            $this->printer->setEmphasis(true);
            $this->printer->text(str_pad("Subtotal:", 32) . str_pad(number_format($sale['subtotal'], 2), 16, ' ', STR_PAD_LEFT) . "\n");
            if (!empty($sale['tax_amount']) && $sale['tax_amount'] > 0) {
                $this->printer->text(str_pad("Tax:", 32) . str_pad(number_format($sale['tax_amount'], 2), 16, ' ', STR_PAD_LEFT) . "\n");
            }
            $this->printer->text(str_pad("Total:", 32) . str_pad(number_format($sale['total_amount'], 2), 16, ' ', STR_PAD_LEFT) . "\n");
            $this->printer->text(str_pad("Paid:", 32) . str_pad(number_format($sale['amount_paid'], 2), 16, ' ', STR_PAD_LEFT) . "\n");
            if ($sale['payment_status'] !== 'paid') {
                $this->printer->text(str_pad("Balance:", 32) . str_pad(number_format($sale['total_amount'] - $sale['amount_paid'], 2), 16, ' ', STR_PAD_LEFT) . "\n");
            }
            $this->printer->setEmphasis(false);
            
            // Footer
            $this->printer->feed();
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->text($settings['receipt_thank_you_message'] ?? "Thank you for your business!\n");
            $this->printer->text("Payment Status: " . ucfirst($sale['payment_status']) . "\n");
            $this->printer->text(date('d/m/Y H:i:s') . "\n");
            
            // Cut receipt
            $this->printer->cut();
            
            // Open cash drawer if configured
            if (!empty($settings['open_cash_drawer']) && $settings['open_cash_drawer'] === 'true') {
                $this->printer->pulse();
            }
            
            // Close printer
            $this->printer->close();
            
            return true;
        } catch (Exception $e) {
            error_log("Printer Error: " . $e->getMessage());
            throw new Exception("Printing failed: " . $e->getMessage());
        }
    }
    
    public function __destruct() {
        if ($this->printer !== null) {
            try {
                $this->printer->close();
            } catch (Exception $e) {
                error_log("Printer closing error: " . $e->getMessage());
            }
        }
    }
}