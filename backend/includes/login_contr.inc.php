<?php
declare(strict_types=1);

require_once 'login_model.inc.php';

function is_input_empty(string $email,string $pwd) :bool
{
    if (empty($pwd) || empty($email)) {
        return true;
    }
    return false;
} 

function is_pwd_wrong(string $iPwd, string $oPwdHash) : bool{

if(!password_verify($iPwd, $oPwdHash)){
    return true;
}

return false;
}

function get_user_by_email(PDO $pdo, $email){
return get_user($pdo, $email);
}