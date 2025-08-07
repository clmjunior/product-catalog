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
 

document.addEventListener("DOMContentLoaded", function () {
    const menu = document.querySelector("#main-dropdown-menu");
    const submenu = document.getElementById("floating-submenu");
    const trigger = document.querySelector(".more-categories");
    let hideTimeout;

    function showMenu() {
        clearTimeout(hideTimeout);
        menu.style.display = "block";
    }

    function hideMenuWithDelay() {
        hideTimeout = setTimeout(() => {
            if (!menu.matches(':hover') && !submenu.matches(':hover') && !trigger.matches(':hover')) {
                menu.style.display = "none";
                submenu.style.display = "none";
            }
        }, 200);
    }

    // Mostrar menu ao passar o mouse
    trigger.addEventListener("mouseenter", showMenu);
    menu.addEventListener("mouseenter", showMenu);
    submenu.addEventListener("mouseenter", showMenu);

    // Esconder menu ao sair com atraso
    trigger.addEventListener("mouseleave", hideMenuWithDelay);
    menu.addEventListener("mouseleave", hideMenuWithDelay);
    submenu.addEventListener("mouseleave", hideMenuWithDelay);

    // Tratar os submenus dinâmicos
    document.querySelectorAll('.subdropdown-link').forEach(link => {
        link.addEventListener('mouseenter', function () {
            clearTimeout(hideTimeout);
    
            const items = JSON.parse(this.dataset.submenu);
            if (!items || items.length === 0) {
                submenu.style.display = 'none';
                return;
            }
    
            // Popula o submenu
            submenu.innerHTML = '';
            items.forEach(item => {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = `/${item.slug_categoria}`;
                a.textContent = item.categoria;
                li.appendChild(a);
                submenu.appendChild(li);
            });
    
            // Torna o submenu visível para calcular altura
            submenu.style.display = 'block';
            submenu.style.position = 'fixed';
    
            const rect = this.getBoundingClientRect();
            const submenuHeight = submenu.offsetHeight;
            const viewportHeight = window.innerHeight;
    
            // Verifica se há espaço suficiente abaixo
            let top;
            if (rect.top + submenuHeight > viewportHeight) {
                // Sem espaço → abre para cima
                top = rect.bottom - submenuHeight;
            } else {
                // Espaço suficiente → abre para baixo
                top = rect.top;
            }
    
            submenu.style.top = `${top}px`;
            submenu.style.left = `${rect.right}px`;
        });
    });
    
});

