<?php
declare(strict_types =1);

require_once 'perfil_model.inc.php';

function is_input_empty(string $username,int $age, int $DM, int $min, int $max) :bool
{
    if (empty($username) || empty($age) || empty($DM|| empty(min) || empty(max)) {
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

function is_target_invalid(int $min, int $max) :bool {
if($min <20 || $min >1500 || $max <20 || $max >1500 || $min>$max){
return true;
}
return false;
}


function get_birth_year(int $age) :int
{
    return (int)date('Y') - $age;
}


function alter_usuario(PDO $pdo, int $id, string $username,int $age, int $DM, string $medic, int $min, int $max)
{
    alter_user($pdo, $id, $username,$age, $DM, $medic, $min, $max);
}
