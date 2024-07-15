document.addEventListener('DOMContentLoaded', () => {
    const categoryId = sessionStorage.getItem('categoryId');
    if (categoryId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'processa_categoria.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('category-info').innerHTML = xhr.responseText;
            }
        };
        xhr.send('categoryId=' + categoryId);
    } else {
        document.getElementById('category-info').textContent = 'Nenhum ID de categoria encontrado no sessionStorage';
    }
});