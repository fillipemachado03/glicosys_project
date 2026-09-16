/* GlicoSys - lógica do Painel (dashboard) */

document.addEventListener('DOMContentLoaded', function () {
  var usuario = Store.obterUsuarioAtual();
  if (!usuario) return;

  var perfil = Store.obterPerfil(usuario.id);
  var glicemias = Store.obterGlicemias(usuario.id).slice().sort(Store.compararDataHoraDesc.bind(Store));
  var refeicoes = Store.obterRefeicoes(usuario.id).slice().sort(Store.compararDataHoraDesc.bind(Store));

  var primeiroNome = (perfil.nome || usuario.nome || '').split(' ')[0];
  document.getElementById('saudacao').textContent = 'Olá, ' + primeiroNome;
  document.getElementById('meta-texto').textContent =
    'Diabetes ' + (perfil.tipoDM || 'Tipo 1') + ' · Meta glicêmica: ' + perfil.metaMin + '–' + perfil.metaMax + ' mg/dL';

  /* ----- KPI: última glicemia ----- */
  var elUltimaValor = document.getElementById('kpi-ultima-valor');
  var elUltimaLegenda = document.getElementById('kpi-ultima-legenda');
  if (glicemias.length) {
    var ultima = glicemias[0];
    elUltimaValor.innerHTML = ultima.valor + ' <span>mg/dL</span>';
    elUltimaLegenda.textContent = Store.rotuloContexto(ultima.contexto).toLowerCase() + ' · ' + Store.formatarDataBR(ultima.data);
  } else {
    elUltimaValor.textContent = '—';
    elUltimaLegenda.textContent = 'Nenhum registro ainda';
  }

  /* ----- KPI: média glicêmica ----- */
  var elMediaValor = document.getElementById('kpi-media-valor');
  var elMediaLegenda = document.getElementById('kpi-media-legenda');
  if (glicemias.length) {
    var soma = glicemias.reduce(function (acc, g) { return acc + Number(g.valor); }, 0);
    var media = Math.round(soma / glicemias.length);
    elMediaValor.innerHTML = media + ' <span>mg/dL</span>';
    elMediaLegenda.textContent = glicemias.length + (glicemias.length === 1 ? ' medição' : ' medições');
  } else {
    elMediaValor.textContent = '—';
    elMediaLegenda.textContent = 'Nenhum registro ainda';
  }

  /* ----- KPI: tempo no alvo ----- */
  var elAlvoValor = document.getElementById('kpi-alvo-valor');
  if (glicemias.length) {
    var noAlvo = glicemias.filter(function (g) { return g.valor >= perfil.metaMin && g.valor <= perfil.metaMax; }).length;
    elAlvoValor.textContent = Math.round((noAlvo / glicemias.length) * 100) + '%';
  } else {
    elAlvoValor.textContent = '—';
  }
  document.getElementById('kpi-alvo-legenda').textContent = 'Meta ' + perfil.metaMin + '–' + perfil.metaMax + ' mg/dL';

  /* ----- Medições recentes (até 5) ----- */
  var listaMed = document.getElementById('lista-medicoes-recentes');
  listaMed.innerHTML = '';
  if (!glicemias.length) {
    listaMed.innerHTML = '<p class="subtexto">Nenhuma medição registrada ainda.</p>';
  }
  glicemias.slice(0, 5).forEach(function (g) {
    var status = Store.classificarGlicemia(g.valor, perfil);
    var div = document.createElement('div');
    div.className = 'lista-item';
    div.innerHTML =
      '<div class="data">' + Store.formatarDataBR(g.data) + '<br>' + (g.hora || '') + '</div>' +
      '<div class="principal">' +
        '<div class="valor">' + g.valor + ' mg/dL</div>' +
        '<div class="subtexto">' + Store.rotuloContexto(g.contexto) + '</div>' +
      '</div>' +
      '<span class="badge ' + status.classe + '">' + status.rotulo + '</span>';
    listaMed.appendChild(div);
  });

  /* ----- Refeições recentes (até 3) ----- */
  var listaRef = document.getElementById('lista-refeicoes-recentes');
  listaRef.innerHTML = '';
  if (!refeicoes.length) {
    listaRef.innerHTML = '<p class="subtexto">Nenhuma refeição registrada ainda.</p>';
  }
  refeicoes.slice(0, 3).forEach(function (r) {
    var cg = Store.calcularCGRefeicao(r);
    var classe = Store.classificarCG(cg);
    var div = document.createElement('div');
    div.className = 'refeicao-recente';
    div.innerHTML =
      '<div class="refeicao-recente-topo">' +
        '<div class="titulo">' + r.nome + '</div>' +
        '<span class="badge ' + classe.classe + '">' + classe.rotulo + '</span>' +
      '</div>' +
      '<div class="subtexto">' + (r.descricao || '') + '</div>' +
      '<div class="rodape">' + Store.formatarDataBR(r.data) + ' · ' + (r.hora || '') + '</div>';
    listaRef.appendChild(div);
  });
});
