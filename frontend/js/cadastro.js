/* GlicoSys - lógica da tela de cadastro */

async function get_medicos(){
const res = await fetch("../../backend/Medicos.php");
let medicos = await res.json(); 
return JSON.parse(medicos);
}

function show_options(med){
let op ="<option value='null'>nenhum</option>";
forEach(med=>{
op += "<option value= "+med.nome+">"+med.nome+"</option>"
});
return op;
}

document.addEventListener('DOMContentLoaded', function () {
  //if (Store.obterUsuarioAtual()) {
  //  window.location.href = 'painel.php';
 //   return;
 // }

let medicos = get_medicos();

  var form = document.querySelector('.auth-card form');


  var erroEl = document.querySelector('.erro-auth');

  form.addEventListener('submit', function (evento) {
    evento.preventDefault();
    erroEl.textContent = '';

    var nome = document.getElementById('nome').value.trim();
    var email = document.getElementById('email').value.trim();
    var senha = document.getElementById('senha').value;
    var idade = document.getElementById('idade').value;
    var tipoDM = document.getElementById('tipo-dm').value;
    let medico_camp = document.querySelector('.medico_camp_div');

let op = show_option(medicos));
let sel = "<select id= 'medico' name='medico'>"+op+"</select>"
medico_camp.innerHTML=sel;


    if (!nome || !email || !senha) {
      erroEl.textContent = 'Preencha nome, e-mail e senha.';
      return;
    }
    if (senha.length < 6) {
      erroEl.textContent = 'A senha deve ter ao menos 6 caracteres.';
      return;
    }
    if (Store.obterUsuarioPorEmail(email)) {
      erroEl.textContent = 'Já existe uma conta com este e-mail.';
      return;
    }

    var usuario = { id: Store.gerarId(), nome: nome, email: email, senha: senha };
    var usuarios = Store.obterUsuarios();
    usuarios.push(usuario);
    Store.salvarUsuarios(usuarios);

    Store.salvarPerfil(usuario.id, {
      nome: nome,
      idade: Number(idade) || null,
      tipoDM: tipoDM,
      medico: medico,
      metaMin: 70,
      metaMax: 140
    });

    // Toda conta nova entra com dados de exemplo, como avisado na tela de login
    Store.semear(usuario.id);

    // Store.criarSessao(usuario.id);
    // window.location.href = 'painel.php';
  });
});
