<?php

declare(strict_types=1);

function check_signup_errors()
{
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        unset($_SESSION['errors_signup']);
    }
}

function signup_input(){

if(isset($_SESSION['signup_data']['nome']) && !empty($_SESSION['signup_data']['nome'])){
echo'        <div class="campo">
          <label for="nome">Nome completo</label>
          <input type="text" id="nome"n name ="nome" value="'. $_SESSION['signup_data']['nome'].'">
        </div>
';
}else{
echo'        <div class="campo">
          <label for="nome">Nome completo</label>
          <input type="text" id="nome" name="nome" placeholder="Maria Silva">
        </div>
';
}
if(isset(['signup_data']['email']) && !isset($_SESSION['errors_signup']['email_registered']) && !isset($_SESSION['errors_signup']['invalid_email'])
   && !empty($_SESSION['signup_data']['email'])){

echo'        <div class="campo">
          <label for="email">E-mail<</label>
          <input type="email" id="email" name="email" value="'. $_SESSION['signup_data']['email'].'">
        </div>
';
}else{
    
echo '
        <div class="campo">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="seu@email.com">
        </div>';    
}

unset($_SESSION['signup_data']);
}


