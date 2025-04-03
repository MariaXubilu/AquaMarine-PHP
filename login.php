<?php
session_start();
include('conexao.php');
if (isset($_SESSION['usuario'])) {
    header("Location: inicio.php");
    exit(); 
}

$error_message = ""; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $senha_digitada = $_POST['password'];

    $query = "SELECT senha FROM usuarios WHERE user = '$username'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $senha_armazenada = $row['senha'];

      
        if ($senha_digitada === $senha_armazenada) {
           
            $_SESSION['usuario'] = $username; 
            header("Location: inicio.php");
            exit(); 
        } else {
            $error_message = "Usuário ou senha incorretos!";
        }
    } else {
        $error_message = "Usuário não encontrado!";
    }
}

mysqli_close($link); 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        <h2>Login</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <input type="submit" value="Entrar">
        </form>

        <?php
        if ($error_message) {
            echo "<div class='error-message'>$error_message</div>";
        }
        ?>

        <p>Não tem uma conta? <a href="cadastro.php">Clique aqui</a></p>
    </div>
</body>
</html>
