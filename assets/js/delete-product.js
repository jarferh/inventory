document.addEventListener('DOMContentLoaded', function() {
    // Handle Delete Product
    const deleteProductModal = document.getElementById('deleteProductModal');
    if (deleteProductModal) {
        // Set product ID when delete modal opens
        deleteProductModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-product-id');
            document.getElementById('delete_product_id').value = productId;
        });

        // Handle delete form submission
        const deleteForm = document.getElementById('deleteProductForm');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();

                fetch('/inventory/actions/delete_product.php', {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // First close the modal
                    const modal = bootstrap.Modal.getInstance(deleteProductModal);
                    if (modal) {
                        modal.hide();
                    }

                    // Wait for modal to close
                    setTimeout(() => {
                        // Find the container and the first card
                        const container = document.querySelector('.page-body .container-xl');
                        const firstElement = container.firstChild;
                        
                        // Create alert div
                        const alertDiv = document.createElement('div');
                        alertDiv.className = `alert alert-${data.success ? 'success' : 'danger'} alert-dismissible fade show`;
                        alertDiv.innerHTML = `
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;

                        // Insert alert
                        if (firstElement) {
                            container.insertBefore(alertDiv, firstElement);
                        } else {
                            container.appendChild(alertDiv);
                        }

                        // Reload page after delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }, 200); // Wait for modal animation to complete
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Close modal first
                    const modal = bootstrap.Modal.getInstance(deleteProductModal);
                    if (modal) {
                        modal.hide();
                    }

                    // Wait for modal to close
                    setTimeout(() => {
                        // Find the container
                        const container = document.querySelector('.page-body .container-xl');
                        if (!container) return;

                        // Create alert div
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            Error: ${error.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;

                        // Insert at the beginning of the container
                        const firstElement = container.firstChild;
                        if (firstElement) {
                            container.insertBefore(alertDiv, firstElement);
                        } else {
                            container.appendChild(alertDiv);
                        }
                    }, 200);
                });
            });
        }
    }
});
