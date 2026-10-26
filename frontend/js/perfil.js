/* GlicoSys - lógica da tela Meu Perfil */

async function get_medicos() {
  try {
    const res = await fetch("../../backend/Medicos.php", { method: "POST" });
    if (!res.ok) {
      throw new Error(`Erro HTTP: ${res.status}`);
    }

    let medicos = await res.json();
    console.log(medicos);

    return medicos;
  } catch (erro) {
    console.log(erro);
  }
}

function show_options(med){
let op =[]; 
let o = document.createElement('option');
o.value='null';
o.textContent='nenhum';
op.push(o);
med.forEach(m=>{
let nOp = document.createElement('option')
nOp.value=m.nome;
nOp.textContent=m.nome;
  op.push(nOp);
});
console.log(op)
return op;
}


document.addEventListener('DOMContentLoaded', async function () {
 let medicoCamp = document.querySelector('.medico_camp_div');

let op = await get_medicos().then(med=>show_options(med));
console.log(op);
let sel = document.createElement('select');
sel.id='medico';
sel.name='medico';
op.forEach(O=>{
sel.append(O);
})
medicoCamp.append(sel);
});
