<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../frontend/pages/painel.php');
    die();
}

try{
require_once 'includes/dbh.inc.php';
require_once 'includes/get_glicemia_contr.inc.php';
require_once 'includes/config_session.inc.php';

$glics = get_glics($pdo, $_SESSION['user_id']) ?? [];

echo json_encode($glics);

}catch(PDOException $e){
die("Query failed:".$e->getMessage());
}
