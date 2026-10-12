<?php
require_once'includes/dbh.inc.php';
require_once'includes/painel_contr.inc.php';

$ref = get_ref($pdo, (int)$_SESSION['user_id']);
$glcs = get_glicos($pdo, (int)$_SESSION['user_id']);
