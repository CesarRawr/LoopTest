
<!DOCTYPE html>

<?php
session_start();
include_once('./public/php/connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $database = new Connection();
    $db = $database->open();
    
    try{
    
        $username = $_POST["username"];
        $contra = $_POST["contra"];
        
        $_GRABAR_SQL = "SELECT id, nombre, apellido, nickname, is_admin FROM usuario WHERE nickname = '$username' AND contrasena = '$contra'";

        $data = $db->query( $_GRABAR_SQL);  
        $hi = $data -> fetchAll();

        if($hi){
            $_SESSION['id'] = $hi[0]['id'];
            $_SESSION['nombre'] = $hi[0]['nombre'];
            $_SESSION['apellido'] = $hi[0]['apellido'];
            $_SESSION['nickname'] = $hi[0]['nickname'];
            $_SESSION['is_admin'] = $hi[0]['is_admin'];

            header("location: home.php");
        }else{
            alertMessage("Usuario y/o usuario incorrectos");
        }

    }catch(PDOException $e){
        alertMessage("Algo salió mal al conectarse con la base de datos");
    }

    $database->close();
}

?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Préstamos UV</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
        * {
            margin: 0;
            box-sizing: border-box;
        }

        *:focus {
            outline: none;
        }

        body {
            font-family: Arial;
        }

        .principal {
            display: flex;
        }

        .imagen {
            text-align: center;
            
            height: 100vh;
            width: 55vw;
        }

        .fondo{
            margin-top: 17%;
            width: 100%;
        }

        .login {
            text-align: center;
            background-color: #a1a1a1;
            height: 100vh;
            width: 45vw;
        }

        .user{
            margin-top: 5%;
            margin-bottom: 5%;
            width: 30%;
            height: 25%;
        }

        .login-screen {
            
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 6%;
            background-color: white;
            padding: 10px;
            border-radius: 25px
            
        }

        .app-title {
            text-align: left;
            margin-left: 0;
            color: black;
        }

        .login-form {
            text-align: center;
        }

        .control-group {
            margin-bottom: 10px;
        }

        input {
            text-align: left;
            background-color: #ECF0F1;
            border: 2px solid transparent;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 200px;
            padding: 10px 0;
            width: 38vw;
            transition: border .5s;
            
        }

        input:focus {
            border: 2px solid #3498DB;
            box-shadow: none;
        }

        .btn {
            text-align: center;
            border: 2px solid transparent;
            background: #3498DB;
            color: white;
            font-size: 20px;
            line-height: 15px;
            padding: 10px 0;
            text-decoration: none;
            text-shadow: none;
            border-radius: 10px;
            box-shadow: none;
            transition: 0.25s;
            display: block;
            width: 100px;
            margin: 0 auto;
        }

        .btn:hover {
            background-color: #2980B9;
        }

        .login-link {
            text-align: center;
            font-size: 12px;
            color: #444;
            display: block;
            margin-top: 12px;
        }
    </style>
</head>

<body>
    <div class="principal">

        <div class="imagen">
            <img src="images/fondo.png" alt="fondo" class="fondo">
        </div>
        
        <div class="login">
            
            <img src="images/user.png" alt="user" class="user">

            <h1>Iniciar Sesión</h1>

            <div class="login-screen">

                <div class="login-form">

                    <main>

                        <form method="POST" action="">

                            <div class="app-title">
                                <h2>Nickname</h2>
                            </div>

                            <div class="control-group">
                                <input type="text" class="login-field" id="login-name" name="username">
                                <label class="login-field-icon fui-user" for="login-name"></label>
                            </div>

                            <div class="app-title">
                                <h2>Contraseña</h2>
                            </div>

                            <div class="control-group">
                                <input type="password" class="login-field" id="login-pass" name="contra">
                                <label class="login-field-icon fui-lock" for="login-pass"></label>
                            </div>

                            <input type="submit" value="Entrar" class="btn btn-primary btn-large btn-block"/>
                        </form>

                    </main>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
