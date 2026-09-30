<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../frontend/pages/login.php');
    die();
}

$email = $_POST['email'];
$pwd = $_POST['senha'];

try{
require_once 'includes/dbh.inc.php';
require_once 'includes/login_contr.inc.php';

$errors= [];
if(is_input_empty($email, $pwd)){
    $errors['empty_input'] = 'Preencha todos os campos';
}

$result = get_user($pdo, $email); //TODO

if(is_pwd_wrong($pwd, $result['senha_hash'])){
    $errors['invalid_info'] = 'E-mail ou senha inválidos.';
}


require_once 'includes/config_session.inc.php';

if($errors){
$_SESSION['errors_login'] = $errors;

$login_data = ['email' => $email];

$_SESSION['login_data'] = $login_data;

    header('Location: ../frontend/pages/login.php');
die();
}


header("Location: ../frontend/pages/cadastro.php");

$pdo=null;
$stmt=null;
die();
}
catch(PDOException $e){
echo 'Query Failed: '. $e->getMessage();
}
