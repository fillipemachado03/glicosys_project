
async function get_ref(){
const res = await fetch('../../backend/get_refeicoes
php');
let meals = await res.json();
return JSON.parse(meals);
}

/*
function show_options(ref){
let op ="<option value='null'>nenhum</option>";
forEach(ref=>{
op += "<option value= "+ref.id_refeicoes+">"+ref.nome+"</option>"
});
return op;
}
*/

function get_data(raw){
return raw.split(" ")[0]; 
}
function get_time(raw){
return raw.split(" ")[1];
}

/* GlicoSys - lógica do formulário Registrar Glicemia */

document.addEventListener('DOMContentLoaded', function () {
  var usuario = Store.obterUsuarioAtual();
  if (!usuario) return;

  var seletorRefeicao = document.getElementById('refeicao');
  var refeicoes = get_ref();
  refeicoes.forEach(function (r) {
    var opcao = document.createElement('option');
    opcao.value = r.id_refeicoes;
    opcao.textContent = r.nome + ' · ' + get_data(r.data_horario) + '' + get_time(r
data_horario);
    seletorRefeicao.appendChild(opcao);
  });

  var dataInput = document.getElementById('data');
  if (dataInput && !dataInput.value) dataInput.value = new Date().toISOString().slice(0, 10);

  var form = document.querySelector('.card form');
  form.addEventListener('submit', function (evento) {
    evento.preventDefault();

    var valor = Number(document.getElementById('valor').value);
    var data = document.getElementById('data').value;

    if (!data || !valor) {
      alert('Preencha ao menos a data e o valor da glicemia.');
      return;
    }

    var registro = {
      id: Store.gerarId(),
      data: data,
      hora: document.getElementById('hora').value,
      valor: valor,
      contexto: document.getElementById('contexto').value,
      refeicaoId: seletorRefeicao.value,
      observacao: document.getElementById('observacao').value.trim()
    };

    var lista = Store.obterGlicemias(usuario.id);
    lista.push(registro);
    Store.salvarGlicemias(usuario.id, lista);

    window.location.href = 'glicemia.php';
  });
});
