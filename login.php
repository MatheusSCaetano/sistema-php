<?php

include("conexao.php");
$erro = [];

if (isset($_POST['email']) && strlen($_POST['email']) > 0) {
    if (!isset($_SESSION)) //start naSESSAO
        session_start();  //session para criar variaveis que poderao ser utilizadas em todas as paginas do site

    $_SESSION['email'] = $mysqli->escape_string($_POST['email']); // escape_string -> limpa o dado de possiveis ataques
    //$_SESSION['senha'] = md5($_POST['senha']); //criptografando a senha 2x com "md5"
    $_SESSION['senha'] = $_POST['senha'];
    $sql_code = "SELECT senha, codigo FROM usuario WHERE email ='$_SESSION[email]'";
    //executar codigo
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    //pegar resultado:
    $dado = $sql_query->fetch_assoc();

    $total = $sql_query->num_rows; //contador = quantidade retornada pelo banco de dados de usuarios com aquele email

    if ($total == 0) {
        $erro[] = "Este e-mail não está cadastrado";
    } else {

        if ($dado['senha'] == $_SESSION['senha']) { //se a senha do resultado for igual a senha que o user digotou

            $_SESSION['usuario'] = $dado['codigo']; //SESSION USUARIO INDICA O LOGIN 

        } else {
            $erro[] = "Senha incorreta";
        }
    }

    if (count($erro) == 0 || !isset($erro)) {
        echo "<script> alert('Login efetuado com sucesso!');  location.href='sucesso.php'; </script>";
    }
}

?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: #D6C9B4;
        flex-direction: column;
        display: block;
    }

    header {
        text-decoration: none;

    }

    .menu {
        width: 100%;
        display: flex;
        text-decoration: none;

    }

    .logo-login img {
        width: 100px;
    }

    .logo-login {
        width: 50%;
    }

    .menu-items {
        text-decoration: none;
        padding: 10;
        margin-left: 90;
    }

    .menu-items u {
        display: flex;
        text-decoration: none;

    }

    .menu-items a {
        text-decoration: none;
        padding: 10;

    }


    form {

        display: flex;
        width: 100%;
        align-items: center;
        flex-direction: column;
    }

    form p {
        margin: 10;
        padding: 5;
        font-weight: bold;
        border: solid 2px black;
        border-radius: 5px;
    }

    form p a {
        text-decoration: none;
    }

    input {
        display: block;
        margin: 10px;
        width: 25%;
        text-align: center;
        border: black solid 2px;
        border-radius: 5px;
    }

    a {
        color: black;
    }
</style>



<html>

<head>
    <header>
        <div class="menu">
            <div class="logo-login"><img src="./images/logo.png"></div>

            <div class="menu-items">
                <u>
                    <a href="login.php">HOME</a>
                    <a href="cadastro.php">CADASTRE-SE</a>
                    <a href="">CONTATO</a>

                </u>
            </div>

        </div>

    </header>
</head>

<body>


    <?php

    if (count($erro) > 0)
        foreach ($erro as $msg) {
            echo "<p> $msg </p>";
        }



    ?>

    <form method="POST" action="">
        <input value="" type="text" name="email" placeholder="Digite seu e-mail">
        <input type="password" name="senha" placeholder="Digite sua senha">
        <input value="Entrar" type="submit">
        <p><a href="esqueceu.php">Esqueceu sua senha?</a></p>
        <p><a href="cadastro.php">Cadastre-se</a></p>
    </form>


</body>

</html>