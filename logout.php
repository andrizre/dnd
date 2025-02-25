<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

session_start();
$auth = new Auth(null);
$auth->logout();
header('Location: index.php');
exit;
?>