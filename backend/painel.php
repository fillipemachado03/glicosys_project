<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/painel_contr.inc.php';
require_once 'includes/config_session.inc.php';

$id= (int)$_SESSION['user_id'];

$ref = get_ref($pdo, $id);
$glics = get_glicos($pdo, $id);
$last_glic = get_last_glic($pdo, $id);
$avg_glic = get_avg_glic($pdo, $id);
$perc = get_perc_in_meta($pdo, $id);
