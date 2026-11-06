<?php
declare(strict_types =1);

function show_last_glic(array $glic){
echo $glic['nivel_glicose']. ' </span>mg/dl</span>'; 
};

function show_last_glic_desc(array $glic){ 
  
echo $glic['contexto'].' • '. substr($glic['data_horario_registro'], 0, 11);
};

function show_avg_glic(array $glic){
echo round((float)$glic['avg(nivel_glicose)']). ' </span>mg/dl</span>'; 
};

function show_total_glic(array $total_glic){
echo $total_glic['count(*)']. ' medições';
};

function show_perc_in_glic_target(float $glic){
echo $glic. '%';
};

function show_glic_meta(int $min, int $max){
echo 'Meta '.$min.'-'.$max.' </span>mg/dl</span>';
};

function get_time_from_raw(string $raw){
return substr($raw, 11, 5);
}

function get_data_from_raw(string $raw){
return substr($raw, 0, 10);
}

function show_painel_glic(array $glics){

foreach($glics as $glic){
$raw = $glic  ['data_horario_registro'];
$data = new DateTimeImmutable(get_data_from_raw($raw));
$data = $data->format('d/m/Y');
$time = get_time_from_raw($raw);

$nivGlic =(int) $glic['nivel_glicose'];
$targetO = ['min'=>$_SESSION['meta_min'],'max'=>$_SESSION['meta_max']];
switch($nivGlic){
  case $nivGlic < $targetO['min']:
    $bad = 'baixa';
    break;
    case $nivGlic >= $targetO['min'] and $nivGlic <= $targetO['max']:
    $bad = 'No alvo';
    break;
    case $nivGlic > $targetO['max'] and $nivGlic <= $targetO['max']+20:
    $bad = 'Elevada';
    break;
    case $nivGlic > $targetO['max']:
    $bad = 'alta';
    break;
    default: $bad ='BAD INDEFINIDA';
  }

  echo(
    '<div class= "lista-item">'.
      '<div class="data">' . $data . '<br>' . $time . '</div>' .
      '<div class="principal">' .
        '<div class="valor">' . $glic['nivel_glicose'] . ' mg/dL</div>' .
        '<div class="subtexto">' . $glic['contexto'] . '</div>' .
      '</div>' .
      '<span class="badge ' . $bad . '">' . $bad . '</span>'.
    '</div>'
    );
};


};


function show_meals(array $meals){
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
    $txt ='verde';
    break;
  case $cg>10 and $cg<20:
    $bad='moderada';
    $txt ='amarela';
    break;
    case $cg>20:
     $bad='Alta';
     $txt ='vermelha';
      break;
}


$avs = ($bad == 'Alta') ? 'Considere alimentos de menor índice glicêmico nesta refeição': '';



$last_index = array_key_last($meals);

$next_id = ($i < $last_index)
    ? $meals[$i + 1]['id_refeicoes']
    : null;

if ($id !== $next_id) {
  $food =substr($food, 0, -2);  
echo('<div class="refeicao-recente-topo">' .
        '<div class="titulo">' . $titu . '</div>' .
        '<span class="badge ' . 'badge'. $txt . '"> CG ' . $bad . '</span>' .
      '</div>' .
      '<div class="subtexto">' . $food . '</div>' .
      '<div class="rodape">' . $data . ' · ' . $hora . '</div>');

      $food='';

}

$last_id = $id;
}
 

    }




