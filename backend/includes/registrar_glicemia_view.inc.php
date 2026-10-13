<?php
declare(strict_types=1);

function check_set_glic_errors(){
    if (isset($_SESSION['errors_reg_glic'])) {
        $errors = $_SESSION['errors_reg_glic'];
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        unset($_SESSION['errors_reg_glic']);
    }

}