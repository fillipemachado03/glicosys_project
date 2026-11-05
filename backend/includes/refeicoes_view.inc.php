<?php

function get_time_from_raw(string $raw){
return substr($raw, 11, 5);
}

function get_data_from_raw(string $raw){
return substr($raw, 0, 10);
}

function show_meals(array| null $meals){

if($meals == null){
echo('Nenhuma refeição registrada');
return;
}

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
    $bad='Baixo';
    break;
  case $cg>10 and $cg<20:
    $bad='medio';
    break;
    case $cg>20:
     $bad='alto';
      break;
}


$avs = ($bad == 'alto') ? 'Considere alimentos de menor índice glicêmico nesta refeição': '';

$last_index = array_key_last($meals);

$next_id = ($i < $last_index)
    ? $meals[$i + 1]['id_refeicoes']
    : null;



if ($id !== $next_id) {
  $food =substr($food, 0, -2);
  echo(
    '<div class="refeicao-card ig-'.$bad.'">'.
      '<div class="refeicao-card-topo">' .
        '<div><div class="titulo">' . $titu . '</div></div>' .
        '<div>' .
          '<span class="badge ' . $bad . '"> CG ' . $bad . ' · ' . $cg . '</span>' .
'<form action="../../backend/del_refeicoes.php" method="POST">
            <input
                type="hidden"
                name="id"
                value='. (int) $id .'>'.
          '<button type= "submit" class="btn-excluir" data-id="' . $id . '" title="Excluir">' .
            '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>' .
          '</button> </form>' .
        '</div>' .
      '</div>' .
      '<div class="meta">' .
        '<span><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>' . $data . '</span>' .
        '<span><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>' .  $hora . '</span>' .
      '</div>' .
      '<div class="descricao">' . $food . '</div>' .
      '<div class="subtexto">Potencial de elevação glicêmica: ' . (($bad =='medio') ? 'moderado' : $bad)  . '</div>' .
      ($obs ? '<div class="subtexto" style="margin-top:6px;">Obs.: ' . $obs . '</div>' : '') .
      $avs
      .'</div>');


      $food='';

}



}

$last_id = $id;
}
 
function show_glic_classes(array $classes){
  $b = $classes['baixo'];
  $m = $classes['medio'];
  $a = $classes['alto'];
echo('<div class="resumo-badges" id="resumo-badges">
 <span class="badge badge-verde">CG baixa: '. $b.'</span>
 <span class="badge badge-laranja">CG moderada: '.$m.'</span>
 <span class="badge badge-vermelho">CG alta: '.$a.'</span></div>
');
}
   
    
    

