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
