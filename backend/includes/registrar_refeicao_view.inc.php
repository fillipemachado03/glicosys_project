<?php
declare(strict_types=1);

function check_ref_errors()
{
    if (isset($_SESSION['ref_errors'])) {
        $errors = $_SESSION['ref_errors'];
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        unset($_SESSION['ref_errors']);
    }
}