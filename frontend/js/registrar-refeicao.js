/* GlicoSys - lógica do formulário Registrar Refeição
   Permite adicionar vários alimentos sem duplicação.
   Calcula a Carga Glicêmica (CG) em tempo real.
*/

document.addEventListener('DOMContentLoaded', function () {
  // var usuario = Store.obterUsuarioAtual();
  // if (!usuario) return;

  var container = document.getElementById('itens-container');
  var botaoAdicionar = document.getElementById('btn-adicionar-alimento');

  var dataInput = document.getElementById('data');

  if (dataInput && !dataInput.value) {
    dataInput.value = new Date().toISOString().slice(0, 10);
  }

  /*
   * Retorna os IDs dos alimentos já selecionados
   * em outras linhas da refeição.
   */
  function alimentosSelecionados(linhaAtual) {
    var ids = [];

    Array.prototype.forEach.call(
      container.querySelectorAll('.item-alimento'),
      function (linha) {
        if (linha === linhaAtual) return;

        var select = linha.querySelector('.select-alimento');
        if (select && select.value) {
          ids.push(select.value);
        }
      }
    );

    return ids;
  }

  /*
   * Gera as opções do select.
   * Exclui alimentos selecionados em outras linhas.
   * Sempre começa com um placeholder quando não há
   * alimento previamente definido.
   */
  function opcoesAlimentos(linhaAtual, selecionadoId) {
    var idsEmUso = alimentosSelecionados(linhaAtual);

    var placeholder =
      '<option value="" disabled' +
      (!selecionadoId ? ' selected' : '') +
      '>Selecione um alimento</option>';

    var opcoes = Store.obterAlimentos()
      .filter(function (alimento) {
        return (
          !idsEmUso.includes(String(alimento.id)) ||
          String(alimento.id) === String(selecionadoId)
        );
      })
      .map(function (alimento) {
        var selecionado =
          String(alimento.id) === String(selecionadoId)
            ? ' selected'
            : '';

        return '<option value="' + alimento.id + '"' +
          selecionado + '>' +
          alimento.nome + ' (' +
          alimento.porcao + alimento.unidade +
          ' · ' + alimento.carboidratos +
          'g carb · IG ' + alimento.ig +
          ')</option>';
      })
      .join('');

    return placeholder + opcoes;
  }

  /*
   * Atualiza as opções de todas as linhas,
   * preservando as seleções válidas.
   */
  function atualizarSeletores() {
    Array.prototype.forEach.call(
      container.querySelectorAll('.item-alimento'),
      function (linha) {
        var select = linha.querySelector('.select-alimento');
        var valorAtual = select.value;

        // Se o alimento atual estiver selecionado
        // em outra linha, limpa a seleção duplicada.
        if (alimentosSelecionados(linha).includes(valorAtual)) {
          valorAtual = '';
        }

        select.innerHTML = opcoesAlimentos(linha, valorAtual);

        if (valorAtual) {
          select.value = valorAtual;
        } else {
          select.value = '';
        }
      }
    );
  }

  function atualizarLinha(linha) {
    var alimentoId =
      linha.querySelector('.select-alimento').value;

    var quantidade =
      Number(linha.querySelector('.input-quantidade').value) || 0;

    var alimento = alimentoId
      ? Store.obterAlimentoPorId(alimentoId)
      : null;

    var textoInfo = linha.querySelector('.texto-info');

    if (alimento && quantidade > 0) {
      var carb = Store.carboidratosAjustados(alimento, quantidade);
      var cg = Store.cgItem(alimento, quantidade);

      textoInfo.textContent =
        'Carboidratos ajustados: ' +
        (Math.round(carb * 10) / 10) +
        'g · CG do item: ' + cg;
    } else if (!alimento) {
      textoInfo.textContent = 'Selecione um alimento.';
    } else {
      textoInfo.textContent = 'Informe uma quantidade válida.';
    }

    atualizarEstimativa();
  }

  function atualizarEstimativa() {
    var total = 0;

    Array.prototype.forEach.call(
      container.querySelectorAll('.item-alimento'),
      function (linha) {
        var alimentoId =
          linha.querySelector('.select-alimento').value;

        var quantidade =
          Number(linha.querySelector('.input-quantidade').value) || 0;

        var alimento = alimentoId
          ? Store.obterAlimentoPorId(alimentoId)
          : null;

        if (alimento && quantidade > 0) {
          total += Store.cgItem(alimento, quantidade);
        }
      }
    );

    var classe = Store.classificarCG(total);

    var potencial =
      classe.chave === 'baixa'
        ? 'baixo'
        : classe.chave === 'moderada'
          ? 'moderado'
          : 'alto';

    document.getElementById('cg-total-valor').textContent =
      'Carga Glicêmica total: ' + total;

    document.getElementById('cg-total-subtexto').textContent =
      'Potencial de elevação glicêmica: ' + potencial;

    var badge = document.getElementById('cg-total-badge');
    badge.textContent = classe.rotulo;
    badge.className = 'badge ' + classe.classe;
  }

  function novaLinha() {
    var linha = document.createElement('div');
    linha.className = 'item-alimento';

    linha.innerHTML =
      '<div class="form-linha">' +
        '<div class="campo">' +
          '<label>Alimento</label>' +
          '<select name="alimento[]" class="select-alimento" required>' +
            '<option value="" selected disabled>' +
              'Selecione um alimento' +
            '</option>' +
          '</select>' +
        '</div>' +
        '<div class="campo">' +
          '<label>Quantidade (g)</label>' +
          '<input type="number" name="porcoes[]" ' +
            'class="input-quantidade" min="0" value="100" required>' +
        '</div>' +
      '</div>' +
      '<div class="campo item-info">' +
        '<p class="ajuda">' +
          '<span class="texto-info">Selecione um alimento.</span>' +
          ' · ' +
          '<button type="button" class="btn-remover-item">' +
            'Remover' +
          '</button>' +
        '</p>' +
      '</div>';

    container.appendChild(linha);

    // Atualiza as opções após inserir a nova linha.
    atualizarSeletores();

    linha.querySelector('.select-alimento')
      .addEventListener('change', function () {
        // Ao selecionar um alimento, ele deixa de aparecer
        // nos outros seletores.
        atualizarSeletores();

        Array.prototype.forEach.call(
          container.querySelectorAll('.item-alimento'),
          atualizarLinha
        );
      });

    linha.querySelector('.input-quantidade')
      .addEventListener('input', function () {
        atualizarLinha(linha);
      });

    linha.querySelector('.btn-remover-item')
      .addEventListener('click', function () {
        if (
          container.querySelectorAll('.item-alimento').length <= 1
        ) {
          alert('A refeição precisa ter ao menos um alimento.');
          return;
        }

        linha.remove();

        // O alimento removido volta a ficar disponível
        // nas outras linhas.
        atualizarSeletores();

        Array.prototype.forEach.call(
          container.querySelectorAll('.item-alimento'),
          atualizarLinha
        );
      });

    atualizarLinha(linha);
  }

  botaoAdicionar.addEventListener('click', function () {
    novaLinha();
  });

  // Começa com um campo vazio, sem alimento pré-selecionado.
  novaLinha();

  var form = document.querySelector('#form-refeicao');

  form.addEventListener('submit', function (evento) {
    var itens = [];
    var nomesAlimentos = [];
    var idsUtilizados = [];
    var invalido = false;

    Array.prototype.forEach.call(
      container.querySelectorAll('.item-alimento'),
      function (linha) {
        var alimentoId =
          linha.querySelector('.select-alimento').value;

        var quantidade =
          Number(linha.querySelector('.input-quantidade').value) || 0;

        // Exige alimento e quantidade válida em cada linha.
        if (!alimentoId || quantidade <= 0) {
          invalido = true;
          return;
        }

        // Validação adicional contra alimentos duplicados.
        if (idsUtilizados.includes(alimentoId)) {
          invalido = true;
          return;
        }

        idsUtilizados.push(alimentoId);

        itens.push({
          alimentoId: alimentoId,
          quantidade: quantidade
        });

        var alimento = Store.obterAlimentoPorId(alimentoId);

        if (alimento) {
          nomesAlimentos.push(alimento.nome);
        }
      }
    );

    var dataForm = document.getElementById('data').value;

    if (!dataForm || !itens.length || invalido) {
      evento.preventDefault();

      alert(
        'Preencha a data e selecione um alimento diferente ' +
        'em cada linha, com quantidade válida.'
      );

      return;
    }

    var seletorNome = document.getElementById('nome');

    var registro = {
      id: Store.gerarId(),
      nome: seletorNome.options[
        seletorNome.selectedIndex
      ].textContent,
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