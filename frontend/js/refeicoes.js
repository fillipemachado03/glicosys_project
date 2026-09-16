/* GlicoSys - lógica da listagem de Refeições */

document.addEventListener('DOMContentLoaded', function () {
  var usuario = Store.obterUsuarioAtual();
  if (!usuario) return;
  renderizar(usuario);
});

function renderizar(usuario) {
  var refeicoes = Store.obterRefeicoes(usuario.id).slice().sort(Store.compararDataHoraDesc.bind(Store));
  var container = document.getElementById('lista-refeicoes');
  container.innerHTML = '';

  var contagem = { baixa: 0, moderada: 0, alta: 0 };

  if (!refeicoes.length) {
    container.innerHTML = '<p class="subtexto">Nenhuma refeição registrada ainda.</p>';
  }

  refeicoes.forEach(function (r) {
    var cg = Store.calcularCGRefeicao(r);
    var classe = Store.classificarCG(cg);
    contagem[classe.chave]++;

    var classeExtra = classe.chave === 'moderada' ? ' ig-medio' : (classe.chave === 'alta' ? ' ig-alto' : '');
    var potencial = classe.chave === 'baixa' ? 'baixo' : (classe.chave === 'moderada' ? 'moderado' : 'alto');

    var avisoHtml = '';
    if (classe.chave === 'alta') {
      avisoHtml = '<div class="aviso">' +
        '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4M12 17h.01"/></svg>' +
        'Considere alimentos de menor índice glicêmico nesta refeição' +
      '</div>';
    }

    var div = document.createElement('div');
    div.className = 'refeicao-card' + classeExtra;
    div.innerHTML =
      '<div class="refeicao-card-topo">' +
        '<div><div class="titulo">' + r.nome + '</div></div>' +
        '<div>' +
          '<span class="badge ' + classe.classe + '">' + classe.rotulo + ' · ' + cg + '</span>' +
          '<button class="btn-excluir" data-id="' + r.id + '" title="Excluir">' +
            '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>' +
          '</button>' +
        '</div>' +
      '</div>' +
      '<div class="meta">' +
        '<span><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>' + Store.formatarDataBR(r.data) + '</span>' +
        '<span><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>' + (r.hora || '') + '</span>' +
      '</div>' +
      '<div class="descricao">' + (r.descricao || '') + '</div>' +
      '<div class="subtexto">Potencial de elevação glicêmica: ' + potencial + '</div>' +
      (r.observacao ? '<div class="subtexto" style="margin-top:6px;">Obs.: ' + r.observacao + '</div>' : '') +
      avisoHtml;
    container.appendChild(div);
  });

  document.getElementById('resumo-badges').innerHTML =
    '<span class="badge badge-verde">CG baixa: ' + contagem.baixa + '</span>' +
    '<span class="badge badge-laranja">CG moderada: ' + contagem.moderada + '</span>' +
    '<span class="badge badge-vermelho">CG alta: ' + contagem.alta + '</span>';

  Array.prototype.forEach.call(container.querySelectorAll('.btn-excluir'), function (botao) {
    botao.addEventListener('click', function () {
      if (!confirm('Excluir esta refeição?')) return;
      var id = botao.getAttribute('data-id');
      var atualizado = Store.obterRefeicoes(usuario.id).filter(function (r) { return r.id !== id; });
      Store.salvarRefeicoes(usuario.id, atualizado);
      renderizar(usuario);
    });
  });
}
