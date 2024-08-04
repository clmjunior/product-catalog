document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('scroll', function() {
        var header = document.querySelector('.navbar');
        var navBot = document.querySelector('.nav-bot');
        var icons = document.querySelectorAll('.icon-img');
        var iconImg = document.querySelectorAll('.categ-icon');
        var navLogo = document.querySelector('.nav-logo');
        var searchbar = document.querySelector('.search-input');

        if (window.scrollY < 60) {
            header.style.padding = '12px 80px 12px 80px';
            navBot.style.height = '30px';
            navLogo.style.width = '200px';
            searchbar.style.width = '350px';
            header.style.boxShadow = '1px 1px 10px #eee';
            icons.forEach(icon => icon.style.display = 'none');
            iconImg.forEach(icon => icon.style.display = 'none');
        }
    });

    document.getElementById('document').addEventListener('input', function() {
        let documentValue = this.value;
        let responseMessage = document.getElementById('response-message');
        let responseWrap = document.querySelector('.resp-wrap');
        let cnpjData = document.querySelector('.cnpj-data');
        let cpfData = document.querySelector('.cpf-data');

        if (documentValue.length > 0) {
            fetch('check-user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ document: documentValue })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    responseMessage.textContent = data.error;
                    responseWrap.style.display = 'block'; // Mensagem de erro geral
                } else {
                    responseMessage.textContent = ''; 
                    responseWrap.style.display = 'none';
                    if(documentValue.replace(/\D/g, '').length == 14) {
                        console.log(documentValue.replace(/\D/g, ''))
                        cnpjData.style.display = 'block';
                    } else if(documentValue.replace(/\D/g, '').length == 11) {
                        cpfData.style.display = 'block';
                    } else {
                        cpfData.style.display = 'none';
                        cnpjData.style.display = 'none';
                    }

                }
            })
            .catch(error => {
                responseMessage.textContent = 'Erro ao conectar com o servidor.'; // Mensagem de erro geral
                console.error('Erro:', error);
            });
        } else {
            responseMessage.textContent = ''; // Limpa a mensagem se o campo estiver vazio
            responseWrap.style.display = 'none';
        }
    });

});