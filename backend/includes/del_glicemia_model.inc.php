<?php
declare(strict_types=1);

function del_glic (PDO $pdo,int $glic_id, int $user_id){
$query="DELETE from glicemia where id_glicemia = :glic_id and user_fk = :user_id;";
$stmt= $pdo->prepare($query);
$stmt->bindParam(":glic_id", $glic_id);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
}