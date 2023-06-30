<?php  // Permite que o usuário faça LOGOUT
session_start();

// Limpar todos os dados da sessão
session_unset();

// Destruir a sessão
session_destroy();

// Redirecionar de volta para a página de login
header("Location: login.php");
exit();
?>
