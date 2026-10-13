<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../frontend/pages/cadastro.php');
    die();
}


$id = $_POST['id'];

try{
require_once'includes/del_refeicao_contr.inc.php';
require_once'includes/config_session.inc.php';

delete_me($pdo, $id, $_SESSION['user_id']);
header("Location: ../frontend/pages/refeicao.php");
    die();
    
}catch(PDOException $e){die("Query failed: ". $e->getMessage());}


