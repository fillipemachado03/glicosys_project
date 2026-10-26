<?php
declare(strict_types =1);

require_once 'painel_model.inc.php';

function get_perc_in_meta(PDO $pdo, int $id){
return ((int)get_glic_in_meta($pdo,$id) / (int)get_total_glic($pdo,$id))*100;
}

function get_avg_glico(PDO $pdo, int $id){
return get_avg_glic($pdo,$id);
} 
 
function get_last_glico(PDO $pdo, int $id){ 
return get_last_glic($pdo,$id);
}

function get_total_glico(PDO $pdo, int $id){
return get_total_glic($pdo,$id);
}

function get_glicos(PDO $pdo, int $id){
return get_glics($pdo,$id);
}

function get_ref(PDO $pdo, int $id){
return get_meals($pdo,$id);
}
