<?php

session_start();

// Conexão com o banco de dados
$dbHost = "localhost"; 
$dbUsername = "root"; 
$dbPassword = "";
$dbName = "saap_novo";

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Falha na conexão: " . $db->connect_error);
}

// Validação dos dados do formulário
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validação do nome de usuário
    if (empty($username)) {
        echo "<p class='error'>Informe seu nome de usuário.</p>";
        exit();
    }

    // Validação da senha
    if (empty($password)) {
        echo "<p class='error'>Informe sua senha.</p>";
        exit();
    }

    // Consulta SQL para verificar usuário e senha (sem criptografia)
    $sql = "SELECT * FROM usuarios WHERE nome = ? AND senha = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificando se o usuário existe
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Usuário e senha válidos
        $_SESSION['id_usuario'] = $row['id'];
        $_SESSION['nome_de_usuario'] = $row['nome_de_usuario'];
        header("Location: paginaPrincipal.php"); // Redirecione para a página inicial ou página de perfil
        exit();
    } else {
        // Usuário ou senha incorretos
        echo "<p class='error'>Usuário ou senha incorretos.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="page">
        <form method="post" class="formLogin">
            <h1>Login</h1>
            <h2>Bem vindo de volta :)</h2>
            <p>Digite os seus dados de acesso nos campos abaixo.</p>
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required placeholder="Digite seu usuário" autofocus="true">
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required placeholder="Digite sua senha">
            <br><br>
            <button type="submit" class="btn-acessar">Acessar</button>
            <a href="/">Esqueci minha senha</a>
            <p>Ainda não tem conta? <a href="registro.html">Cadastre-se</a></p>
        </form>
    </div>
</body>
</html>
