// System Constants
const SYSTEM = {
    CURRENT_TIME: "2025-02-21 18:41:50",
    CURRENT_USER: "musty131311"
};

class ProductManager {
    constructor() {
        this.initializeDataTable();
        this.attachEventListeners();
        this.setupAutoRefresh();
    }

    initializeDataTable() {
        this.table = $('#productsTable').DataTable({
            serverSide: true,
            ajax: {
                url: 'api/products/list.php',
                type: 'POST'
            },
            columns: [
                {
                    data: null,
                    render: function(data) {
                        return `
                            <div class="d-flex align-items-center">
                                <div class="product-image me-3">
                                    <img src="${data.image || 'assets/img/default-product.png'}" 
                                         class="rounded" width="48" height="48">
                                </div>
                                <div>
                                    <h6 class="mb-0">${data.name}</h6>
                                    <small class="text-muted">Code: ${data.code}</small>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'category_name',
                    render: function(data) {
                        return `<span class="badge bg-info">${data}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data) {
                        const stockStatus = this.getStockStatus(data.quantity, data.min_stock_level);
                        return `
                            <div>
                                <h6 class="mb-0 ${stockStatus.textClass}">${data.quantity} ${data.unit}</h6>
                                <small class="text-muted">Min: ${data.min_stock_level}</small>
                            </div>
                        `;
                    }.bind(this)
                },
                {
                    data: null,
                    render: function(data) {
                        return `
                            <div>
                                <h6 class="mb-0">₦${parseFloat(data.selling_price).toLocaleString()}</h6>
                                <small class="text-muted">Buy: ₦${parseFloat(data.buying_price).toLocaleString()}</small>
                            </div>
                        `;
                    }
                },
                {
                    data: null,
                    render: function(data) {
                        const stockStatus = this.getStockStatus(data.quantity, data.min_stock_level);
                        return `
                            <span class="badge ${stockStatus.badgeClass}">
                                ${stockStatus.text}
                            </span>
                        `;
                    }.bind(this)
                },
                {
                    data: null,
                    render: function(data) {
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary product-action-btn" 
                                        onclick="productManager.editProduct(${data.id})"
                                        data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-success product-action-btn" 
                                        onclick="productManager.adjustStock(${data.id})"
                                        data-bs-toggle="tooltip" title="Adjust Stock">
                                    <i class="fas fa-box"></i>
                                </button>
                                <button class="btn btn-sm btn-danger product-action-btn" 
                                        onclick="productManager.deleteProduct(${data.id})"
                                        data-bs-toggle="tooltip" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            order: [[0, 'asc']],
            pageLength: 25,
            responsive: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            language: {
                emptyTable: "No products found",
                zeroRecords: "No matching products found"
            },
            drawCallback: function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
    }

    getStockStatus(quantity, minStockLevel) {
        if (quantity <= 0) {
            return {
                text: 'Out of Stock',
                badgeClass: 'bg-danger',
                textClass: 'text-danger'
            };
        } else if (quantity <= minStockLevel) {
            return {
                text: 'Low Stock',
                badgeClass: 'bg-warning',
                textClass: 'text-warning'
            };
        } else {
            return {
                text: 'In Stock',
                badgeClass: 'bg-success',
                textClass: 'text-success'
            };
        }
    }

    attachEventListeners() {
        // Add Product Form Submission
        $('#addProductForm').on('submit', this.handleAddProduct.bind(this));

        // Edit Product Form Submission
        $('#editProductForm').on('submit', this.handleEditProduct.bind(this));

        // Stock Adjustment Form Submission
        $('#adjustStockForm').on('submit', this.handleStockAdjustment.bind(this));

        // Delete Product Confirmation
        $('#deleteProductForm').on('submit', this.handleDeleteProduct.bind(this));

        // Refresh Button
        $('#refreshProducts').on('click', () => this.refreshTable());
    }

    setupAutoRefresh() {
        // Auto refresh table every 5 minutes
        setInterval(() => this.refreshTable(), 300000);
    }

    async handleAddProduct(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);

        try {
            const response = await fetch('api/products/create.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                this.showNotification('success', 'Product added successfully');
                $('#addProductModal').modal('hide');
                this.refreshTable();
                form.reset();
            } else {
                this.showNotification('error', result.message);
            }
        } catch (error) {
            this.showNotification('error', 'Error adding product');
            console.error(error);
        }
    }

    showNotification(type, message) {
        const toast = `
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-${type === 'success' ? 'success' : 'danger'} text-white">
                    <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>
                    <strong class="me-auto">Notification</strong>
                    <small>${SYSTEM.CURRENT_TIME}</small>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;

        const toastContainer = document.getElementById('toastContainer');
        toastContainer.innerHTML = toast;
        
        setTimeout(() => {
            const toastElement = toastContainer.querySelector('.toast');
            if (toastElement) {
                $(toastElement).toast('hide');
            }
        }, 5000);
    }

    refreshTable() {
        this.table.ajax.reload(null, false);
        this.updateDashboardStats();
    }

    updateDashboardStats() {
        fetch('api/products/stats.php')
            .then(response => response.json())
            .then(data => {
                $('#totalProducts').text(data.total);
                $('#lowStockCount').text(data.lowStock);
                $('#outOfStockCount').text(data.outOfStock);
            })
            .catch(error => console.error('Error updating stats:', error));
    }
}

// Initialize Product Manager
const productManager = new ProductManager();