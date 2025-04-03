<?php

$link = mysqli_connect("localhost", "root", "", "marinho") 
        or die("Não encontrei o Mysql");

if (!$link) {
    die("Falha na conexão: " . mysqli_connect_error());
}


?>
