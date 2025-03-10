<?php
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Set page variables
$pageTitle = "Proforma Invoice Generator";
$currentPage = "proforma";

// Get database connection
$db = Database::getInstance()->getConnection();

// Fetch all products for the product selector
try {
    $stmt = $db->query("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.status = 'active' 
        ORDER BY p.name
    ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch customers for customer selector
    $stmt = $db->query("SELECT * FROM customers ORDER BY name");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

include 'templates/header.php';
?>

<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Proforma Invoice Generator
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <button type="button" class="btn btn-primary" onclick="generateProforma()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                            <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                        </svg>
                        Generate Proforma
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="proformaForm">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label required">Customer Name</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Validity (Days)</label>
                                        <input type="number" class="form-control" id="validity" name="validity" value="30" min="1">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Items</label>
                                    <div class="table-responsive">
                                        <table class="table " id="itemsTable">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Items will be added here -->
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5">
                                                            <button type="button" class="btn btn-success btn-sm" onclick="addItem()">
                                                                Add Item
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-end">Subtotal:</td>
                                                        <td>₦<span id="subtotal">0.00</span></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-end">VAT (7.5%):</td>
                                                        <td>₦<span id="vat">0.00</span></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-end">Total:</td>
                                                        <td>₦<span id="total">0.00</span></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Proforma Preview Modal -->
<div class="modal modal-blur fade" id="proformaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proforma Invoice Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="proformaPreview">
                <!-- Proforma preview will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printProforma()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                        <rect x="7" y="13" width="10" height="8" rx="2" />
                    </svg>
                    Print Proforma
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Replace the existing JavaScript with this enhanced version
    const CURRENT_TIME = '2025-03-10 15:40:59';
    const CURRENT_USER = 'jarferh';
    const products = <?= json_encode($products) ?>;

    let itemCounter = 0;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize first row
        addItem();

        // Setup real-time calculation listeners
        setupCalculationListeners();
    });

    function setupCalculationListeners() {
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity-input') ||
                e.target.classList.contains('price-input')) {
                calculateRowTotal(e.target.closest('tr'));
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const row = e.target.closest('tr');
                const option = e.target.selectedOptions[0];
                const priceInput = row.querySelector('.price-input');
                const quantityInput = row.querySelector('.quantity-input');

                if (option.dataset.price) {
                    priceInput.value = option.dataset.price;
                    quantityInput.max = option.dataset.available;
                    quantityInput.placeholder = `Max: ${option.dataset.available}`;

                    // Trigger calculation
                    calculateRowTotal(row);
                }
            }
        });
    }

    function addItem() {
        itemCounter++;
        const tbody = document.querySelector('#itemsTable tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
        <td>
            <select class="form-select product-select" id="product_${itemCounter}" required>
                <option value="">Select Product</option>
                ${products.map(p => `
                    <option value="${p.id}" 
                            data-price="${p.selling_price}"
                            data-available="${p.quantity}"
                            data-code="${p.code}">
                        ${p.name} (${p.code})
                    </option>
                `).join('')}
            </select>
        </td>
        <td>
            <input type="number" class="form-control quantity-input" 
                   id="quantity_${itemCounter}" min="1" required>
        </td>
        <td>
            <div class="input-group">
                <span class="input-group-text">₦</span>
                <input type="number" class="form-control price-input" 
                       id="price_${itemCounter}" step="0.01" required>
            </div>
        </td>
        <td class="text-end">₦<span class="row-total">0.00</span></td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </td>
    `;
        tbody.appendChild(row);

        // Initialize new row elements
        const select = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const priceInput = row.querySelector('.price-input');

        // Add event listeners for real-time calculations
        quantityInput.addEventListener('input', function() {
            calculateRowTotal(row);
        });

        priceInput.addEventListener('input', function() {
            calculateRowTotal(row);
        });

        select.addEventListener('change', function() {
            const option = this.selectedOptions[0];
            if (option && option.dataset.price) {
                priceInput.value = option.dataset.price;
                quantityInput.max = option.dataset.available;
                calculateRowTotal(row);
            }
        });
    }

    function removeItem(button) {
        const row = button.closest('tr');
        row.remove();
        calculateTotals();
    }

    function calculateRowTotal(row) {
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const total = quantity * price;

        // Update row total with animation
        const totalSpan = row.querySelector('.row-total');
        const oldTotal = parseFloat(totalSpan.textContent.replace(/,/g, '')) || 0;

        animateNumber(oldTotal, total, 500, function(value) {
            totalSpan.textContent = formatNumber(value);
        });

        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.row-total').forEach(span => {
            subtotal += parseFloat(span.textContent.replace(/,/g, '')) || 0;
        });

        const vat = subtotal * 0.075; // 7.5% VAT
        const total = subtotal + vat;

        // Animate totals
        animateNumber(
            parseFloat(document.getElementById('subtotal').textContent.replace(/,/g, '')) || 0,
            subtotal,
            500,
            value => document.getElementById('subtotal').textContent = formatNumber(value)
        );

        animateNumber(
            parseFloat(document.getElementById('vat').textContent.replace(/,/g, '')) || 0,
            vat,
            500,
            value => document.getElementById('vat').textContent = formatNumber(value)
        );

        animateNumber(
            parseFloat(document.getElementById('total').textContent.replace(/,/g, '')) || 0,
            total,
            500,
            value => document.getElementById('total').textContent = formatNumber(value)
        );
    }

    function animateNumber(start, end, duration, callback) {
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);

            const current = start + (end - start) * progress;
            callback(current);

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    }

    function formatNumber(number) {
        return number.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function generateProforma() {
        // Show loading state
        const generateButton = document.querySelector('button[onclick="generateProforma()"]');
        const originalText = generateButton.innerHTML;
        generateButton.disabled = true;
        generateButton.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Generating...
    `;

        try {
            // Get form elements
            const customerName = document.getElementById('customer_name');
            const customerPhone = document.getElementById('customer_phone');
            const customerEmail = document.getElementById('customer_email');
            const customerAddress = document.getElementById('customer_address');
            const validity = document.getElementById('validity');
            const notes = document.getElementById('notes');

            // Validate required fields
            if (!customerName || !customerName.value.trim()) {
                throw new Error('Customer name is required');
            }

            // Collect data
            const data = {
                customer: {
                    name: customerName.value.trim(),
                    phone: customerPhone ? customerPhone.value.trim() : '',
                    email: customerEmail ? customerEmail.value.trim() : '',
                    address: customerAddress ? customerAddress.value.trim() : ''
                },
                validity: validity ? validity.value : '30',
                notes: notes ? notes.value.trim() : '',
                items: [],
                created_at: '2025-03-10 15:53:39',
                created_by: 'jarferh'
            };

            // Collect items
            const items = document.querySelectorAll('#itemsTable tbody tr');
            if (!items.length) {
                throw new Error('No items added to proforma');
            }

            items.forEach(row => {
                const select = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity-input');
                const priceInput = row.querySelector('.price-input');
                const totalSpan = row.querySelector('.row-total');

                if (select && select.value && quantityInput && priceInput) {
                    const option = select.selectedOptions[0];
                    data.items.push({
                        product_id: select.value,
                        product_name: option.text,
                        product_code: option.dataset.code,
                        quantity: quantityInput.value,
                        price: priceInput.value,
                        total: parseFloat(totalSpan.textContent.replace(/,/g, ''))
                    });
                }
            });

            if (!data.items.length) {
                throw new Error('Please add at least one item');
            }

            // Add totals
            const subtotal = document.getElementById('subtotal');
            const vat = document.getElementById('vat');
            const total = document.getElementById('total');

            data.totals = {
                subtotal: parseFloat(subtotal.textContent.replace(/,/g, '')),
                vat: parseFloat(vat.textContent.replace(/,/g, '')),
                total: parseFloat(total.textContent.replace(/,/g, ''))
            };

            // Generate proforma
            fetch('actions/generate_proforma.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    const previewDiv = document.getElementById('proformaPreview');
                    if (!previewDiv) {
                        throw new Error('Preview container not found');
                    }
                    previewDiv.innerHTML = html;
                    const modal = new bootstrap.Modal(document.getElementById('proformaModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error generating proforma invoice: ' + error.message);
                })
                .finally(() => {
                    // Restore button state
                    generateButton.disabled = false;
                    generateButton.innerHTML = originalText;
                });

        } catch (error) {
            // Handle any errors in the data collection process
            console.error('Error:', error);
            alert(error.message);
            generateButton.disabled = false;
            generateButton.innerHTML = originalText;
        }
    }
</script>

<?php include 'templates/footer.php'; ?>