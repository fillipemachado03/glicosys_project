<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../frontend/pages/painel.php');
    die();
}

try{
require_once 'includes/dbh.inc.php';
require_once 'includes/get_refeicoes_contr.inc.php';
require_once 'includes/config_session.inc.php';

$ref = get_meals($pdo, $_SESSION['user_id']) ?? [];

echo json_encode($ref);

}catch(PDOException $e){
die("Query failed:".$e->getMessage());
}
