<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../frontend/pages/login.php');
    die();
}

$username = $_POST['nome'];
$age = (int)$_POST['idade'];
$DM = (int)$_POST['tipo_dm'];
$medico = $_POST['medico'];
$min_meta = (int)$_POST['meta_min'];
$max_meta = (int)$_POST['meta_max'];

try{
require_once 'includes/dbh.inc.php';
require_once 'includes/perfil_contr.inc.php';

$errors = [];

if(is_input_empty($username, $age, $DM, $min_meta, $max_meta)){
    $errors['empty_input'] = 'Preencha nome, idade, e-mail e senha.';
}

if(is_DM_INvalid($DM)){
$errors['dm_invalid'] = 'O tipo de diabetes é inválida';
}

if(is_age_invalid($age)){
$errors['age_invalid'] = 'A idade é inválida';
}

if(is_target_invalid($min_meta, $max_meta)){
$errors['target_invalid'] = 'O mínimo ou máximo glicêmico é inválido';
}

require_once 'includes/config_session.inc.php';

if($errors){
$_SESSION['errors_perfil'] = $errors;

$perfil_data = ['nome' => $username];

$_SESSION['perfil_data'] = $perfil_data;


    header('Location: ../frontend/pages/perfil.php');
die();
}

alter_usuario($pdo, $_SESSION['user_id'], $username, $age, $DM, $medico, $min_meta, $max_meta);
$result = get_user($pdo, (int)$_SESSION['user_id']);

    $_SESSION['user_username'] = htmlspecialchars($result['nome']);
    $_SESSION['user_DM'] = $result['tipo_diabetes'];
    $_SESSION['meta_min'] = (int) $result['min_meta_glicemica'];
    $_SESSION['meta_max'] = (int) $result['max_meta_glicemica'];
    $_SESSION['last_regeneration'] = time();

header("Location: ../frontend/pages/perfil.php");

// $pdo= null;
// $stmt = null;
die();
}catch(PDOException $e){
    die('Query failed: '. $e->getMessage());
}