window.addEventListener('scroll', function() {
    var header = document.querySelector('.navbar');
    var navBot = document.querySelector('.nav-bot');
    var icons = document.querySelectorAll('.icon-img');
    var iconImg = document.querySelectorAll('.categ-icon');
    var navLogo = document.querySelector('.nav-logo');
    var searchbar = document.querySelector('.search-input');

    if (window.scrollY < 60) {
        header.style.padding = '18px 80px 18px 80px';
        navBot.style.height = '90px';
        header.style.boxShadow = 'none';
        navLogo.style.width = '250px';
        searchbar.style.width = '250px';
        icons.forEach(icon => icon.style.display = 'block');
        iconImg.forEach(icon => icon.style.display = 'block');
    } else if (window.scrollY >= 60 && window.scrollY <= 900) {
        header.style.padding = '12px 80px 12px 80px';
        navBot.style.height = '30px';
        navLogo.style.width = '200px';
        searchbar.style.width = '350px';
        header.style.boxShadow = '1px 1px 10px #eee';
        icons.forEach(icon => icon.style.display = 'none');
        iconImg.forEach(icon => icon.style.display = 'none');
    }
});
