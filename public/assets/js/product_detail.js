window.addEventListener('scroll', function() {
    var header = document.querySelector('.navbar');

    if (window.scrollY < 60) {
        header.style.backgroundColor = 'rgba(24, 26, 29, 0.8)';
    }
});