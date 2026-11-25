<?php
declare(strict_types=1);

function get_glic(PDO $pdo, int $id){
$query='SELECT * from glicemia where user_fk = :id order by data_horario_registro desc;';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id',$id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $results ?? null;
}  

function get_model_meals(PDO $pdo, int $user_id){

$query='SELECT * from full_rel_ali_ref where id_users = :user_id;';

// $query= 'SELECT  * from refeicoes as r 
// inner join alimentos_refeicoes as al on r.id_refeicoes = al.refeicoes_fk
// INNER join alimentos as a on al.alimentos_fk = a.id_alimentos where r.user_fk = :user_id;';

$stmt= $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results ? $results : null;
}