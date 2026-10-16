<?php
declare(strict_types=1);

function get_time_from_raw(string $raw){
return substr($raw, 11, 9);
}

function get_data_from_raw(string $raw){
return substr($raw, 0, 10);
}

function show_glic(array $glics){

$raw = $glics['data_horario'];
$data = get_data_from_raw($raw);
$time = get_time_from_raw($raw);

foreach($glics as $glic){
  echo(
      '<td>' . $data . '</td>' .
      '<td>' . $time . '</td>' .
      '<td><strong>' . $glic['valor_glicemico'] . '</strong></td>' .
      '<td><span class="badge ' . 'status.classe' . '">' . 'status.rotulo' . '</span></td>' .
      '<td>' . 'contextoHtml' . '</td>' .
      '<td>' . '(variacao !== undefined ?'. '<strong>' . '(variacao > 0 ? '.' : "")' . 'variacao' . '</strong>' .':'. '—' . '</td>' .
      ');
<form action="../del_glicemia.php" method="POST">
            <input
                type="hidden"
                name="id"
                value='.(int) $glic['id_glicemia'].'.
            ><td><button type=submit class="btn-excluir" data-id="' . 'g.id' . '" title="Excluir"></form>' .
        '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>' .
      '</button></td>' );
};


};

