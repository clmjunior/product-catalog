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

window.addEventListener('scroll', function() {
    var header = document.querySelector('.navbar');

    if (window.scrollY < 60) {
        header.style.backgroundColor = 'rgba(24, 26, 29, 0.8)';
    }
});