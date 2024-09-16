<?php

//INSERIR NOVOS USERS
include('conexao.php');


if (isset($_POST['cadastrar']) and !empty($_POST['email']) and !empty($_POST['senha']) and !empty($_POST['confirmasenha'])) {
    $erros = [];
    //filtrando email valido
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

    //filtrando nome valido:
    $nome = $mysqli->escape_string($_POST['nome']);
    $senha = $_POST['senha'];
    $sobrenome = $mysqli->escape_string($_POST['sobrenome']);
    $sexo = $_POST['selectsexo'];

    if ($_POST['senha'] != $_POST['confirmasenha']) {
        $erros[] = "As senhas digitadas são diferentes!";
    }
    $queryEmail = "SELECT email FROM usuario WHERE email = '$email' "; //'email'
    //SELECT CAMPO EMAIL DA TABELA USUARIOS QUANDO EMAIL = $_SESSION['']

    //buscar email    
    $buscaEmail = $mysqli->query($queryEmail) or die($mysqli->error);


    $total = $buscaEmail->num_rows;

    if ($total > 0) {
        $erros[] = "E-mail já cadastrado!";
    }

    if (empty($erros)) {
        $query = "INSERT INTO usuario (nome, sobrenome, email, senha, sexo,
             datadecadastro) VALUES ('$nome', '$sobrenome', '$email', '$senha', '$sexo' 
             , NOW())";

        $executar = $mysqli->query($query);

        if ($executar) {
            echo "<script>alert('Cadastro efetuado com sucesso!')</script>";
        } else {
            $erros[] = "Erro ao inserir user.";
        }
    } else {
        foreach ($erros as $erro) {
            echo "<p> $erro</p>";
        }
    }
} else if (isset($_POST['cadastrar']) and empty($_POST['email'])) {
    echo "<script>alert('Campo e-mail nao preenchido ')</script>";
} else if (isset($_POST['cadastrar']) and empty($_POST['senha'])) {
    echo "<script>alert('Campo senha nao preenchido ')</script>";
} elseif (isset($_POST['cadastrar']) and empty($_POST['confirmasenha'])) {
    echo "<script>alert('Campo confirmar senha nao preenchido ')</script>";
}



?>
 <style>
        *{
            font-family: "Public Sans", sans-serif;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        header {
            margin-top: 50px;
            max-width: 100%;
            display: flex;
            flex-direction: column;
                align-items: center;
        }
        .logo img{
            width: 100px;

        }

        body {
            background-color: lightyellow;
        }

        form {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input {
            display: block;
            width: 30%;
            padding: 5;
            margin: 8;
            border: solid black 2px;
            border-radius: 8px;

        }
        a{
            text-decoration: none;
            color: black;
        }

        select {
            width: 30%;
        }

        form input[type="submit"] {
            cursor: pointer;
        }
    </style>
<html>

<head>
    <header>
        <h1>Cadastre-se Gratuitamente</h1>
        <div class="logo">
        <a href="login.php" ><img src="./images/logo.png"></a>
        </div><!-- logo-->
        <div class="menu">

        </div>

    </header>
</head>

<body>
   

    <form method="POST" action="">
        <input type="text" name="nome" placeholder="Dgite seu nome">
        <input type="text" name="sobrenome" placeholder="Dgite seu sobrenome">
        <input type="email" name="email" placeholder="Dgite seu email">
        <select name="selectsexo">
            <option value="masculino">Masculino</option>
            <option value="feminino">Feminino</option>
        </select>
        <input type="password" name="senha" placeholder="Dgite a senha">
        <input type="password" name="confirmasenha" placeholder="Confirme a senha">
        <input value="Cadastrar" name="cadastrar" type="submit">
        <h3>Já possui conta?</h3> <hr>
        <a href="login.php">  <p>Entre agora</p></a>

    </form>

</body>

</html>