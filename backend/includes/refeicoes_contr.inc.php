<?php
declare(strict_types=1);
require_once 'refeicao_model.inc.php';

function get_CG(PDO $pdo, string $alimentoName, float $grams){
$alimento = get_alimento_by_name($pdo ,$alimentoName); //TODO
$ig = $alimento['ig'];
$carb_by_gram = $alimento['carb_por_grama'];

return ($ig*($carb_by_gram*$grams)/100);
}