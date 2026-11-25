<?php
declare(strict_types=1);
require_once 'refeicoes_model.inc.php';

function get_CG(PDO $pdo, string $alimentoName, float $grams){
$alimento = get_alimento_by_name($pdo ,$alimentoName); //TODO
$ig = $alimento['ig'];
$carb_by_gram = $alimento['carb_por_grama'];

return ($ig*($carb_by_gram*$grams)/100);
}

function get_meals(PDO $pdo, int $id){
return get_model_meals($pdo,$id);
} 

 function get_classes_refs(array|null $refs){
  $classes= ['baixo'=>0,'medio'=>0,'alto'=>0];
if($refs == null){return $classes;}

foreach($refs as $i=>$ref){
$nivel = $ref['cg'];
$last_index = array_key_last($refs);
$id = $ref['id_refeicoes'];

$next_id = ($i < $last_index)
    ? $refs[$i + 1]['id_refeicoes']
    : null;

    if ($id !== $next_id) {
switch($nivel){
case $nivel<=10:
$classes['baixo'] ++;
  break;
case $nivel>10 and $nivel<20:
  $classes['medio'] ++;
  break;
case $nivel>20:
  $classes['alto'] ++;
  break;
}
    }
}

return $classes;
}
