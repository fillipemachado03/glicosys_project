/* GlicoSys - lógica da tela Meu Perfil */

document.addEventListener('DOMContentLoaded', function () {
  var usuario = Store.obterUsuarioAtual();
  if (!usuario) return;

  var perfil = Store.obterPerfil(usuario.id);

  document.getElementById('nome').value = perfil.nome || usuario.nome || '';
  document.getElementById('idade').value = perfil.idade || '';
  document.getElementById('tipo-dm').value = perfil.tipoDM || 'Tipo 1';
  document.getElementById('medico').value = perfil.medico || '';
  document.getElementById('min').value = perfil.metaMin || 70;
  document.getElementById('max').value = perfil.metaMax || 140;

  var form = document.querySelector('.card form');
  form.addEventListener('submit', function (evento) {
    evento.preventDefault();

    var min = Number(document.getElementById('min').value);
    var max = Number(document.getElementById('max').value);

    if (!min || !max || min >= max) {
      alert('A meta glicêmica mínima deve ser menor que a máxima.');
      return;
    }

    var novoPerfil = {
      nome: document.getElementById('nome').value.trim() || usuario.nome,
      idade: Number(document.getElementById('idade').value) || null,
      tipoDM: document.getElementById('tipo-dm').value,
      medico: document.getElementById('medico').value.trim(),
      metaMin: min,
      metaMax: max
    };

    Store.salvarPerfil(usuario.id, novoPerfil);

    var nomeEl = document.getElementById('sidebar-nome');
    var infoEl = document.getElementById('sidebar-info');
    if (nomeEl) nomeEl.textContent = novoPerfil.nome;
    if (infoEl) infoEl.textContent = 'DM ' + novoPerfil.tipoDM;

    alert('Perfil salvo com sucesso.');
  });
});
