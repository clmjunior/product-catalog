$(document).ready(function(){
  $('.multiple-items').slick({
      infinite: true,
      arrows: true,
      slidesToShow: 4,
      slidesToScroll: 4,
      dots: true,
      responsive: [{
            breakpoint: 769,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
        }
        }, {
            breakpoint: 501,
            settings: {
                arrows: false,
                slidesToShow: 2,
                slidesToScroll: 2,
    }
        }]
  });
});


document.addEventListener('DOMContentLoaded', () => {
    const imageContainers = document.querySelectorAll('.category');
    imageContainers.forEach(imageContainer => {
        const imageTag = imageContainer.querySelector('.category-img');
        imageContainer.addEventListener('mouseover', () => {
            imageTag.classList.add('zoom-in');
            imageTag.classList.remove('zoom-out');
        });

        imageContainer.addEventListener('mouseout', () => {
            imageTag.classList.remove('zoom-in');
            imageTag.classList.add('zoom-out');
        });
    });
});

function rollToProductsSection() {
    const productsSection = document.getElementById('products-section');

    if (productsSection) {
        productsSection.scrollIntoView({ behavior: 'smooth' });
    }
}
