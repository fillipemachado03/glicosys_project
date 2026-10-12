<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../frontend/pages/cadastro.php');
    die();
}

try{
require_once 'includes/dbh.inc.php';
require_once 'includes/medicos_contr.inc.php';
$medicos = get_medics($pdo) ?? [];

echo json_encode($medicos);
}catch(PDOException $e){
die("Query failed:".$e->getMessage);
}