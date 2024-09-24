// Menambahkan event listener untuk tombol select image
document.getElementById('game_image_button').addEventListener('click', function() {
    document.getElementById('game_image').click();
});

// Function to preview the selected image
function previewImage(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Function to add a new item card
function addMoreItem() {
    const itemContainer = document.getElementById('item-container');
    const itemCount = document.querySelectorAll('.item-card').length; // Count current items
    const newItemHTML = `
        <div class="col item-card">
            <div class="detail p-1 my-1">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button type="button" class="close-btn" onclick="removeItem(this)"><i class="fa-regular fa-circle-xmark"></i></button>
                    </div>
                </div>

                <img src="default-icon.png" alt="No Image" class="img-fluid mx-auto my-1" style="max-height: 50px;" id="preview_item_${itemCount}"><br>
                <input type="file" id="preview_icon_${itemCount}" name="item_image[]" accept="image/*" style="display:none;" onchange="previewImage(this, 'preview_item_${itemCount}')">
                <button type="button" class="button text-center text-light" onclick="document.getElementById('preview_icon_${itemCount}').click();">Select Icon</button>
                
                <div class="row text-center">
                    <div class="col">Item</div>
                    <div class="col">Harga</div>
                </div>
                <div class="row">
                    <div class="col text-start form-floating">
                        <input type="text" id="item_name_${itemCount}" name="item_name[]" value="" style="width: 100%;" class="form-control mt-0 py-0">
                    </div>
                    <div class="col text-end form-floating">
                        <input type="number" id="item_price_${itemCount}" name="item_price[]" value="" style="width: 100%;" class="form-control py-0">
                    </div>
                </div>
            </div>
        </div>
    `;
    // Insert new item inside the item container
    itemContainer.insertAdjacentHTML('beforeend', newItemHTML); // Append new item card
    checkCloseButtonVisibility(); // Check visibility of close buttons
}

// Function to remove an item card
function removeItem(button) {
    const card = button.closest('.item-card'); // Find the closest parent card
    card.remove(); // Remove the card
    checkCloseButtonVisibility(); // Check visibility of close buttons
}

// Function to ensure close button is hidden if only one card remains
function checkCloseButtonVisibility() {
    const cards = document.querySelectorAll('.item-card'); // Select all item cards
    cards.forEach(card => {
        const closeButton = card.querySelector('.close-btn');
        if (cards.length === 1) {
            closeButton.style.display = 'none'; // Hide close button if only one card is left
        } else {
            closeButton.style.display = 'block'; // Show close button if more than one card
        }
    });
}

// Call the check visibility function on page load to handle the initial state
document.addEventListener('DOMContentLoaded', function() {
    checkCloseButtonVisibility();
});