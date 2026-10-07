<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../frontend/pages/refeicao.php');
    die();
}

$nome = strtolower($_POST['nome']);
$data = $_POST['data']. ' '. $_POST['hora']. ':00';


if(isset($_POST['descricao'])){
    $observacao = $_POST['descricao'];
} else{
    $observacao = null;
}

try{    
require_once 'includes/registrar_refeicao_contr.inc.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/config_session.inc.php';

$alimentos = normalize_array(
    $_POST['alimento'],
    $_POST['porcoes']
);

// $total_cg = get_total_cg($pdo, $alimentos);

// var_dump('#########$');

// $alimentos = normalize_array($_POST['alimento'], $_POST['porcoes']);
// var_dump('ali');
// var_dump($alimentos);

// $res = get_each_ig_carbs($pdo, $alimentos);
// var_dump('res:');
// var_dump($res);

// $cg = get_total_cg($pdo, $alimentos);
// var_dump('cg');
// var_dump($cg);

// var_dump('########');

// var_dump($_POST);

create_meal($pdo, (int)$_SESSION['user_id'], $nome, $observacao, $data, $alimentos);
header('Location: ../frontend/pages/refeicoes.php');

die();
}catch(PDOException $e){
    die('Query failed: '. $e->getMessage());
}
