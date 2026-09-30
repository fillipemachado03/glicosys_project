<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>GlicoSys - Entrar</title>
<link rel="stylesheet" href="../style/style.css">
</head>
<?
require_once '../../backend/includes/login_view.inc.php';
require_once '../../backend/includes/config_session.inc.php';
?>
<body>

<div class="auth-tela">

  <div class="auth-lado-verde">
    <div class="sidebar-logo">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
      GlicoSys
    </div>
    <h2>Controle sua glicemia com simplicidade</h2>
    <p>Acompanhe suas medições, refeições e índice glicêmico dos alimentos em um só lugar, feito para pacientes com diabetes.</p>
  </div>

  <div class="auth-lado-form">
    <div class="auth-card">
      <div class="sidebar-logo">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        GlicoSys
      </div>

      <h1>Entrar na conta</h1>
      <p>Acesse seu painel de controle glicêmico.</p>
      <form action="backend\login.php">
      
      <?php
      login_input();
      ?>  
      
      <!-- <div class="campo">
          <label for="email">E-mail</label>
          <input type="email" id="email" name='email' placeholder="seu@email.com">
        </div> -->

        <div class="campo campo-senha">
          <label for="senha">Senha</label>
          <input type="password" id="senha" name='senha' placeholder="••••••">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>

         <div class="erro-auth">
          <?php
          check_login_errors();
          ?>
        </div>
              <button type="submit" class="btn btn-primario btn-full">Criar conta</button>
            </form>

            <p class="auth-rodape">Já tem conta? <a href="login.php">Entrar</a></p>
          </div>
        </div>
        
        <button type="submit" class="btn btn-primario btn-full">Entrar</button>
      </form>

      <p class="auth-rodape">Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>

      <div class="auth-demo">
        <div class="titulo">Demonstração</div>
        <p>Crie uma conta para explorar o sistema com dados de exemplo.</p>
      </div>
    </div>
  </div>

</div>

<script src="../js/store.js"></script>
<script src="../js/login.js"></script>
</body>
</html>
