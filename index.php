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



// Consulta SQL para verificar usuário e senha (sem criptografia)
$sql = "SELECT * FROM horario";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Responsiva</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="left">
            <p>Olá, <?= $_SESSION['nome_de_usuario'] ?? 'Mariana' ?></p>
        </div>
        <div class="right">
            <p>Gestão da Tecnologia da Informação | Matutino</p>
        </div>
    </header>
    <main>
        <section class="aulas-hoje">
            <h2>Aulas de hoje</h2>
            <div class="container-cards">
                <?php
                    foreach ($result as $row) {
                     
                ?>
                <div class="card">
                    <h3>Nome da Aula</h3>
                    <p>Professor: <?= $row['nome_do_professor'] ?></p>
                    <p>Horário: <?= $row['horario_inicio'] ?> -  <?= $row['horario_fim'] ?></p>
                    <p>Status: Confirmada</p>
                </div>
                <?php } ?>
            </div>
        </section>
        <section class="eventos-unidade">
            <h2>Eventos da unidade escolar</h2>
            <div class="evento">
                <h3>Evento 1</h3>
                <p>Descrição do evento 1</p>
            </div>
            <div class="evento">
                <h3>Evento 2</h3>
                <p>Descrição do evento 2</p>
            </div>
            <div class="evento">
                <h3>Evento 3</h3>
                <p>Descrição do evento 3</p>
            </div>
        </section>
    </main>
</body>
</html>
