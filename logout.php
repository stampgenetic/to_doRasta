<?php
require_once('../src/Auth.php'); // O autoloading cuidaria disso, mas por enquanto fazemos manualmente.

// A classe Auth não precisa do pdo para o logout, mas mantemos o padrão
require_once('../database/Database.php');
$db = Database::getInstance()->getConnection();
$auth = new Auth($db);

$auth->logout();
header('Location: login.php');
exit;