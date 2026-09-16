/* GlicoSys - lógica da tela de cadastro */

document.addEventListener('DOMContentLoaded', function () {
  if (Store.obterUsuarioAtual()) {
    window.location.href = 'painel.html';
    return;
  }

  var form = document.querySelector('.auth-card form');
  var botao = form.querySelector('button');

  var erroEl = document.createElement('p');
  erroEl.className = 'erro-auth';
  erroEl.style.color = '#b3261e';
  erroEl.style.fontSize = '13px';
  erroEl.style.marginTop = '-8px';
  erroEl.style.marginBottom = '14px';
  form.insertBefore(erroEl, botao);

  form.addEventListener('submit', function (evento) {
    evento.preventDefault();
    erroEl.textContent = '';

    var nome = document.getElementById('nome').value.trim();
    var email = document.getElementById('email').value.trim();
    var senha = document.getElementById('senha').value;
    var idade = document.getElementById('idade').value;
    var tipoDM = document.getElementById('tipo-dm').value;
    var medico = document.getElementById('medico').value.trim();

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

    Store.criarSessao(usuario.id);
    window.location.href = 'painel.html';
  });
});
