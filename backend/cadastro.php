<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../frontend/pages/cadastro.php');
    die();
}

$username = $_POST['nome'];
$pwd = $_POST['pwd'];
$email = $_POST['email'];
$age = (int) $_POST['idade'];
$DM = (int) $_POST['dm'];
$medico = $_POST['medico'];

try{
require_once 'includes/dbh.inc.php';
require_once 'includes/cadastro_contr.inc.php';

$errors = [];

if(is_input_empty($username, $pwd, $email, $age, $DM)){
    $errors['empty_input'] = 'Preencha nome, idade, e-mail e senha.';
}

if(is_email_invalid($email)){
$errors['invalid_email'] = 'Email está incorreto';
}

if(is_email_registered($pdo, $email)){
$errors['registered_email'] = 'Já existe uma conta com este e-mail.';
}

if(mb_strlen($pwd)<6){
$errors['short_pwd'] = 'A senha deve ter ao menos 6 caracteres.';
}

if(is_DM_INvalid($DM)){
$errors['dm_invalid'] = 'O tipo de diabetes é inválida';
}

if(is_age_invalid($age)){
$errors['age_invalid'] = 'A idade é inválida';
}

require_once 'includes/config_session.inc.php';

if($errors){
$_SESSION['errors_signup'] = $errors;

$signup_data = ['nome' => $username, 'email' => $email];

$_SESSION['signup_data'] = $signup_data;


    header('Location: ../frontend/pages/cadastro.php');
die();
}

create_user($pdo, $username, $pwd, $email, $age, $DM, $medico);
header("Location: ../frontend/pages/painel.php");

// $pdo= null;
// $stmt = null;
die();
}catch(PDOException $e){
    die('Query failed: '. $e->getMessage());
}
