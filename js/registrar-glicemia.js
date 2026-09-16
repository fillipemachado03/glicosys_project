/* GlicoSys - lógica do formulário Registrar Glicemia */

document.addEventListener('DOMContentLoaded', function () {
  var usuario = Store.obterUsuarioAtual();
  if (!usuario) return;

  var seletorRefeicao = document.getElementById('refeicao');
  var refeicoes = Store.obterRefeicoes(usuario.id).slice().sort(Store.compararDataHoraDesc.bind(Store));
  refeicoes.forEach(function (r) {
    var opcao = document.createElement('option');
    opcao.value = r.id;
    opcao.textContent = r.nome + ' · ' + Store.formatarDataBR(r.data) + ' · ' + (r.hora || '');
    seletorRefeicao.appendChild(opcao);
  });

  var dataInput = document.getElementById('data');
  if (dataInput && !dataInput.value) dataInput.value = new Date().toISOString().slice(0, 10);

  var form = document.querySelector('.card form');
  form.addEventListener('submit', function (evento) {
    evento.preventDefault();

    var valor = Number(document.getElementById('valor').value);
    var data = document.getElementById('data').value;

    if (!data || !valor) {
      alert('Preencha ao menos a data e o valor da glicemia.');
      return;
    }

    var registro = {
      id: Store.gerarId(),
      data: data,
      hora: document.getElementById('hora').value,
      valor: valor,
      contexto: document.getElementById('contexto').value,
      refeicaoId: seletorRefeicao.value,
      observacao: document.getElementById('observacao').value.trim()
    };

    var lista = Store.obterGlicemias(usuario.id);
    lista.push(registro);
    Store.salvarGlicemias(usuario.id, lista);

    window.location.href = 'glicemia.html';
  });
});
