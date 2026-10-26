/* GlicoSys - lógica da listagem de Glicemia */
async function get_glicemia() {
  try {
    const res = await fetch("../../backend/get_glicemia.php", { method: "POST" });
    if (!res.ok) {
      throw new Error(`Erro HTTP: ${res.status}`);
    }

    let glic = await res.text();
console.log(glic);

    return glic;
  } catch (erro) {
    console.log(erro);
  }
}
async function get_glic_target() {
  try {
    const res = await fetch("../../backend/get_glic_target.php", { method: "POST" });
    if (!res.ok) {
      throw new Error(`Erro HTTP: ${res.status}`);
    }
    let Tglic = await res.json();
    return Tglic;
  } catch (erro) {
    console.log(erro);
  }
}

get_glic_target().then(r=>{console.log(r);
   let targetO = {min:r[0].min_meta_glicemica, max:r[0].max_meta_glicemica};
  });

get_glicemia().then(r=>console.log(r));



document.addEventListener('DOMContentLoaded', function () {

async function renderizarTabela(usuario) {
  // var glicemias = await get_glicemia();

  var corpo = document.getElementById('tabela-corpo');

  corpo.innerHTML = '';

  if (await get_glicemia()) {
    corpo.innerHTML = '<tr><td colspan="7" class="subtexto">Nenhuma medição registrada ainda.</td></tr>';
    return;
  }

  let gs = await get_glicemia()

  descendente.forEach(function (g) {
    let status='';
    switch(g.nivel_glicose){
      case g.nivel_glicose > targetO.max && g.nivel_glicose-30 > targetO.max: status='alta'; break;
      case g.nivel_glicose > targetO.max && g.nivel_glicose+30 < targetO.max: status='Elevada' ;break;
      case g.nivel_glicose < targetO.max && g.nivel_glicose > targetO.min: status='No alvo'; break;
      case g.nivel_glicose < targetO.min: status='Baixa'; break;
    }
    
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
}})
