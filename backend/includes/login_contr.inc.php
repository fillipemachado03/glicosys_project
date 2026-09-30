<?php
declare(strict_types=1);

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