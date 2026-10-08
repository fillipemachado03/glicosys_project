/* GlicoSys - lógica do formulário Registrar Refeição
   Permite adicionar vários alimentos e calcula a Carga Glicêmica (CG) em tempo real. */

document.addEventListener('DOMContentLoaded', function () {
  // var usuario = Store.obterUsuarioAtual();
  // if (!usuario) return;

  var container = document.getElementById('itens-container');
  var botaoAdicionar = document.getElementById('btn-adicionar-alimento');

  var dataInput = document.getElementById('data');
  if (dataInput && !dataInput.value) dataInput.value = new Date().toISOString().slice(0, 10);

  function opcoesAlimentos(selecionadoId) {
    return Store.obterAlimentos().map(function (a) {
      var selecionado = a.id === selecionadoId ? ' selected' : '';
      return '<option value="' + a.id + '"' + selecionado + '>' +
        a.nome + ' (' + a.porcao + a.unidade + ' · ' + a.carboidratos + 'g carb · IG ' + a.ig + ')</option>';
    }).join('');
  }

  function atualizarLinha(linha) {
    var alimentoId = linha.querySelector('.select-alimento').value;
    var quantidade = Number(linha.querySelector('.input-quantidade').value) || 0;
    var alimento = Store.obterAlimentoPorId(alimentoId);
    var textoInfo = linha.querySelector('.texto-info');

    if (alimento && quantidade > 0) {
      var carb = Store.carboidratosAjustados(alimento, quantidade);
      var cg = Store.cgItem(alimento, quantidade);
      textoInfo.textContent = 'Carboidratos ajustados: ' + (Math.round(carb * 10) / 10) + 'g · CG do item: ' + cg;
    } else {
      textoInfo.textContent = 'Informe uma quantidade válida.';
    }
    atualizarEstimativa();
  }

  function atualizarEstimativa() {
    var total = 0;
    Array.prototype.forEach.call(container.querySelectorAll('.item-alimento'), function (linha) {
      var alimentoId = linha.querySelector('.select-alimento').value;
      var quantidade = Number(linha.querySelector('.input-quantidade').value) || 0;
      var alimento = Store.obterAlimentoPorId(alimentoId);
      if (alimento) total += Store.cgItem(alimento, quantidade);
    });

    var classe = Store.classificarCG(total);
    var potencial = classe.chave === 'baixa' ? 'baixo' : (classe.chave === 'moderada' ? 'moderado' : 'alto');

    document.getElementById('cg-total-valor').textContent = 'Carga Glicêmica total: ' + total;
    document.getElementById('cg-total-subtexto').textContent = 'Potencial de elevação glicêmica: ' + potencial;
    var badge = document.getElementById('cg-total-badge');
    badge.textContent = classe.rotulo;
    badge.className = 'badge ' + classe.classe;
  }

  function novaLinha(alimentoId, quantidade) {
    var linha = document.createElement('div');
    linha.className = 'item-alimento';
    linha.innerHTML =
      '<div class="form-linha">' +
        '<div class="campo">' +
          '<label>Alimento</label>' +
          '<select name= alimento[] class="select-alimento">' + opcoesAlimentos(alimentoId) + '</select>' +
        '</div>' +
        '<div class="campo">' +
          '<label>Quantidade (g)</label>' +
          '<input type="number" name=porcoes[] class="input-quantidade" min="0" value="' + (quantidade || 100) + '">' +
        '</div>' +
      '</div>' +
      '<div class="campo item-info">' +
        '<p class="ajuda"><span class="texto-info"></span> · <button type="button" class="btn-remover-item">Remover</button></p>' +
      '</div>';
    container.appendChild(linha);

    linha.querySelector('.select-alimento').addEventListener('change', function () { atualizarLinha(linha); });
    linha.querySelector('.input-quantidade').addEventListener('input', function () { atualizarLinha(linha); });
    linha.querySelector('.btn-remover-item').addEventListener('click', function () {
      if (container.querySelectorAll('.item-alimento').length <= 1) {
        alert('A refeição precisa ter ao menos um alimento.');
        return;
      }
      linha.remove();
      atualizarEstimativa();
    });

    atualizarLinha(linha);
  }

  botaoAdicionar.addEventListener('click', function () { novaLinha(); });
  novaLinha('arroz-branco', 100);

  var form = document.querySelector('#form-refeicao');
  form.addEventListener('submit', function (evento) {
    // evento.preventDefault();

    var itens = [];
    var nomesAlimentos = [];
    Array.prototype.forEach.call(container.querySelectorAll('.item-alimento'), function (linha) {
      var alimentoId = linha.querySelector('.select-alimento').value;
      var quantidade = Number(linha.querySelector('.input-quantidade').value) || 0;
      if (quantidade > 0) {
        itens.push({ alimentoId: alimentoId, quantidade: quantidade });
        var alimento = Store.obterAlimentoPorId(alimentoId);
        if (alimento) nomesAlimentos.push(alimento.nome);
      }
    });

    var dataForm = document.getElementById('data').value;
    if (!dataForm || !itens.length) {
      alert('Preencha a data e adicione ao menos um alimento com quantidade válida.');
      return;
    }

    var seletorNome = document.getElementById('nome');
    var registro = {
      id: Store.gerarId(),
      nome: seletorNome.options[seletorNome.selectedIndex].textContent,
      data: dataForm,
      hora: document.getElementById('hora').value,
      itens: itens,
      descricao: nomesAlimentos.join(', '),
      observacao: document.getElementById('descricao').value.trim()
    };

    var lista = Store.obterRefeicoes(usuario.id);
    lista.push(registro);
    Store.salvarRefeicoes(usuario.id, lista);

    window.location.href = 'refeicoes.php';
  });
});
