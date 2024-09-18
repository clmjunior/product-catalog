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

    var ufFilter = document.getElementById('uf-filter');
    var partnerCards = document.querySelectorAll('.partner-card');
    var shownSites = new Set();

    function filterPartners() {
        var selectedUf = ufFilter.value;
        shownSites.clear();

        partnerCards.forEach(function(card) {
            var partnerUf = card.getAttribute('data-uf');
            var partnerSite = card.getAttribute('href');

            if ((selectedUf === '' || partnerUf === selectedUf) && !shownSites.has(partnerSite)) {
            
                card.classList.remove('hidden');
                shownSites.add(partnerSite);
            } else {
            
                card.classList.add('hidden');
            }
        });
    }


    filterPartners();


    ufFilter.addEventListener('change', filterPartners);

});

function rollToProductsSection() {
    const productsSection = document.getElementById('products-section');

    if (productsSection) {
        productsSection.scrollIntoView({ behavior: 'smooth' });
    }
}


