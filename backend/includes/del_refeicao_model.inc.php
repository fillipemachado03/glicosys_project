<?php
declare(strict_types=1);

function del_ref (PDO $pdo,int $ref_id, int $user_id){
$query="DELETE from refeicoes where id_refeicoes = :ref_id and user_fk = :user_id;";
$stmt= $pdo->prepare($query);
$stmt->bindParam(":ref_id", $ref_id);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
}