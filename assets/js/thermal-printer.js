function printThermalReceipt(saleId) {
    // Show loading indicator
    const loadingToast = showNotification('Printing receipt...', 'info');
    
    fetch(`print_invoice.php?id=${saleId}&thermal=true`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification('Receipt printed successfully', 'success');
        } else {
            throw new Error(data.error || 'Unknown printing error');
        }
    })
    .catch(error => {
        console.error('Printing error:', error);
        showNotification(
            'Printing failed: ' + (error.message || 'Unknown error'), 
            'error'
        );
    })
    .finally(() => {
        // Hide loading indicator
        if (loadingToast && loadingToast.remove) {
            loadingToast.remove();
        }
    });
}

function showNotification(message, type = 'info') {
    // Check if Tabler's notification system is available
    if (typeof Notify === 'function') {
        return new Notify({
            status: type,
            title: type === 'error' ? 'Error' : 'Notification',
            text: message,
            effect: 'fade',
            speed: 300,
            customClass: '',
            customIcon: '',
            showIcon: true,
            showCloseButton: true,
            autoclose: true,
            autotimeout: 3000,
            gap: 20,
            distance: 20,
            type: 1,
            position: 'right top'
        });
    } else {
        // Fallback to alert if Notify is not available
        alert(message);
    }
}