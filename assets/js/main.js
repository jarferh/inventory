// Global variables
let currentUser = 'musty131311';
let currentTime = '2025-02-18 18:02:27';

// Update system time
function updateSystemTime() {
    const now = new Date();
    currentTime = now.toISOString().slice(0, 19).replace('T', ' ');
    document.getElementById('currentTime').textContent = currentTime;
}

// Initialize time updates
setInterval(updateSystemTime, 1000);

// Product management functions
function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        $.ajax({
            url: 'ajax/delete_product.php',
            type: 'POST',
            data: { id: id },
            success: function (response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error deleting product');
                }
            },
            error: function () {
                alert('Server error occurred');
            }
        });
    }
}

// Get product details
function getProduct(id) {
    $.ajax({
        url: 'ajax/get_product.php',
        type: 'GET',
        data: { id: id },
        success: function (product) {
            $('#editProductModal').find('input[name="id"]').val(product.id);
            $('#editProductModal').find('input[name="name"]').val(product.name);
            $('#editProductModal').find('input[name="code"]').val(product.code);
            $('#editProductModal').find('textarea[name="description"]').val(product.description);
            $('#editProductModal').find('input[name="quantity"]').val(product.quantity);
            $('#editProductModal').find('input[name="buying_price"]').val(product.buying_price);
            $('#editProductModal').find('input[name="selling_price"]').val(product.selling_price);
            $('#editProductModal').find('input[name="min_stock_level"]').val(product.min_stock_level);
            $('#editProductModal').modal('show');
        },
        error: function () {
            alert('Error fetching product details');
        }
    });
}

// Document ready handlers
$(document).ready(function () {
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Initialize datepicker if exists
    if ($.fn.datepicker) {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    }

    // Add any other initialization code here
});

// Add this to your existing JavaScript or create a new file profile.js
document.addEventListener('DOMContentLoaded', function () {
    // Password validation
    const passwordForm = document.querySelector('form[action="update_password"]');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function (e) {
            const newPass = this.querySelector('[name="new_password"]').value;
            const confirmPass = this.querySelector('[name="confirm_password"]').value;

            if (newPass !== confirmPass) {
                e.preventDefault();
                alert('New passwords do not match');
                return false;
            }

            if (newPass.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long');
                return false;
            }
        });
    }

    // Avatar upload preview
    const avatarInput = document.querySelector('input[name="avatar"]');
    if (avatarInput) {
        avatarInput.addEventListener('change', function (e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const avatar = document.querySelector('.avatar');
                    if (avatar) {
                        avatar.style.backgroundImage = `url(${e.target.result})`;
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
});