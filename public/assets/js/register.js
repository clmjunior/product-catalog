document.addEventListener('DOMContentLoaded', function() {

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
                    responseWrap.style.display = 'block';
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
                responseMessage.textContent = 'Erro ao conectar com o servidor.'; 
                console.error('Erro:', error);
            });
        } else {
            responseMessage.textContent = '';
            responseWrap.style.display = 'none';
        }
    });

});