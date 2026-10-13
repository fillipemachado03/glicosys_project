<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../frontend/pages/glicemia.php');
    die();
}

$data = $_POST['data'];
$time = $_POST['hora'];
$value = (int)$_POST['valor'];
$cnxt = $_POST['contexto'];
$ref = $_POST['refeicao'];
$obs = $_POST['observacao'];

try{
require_once 'includes/dbh.inc.php';
require_once 'includes/registrar_glicemia_contr.inc.php';

$errors = [];

if(is_input_empty($data, $time, $value, $cntx, $ref, $obs)){
    $errors['empty_input'] = 'Preencha todos os campos.';
}

if(is_value_invalid($value)){
$errors['invalid_value'] = 'Valor inválido';
}

$data_time = normalize_data_time($data, $time);

if(is_data_time_invalid($data_time)){
$errors['invalid_data_time'] = 'Data e hora inválidos';
}

require_once 'includes/config_session.inc.php';

if($errors){
$_SESSION['errors_reg_glic'] = $errors;

    header('Location: ../frontend/pages/glicemia.php');
die();
}


create_glic($pdo, $date_time, $value, $cnxt, $ref, $obs);

}catch(PDOException $e){
die("Query failed: ". $e->getMessage(););
}

