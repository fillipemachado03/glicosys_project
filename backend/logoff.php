<?php
require_once 'includes/config_session.inc.php';
unset($_SESSION['user_id']);
unset($_SESSION['user_username']);
unset($_SESSION['user_DM']);
unset($_SESSION['last_regeneration']);


header('Location: ../frontend/pages/login.php');
die();