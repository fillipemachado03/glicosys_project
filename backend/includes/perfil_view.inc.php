<?php
declare(strict_types=1);

function check_perfil_errors()
{
    if (isset($_SESSION['errors_perfil'])) {
        $errors = $_SESSION['errors_perfil'];
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        unset($_SESSION['errors_perfil']);
    }
}

function perfil_input(){

if(isset($_SESSION['perfil_data']['nome']) && !empty($_SESSION['perfil_data']['nome'])){
echo'        <div class="campo">
          <label for="nome">Nome completo</label>
          <input type="text" id="nome"n name ="nome" value="'. $_SESSION['perfil_data']['nome'].'">
        </div>
';
}else{
echo'        <div class="campo">
          <label for="nome">Nome completo</label>
          <input type="text" id="nome" name="nome" placeholder="">
        </div>
';
}

unset($_SESSION['perfil_data']);
}