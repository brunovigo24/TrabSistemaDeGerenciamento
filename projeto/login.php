<?php   // Primeira tentativa de inserção de login 
session_start();
 include("./Model/Myconnect.php");

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar as credenciais do usuário
    $username = $_POST["username"];
    $password = $_POST["password"];
    $database = "login";
    $host = "localhost";
    $connnection = new Myconnect();

    //$mysql = new msqli($host, $usuario, $senha, $database);

    if($mysqli ->error) {
        die("Falha ao conectar ao banco de dados: " . $mysqli->error);
    }

    

    // Tentei adicionar uma lógica para verificar as credenciais do usuário
    // por exemplo, consultando um banco de dados ou comparando com valores armazenados
    
    if ($username == "Bruno" && $password == "2424") {
        // Autenticação bem-sucedida, iniciar a sessão
        $_SESSION["username"] = $username;
        
        // Redirecionar para a página protegida
        header("Location: index.php");
        exit();
    } else {
        // Credenciais inválidas, exibir mensagem de erro
        $erro = "Usuário ou senha inválidos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tela de Login</title>
</head>
<style>
        /* Estilos personalizados */
        form {
            padding: 30px; /* Define o preenchimento do formulário */
        }

        label, input, p {
            margin: 15px 0; /* Define as margens para os elementos */
        }
    </style>
<body>
    <h2>Tela de Login</h2>
    <form action="login.php" method="POST">
        <label for="username">Usuário:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Entrar">
        
        <?php if (isset($erro)): ?>
            <p><?php echo $erro; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
