window.addEventListener('scroll', function() {
    var header = document.querySelector('.navbar');

    if (window.scrollY < 60) {
        header.style.backgroundColor = 'transparent';
        header.style.padding = '70px 80px 70px 80px';
        header.style.boxShadow = 'none';
    } else if (window.scrollY >= 60 && window.scrollY <= 900) {
        header.style.backgroundColor = 'rgba(24, 26, 29, 0.8)';
        header.style.padding = '40px 80px 40px 80px';
        header.style.boxShadow = '1px 1px 10px #1b1b1b';
    } else if (window.scrollY > 900) {
        header.style.backgroundColor = 'rgba(24, 26, 29)';
    }
});
