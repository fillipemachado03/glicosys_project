<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../frontend/pages/painel.php');
    die();
}

try{
require_once 'includes/dbh.inc.php';
require_once 'includes/get_glic_target_contr.inc.php';
require_once 'includes/config_session.inc.php';

$glic_target = get_glic_target($pdo, $_SESSION['user_id']) ?? [];

echo json_encode($glic_target);

}catch(PDOException $e){
die("Query failed:".$e->getMessage());
}
