<?php
declare(strict_types=1);
require_once 'get_glic_target_model.inc.php';

function get_glic_target(PDO $pdo, int $id){
return get_model_glic_target($pdo, $id);
}