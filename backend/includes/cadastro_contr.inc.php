<?php

declare(strict_types=1);

require_once 'cadastro_model.inc.php';

function is_input_empty(string $username, string $pwd, string $email, int $age, int $DM) :bool
{
    if (empty($username) || empty($pwd) || empty($email) || empty($age) || empty($DM)) {
        return true;
    }
    return false;
}

function is_email_invalid(string $email) :bool
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function is_email_registered(PDO $pdo, string $email) :bool
{
    if (get_email($pdo, $email) === strtolower($email)) {
        return true;
    }
    return false;
}

function is_DM_INvalid(int $DM) :bool
{
    if ($DM === 1 || $DM === 2) {
        return false;
    }
    return true;
}

function is_age_invalid(int $age) :bool
{
    if($age < 0 || $age > 150){
        return true;
    }
        return false;
}

function get_birth_year(int $age) :int
{
    return (int)date('Y') - $age;
}


function create_user(PDO $pdo, string $username, string $pwd, string $email, int $age, int $DM, string $medic)
{
    set_user($pdo, $username, $pwd, $email, $age, $DM, $medic);
}
