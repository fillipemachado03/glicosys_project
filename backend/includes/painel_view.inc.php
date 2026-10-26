<?php
declare(strict_types =1);

function show_last_glic(array $glic){
echo $glic['nivel_glicose']. '</span>mg/dl</span>'; 
};

function show_last_glic_desc(array $glic){ 
  
echo $glic['contexto'].' • '. $glic['data_horario_registro'];
};

function show_avg_glic(array $glic){
echo round((float)$glic['avg(nivel_glicose)']). '</span>mg/dl</span>'; 
};

function show_total_glic(array $total_glic){
echo $total_glic['count(*)']. ' medições';
};

function show_perc_in_glic_target(float $glic){
echo '% '.$glic;
};

function show_glic_meta(int $min, int $max){
echo 'Meta '.$min.'-'.$max.' </span>mg/dl</span>';
};

function get_time_from_raw(string $raw){
return substr($raw, 11, 9);
}

function get_data_from_raw(string $raw){
return substr($raw, 0, 10);
}

function show_glic(array $glics){

foreach($glics as $glic){
$raw = $glic  ['data_horario_registro'];
$data = get_data_from_raw($raw);
$time = get_time_from_raw($raw);

  echo(
    '<div class= "lista-item">'.
      '<div class="data">' . $data . '<br>' . $time . '</div>' .
      '<div class="principal">' .
        '<div class="valor">' . $glic['nivel_glicose'] . ' mg/dL</div>' .
        '<div class="subtexto">' . $glic['contexto'] . '</div>' .
      '</div>' .
      '<span class="badge ' . 'status.classe' . '">' . 'status.rotulo' . '</span>'.
    '</div>'
    );
};


};


function show_meals(array $meals){
//TODO
$food = '';

    foreach($meals as $i =>$ref){
      $raw = $ref['data_horario'];
  


$data =get_data_from_raw($raw);
$hora =get_time_from_raw($raw);


$id = $ref['id_refeicoes'];
$titu =$ref['titulo'];
$cg =$ref['cg'];
$obs =$ref['observacao'];
$food = $food.$ref['nome']. ', ';

if(!isset($last_id)){
$last_id ='';
}

$bad='';
switch ($cg) {
  case $cg<10:
    $bad='Baixa';
    break;
  case $cg>10 and $cg<20:
    $bad='moderada';
    break;
    case $cg>20:
     $bad='Alta';
      break;
}


$avs = ($bad == 'Alta') ? 'Considere alimentos de menor índice glicêmico nesta refeição': '';
var_dump('id');
  var_dump($id);
  var_dump('last');
var_dump($last_id);
var_dump('id array last');
var_dump($meals[array_key_last($meals)]['id_refeicoes']);
var_dump('array last');
var_dump(array_key_last($meals));
var_dump('i');
var_dump($i);
var_dump('++');
var_dump("\n\n\n\n");

if($id == $meals[array_key_last($meals)]['id_refeicoes'] && $i == array_key_last($meals) 
  || ($last_id == $id && $id != $meals[++$i]['id_refeicoes']) ||
 $last_id == '' && $id != $meals[++$i]['id_refeicoes']){



if(isset($meals[++$i]['id_refeicoes'])){
// var_dump($meals[++$i]['id_refeicoes']);
}
echo('<div class="refeicao-recente-topo">' .
        '<div class="titulo">' . $titu . '</div>' .
        '<span class="badge ' . 'classe.classe' . '">' . 'classe.rotulo' . '</span>' .
      '</div>' .
      '<div class="subtexto">' . $obs . '</div>' .
      '<div class="rodape">' . $data . ' · ' . $hora . '</div>');

      $food='';

}

$last_id = $id;
}
 

    }




