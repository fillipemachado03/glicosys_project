<?php
unset($_SESSION['user_id']);
unset($_SESSION['user_username']);
unset($_SESSION['user_DM']);
unset($_SESSION['last_regeneration']);

$pdo= null;
$stmt = null;
header('Location: ../frontend/pages/login.html');
die();