<?php
declare(strict_types=1);
require_once'del_glicemia_model.inc.php';

function delete_glic(PDO $pdo, int $glic_id, int $user_id){
del_glic($pdo,$glic_id,$user_id);
}
 