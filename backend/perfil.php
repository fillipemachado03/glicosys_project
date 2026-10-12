<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../frontend/pages/login.php');
    die();
}

$nome = $_POST['nome'];
$idade =$_POST['idadde'];
$tipo = $_POST['tipo_dm'];
$medico = $_POST['medico'];
$min_meta = $_POST['min_eta'];
$max_meta = $_POST['max_meta'];