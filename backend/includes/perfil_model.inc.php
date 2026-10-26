<?php
declare(strict_types=1);

function get_medic_id_by_name(PDO $pdo, string $medic_name) :int|null
{
    $query = 'SELECT id_medicos from medicos where nome = :nome';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nome', $medic_name);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results ? $results['id_medicos'] : null;
}

function alter_user(PDO $pdo, int $id,string $username,int $age, int $DM, string $medic, int $min, int $max)
{

    
    $query = 'UPDATE users set nome = :nome,
data_de_nascimento = :data_de_nascimento, tipo_diabetes = :tipo_diabetes,
 min_meta_glicemica = :min, max_meta_glicemica = :max, medicos_fk= :medicos_fk
 where id_users = :id
';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nome', $username);
    $birth_Year = get_birth_year($age);
$medic_id = get_medic_id_by_name($pdo, $medic);


    $stmt->bindParam(':data_de_nascimento', $birth_Year);
    $stmt->bindParam(':tipo_diabetes', $DM);
    $stmt->bindParam(':medicos_fk', $medic_id);
    $stmt->bindParam(':min', $min);
    $stmt->bindParam(':max', $max);
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}

function get_model_user(PDO $pdo, int $id) : array{
$query ='SELECT * from users where id_users = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
return $results ? $results : null;
} 
