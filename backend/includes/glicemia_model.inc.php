<?php
declare(strict_types=1);

function get_glic(PDO $pdo, int $id){
$query='SELECT * from glicemia where user_fk = :id;';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id',$id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $results ?? null;
} 