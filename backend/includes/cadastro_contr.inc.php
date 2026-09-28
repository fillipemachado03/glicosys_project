<?php

declare(strict_types=1);

require_once 'cadastro_model.inc.php';

function is_input_empty(string $username, string $pwd, string $email, int $age, int $DM)
{
    if (empty($username) || empty($pwd) || empty($email) || empty($age) || empty($DM)) {
        return true;
    }
    return false;
}

function is_email_invalid(string $email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function is_email_registered(PDO $pdo, string $email)
{
    if (get_email($pdo, $email) === strtolower($email)) {
        return true;
    }
    return false;
}

function is_DM_valid(int $DM)
{
    if ($DM == 1 || $DM == 2) {
        return true;
    }
    return false;
}

function get_birth_year(int $age)
{
    return (int)date('Y') - $age;
}


function create_user(PDO $pdo, string $username, string $pwd, string $email, int $age, int $DM, string $medic)
{
    set_user($pdo, $username, $pwd, $email, $age, $DM, $medic);
}
