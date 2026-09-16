<?php
require_once 'backend\includes\refeicao_model.inc.php';

function get_CG($alimentoName, $carb){
$alimento = get_alimento_by_name($alimentoName); //TODO
$ig = $alimento['ig'];
return ($ig*$carb)/100;
}