<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>GlicoSys - Alimentos (IG)</title>
<link rel="stylesheet" href="../style/style.css">
<?php
require_once '../../backend/includes/config_session.inc.php';

if(!isset($_SESSION['user_id'])){
  header('Location: ../../backend/logoff.php');
  die();
}
?>
</head>
<body>

<div class="app">

  <aside class="sidebar">
    <div class="sidebar-logo">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
      GlicoSys
    </div>

   <div class="paciente-card">
      <div class="rotulo">Paciente</div>
      <div class="nome" id="sidebar-nome"><?php echo $_SESSION['user_username'];?></div>
      <div class="info" id="sidebar-info">DM Tipo <?php echo $_SESSION['user_DM'];?></div>
    </div>

    <ul class="sidebar-nav">
      <li><a href="painel.php">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Painel
      </a></li>
      <li><a href="glicemia.php">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        Glicemia
      </a></li>
      <li><a href="refeicoes.php">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2v7c0 1-1 2-2 2s-2-1-2-2V2M14 11v11M6 2v9c0 1 1 2 2 2h0v9"/></svg>
        Refeições
      </a></li>
      <li><a href="alimentos.php" class="ativo">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V4H6.5A2.5 2.5 0 0 0 4 6.5v13z"/></svg>
        Alimentos (IG)
      </a></li>
      <li><a href="perfil.php">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/></svg>
        Meu Perfil
      </a></li>
    </ul>

    <div class="sidebar-sair">
      <a href="../../backend/logoff.php" id="link-sair">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
        Sair
      </a>
    </div>
  </aside>

  <main class="conteudo">

    <div class="cabecalho-pagina">
      <h1>Tabela de Índice Glicêmico</h1>
      <p>Referência científica — alimentos classificados por categoria de IG. Os carboidratos e o IG de cada alimento alimentam o cálculo da Carga Glicêmica (CG) na tela de Refeições.</p>
    </div>

    <div class="categorias-ig">
      <div class="categoria-card baixo">
        <div class="titulo">IG BAIXO</div>
        <div class="faixa">≤ 55</div>
        <div class="descricao">Elevação gradual da glicemia. Recomendado para diabéticos.</div>
      </div>
      <div class="categoria-card medio">
        <div class="titulo">IG MÉDIO</div>
        <div class="faixa">56 - 69</div>
        <div class="descricao">Elevação moderada. Consumo controlado e consciente.</div>
      </div>
      <div class="categoria-card alto">
        <div class="titulo">IG ALTO</div>
        <div class="faixa">≥ 70</div>
        <div class="descricao">Pico glicêmico rápido. Evitar ou limitar a ingestão.</div>
      </div>
    </div>

    <div class="filtros">
      <input type="text" id="campo-busca-alimento" class="campo-busca" placeholder="Buscar alimento...">
      <div class="filtro-botoes">
        <button class="ativo" data-filtro="todos">Todos</button>
        <button data-filtro="baixo">Baixo</button>
        <button data-filtro="medio">Médio</button>
        <button data-filtro="alto">Alto</button>
      </div>
    </div>

    <div class="card">
      <table id="tabela-alimentos">
        <thead>
          <tr>
            <th>Alimento</th>
            <th>Porção</th>
            <th>Carboidratos</th>
            <th>IG</th>
            <th>CG da porção</th>
            <th>Categoria (IG)</th>
          </tr>
        </thead>
        <tbody>
          <tr data-nome="feijão preto cozido" data-categoria="baixo"><td>Feijão preto cozido</td><td>150g</td><td>24g</td><td><strong>30</strong></td><td>7</td><td><span class="badge badge-verde">baixo</span></td></tr>
          <tr data-nome="lentilha cozida" data-categoria="baixo"><td>Lentilha cozida</td><td>150g</td><td>30g</td><td><strong>32</strong></td><td>10</td><td><span class="badge badge-verde">baixo</span></td></tr>
          <tr data-nome="leite integral" data-categoria="baixo"><td>Leite integral</td><td>250ml</td><td>12g</td><td><strong>31</strong></td><td>4</td><td><span class="badge badge-verde">baixo</span></td></tr>
          <tr data-nome="iogurte natural" data-categoria="baixo"><td>Iogurte natural</td><td>200g</td><td>9g</td><td><strong>36</strong></td><td>3</td><td><span class="badge badge-verde">baixo</span></td></tr>
          <tr data-nome="maçã" data-categoria="baixo"><td>Maçã</td><td>120g</td><td>16g</td><td><strong>36</strong></td><td>6</td><td><span class="badge badge-verde">baixo</span></td></tr>
          <tr data-nome="laranja" data-categoria="baixo"><td>Laranja</td><td>130g</td><td>15g</td><td><strong>40</strong></td><td>6</td><td><span class="badge badge-verde">baixo</span></td></tr>
          <tr data-nome="morango" data-categoria="baixo"><td>Morango</td><td>120g</td><td>8g</td><td><strong>41</strong></td><td>3</td><td><span class="badge badge-verde">baixo</span></td></tr>
          <tr data-nome="uva" data-categoria="medio"><td>Uva</td><td>120g</td><td>18g</td><td><strong>59</strong></td><td>11</td><td><span class="badge badge-laranja">médio</span></td></tr>
          <tr data-nome="mamão" data-categoria="medio"><td>Mamão</td><td>150g</td><td>13g</td><td><strong>60</strong></td><td>8</td><td><span class="badge badge-laranja">médio</span></td></tr>
          <tr data-nome="mel" data-categoria="medio"><td>Mel</td><td>25g</td><td>21g</td><td><strong>61</strong></td><td>13</td><td><span class="badge badge-laranja">médio</span></td></tr>
          <tr data-nome="banana madura" data-categoria="medio"><td>Banana madura</td><td>120g</td><td>28g</td><td><strong>62</strong></td><td>17</td><td><span class="badge badge-laranja">médio</span></td></tr>
          <tr data-nome="arroz branco cozido" data-categoria="medio"><td>Arroz branco cozido</td><td>150g</td><td>42g</td><td><strong>64</strong></td><td>27</td><td><span class="badge badge-laranja">médio</span></td></tr>
          <tr data-nome="beterraba cozida" data-categoria="medio"><td>Beterraba cozida</td><td>80g</td><td>7g</td><td><strong>64</strong></td><td>4</td><td><span class="badge badge-laranja">médio</span></td></tr>
          <tr data-nome="pão de forma branco" data-categoria="medio"><td>Pão de forma branco</td><td>30g</td><td>14g</td><td><strong>65</strong></td><td>9</td><td><span class="badge badge-laranja">médio</span></td></tr>
          <tr data-nome="tapioca" data-categoria="alto"><td>Tapioca</td><td>100g</td><td>34g</td><td><strong>70</strong></td><td>24</td><td><span class="badge badge-vermelho">alto</span></td></tr>
          <tr data-nome="melancia" data-categoria="alto"><td>Melancia</td><td>150g</td><td>11g</td><td><strong>72</strong></td><td>8</td><td><span class="badge badge-vermelho">alto</span></td></tr>
          <tr data-nome="pão francês" data-categoria="alto"><td>Pão francês</td><td>50g</td><td>29g</td><td><strong>73</strong></td><td>21</td><td><span class="badge badge-vermelho">alto</span></td></tr>
          <tr data-nome="pão de queijo" data-categoria="alto"><td>Pão de queijo</td><td>60g</td><td>26g</td><td><strong>74</strong></td><td>19</td><td><span class="badge badge-vermelho">alto</span></td></tr>
          <tr data-nome="batata cozida" data-categoria="alto"><td>Batata cozida</td><td>150g</td><td>26g</td><td><strong>78</strong></td><td>20</td><td><span class="badge badge-vermelho">alto</span></td></tr>
          <tr data-nome="arroz branco inst." data-categoria="alto"><td>Arroz branco inst.</td><td>150g</td><td>45g</td><td><strong>87</strong></td><td>39</td><td><span class="badge badge-vermelho">alto</span></td></tr>
          <tr data-nome="refrigerante (cola)" data-categoria="alto"><td>Refrigerante (cola)</td><td>350ml</td><td>37g</td><td><strong>90</strong></td><td>33</td><td><span class="badge badge-vermelho">alto</span></td></tr>
        </tbody>
      </table>
    </div>

    <div class="card">
      <h2>Como a Carga Glicêmica (CG) é calculada</h2>
      <p>CG = (IG × carboidratos disponíveis na porção) ÷ 100</p>
      <p class="subtexto">Quando a quantidade consumida é diferente da porção de referência, os carboidratos são ajustados proporcionalmente antes do cálculo. A CG de cada alimento é somada para formar a CG da refeição, classificada como <strong>baixa</strong> (≤ 10), <strong>moderada</strong> (11 a 19) ou <strong>alta</strong> (≥ 20). O resultado é apresentado como uma estimativa de potencial de resposta glicêmica, não como uma previsão exata da glicemia.</p>
    </div>

  </main>

</div>

<script src="../js/store.js"></script>
<!-- <script src="../js/comum.js"></script> -->
<script src="../js/alimentos.js"></script>
</body>
</html>
