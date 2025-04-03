<?php
// Incluir a conexão com o banco de dados
session_start();
include('conexao.php'); // Inclui a conexão com o banco de dados

// Processar o formulário de cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($link, $_POST['username']); // 'username' vem do formulário
    $senha = $_POST['password']; 

    // Inserir os dados no banco
    $query = "INSERT INTO usuarios (user, senha) VALUES ('$user', '$senha')";
    if (mysqli_query($link, $query)) {
        echo "<p>Cadastro realizado com sucesso! <a href='login.php'>Clique aqui para fazer login</a></p>";
    } else {
        echo "<p>Erro ao cadastrar: " . mysqli_error($link) . "</p>";
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('imagens/agua.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 320px;
            padding: 50px;
            margin: 100px auto;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
        }

        h2 {
            text-align: center;
            font-size: 2em;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 1.2em;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
        }

        input[type="submit"] {
            width: 107%;
            padding: 10px;
            font-size: 1.2em;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 15px;
        }

        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Cadastro de Usuário</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <input type="submit" value="Cadastrar">
        </form>

        <p>Já tem uma conta? <a href="login.php">Clique aqui</a></p>
    </div>
</body>
</html>
