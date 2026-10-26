/* GlicoSys - lógica da tela de cadastro */

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
get_medicos().then(r=>console.log(r));


function show_options(med) {
  let op = "<option value='null'>nenhum</option>";
  med.forEach((m) => {
    op += "<option value= " + m.nome + ">" + m.nome + "</option>";
  });
  return op;
}

document.addEventListener("DOMContentLoaded", async function () {

  let op = await get_medicos().then(meds=> show_options(meds));

  var form = document.querySelector(".auth-card form");

  var erroEl = document.querySelector(".erro-auth");
 
  let medico_camp = document.querySelector(".medico_camp_div");

    // let op = show_options(medicos);
    let sel = "<select id= 'medico' name='medico'>" + op + "</select>";
    medico_camp.innerHTML = sel;
});
