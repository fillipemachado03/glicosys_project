<?php

function get_time_from_raw(string $raw){
return substr($raw, 11, 9);
}

function get_data_from_raw(string $raw){
return substr($raw, 0, 10);
}

function show_meals(array $meals){

$food = '';

    foreach($meals as $ref){
      $raw = $ref['data_horario'];
   


$data =get_data_from_raw($raw);
$hora =get_time_from_raw($raw);


$id = $ref['id_refeicoes'];
$titu = (int)$ref['titulo'];
$cg =$ref['cg'];
$obs =$ref['observacao'];
$food = $food.$ref['nome'];


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

    }
   
    
    
 echo(
      '<div class="refeicao-card">'.
      '<div class="refeicao-card-topo">' .
        '<div><div class="titulo">' . $titu . '</div></div>' .
        '<div>' .
          '<span class="badge ' . $bad . '">' . $bad . ' · ' . $cg . '</span>' .
          '<button class="btn-excluir" data-id="' . $id . '" title="Excluir">' .
            '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>' .
          '</button>' .
        '</div>' .
      '</div>' .
      '<div class="meta">' .
        '<span><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>' . $data . '</span>' .
        '<span><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>' .  $hora . '</span>' .
      '</div>' .
      '<div class="descricao">' . $food . '</div>' .
      '<div class="subtexto">Potencial de elevação glicêmica: ' . $bad . '</div>' .
      ($obs ? '<div class="subtexto" style="margin-top:6px;">Obs.: ' . $obs . '</div>' : '') .
      $avs)
      .'</div>';
}