<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../frontend/pages/painel.php');
    die();
}

try{
require_once 'includes/dbh.inc.php';
require_once 'includes/get_glicemia_contr.inc.php';
$glicemia = get_glicemia($pdo) ?? [];

echo json_encode($glicemia);
}catch(PDOException $e){
die("Query failed:".$e->getMessage);
}