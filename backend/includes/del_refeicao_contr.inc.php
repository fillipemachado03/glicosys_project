<?php
declare(strict_types=1);
require_once'del_refeical_model.inc.php';

function delete_meal(PDO $pdo, int $ref_id, int $user_id){
del_ref($pdo,$ref_id,$user_id);
}
