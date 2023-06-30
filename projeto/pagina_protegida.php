<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    // Usuário não autenticado, redirecionar de volta para a página de login
    header("Location: login.php");
    exit();
}

// O usuário está autenticado, exibir o conteúdo protegido
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página Protegida</title>
</head>
<body>
    <h2>Bem-vindo, <?php echo $_SESSION["username"]; ?></h2>
    <p>Esta é uma página protegida.</p>
    <p><a href="logout.php">Sair</a></p>
</body>
</html>
