/* GlicoSys - lógica da tela de login */

document.addEventListener('DOMContentLoaded', function () {
  // Se já está logado, vai direto para o painel
  if (Store.obterUsuarioAtual()) {
    window.location.href = 'painel.php';
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

    var email = document.getElementById('email').value.trim();
    var senha = document.getElementById('senha').value;

    if (!email || !senha) {
      erroEl.textContent = 'Preencha e-mail e senha.';
      return;
    }

    var usuario = Store.obterUsuarioPorEmail(email);
    if (!usuario || usuario.senha !== senha) {
      erroEl.textContent = 'E-mail ou senha inválidos.';
      return;
    }

    Store.criarSessao(usuario.id);
    window.location.href = 'painel.php';
  });
});
