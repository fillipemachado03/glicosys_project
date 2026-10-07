<?php
require_once '../../backend/includes/refeicoes_contr.inc.php';
require_once '../../backend/includes/dbh.inc.php';

$r = get_meals($pdo, (int)$_SESSION['user_id']);