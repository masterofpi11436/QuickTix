// flash-message-expiry.js

document.addEventListener("DOMContentLoaded", function() {
    // Hide the flash message after 5 seconds
    setTimeout(function() {
        var flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.display = 'none';
        }
    }, 5000); // 5000ms = 5 seconds
});
