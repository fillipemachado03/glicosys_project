<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../frontend/pages/cadastro.php');
    die();
}


$id = $_POST['id'];

try{
require_once'includes/del_glicemia_contr.inc.php';
require_once'includes/config_session.inc.php';

delete_glic($pdo, $id, $_SESSION['user_id']);
header("Location: ../frontend/pages/glicemia.php");
    die();
    
}catch(PDOException $e){die("Query failed: ". $e->getMessage());}


