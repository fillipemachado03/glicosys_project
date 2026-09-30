<?php
declare(strict_types=1);

function check_login_errors()
{
    if (isset($_SESSION['errors_login'])) {
        $errors = $_SESSION['errors_login'];
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        unset($_SESSION['errors_login']);
    }
}

function login_input(){
if(isset(['login_data']['email']) && !isset($_SESSION['errors_login']['email_registered']) && !isset($_SESSION['errors_login']['invalid_email'])
   && !empty($_SESSION['login_data']['email'])){

echo'        <div class="campo">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" value="'. $_SESSION['login_data']['email'].'" placeholder="seu@gmail.com">
        </div>
';
}else{
    
echo '
        <div class="campo">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="seu@email.com">
        </div>';    
}

unset($_SESSION['login_data']);
}

//    <div class="campo">
//           <label for="email">E-mail</label>
//           <input type="email" id="email" name='email' placeholder="seu@email.com">
//         </div>
