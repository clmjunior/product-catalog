// document.addEventListener('DOMContentLoaded', () => {
//     const categoryId = sessionStorage.getItem('categoryId');
//     if (categoryId) {
//         const xhr = new XMLHttpRequest();
//         xhr.open('POST', 'processa_categoria.php', true);
//         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//         xhr.onreadystatechange = function () {
//             if (xhr.readyState == 4 && xhr.status == 200) {
//                 document.getElementById('category-info').innerHTML = xhr.responseText;
//             }
//         };
//         xhr.send('categoryId=' + categoryId);
//     } else {
//         document.getElementById('category-info').textContent = 'Nenhum ID de categoria encontrado no sessionStorage';
//     }
// });

window.addEventListener('scroll', function() {
    var header = document.querySelector('.navbar');

    if (window.scrollY < 60) {
        header.style.padding = '70px 80px 70px 80px';
        header.style.boxShadow = 'none';
    } else if (window.scrollY >= 60 && window.scrollY <= 900) {
        header.style.padding = '40px 80px 40px 80px';
        header.style.boxShadow = '1px 1px 10px #eee';

    } 
});
