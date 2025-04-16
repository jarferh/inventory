<?php
class ThermalPrinter {
    private $connector;
    private $printer;
    
    public function __construct($printerName = 'USB_THERMAL_PRINTER') {
        // For Windows
        // $this->connector = new WindowsPrintConnector($printerName);
        // For Linux
        $this->connector = new FilePrintConnector("/dev/usb/lp0");
        
        $this->printer = new Printer($this->connector);
    }
    
    public function printReceipt($sale, $items, $settings) {
        try {
            // Initialize
            $this->printer->initialize();
            
            // Print Header
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->setEmphasis(true);
            $this->printer->text($settings['store_name'] . "\n");
            $this->printer->setEmphasis(false);
            $this->printer->text($settings['store_address'] . "\n");
            $this->printer->text("Tel: " . $settings['store_phone'] . "\n");
            $this->printer->feed();
            
            // Receipt Details
            $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->printer->text("Receipt #: " . $sale['invoice_number'] . "\n");
            $this->printer->text("Date: " . date('Y-m-d H:i', strtotime($sale['created_at'])) . "\n");
            $this->printer->text("Cashier: " . $sale['created_by_user'] . "\n");
            $this->printer->feed();
            
            // Items
            $this->printer->text("--------------------------------\n");
            $this->printer->text("ITEM      QTY    PRICE    TOTAL\n");
            $this->printer->text("--------------------------------\n");
            
            foreach ($items as $item) {
                $this->printer->text(
                    str_pad(substr($item['product_name'], 0, 8), 9) .
                    str_pad($item['quantity'], 7) .
                    str_pad($item['selling_price'], 8) .
                    str_pad($item['quantity'] * $item['selling_price'], 8) . "\n"
                );
            }
            
            $this->printer->text("--------------------------------\n");
            
            // Totals
            $this->printer->setEmphasis(true);
            $this->printer->text("Subtotal: " . str_pad($sale['subtotal'], 23) . "\n");
            if ($sale['tax_amount'] > 0) {
                $this->printer->text("Tax: " . str_pad($sale['tax_amount'], 28) . "\n");
            }
            $this->printer->text("Total: " . str_pad($sale['total_amount'], 26) . "\n");
            $this->printer->text("Paid: " . str_pad($sale['amount_paid'], 27) . "\n");
            if ($sale['payment_status'] !== 'paid') {
                $this->printer->text("Balance: " . str_pad($sale['total_amount'] - $sale['amount_paid'], 24) . "\n");
            }
            $this->printer->setEmphasis(false);
            
            // Footer
            $this->printer->feed();
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->text("Thank you for your business!\n");
            $this->printer->text("--------------------------------\n");
            
            // Cut receipt
            $this->printer->cut();
            
            // Close printer
            $this->printer->close();
            
            return true;
        } catch (Exception $e) {
            error_log("Printer Error: " . $e->getMessage());
            return false;
        }
    }
}