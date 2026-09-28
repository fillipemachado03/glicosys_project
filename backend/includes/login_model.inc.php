<?php
declare(strict_types=1);

function get_user(object $pdo, string $username){
$query ='SELECT * from users where nome = :username';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
return $results;
}


