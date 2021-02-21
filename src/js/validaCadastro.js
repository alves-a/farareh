export function valida(input) {
    const tipoDeInput = input.dataset.tipo

    if(validadores[tipoDeInput]) {
        validadores[tipoDeInput](input)
    }
}

const validadores = {
    //data de nascimento
    //checa cpf
    cep:input => recuperarCep(input)
}


// Identificacao de erros
const tiposDeErro = [
    'valueMissing',
    'typeMismatch',
    'patternMismatch',
    'customError'
]



// Validando o CEP e preenchendo os campos automaticamente
function recuperarCep(input) {
    const cep = input.value.replace(/\D/g,'')
    const url = `https://viacep.com.br/ws/${cep}/json/`
    const options = {
        method: 'GET',
        mode: 'cors',
        headers: {
            'content-type': 'application/json;charset=utf-8'
        }
    }
        
        if(!input.validity.patternMismatch && !input.validity.valueMissing){
            fetch(url,options).then(
                response => response.json()
            ).then(
                data => {
                    if (data.erro) {
                        input.setCustomValidity('Não foi possível buscar o CEP')
                        return
                    }
                    input.setCustomValidity('')
                    preencheCamposComCep(data)
                    return
                }
            )
        }
}


function preencheCamposComCep(data) {
    const logradouro = document.querySelector('[data-tipo="logradouro"]')
    const cidade = document.querySelector('[data-tipo="cidade"]')
    const estado = document.querySelector('[data-tipo="estado"]')

    logradouro.value = data.logradouro
    cidade.value = data.localidade
    estado.value = data.uf
}