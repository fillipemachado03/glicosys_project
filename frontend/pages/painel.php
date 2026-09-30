<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>GlicoSys - Painel</title>
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
      <li><a href="painel.php" class="ativo">
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
      <li><a href="alimentos.php">
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
      <h1 id="saudacao">Olá, <?php echo $_SESSION['user_username'];?></h1>
      <p id="meta-texto">Diabetes tipo <?php echo $_SESSION['user_DM'];?> · Meta Glicêmica: </p>
    
    </div>

    <div class="kpis">
      <div class="kpi-card">
        <div class="kpi-topo">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2s6 7 6 12a6 6 0 0 1-12 0c0-5 6-12 6-12z"/></svg>
          Última Glicemia
        </div>
        <div class="kpi-valor" id="kpi-ultima-valor">—</div>
        <div class="kpi-legenda" id="kpi-ultima-legenda"></div>
      </div>

      <div class="kpi-card">
        <div class="kpi-topo">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
          Média Glicêmica
        </div>
        <div class="kpi-valor" id="kpi-media-valor">—</div>
        <div class="kpi-legenda" id="kpi-media-legenda"></div>
      </div>

      <div class="kpi-card">
        <div class="kpi-topo">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/></svg>
          Tempo no Alvo
        </div>
        <div class="kpi-valor" id="kpi-alvo-valor">—</div>
        <div class="kpi-legenda" id="kpi-alvo-legenda"></div>
      </div>
    </div>

    <div class="card">
      <h2>Medições Recentes</h2>
      <div id="lista-medicoes-recentes"></div>
    </div>

    <div class="card">
      <h2>Refeições Recentes</h2>
      <div id="lista-refeicoes-recentes"></div>
    </div>

  </main>

</div>

<script src="../js/store.js"></script>
<!-- <script src="../js/comum.js"></script> -->
<script src="../js/painel.js"></script>
</body>
</html>
