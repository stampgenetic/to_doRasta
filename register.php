<?php
session_start();
require_once('../database/Database.php');
require_once('../src/Auth.php');

$db = Database::getInstance()->getConnection();
$auth = new Auth($db);

// Se o usuário já estiver logado, redireciona para o index
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (!empty($user) && !empty($pass)) {
        $result = $auth->register($user, $pass);
        if ($result === true) {
            // O método register já faz o login, então podemos redirecionar
            header('Location: index.php');
            exit;
        } else {
            $error = $result;
        }
    } else {
        $error = "Preencha todos os campos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Lista Rasta</title>
    <link rel="stylesheet" href="styles/login.css">
    <style>
        body {
            /* Substitua 'assets/background.jpg' pelo caminho e nome da sua imagem */
            background-image: url('assets/background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
    <form method="POST" action="register.php">
        <h2>Cadastre-se</h2>
        <?php if (isset($error)): ?>
            <p style="color: #ef4444; margin-bottom: 15px;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Cadastrar</button>
        <p>Já tem uma conta? <a href="login.php">Faça o login</a></p>
    </form>
</body>
</html>