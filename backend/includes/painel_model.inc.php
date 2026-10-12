<?php
declare(strict_types =1);

function get_last_glic(PDO $pdo, int $id){
$query='SELECT * from glicemia where user_fk = :id order by data_horario_registro desc limit 1;';
$stmt= $pdo->prepare($query);
$stmt->bindParam(':id',$id);
$stmt->execute();

$results = $stmt->fetch(PDO::FETCH_ASSOC);
return $results ? $results : null;
};

function get_avg_glic(PDO $pdo, int $id){
$query='Select avg(nivel_glicose) from glicemia where user_fk = :id;';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id',$id); 
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
return $results ? $results : null;
};

function get_total_glic(PDO $pdo, int $id){
$query='select count(id_glicemia) from glicemia where user_fk = :id;';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id',$id);
$stmt->execute();
$results =$stmt->fetch(PDO::FETCH_ASSOC);
return $results ? $results : null;
};

function get_meals(PDO $pdo, int $user_id){

$query= 'SELECT  * from refeicoes as r 
inner join alimentos_refeicoes as al on r.id_refeicoes = al.refeicoes_fk
INNER join alimentos as a on al.alimentos_fk = a.id_alimentos where r.user_fk = :user_id;';

$stmt= $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results ? $results : null;
}


function get_glics(PDO $pdo, int $id){
$query='SELECT * from glicemia where user_fk = :id;';
$stmt = $pdo->prepare($quey);
$stmt->bindParam(':id',$id);
$stmt->execute();
$results=$stmt->fetch(PDO::FETCH_ASSOC);
return $results ? $results : null;
};

function get_glic_meta(PDO $pdo, int $id){
$query = 'select min_meta_glicemica, max_meta_glicemica from users where id_users = :id;';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id',$id);
$stmt->execute();
$results =$stmt->fetch(PDO::FETCH_ASSOC);
return $results ? $results : null;
};

