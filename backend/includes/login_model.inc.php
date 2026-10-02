<?php
declare(strict_types=1);

function get_user(PDO $pdo, string $email) : array{
$query ='SELECT * from users where email = :email';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
return $results['id_users'] ? $results : null;
} 


 