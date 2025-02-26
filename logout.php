<?php
session_start();
require_once 'includes/auth.php';
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

$auth->logout();
?>