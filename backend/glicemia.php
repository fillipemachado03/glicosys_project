<?php
require_once'includes/dbh.inc.php';
require_once'includes/glicemia_contr.inc.php';
$glics = get_glics($pdo, $_SESSION['user_id']);