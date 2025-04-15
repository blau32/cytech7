document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('.product-detail__comment');
    if (textarea) {
        textarea.style.height = "auto";
        textarea.style.height = (textarea.scrollHeight) + "px";
    }
});
