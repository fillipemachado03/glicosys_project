<?php
declare(strict_types=1);

function get_model_glic_target(PDO $pdo, int $id){
$query = 'SELECT min_meta_glicemica,max_meta_glicemica from users where id_users = :id;';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $results ?? null;
}