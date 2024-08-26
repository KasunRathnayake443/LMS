window.addEventListener('load', function() {
    setTimeout(function() {
        const spinner = document.getElementById('spinner');
        spinner.classList.remove('show');
    }, 500); // 500ms = 0.5 seconds
});