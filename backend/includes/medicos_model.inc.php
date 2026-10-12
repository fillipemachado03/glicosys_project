<?php
declare(strict_types=1);

function get_medicos(PDO $pdo){
$query= "SELECT nome,especializacao from medicos;";
$stmt = $pdo->prepare($query);
$results =$stmt->fetchAll(PDO::FETCH_ASSOC);
return $results ?? null; 
};