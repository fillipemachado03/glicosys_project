<?php
declare(strict_types =1);

require_once 'painel_model.inc.php';

function get_perc_in_meta(PDO $pdo, int $id){
return (get_glic_in_meta($pdo,$id)/get_total_glic($pdo,$id))*100;
}