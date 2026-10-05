<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../frontend/pages/login.php');
    die();
}

$email = $_POST['email'];
$pwd = $_POST['senha'];

try {
    require_once 'includes/dbh.inc.php';
    require_once 'includes/login_contr.inc.php';

    $errors = [];
    if (is_input_empty($email, $pwd)) {
        $errors['empty_input'] = 'Preencha todos os campos';
    }

    if(!$errors){
    $result = get_user_by_email($pdo, $email);

    if (is_pwd_wrong($pwd, $result['senha_hash'])) {
        $errors['invalid_info'] = 'E-mail ou senha inválidos.';
    }
    }


    require_once 'includes/config_session.inc.php';

    if ($errors) {
        $_SESSION['errors_login'] = $errors;

        if (!$errors['empty_input']) {
            $login_data = ['email' => $email];

            $_SESSION['login_data'] = $login_data;
        }

        header('Location: ../frontend/pages/login.php');
        die();
    }

    $_SESSION['user_id'] = $result['id_users'];
    $_SESSION['user_username'] = htmlspecialchars($result['nome']);
    $_SESSION['user_DM'] = $result['tipo_diabetes'];
    $_SESSION['last_regeneration'] = time();

    $pdo = null;
    $stmt = null;

    header("Location: ../frontend/pages/painel.php");
    die();
} catch (PDOException $e) {
    echo 'Query Failed: ' . $e->getMessage();
}
