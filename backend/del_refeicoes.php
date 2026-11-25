<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../frontend/pages/cadastro.php');
    die();
}


$id = (int) $_POST['id'];

try{
require_once 'includes/del_refeicao_contr.inc.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/config_session.inc.php';

delete_meal($pdo, $id, $_SESSION['user_id']);

header("Location: ../frontend/pages/refeicoes.php");
    die();
    
}catch(PDOException $e){die("Query failed: ". $e->getMessage());}


