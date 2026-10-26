<?php
declare(strict_types=1);

function get_user(PDO $pdo, string $email) : array{
$query ='SELECT * from users where email = :email';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
return $results ? $results : null;
} 

function get_model_min(PDO $pdo, int $id){
$query ='SELECT min_meta_glicemica from users where id_users = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
return $results ? $results['min_meta_glicemica'] : null;
}
function get_model_max(PDO $pdo, int $id){
$query ='SELECT max_meta_glicemica from users where id_users = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
return $results ? $results['max_meta_glicemica'] : null;
}
