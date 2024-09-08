window.addEventListener('scroll', function() {
    var header = document.querySelector('.navbar');
    var navBot = document.querySelector('.nav-bot');
    var icons = document.querySelectorAll('.icon-img');
    var iconImg = document.querySelectorAll('.categ-icon');
    var navLogo = document.querySelector('.nav-logo');
    var searchbar = document.querySelector('.search-input');

    if (window.scrollY < 60) {
        header.style.padding = '13px 0';
        header.style.backgroundColor = 'transparent';
        header.style.boxShadow = 'none';
        navLogo.style.width = '300px';
        searchbar.style.width = '600px';
        icons.forEach(icon => icon.style.display = 'block');
        iconImg.forEach(icon => icon.style.display = 'block');
    } else if ((window.scrollY >= 60)) {
        header.style.padding = '10px 0';
        header.style.backgroundColor = '#252525';
        navLogo.style.width = '250px';
        searchbar.style.width = '750px';
        header.style.boxShadow = '1px 1px 10px black';
        icons.forEach(icon => icon.style.display = 'none');
        iconImg.forEach(icon => icon.style.display = 'none');
    } 
});

document.addEventListener("DOMContentLoaded", function() {

    const dropdownToggle = document.getElementById("dropdownMenuButton");
    const dropdownMenu = document.querySelector(".dropdown-menu");

    dropdownToggle.addEventListener("click", function() {
        dropdownMenu.classList.toggle("show");
    });

    window.addEventListener("click", function(event) {
        if (!dropdownToggle.contains(event.target)) {
            dropdownMenu.classList.remove("show");
        }
    });

});

function showMessage() {
    const messageBoxes = document.querySelectorAll('.message-box');

    messageBoxes.forEach(function(messageBox) {
        messageBox.classList.add('show'); 
        setTimeout(function() {
            messageBox.classList.remove('show');
        }, 5000);
    });
}

showMessage();
 
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const navbarMenu = document.querySelector('.navbar-menu');
const closeSidebar = document.querySelector('.close-sidebar');

function showSidebar() {
    sidebar.classList.add('active');
    overlay.classList.add('active');
}

function hideSidebar() {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
}

navbarMenu.addEventListener('click', showSidebar);
closeSidebar.addEventListener('click', hideSidebar);
overlay.addEventListener('click', hideSidebar);