<?php
session_start(); 
include('conexao.php');

// Verificar se usuario ta logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");  
    exit();
}

// Verificar se o botao de logout foi clicado
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy(); 
    header("Location: index.php"); 
    exit(); 
}


$error_message = "";
$success_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
    $newPassword = mysqli_real_escape_string($link, $_POST['newPassword']);
    $confirmPassword = mysqli_real_escape_string($link, $_POST['confirmPassword']);

    // Verificar se senhas são iguais
    if ($newPassword !== $confirmPassword) {
        $error_message = "As senhas não coincidem!";
    } else {
       
        if (isset($_SESSION['usuario'])) {
            $username = $_SESSION['usuario'];

            
            $query = "UPDATE usuarios SET senha='$newPassword' WHERE user='$username'";

            if (mysqli_query($link, $query)) {
                $success_message = "Senha alterada com sucesso!";
            } else {
                $error_message = "Erro ao atualizar a senha: " . mysqli_error($link);
            }
        } else {
            $error_message = "Usuário não encontrado. Por favor, faça login.";
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
    $username = $_SESSION['usuario']; 
    
    // Deletar usuario
    $delete_query = "DELETE FROM usuarios WHERE user='$username'";
    
    if (mysqli_query($link, $delete_query)) {
        session_unset();
        session_destroy();  
        header("Location: index.php"); 
        exit();  
    } else {
        $error_message = "Erro ao excluir a conta: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>AquaMarine - Inicio</title>
    <link rel="stylesheet" href="style.css">
    <style>
      
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('imagens/agua.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

       .hover-area {
            position: fixed;
            top: 0;
            left: 0;
            width: 40px; 
            height: 100vh;
            z-index: 10;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -250px; 
            height: 100%;
            width: 250px;
            background-color: rgba(0, 0, 0, 0.7);
            transition: left 0.3s ease;  
            padding-top: 20px;
            padding-left: 10px;
            padding-right: 10px;
            z-index: 20;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 10px;
            text-decoration: none;
            font-size: 1.2em;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }

      
        .content {
            margin-left: 0;
            padding: 20px;
            text-align: center;
        }

       
        h1 {
            font-size: 3em;
            margin-bottom: 30px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        
.categories {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 40px;
}

.category {
    background-color: rgba(0, 0, 0, 0.7);
    padding: 20px;
    border-radius: 10px;
    width: 200px;
    cursor: pointer;
    transition: transform 0.3s ease;
    text-align: center; 
}

.category:hover {
    transform: scale(1.05);
    background-color: rgba(0, 0, 0, 0.9);
}

.category a {
    text-decoration: none;
    color: white; 
    display: block; 
}

.category h2 {
    font-size: 1.5em;
    margin: 0;
}

        footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 0.9em;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            background-color: #333;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
        }

        .modal input {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .modal button {
            padding: 10px 20px;
            background-color: #0077b6;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal button:hover {
            background-color: #005f8a;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .image-container {
    display: flex;
    justify-content: center; 
    margin-top: 20px;       
}

.center-image {
    max-width: 300px;      
    height: auto;            
}

    </style>
</head>
<body>

<div class="hover-area"></div>

<div class="sidebar" id="sidebar">
    <a href="inicio.php">Início</a>
    <a href="#" id="editProfileBtn">Perfil - Alterar Senha</a>
    <form method="POST" action="">
        <button type="submit" name="logout" style="background-color: #f44336; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; width: 100%;">Sair</button>
    </form>
    <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível.');">
        <button type="submit" name="delete_account" style="background-color: #ff0000; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 10px;">Excluir Conta</button>
    </form>
</div>


   
    <div class="content">
    <h1>Os melhores produtos você encontra aqui!</h1>

        <?php
        if ($error_message != "") {
            echo "<p style='color:red;'>$error_message</p>";
        }
        if ($success_message != "") {
            echo "<p style='color:green;'>$success_message</p>";
        }
        ?>

<div class="categories">
    <div class="category">
        <h2><a href="peixes.php">Peixes</a></h2>
    </div>
    <div class="category">
        <h2><a href="invertebrados.php">Invertebrados</a></h2>
    </div>
    <div class="category">
        <h2><a href="acessorios.php">Acessórios</a></h2>
    </div>
    <div class="category">
        <h2><a href="plantas.php">Plantas</a></h2>
    </div>
    <div class="category">
        <h2><a href="corais.php">Corais</a></h2>
    </div>
</div>
<div class="image-container">
    <img src="imagens/tartaruga.png" alt="Logo" class="center-image">
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const hoverArea = document.querySelector('.hover-area');

    // Função para abrir a sidebar
    function openSidebar() {
        sidebar.style.left = '0'; 
    }

    // Função para fechar a sidebar
    function closeSidebar() {
        sidebar.style.left = '-250px';
    }

    // Colocar mouse em cima o hover = abrir
    hoverArea.addEventListener('mouseenter', openSidebar);

    // Tirar mouse de cima do hover = fechar
    sidebar.addEventListener('mouseleave', closeSidebar);
</script>

        <footer>
            <p>&copy; 2024 AquaShop | Todos os direitos reservados</p>
        </footer>
    </div>

<div id="editProfileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Alterar senha</h2>
        <form method="POST" action="">
            <label for="newPassword">Nova Senha:</label>
            <input type="password" id="newPassword" name="newPassword" required>

            <label for="confirmPassword">Confirmar Senha:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <button type="submit">Confirmar</button>
        </form>
    </div>
</div>

<script>
    var modal = document.getElementById("editProfileModal");
    var btn = document.getElementById("editProfileBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
