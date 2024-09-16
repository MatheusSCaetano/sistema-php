<?php
include('conexao.php');
$erro = [];
if (isset($_POST['ok'])) {

    $email = $mysqli->escape_string($_POST['email']); //variavel email recevendo email e tratando email com escape string

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //CASO NAO SEJA VALIDO
        $error[] = "E-mail digitado não é valido! ";
    }

    $sql_code = "SELECT email FROM usuario WHERE email = '$email'";
    $sql_query = $mysqli->query($sql_code) or die ($mysqli->error);
    $dado = $sql_query->fetch_assoc();
    $total = $sql_query->num_rows;

    if($total  == 0 ){
        $erro[] = "E-mail não cadastrado";
    }

    if (count($erro) == 0 && $total > 0) {

        $novasenha = substr(md5(time()), 0, 6);

        $novasenhacriptografada = md5(md5($novasenha));


        if (mail($email, "Sua nova senha.", "Sua nova senha: ".$novasenha)) { //apenas se o email for enviado que iremos alterar a senha no vbanco de dados

            $sql_code = "UPDATE usuario SET senha = '$novasenhacriptografada' WHERE email = '$email'";

            $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

            if($sql_query){
                $erro[] = "Senha alterada com sucesso!";
            }
        }
    }
}


?>

<style>
    body {
        background-color: #D6C9B4;
        max-width: 100%;
        background-repeat: no-repeat;
        text-align: center;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    input {
        display: block;
        margin: 8;
        padding: 3;
        border: black solid 2px;
        border-radius: 6px;
        width: 30%;
        text-align: center;
    }

    input[type='submit'] {
        padding: 3;
        width: 30%;
        cursor: pointer;
    }

    .logo-esqueceu img {
        width: 100px;
    }
</style>
<html>

<head>
    <header>
        <div class="logo-esqueceu">
            <img src="./images/logo.png">
        </div>
    </header>
</head>

<body>

    <h1>Recuperação de senha</h1>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Digite seu e-mail">
        <input type="submit" name="ok" value="Enviar">
    </form>

    <?php 
    if(count($erro) > 0){
        foreach($erro as $msg){
            echo "<p> $msg </p>";
        }
    }
    
    
    ?>
</body>

</html>