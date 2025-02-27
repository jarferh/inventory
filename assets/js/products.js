// System Constants
const SYSTEM = {
    CURRENT_TIME: "2025-02-18 20:02:41",
    CURRENT_USER: "musty131311"
};

// DataTable Configuration
$(document).ready(function() {
    const productsTable = $('#productsTable').DataTable({
        pageLength: 25,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'excel',
                title: `Product_Inventory_${SYSTEM.CURRENT_TIME.replace(/[: ]/g, '_')}`,
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdf',
                title: `Product_Inventory_${SYSTEM.CURRENT_TIME.replace(/[: ]/g, '_')}`,
                className: 'btn btn-danger',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            }
        ]
    });

    // Initialize select2 for dropdowns
    $('.form-select').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
});

// Product Form Handling
function handleProductForm(formId, action) {
    $(`#${formId}`).submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('timestamp', SYSTEM.CURRENT_TIME);
        formData.append('user', SYSTEM.CURRENT_USER);

        $.ajax({
            url: 'ajax/handle_product.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showNotification('success', response.message);
                    $(`#${formId}`).closest('.modal').modal('hide');
                    reloadProductsTable();
                } else {
                    showNotification('error', response.message);
                }
            },
            error: function() {
                showNotification('error', 'An error occurred while processing your request.');
            }
        });
    });
}

// Edit Product
function editProduct(productId) {
    $.ajax({
        url: 'ajax/get_product.php',
        type: 'GET',
        data: { id: productId },
        success: function(product) {
            // Populate form fields
            $('#edit_product_id').val(product.id);
            $('#edit_name').val(product.name);
            $('#edit_code').val(product.code);
            $('#edit_category_id').val(product.category_id).trigger('change');
            $('#edit_unit').val(product.unit);
            $('#edit_buying_price').val(product.buying_price);
            $('#edit_selling_price').val(product.selling_price);
            $('#edit_quantity').val(product.quantity);
            $('#edit_min_stock_level').val(product.min_stock_level);
            $('#edit_barcode').val(product.barcode);
            $('#edit_description').val(product.description);
            
            // Set creation info
            $('#edit_created_at').text(product.created_at);
            $('#edit_created_by').text(product.created_by);
            
            // Show modal
            $('#editProductModal').modal('show');
        },
        error: function() {
            showNotification('error', 'Failed to load product details.');
        }
    });
}

// Stock Adjustment
function adjustStock(productId) {
    $.ajax({
        url: 'ajax/get_product.php',
        type: 'GET',
        data: { id: productId },
        success: function(product) {
            $('#adjust_product_id').val(product.id);
            $('#adjust_product_name').text(product.name);
            $('#adjust_current_stock').text(
                `Current Stock: ${product.quantity} ${product.unit}`
            );
            $('#adjustment_quantity').val('');
            $('#adjustStockModal').modal('show');
        },
        error: function() {
            showNotification('error', 'Failed to load product details.');
        }
    });
}

// Delete Product
function deleteProduct(productId) {
    $.ajax({
        url: 'ajax/get_product.php',
        type: 'GET',
        data: { id: productId },
        success: function(product) {
            $('#delete_product_id').val(product.id);
            $('#deleteProductModal').modal('show');
        }
    });
}

// Utility Functions
function generateProductCode() {
    const timestamp = Date.now().toString().slice(-6);
    const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    const code = `PRD${timestamp}${random}`;
    $('input[name="code"]').val(code);
}

function generateBarcode() {
    const timestamp = Date.now().toString().slice(-8);
    const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
    const barcode = `${timestamp}${random}`;
    $('input[name="barcode"]').val(barcode);
}

function incrementQuantity() {
    const input = document.getElementById('adjustment_quantity');
    input.value = (parseInt(input.value || 0) + 1).toString();
}

function decrementQuantity() {
    const input = document.getElementById('adjustment_quantity');
    input.value = (parseInt(input.value || 0) - 1).toString();
}

// Notification System
function showNotification(type, message) {
    const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
    const alertClass = type === 'success' ? 'success' : 'danger';
    
    const alert = `
        <div class="alert alert-${alertClass} alert-dismissible fade show" role="alert">
            <i class="fas fa-${icon} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('#alertContainer').html(alert);
    setTimeout(() => {
        $('.alert').alert('close');
    }, 5000);
}

// Table Operations
function reloadProductsTable() {
    $('#productsTable').DataTable().ajax.reload();
}

// Real-time Stock Monitoring
function checkLowStock() {
    $.ajax({
        url: 'ajax/check_low_stock.php',
        type: 'GET',
        success: function(response) {
            if (response.low_stock_items.length > 0) {
                showLowStockAlert(response.low_stock_items);
            }
        }
    });
}

function showLowStockAlert(items) {
    const alertHtml = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h6 class="alert-heading mb-1">
                <i class="fas fa-exclamation-triangle me-2"></i>Low Stock Alert
            </h6>
            <ul class="mb-0 ps-3">
                ${items.map(item => `
                    <li>${item.name} - ${item.quantity} ${item.unit} remaining
                        (Min: ${item.min_stock_level})
                    </li>
                `).join('')}
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('#lowStockAlertContainer').html(alertHtml);
}

// Initialize Components
$(document).ready(function() {
    // Initialize form handlers
    handleProductForm('addProductForm', 'create');
    handleProductForm('editProductForm', 'update');
    handleProductForm('adjustStockForm', 'adjust_stock');
    
    // Start low stock monitoring
    checkLowStock();
    setInterval(checkLowStock, 300000); // Check every 5 minutes
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Update time display
    setInterval(() => {
        const now = new Date(SYSTEM.CURRENT_TIME);
        now.setSeconds(now.getSeconds() + 1);
        SYSTEM.CURRENT_TIME = now.toISOString().slice(0, 19).replace('T', ' ');
        $('#currentTimeDisplay').text( ▋