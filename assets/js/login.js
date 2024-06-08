// JavaScript code for modal functionality
// Get the modal
var modal = document.getElementById('loginModal');

// Open the modal
function openModal() {
    modal.style.display = 'block';
}

// Close the modal
function closeModal() {
    modal.style.display = 'none';
}

// Close the modal if clicked outside of it
window.onclick = function(event) {
    if (event.target == modal) {
        closeModal();
    }
}
