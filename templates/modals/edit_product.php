<?php
// Current system values
$CURRENT_TIME = date('Y-m-d H:i:s');
$CURRENT_USER = $_SESSION['username'] ?? "musty131311";
?>
<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Product
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editProductForm" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Hidden ID -->
                        <input type="hidden" name="id" id="edit_product_id">
                        
                        <!-- Product Basic Information -->
                        <div class="col-md-6">
                            <label class="form-label">Product Name *</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Product Code *</label>
                            <input type="text" class="form-control" name="code" id="edit_code" required>
                        </div>

                        <!-- Category and Unit -->
                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select class="form-select" name="category_id" id="edit_category_id" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit *</label>
                            <select class="form-select" name="unit" id="edit_unit" required>
                                <option value="pcs">Pieces</option>
                                <option value="kg">Kilograms</option>
                                <option value="g">Grams</option>
                                <option value="l">Liters</option>
                                <option value="ml">Milliliters</option>
                                <option value="box">Box</option>
                                <option value="pack">Pack</option>
                            </select>
                        </div>

                        <!-- Price Information -->
                        <div class="col-md-6">
                            <label class="form-label">Buying Price (₦) *</label>
                            <div class="input-group">
                                <span class="input-group-text">₦</span>
                                <input type="number" class="form-control" name="buying_price" 
                                       id="edit_buying_price" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Selling Price (₦) *</label>
                            <div class="input-group">
                                <span class="input-group-text">₦</span>
                                <input type="number" class="form-control" name="selling_price" 
                                       id="edit_selling_price" step="0.01" min="0" required>
                            </div>
                        </div>

                        <!-- Stock Information -->
                        <div class="col-md-6">
                            <label class="form-label">Current Stock</label>
                            <input type="number" class="form-control" id="edit_quantity" readonly>
                            <small class="text-muted">Use stock adjustment to change quantity</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Minimum Stock Level *</label>
                            <input type="number" class="form-control" name="min_stock_level" 
                                   id="edit_min_stock_level" min="0" required>
                        </div>

                        <!-- Barcode -->
                        <div class="col-md-12">
                            <label class="form-label">Barcode</label>
                            <input type="text" class="form-control" name="barcode" id="edit_barcode">
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
                        </div>

                        <!-- System Information -->
                        <div class="col-12">
                            <div class="alert alert-info mb-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small>
                                            <strong>Created:</strong> 
                                            <span id="edit_created_at"></span>
                                            by <span id="edit_created_by"></span>
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small>
                                            <strong>Last Update:</strong> 
                                            <?= $CURRENT_TIME ?>
                                            by <?= htmlspecialchars($CURRENT_USER) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="update">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Stock Adjustment Modal -->
<div class="modal fade" id="adjustStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-box me-2"></i>Adjust Stock
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="adjustStockForm" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="adjust_stock">
                    <input type="hidden" name="id" id="adjust_product_id">
                    
                    <div class="mb-3">
                        <h6 id="adjust_product_name" class="fw-bold"></h6>
                        <div class="text-muted" id="adjust_current_stock"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Adjustment Quantity *</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary" onclick="decrementQuantity()">-</button>
                            <input type="number" class="form-control text-center" name="adjustment_quantity" 
                                   id="adjustment_quantity" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="incrementQuantity()">+</button>
                        </div>
                        <small class="text-muted">Use negative values for stock reduction</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reason for Adjustment *</label>
                        <select class="form-select" name="reason" required>
                            <option value="restock">Restock</option>
                            <option value="damage">Damaged/Expired</option>
                            <option value="correction">Inventory Correction</option>
                            <option value="return">Customer Return</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Stock adjustment will be recorded by <?= htmlspecialchars($CURRENT_USER) ?> 
                            at <?= $CURRENT_TIME ?>
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i>Confirm Adjustment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Delete Product
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteProductForm" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="delete_product_id">
                    
                    <p class="mb-3">Are you sure you want to delete this product?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        This action cannot be undone. All related data will be permanently deleted.
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Type DELETE to confirm</label>
                        <input type="text" class="form-control" id="delete_confirmation" 
                               pattern="DELETE" required>
                    </div>

                    <div class="alert alert-info mb-0">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Deletion will be recorded by <?= htmlspecialchars($CURRENT_USER) ?> 
                            at <?= $CURRENT_TIME ?>
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                         ▋