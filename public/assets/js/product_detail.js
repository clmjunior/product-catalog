window.addEventListener('scroll', function() {
    var header = document.querySelector('.navbar');

    if (window.scrollY < 60) {
        header.style.backgroundColor = 'rgba(24, 26, 29, 0.8)';
    }
});

$(document).ready(function() {
    $('.img-main').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.img-caroussel'
    });

    $('.img-caroussel').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.img-main',
        dots: true,
        centerMode: true,
        focusOnSelect: true
    });
});
