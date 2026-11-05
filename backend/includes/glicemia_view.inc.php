<?php
declare(strict_types=1);


function get_time_from_raw(string $raw){
return substr($raw, 11, 5);
}

function get_data_from_raw(string $raw){
return substr($raw, 0, 10);
}

function get_var(array $glics, int $id){
$iNivel = (int)$glics[$id]['nivel_glicose'];
$lastNivel = (isset($glics[$id +1]))? $glics[$id +1]['nivel_glicose'] : null; 

return ($lastNivel != null and ($iNivel - $lastNivel) >0) ? $iNivel - $lastNivel : null;
}


function show_glic(array|null $glics){

if($glics == null){
  echo('Nenhuma glicemia registrada');
  return;
}

echo('<table>
        
        <thead>
          <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Mg/dL</th>
            <th>Status</th>
            <th>Contexto</th>
            <th>Variação</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tabela-corpo">');


foreach($glics as $i=>$glic){  
  $id =(int) $glic['id_glicemia'];
  $nivGlic =(int) $glic['nivel_glicose'];
$raw = $glic['data_horario_registro'];
$cntx = $glic['contexto'];

$variacao = (get_var($glics, $i) != null) ? '+'.get_var($glics, $i) : "—";

$data = get_data_from_raw($raw);
$time = get_time_from_raw($raw);

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
    '<tr>'.
      '<td>' . $data . '</td>' .
      '<td>' . $time . '</td>' .
      '<td><strong>' . $nivGlic . '</strong></td>' .
      '<td><span class="badge ' . $bad . '">' . $bad . '</span></td>' .
      '<td>' . $cntx . '</td>' .
      '<td>'. '<strong>' . $variacao . '</strong>'  . '</td>' .
      ');
<form action="../del_glicemia.php" method="POST">
            <input
                type="hidden"
                name="id"
                value='.$id.'.
            ><td><button type=submit class="btn-excluir" data-id="' . 'g.id' . '" title="Excluir"></form>' .
        '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>' .
      '</button></td>'.
    '</tr> </tbody>'
    );
};


};


