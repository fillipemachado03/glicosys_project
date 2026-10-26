
async function get_ref(){
  try{
const res = await fetch('http://localhost/glicosys_project/backend/get_refeicoes.php', {
  method: "POST"
})
        if (!res.ok) {
            throw new Error(`Erro HTTP: ${res.status}`);
        }

let meals = await res.json()
return meals;
  }catch(error){console.log(error)}
}
get_ref().then(meals => console.log(meals));

function get_data(raw){
return raw.split(" ")[0]; 
}
function get_time(raw){
return raw.split(" ")[1];
}

/* GlicoSys - lógica do formulário Registrar Glicemia */

document.addEventListener('DOMContentLoaded', async function () {


  var seletorRefeicao = document.getElementById('refeicao');
  var refeicoes = await get_ref();
  refeicoes.forEach(function (r) {
    var opcao = document.createElement('option');
    opcao.value = r.id_refeicoes;
    opcao.textContent = r.titulo + ' · ' + get_data(r.data_horario) + '' + get_time(r.data_horario);
    seletorRefeicao.appendChild(opcao);
  });

  var dataInput = document.getElementById('data');
  if (dataInput && !dataInput.value) dataInput.value = new Date().toISOString().slice(0, 10);

;
});
