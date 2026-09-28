/* ============================================================
   GlicoSys - Bootstrap comum das páginas internas (protegidas)
   Executa guarda de login, preenche o card do paciente na sidebar
   e liga o botão "Sair".
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {
  var usuario = Store.obterUsuarioAtual();

  // if (!usuario) {
  //   window.location.href = 'login.html';
  //   return;
  // }

  var perfil = Store.obterPerfil(usuario.id);

  var nomeEl = document.getElementById('sidebar-nome');
  var infoEl = document.getElementById('sidebar-info');
  if (nomeEl) nomeEl.textContent = perfil.nome || usuario.nome;
  if (infoEl) infoEl.textContent = 'DM ' + (perfil.tipoDM || 'Tipo 1');

  var linkSair = document.getElementById('link-sair');
  if (linkSair) {

// ISSO DA PROBLEMA COM O PHP, NAO RECONHECE E MANDA PRO LOGIN NOVAMENTE


    // linkSair.addEventListener('click', function (evento) {
    //   evento.preventDefault();
    //   Store.encerrarSessao();
    //   // window.location.href = 'login.html';
    // });
  }
});
