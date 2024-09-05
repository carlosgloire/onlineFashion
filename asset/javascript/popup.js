/*----------------------------------
#Popup
----------------------------------*/
const pop = document.querySelector('.popup');
const deleteBtn = document.querySelectorAll('.delete');
const cancelBtn = document.getElementById('cancelBtn');

let productIdToDelete; // Variable to store the product ID to delete

deleteBtn.forEach(button => {
    button.addEventListener('click', (event) => {
        pop.style.display = 'flex';
        // Retrieve the product ID from the button's data attribute or other source
        productIdToDelete = event.target.dataset.productId;
    });
});

cancelBtn.addEventListener('click', () => {
    pop.style.display = 'none';
});

// Assuming imageID or product ID is retrieved when the delete button is clicked
// Redirect to delete_product.php with the product ID
function redirectToDeletePage() {
    if (productIdToDelete) {
        window.location.href = `../controllers/delete_product.php?product_id=${productIdToDelete}`;
    }
}

cancelBtn.addEventListener('click', redirectToDeletePage);
