/* GlicoSys - busca e filtro na Tabela de Índice Glicêmico */

document.addEventListener('DOMContentLoaded', function () {
  var campoBusca = document.getElementById('campo-busca-alimento');
  var botoes = document.querySelectorAll('.filtro-botoes button');
  var linhas = document.querySelectorAll('#tabela-alimentos tbody tr');
  var filtroAtivo = 'todos';

  function aplicarFiltros() {
    var termo = (campoBusca.value || '').toLowerCase().trim();
    Array.prototype.forEach.call(linhas, function (linha) {
      var nome = (linha.getAttribute('data-nome') || '').toLowerCase();
      var categoria = linha.getAttribute('data-categoria');
      var passaCategoria = filtroAtivo === 'todos' || categoria === filtroAtivo;
      var passaBusca = !termo || nome.indexOf(termo) !== -1;
      linha.style.display = (passaCategoria && passaBusca) ? '' : 'none';
    });
  }

  campoBusca.addEventListener('input', aplicarFiltros);

  Array.prototype.forEach.call(botoes, function (botao) {
    botao.addEventListener('click', function () {
      Array.prototype.forEach.call(botoes, function (b) { b.classList.remove('ativo'); });
      botao.classList.add('ativo');
      filtroAtivo = botao.getAttribute('data-filtro');
      aplicarFiltros();
    });
  });
});
