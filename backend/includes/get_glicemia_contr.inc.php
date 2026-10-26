<?php
declare(strict_types=1);
require_once 'get_glicemia_model.inc.php';

function get_glics(PDO $pdo, int $id){
return get_model_glics($pdo, $id);
}