window.addEventListener('scroll', function() {
    var header = document.querySelector('.navbar');

    if (window.scrollY < 60) {
        header.style.backgroundColor = 'transparent';
    } else if (window.scrollY >= 60 && window.scrollY <= 900) {
        header.style.backgroundColor = 'rgba(24, 26, 29, 0.8)';
    } else if (window.scrollY > 900) {
        header.style.backgroundColor = 'rgba(24, 26, 29)';
    }
});