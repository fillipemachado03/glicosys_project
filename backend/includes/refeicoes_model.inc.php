<?php
declare(strict_types=1);

function get_alimento_by_name(PDO $pdo, string $alimentoName) :array|null {

    $query='SELECT * from Alimentos where nome = :nome;';
    $stmt= $pdo->prepare($query);
    $stmt->bindParam(':nome', $alimentoName);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    return $results ? $results : null;
};

function get_meals(PDO $pdo, int $user_id){

$query= 'SELECT DISTINCT * from refeicoes as r 
inner join alimentos_refeicoes as al on r.id_refeicoes = al.refeicoes_fk
INNER join alimentos as a on al.alimentos_fk = a.id_alimentos where r.user_fk = :user_id;';

$stmt= $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results ? $results : null;
}