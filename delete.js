document.addEventListener('DOMContentLoaded', () => {
    // Event listener for clicks on the 'order_items' tbody
    // We use event delegation here because delete buttons are added dynamically
    document.getElementById('order_items').addEventListener('click', async function(event) {
        // Check if the clicked element has the 'delete-btn' class
        if (event.target.classList.contains('delete-btn')) {
            const orderId = event.target.dataset.orderId; // Get the order ID from the button's data-order-id attribute

            // Confirmation dialog
            if (confirm(`Are you sure you want to delete order ID ${orderId}?`)) {
                try {
                    // Send a POST request to your delete_order.php script
                    const response = await fetch('delete_order.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json' // Tell the server we're sending JSON
                        },
                        body: JSON.stringify({ order_id: orderId }) // Send the orderId as a JSON object
                    });

                    // Check if the network request was successful
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json(); // Parse the JSON response from the server

                    if (result.success) {
                        alert(result.message); // Show success message
                        // Re-fetch and re-render the orders table to show the deletion
                        // Ensure loadData is globally accessible or passed as context
                        if (typeof loadData === 'function') {
                            loadData();
                        } else {
                            console.error("loadData function not found. Cannot refresh table.");
                            // You might need to refresh manually or implement a local removal if loadData isn't global
                            event.target.closest('tr').remove(); // Remove the row directly for immediate feedback
                        }
                    } else {
                        alert('Failed to delete order: ' + result.message); // Show error message from server
                    }
                } catch (error) {
                    console.error('Network or parsing error:', error);
                    alert('An error occurred while deleting the order: ' + error.message);
                }
            }
        }
    });
});