document.querySelector('#secao-card').style.display = 'none';

var botaoLogar = document.querySelector('#btn-logar');
botaoLogar.addEventListener("click", function() {

    document.querySelector('#secao-card').style.display = 'block';
    document.querySelector('#secao-carrossel').style.display = 'none';
});