/* GlicoSys - lógica da listagem de Glicemia */

document.addEventListener('DOMContentLoaded', function () {
  var usuario = Store.obterUsuarioAtual();
  if (!usuario) return;
  renderizarTabela(usuario);
});

function renderizarTabela(usuario) {
  var perfil = Store.obterPerfil(usuario.id);
  var refeicoes = Store.obterRefeicoes(usuario.id);
  var glicemias = Store.obterGlicemias(usuario.id);

  /* calcula a variação (apenas para medições pós-prandiais, contra a medição anterior) */
  var ascendente = glicemias.slice().sort(Store.compararDataHoraAsc.bind(Store));
  var variacoes = {};
  var anterior = null;
  ascendente.forEach(function (g) {
    if (g.contexto === 'pos-prandial' && anterior) {
      variacoes[g.id] = g.valor - anterior.valor;
    }
    anterior = g;
  });

  var descendente = glicemias.slice().sort(Store.compararDataHoraDesc.bind(Store));
  var corpo = document.getElementById('tabela-corpo');
  corpo.innerHTML = '';

  if (!descendente.length) {
    corpo.innerHTML = '<tr><td colspan="7" class="subtexto">Nenhuma medição registrada ainda.</td></tr>';
    return;
  }

  descendente.forEach(function (g) {
    var status = Store.classificarGlicemia(g.valor, perfil);
    var refeicao = null;
    for (var i = 0; i < refeicoes.length; i++) {
      if (refeicoes[i].id === g.refeicaoId) { refeicao = refeicoes[i]; break; }
    }
    var variacao = variacoes[g.id];

    var contextoHtml = Store.rotuloContexto(g.contexto);
    if (refeicao) contextoHtml += '<span class="subtexto">Refeição: ' + refeicao.nome + '</span>';
    if (g.observacao) contextoHtml += '<span class="subtexto">' + g.observacao + '</span>';

    var tr = document.createElement('tr');
    tr.innerHTML =
      '<td>' + Store.formatarDataBR(g.data) + '</td>' +
      '<td>' + (g.hora || '—') + '</td>' +
      '<td><strong>' + g.valor + '</strong></td>' +
      '<td><span class="badge ' + status.classe + '">' + status.rotulo + '</span></td>' +
      '<td>' + contextoHtml + '</td>' +
      '<td>' + (variacao !== undefined ? '<strong>' + (variacao > 0 ? '+' : '') + variacao + '</strong>' : '—') + '</td>' +
      '<td><button class="btn-excluir" data-id="' + g.id + '" title="Excluir">' +
        '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>' +
      '</button></td>';
    corpo.appendChild(tr);
  });

  Array.prototype.forEach.call(corpo.querySelectorAll('.btn-excluir'), function (botao) {
    botao.addEventListener('click', function () {
      if (!confirm('Excluir esta medição de glicemia?')) return;
      var id = botao.getAttribute('data-id');
      var atualizado = Store.obterGlicemias(usuario.id).filter(function (g) { return g.id !== id; });
      Store.salvarGlicemias(usuario.id, atualizado);
      renderizarTabela(usuario);
    });
  });
}
