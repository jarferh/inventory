<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Add New Product
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addProductForm" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Product Basic Information -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Product Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="name" required>
                            <div class="invalid-feedback">
                                Please provide a product name
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Product Code <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="code" required>
                                <button type="button" class="btn btn-outline-secondary" id="generateCode">
                                    <i class="fas fa-random"></i>
                                </button>
                                <div class="invalid-feedback">
                                    Please provide a product code
                                </div>
                            </div>
                        </div>

                        <!-- Category and Unit -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="category_id" required>
                                <option value="">Select Category</option>
                                <option value="1">Electronics</option>
                                <option value="2">Clothing</option>
                                <option value="3">Food & Beverages</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a category
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Unit <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="unit" required>
                                <option value="pcs">Pieces</option>
                                <option value="kg">Kilograms</option>
                                <option value="l">Liters</option>
                                <option value="box">Box</option>
                                <option value="pack">Pack</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a unit
                            </div>
                        </div>

                        <!-- Price Information -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Buying Price (₦) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">₦</span>
                                <input type="number" class="form-control" name="buying_price" 
                                       step="0.01" min="0" required>
                                <div class="invalid-feedback">
                                    Please provide a valid buying price
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Selling Price (₦) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">₦</span>
                                <input type="number" class="form-control" name="selling_price" 
                                       step="0.01" min="0" required>
                                <div class="invalid-feedback">
                                    Please provide a valid selling price
                                </div>
                            </div>
                        </div>

                        <!-- Stock Information -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Initial Stock Quantity <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" name="quantity" 
                                   min="0" required>
                            <div class="invalid-feedback">
                                Please provide initial stock quantity
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Minimum Stock Level <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" name="min_stock_level" 
                                   min="0" required>
                            <div class="invalid-feedback">
                                Please provide minimum stock level
                            </div>
                        </div>

                        <!-- Barcode -->
                        <div class="col-md-12">
                            <label class="form-label">Barcode</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="barcode">
                                <button type="button" class="btn btn-outline-secondary" id="generateBarcode">
                                    <i class="fas fa-barcode"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>

                        <!-- System Information -->
                        <div class="col-12">
                            <div class="alert alert-info mb-0">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Product will be created by <?= htmlspecialchars($CURRENT_USER) ?> 
                                    at <?= $CURRENT_TIME ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Add Product -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addProductForm = document.getElementById('addProductForm');
    const CURRENT_TIME = "2025-02-21 18:36:11";
    const CURRENT_USER = "musty131311";

    // Form Validation
    addProductForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        if (!addProductForm.checkValidity()) {
            event.stopPropagation();
            addProductForm.classList.add('was-validated');
            return;
        }

        // Collect form data
        const formData = new FormData(addProductForm);
        formData.append('created_at', CURRENT_TIME);
        formData.append('created_by', CURRENT_USER);

        // Submit form via AJAX
        fetch('api/products/create.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('success', 'Product added successfully');
                $('#addProductModal').modal('hide');
                refreshProductsList();
            } else {
                showNotification('error', data.message);
            }
        })
        .catch(error => {
            showNotification('error', 'An error occurred while adding the product');
        });
    });

    // Generate Product Code
    document.getElementById('generateCode').addEventListener('click', function() {
        const timestamp = Date.now().toString().slice(-6);
        const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
        document.querySelector('input[name="code"]').value = `PRD${timestamp}${random}`;
    });

    // Generate Barcode
    document.getElementById('generateBarcode').addEventListener('click', function() {
        const timestamp = Date.now().toString().slice(-8);
        const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
        document.querySelector('input[name="barcode"]').value = `${timestamp}${random}`;
    });
});

// Notification System
function showNotification(type, message) {
    const toastContainer = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.classList.add('toast', 'show', `bg-${type === 'success' ? 'success' : 'danger'}`, 'text-white');
    toast.innerHTML = `
        <div class="toast-header">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            ${message}
        </div>
    `;
    toastContainer.appendChild(toast);
    setTimeout(() => toast.remove(), 5000);
}
</script>