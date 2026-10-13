<?php
declare(strict_type=1);

function set_glic(PDO $pdo, string $date_time, int $value, string $cntx, int $ref,string $obs, int $id){
$query="INSERT into glicemia (data_horario_registro, nivel_glicose, contexto, refeicoes_fk, observacao) values(:date_time, :value, :cntx, :ref, :obs) where user_fk = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':date_time', $date_time);
$stmt->bindParam(':value', $value);
$stmt->bindParam(':cntx', $cntx);
$stmt->bindParam(':ref', $ref);
$stmt->bindParam(':obs', $obs);
$stmt->bindParam(':id', $id);

$stmt->execute();
}

function get_meals(PDO $pdo, int $id){
$query ='SELECT * from refeicoes where user_fk = :id;';
$stmt = $pdo->prepare($pdo);
$stmt->bindParam(':id',$id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $results ?? null;
}