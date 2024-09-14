<?php 

$hostname = "localhost";
$bancodedados = "sistemaloginphp";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($hostname,$usuario,$senha,$bancodedados);
if($mysqli->connect_errno){
    echo "Erro de conexão ao banco: (" .$mysqli->connect_errno . ") " . $mysqli->connect_error;
}


?>