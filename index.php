<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>AquaMarine</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
        body {
            font-family: Arial, sans-serif;
            color: #fff;
            background: url('imagens/agua.jpg') no-repeat center center fixed; 
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

      
        @keyframes slideIn {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        
        h1 {
            text-align: center;
            font-size: 3em;
            margin-top: 100px;
            animation: fadeIn 2s ease-in-out, slideIn 2s ease-out;
            animation-delay: 0.5s;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        
        .login-link {
            display: block;
            text-align: center;
            font-size: 1.5em;
            color: #fff;
            text-decoration: none;
            margin-top: 20px;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            width: 200px;
            margin: 20px auto;
            border-radius: 5px;
            opacity: 0;
            animation: fadeIn 2s ease-in-out forwards;
            animation-delay: 1s;
        }

        .login-link:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

      
        .cadastro-link {
            display: block;
            text-align: center;
            font-size: 1.5em;
            color: #fff;
            text-decoration: none;
            margin-top: 20px;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            width: 200px;
            margin: 20px auto;
            border-radius: 5px;
            opacity: 0;
            animation: fadeIn 2s ease-in-out forwards;
            animation-delay: 2s;
        }

        .cadastro-link:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

    </style>
</head>
<body>
    <?php

    session_start();
    include('conexao.php'); 
    ?>

    <h1>Bem-vindo ao AquaMarine! </h1>
    <a href="login.php" class="login-link">Login</a>
    <a href="cadastro.php" class="cadastro-link">Cadastrar</a>

</body>
</html>
