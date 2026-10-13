<?php
declare(strict_types=1);
require_once 'glicemia_model.inc.php';

function get_glics(PDO $pdo, int $id){
return get_glic($pdo,$id);
}