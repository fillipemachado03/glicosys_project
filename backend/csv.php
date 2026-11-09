<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../index.php');
    die();
}
require_once 'includes/config_session.inc.php';
if(!isset($_SESSION['user_id'])){
    header('Location: ../index.php');
    die();
}

require_once 'includes/dbh.inc.php';
require_once 'includes/glicemia_contr.inc.php';

$id = $_SESSION['user_id'];

$directory = "csv/users/";

if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
}

$csv = fopen($directory. $id. $_SESSION['user_username'].".csv", "w+");
fputcsv($csv, ['Paciente','Tipo de DM' , 'Mínima', 'Máxima'], ',');
fputcsv($csv, [$_SESSION['user_username'],$_SESSION['user_DM'], $_SESSION['meta_min'], $_SESSION['meta_max']], ',');


$header =['Data', 'Medicão', 'Contexto', 'Refeicao', 'Observacao'];
fputcsv($csv, $header, ',');

$glics = get_glics($pdo, $id);
$refs = get_meals($pdo, $id); 




//GLICS



foreach ($glics as $glic) {
foreach ($refs as $arr) {
    $refid = $glic['refeicoes_fk'];
    if ($arr['id_refeicoes'] == $refid) {
        $ref = ucwords($arr['titulo'], ' ');
        break;
    }


}


$data = new DateTimeImmutable($glic['data_horario_registro']);
$data = $data->format('d/m/Y H:i:s');
    
    $g = [$data, $glic['nivel_glicose'], $glic['contexto'], $ref, $glic['observacao']];
    fputcsv($csv, $g, ',');
}







//REFS




fputcsv($csv, ['Titulo', 'Observacao', 'CG', 'Data', 'Alimentos'], ',');
$food = '';

foreach ($refs as $i => $ref) {
    $rid = $ref['id_refeicoes'];
$titulo = $ref['titulo'];
$obs = $ref['observacao'];
$cg = $ref['ig'];
$data = $ref['data_horario'];

    $last_index = array_key_last($refs);

$next_id = ($i < $last_index)
    ? $refs[$i + 1]['id_refeicoes']
    : null;

$food = $food.$ref['nome']. ', ';

if(!isset($last_id)){
$last_id ='';
}


if ($rid !== $next_id) {
    fputcsv($csv, [$titulo, $obs, $cg, $data, $food], ',');
      $food='';

}
}


//DOWNLOAD/END


// rewind($csv);
// while(!feof($csv)) {
//   $line = fgets($csv);
//   echo $line. "<br>";
// }


date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=" glic_' . $_SESSION['user_username'] .'_'. date('d/m/Y_H:i:s'). ' "');
fclose($csv);

readfile($directory. $id. $_SESSION['user_username'].".csv");
die();

