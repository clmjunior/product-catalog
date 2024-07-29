window.addEventListener('scroll', function() {
    var header = document.querySelector('.navbar');
    var navBot = document.querySelector('.nav-bot');
    var icons = document.querySelectorAll('.icon-img');
    var iconImg = document.querySelectorAll('.categ-icon');

    if (window.scrollY < 60) {
        header.style.padding = '18px 80px 18px 80px';
        navBot.style.height = '90px';
        header.style.boxShadow = 'none';
        icons.forEach(icon => icon.style.display = 'block');
        iconImg.forEach(icon => icon.style.display = 'block');
    } else if (window.scrollY >= 60 && window.scrollY <= 900) {
        header.style.padding = '12px 80px 12px 80px';
        navBot.style.height = '30px';
        header.style.boxShadow = '1px 1px 10px #eee';
        icons.forEach(icon => icon.style.display = 'none');
        iconImg.forEach(icon => icon.style.display = 'none');
    }
});
