<?php

declare(strict_types=1);

function get_email(PDO $pdo, string $email) :array|null
{
    $query = 'SELECT email from users where email = :email';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results ? $results['email'] : null;
}
 
function get_medic_id_by_name(PDO $pdo, string $medic_name) :array|null
{
    $query = 'SELECT id_medicos from medicos where nome = :nome';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nome', $medic_name);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results ? $results['id_medicos'] : null;
}

function get_user_by_email(PDO $pdo, string $email) :array|null 
{
    $query = 'SELECT * from users where email = :email;';

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return  $results['id_users'] ? $results : null;
}


function set_user(PDO $pdo, string $username, string $pwd, string $email, int $age, int $DM, string $medic)
{
    $query = 'INSERT into users(nome, email, senha_hash, data_de_nascimento, tipo_diabetes, medicos_fk)
values (:nome, :email, :senha_hash, :data_de_nascimento, :tipo_diabetes, :medicos_fk)';

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nome', $username);

    $options = ['cost' => 11];
    $hashed_PWD = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $birth_Year = get_birth_year($age);

    $medic_id = get_medic_id_by_name($pdo, $medic) ?? null;

    $stmt->bindParam(':senha_hash', $hashed_PWD);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':data_de_nascimento', $birth_Year);
    $stmt->bindParam(':tipo_diabetes', $DM);
    $stmt->bindParam(':medicos_fk', $medic_id);

    $stmt->execute();
}
