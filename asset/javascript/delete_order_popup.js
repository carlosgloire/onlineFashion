/*----------------------------------
#Popup delete shoe
----------------------------------*/
const deleteButtons = document.querySelectorAll('.delete');
const popup = document.querySelector('.popup');
const cancelPopupButton = document.querySelector('.cancel-popup');
const deletePopupButton = document.querySelector('.delete-popup');
let orderToDelete = null;

deleteButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        orderToDelete = this.getAttribute('data-order-item-id');

        // Show the popup
        popup.classList.remove('hidden-popup');
    });
});

// Cancel deletion
cancelPopupButton.addEventListener('click', function() {
    // Hide the popup
    popup.classList.add('hidden-popup');
    orderToDelete = null; // Reset the orderToDelete variable
});

// Confirm deletion
deletePopupButton.addEventListener('click', function() {
    if (orderToDelete) {
        // Redirect to the delete page with the order item ID
        window.location.href = `../../onlineFashion/controllers/delete_order.php?order_item_id=${orderToDelete}`;
    }
});
