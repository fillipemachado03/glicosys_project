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