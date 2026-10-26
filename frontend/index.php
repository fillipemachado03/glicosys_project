<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GlicoSys index</title>
<!-- index -->
<?php
require_once '../backend/includes/config_session.inc.php';

if(!isset($_SESSION['user_id'])){
  header('Location: ../backend/logoff.php');
  die();
}
header('Location: /frontend/pages/painel.php');
?>
</head>
<body>
</body>
</html>
