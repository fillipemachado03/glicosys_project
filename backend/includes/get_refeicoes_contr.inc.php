<?php
declare(strict_types=1);
require_once 'get_refeicoes_model.inc.php';

function get_meals(PDO $pdo, int $id){
return get_ref($pdo, $id);
}