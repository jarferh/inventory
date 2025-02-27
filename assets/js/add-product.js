// System Constants
const SYSTEM = {
    CURRENT_TIME: "2025-02-21 18:44:29",
    CURRENT_USER: "musty131311"
};

$(document).ready(function() {
    // Initialize form validation
    const addProductForm = $('#addProductForm');
    
    // Add Product Button Click Handler
    $('#addProductBtn').on('click', function() {
        $('#addProductModal').modal('show');
    });

    // Form Submission Handler
    addProductForm.on('submit', function(e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        const formData = new FormData(this);
        formData.append('created_at', SYSTEM.CURRENT_TIME);
        formData.append('created_by', SYSTEM.CURRENT_USER);

        $.ajax({
            url: 'api/products/create.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showNotification('success', 'Product added successfully');
                    $('#addProductModal').modal('hide');
                    addProductForm[0].reset();
                    if (typeof refreshProductTable === 'function') {
                        refreshProductTable();
                    }
                } else {
                    showNotification('error', response.message || 'Error adding product');
                }
            },
            error: function(xhr, status, error) {
                showNotification('error', 'Error adding product: ' + error);
            }
        });
    });

    // Generate Product Code
    $('#generateCode').on('click', function() {
        const timestamp = Date.now().toString().slice(-6);
        const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
        $('input[name="code"]').val(`PRD${timestamp}${random}`);
    });

    // Generate Barcode
    $('#generateBarcode').on('click', function() {
        const timestamp = Date.now().toString().slice(-8);
        const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
        $('input[name="barcode"]').val(`${timestamp}${random}`);
    });
});

function showNotification(type, message) {
    const toast = `
        <div class="toast show align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" 
             role="alert" 
             aria-live="assertive" 
             aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        $('body').append('<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3"></div>');
    }
    
    $('#toastContainer').html(toast);
    setTimeout(() => {
        $('.toast').toast('hide');
    }, 5000);
}