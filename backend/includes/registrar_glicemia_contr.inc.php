<?php
declare(strict_types =1);

require_once 'registrar_glicemia_model.inc.php';


function normalize_data_time(string $data, string $time){
return $data. ' '. $time. ':00';
}

function is_data_time_invalid(string $date_time){
$data_obj = new dateTime($date_time);
$min = new dateTime('1970-01-01 00:00:01');
if($data_obj <= $min){
return true;
}
return false;
}

function is_input_empty(string $data, string $time, int $value, string $cntx, int ref, string $obs ){

if(empty($data)||empty($time)||empty($value)||empty($cntx)||empty($ref)||empty($obs)||){
return true;
}
return false;
}

function is_value_invalid(int $value){
if($value <20 || $value >1500){
return true;
}
return false;
}



function create_glic(PDO $pdo, string $date_time, int $value, string $cntx, int $ref, string $obs){
set_glic($pdo, $date_time, $value, $cntx, $ref, $obs);
}