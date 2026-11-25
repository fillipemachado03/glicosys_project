<?php
declare(strict_types=1);
require_once 'csv_model.inc.php';

function get_glics(PDO $pdo, int $id){
return get_model_glics($pdo, $id);
}

function get_refs(PDO $pdo, int $id){
return get_model_refs($pdo, $id);
}
