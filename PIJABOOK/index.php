<?php
    session_start();
    $alert = '';
    $alerta = '';
    
    switch (!empty($_POST)) {
        //Login
        case empty($_POST['pass_confirm']):
            if (!empty($_POST)) {
                if (empty($_POST['user']) || empty($_POST['password'])) {
                    $alert = '<span class="msg_error">Enter your username and password</span>';
                }else{
                    require_once "conx.php";
        
                    $user = mysqli_real_escape_string($conx,$_POST['user']);
                    $pass = mysqli_real_escape_string($conx,$_POST['password']);
        
                    $query = mysqli_query($conx, "SELECT * FROM usuario WHERE usuario = '$user' AND password='$pass'");
                    mysqli_close($conx);
                    
        
                    $sql = mysqli_num_rows($query);
    
        
                    if ($sql > 0) {
                        $data = mysqli_fetch_array($query);
        
                        $_SESSION['active'] = true;
                        $_SESSION['idUser'] = $data['id_user'];
                        $_SESSION['nombre'] = $data['usuario'];
        
                        header('Location: red/');
                    }else {
                        $alert = '<span class="msg_error">wrong username or password</span>';
                        session_destroy();
                    }
        
                }
            }
         break;
            //REGISTER
        case !empty($_POST['pass_confirm']):
            if (!empty($_POST)) {
                if (empty($_POST['user']) || empty($_POST['password']) || empty($_POST['pass_confirm'])) {
                    $alerta = '<span class="msg_error">Fill in all the fields.</span>';
                }else{
                    require_once "conx.php";
        
                    $user = mysqli_real_escape_string($conx,$_POST['user']);
                    $pass = mysqli_real_escape_string($conx,$_POST['password']);
                    $confirm = mysqli_real_escape_string($conx,$_POST['pass_confirm']);
                    
                    $query = mysqli_query($conx, "SELECT usuario FROM usuario WHERE usuario = '$user'");
                    $sql = mysqli_num_rows($query);

                    if ($sql > 0) {
                        $alerta = '<span class="msg_error"> the user already exists</span>'; 
                    }else{
                        if ($pass === $confirm) {
                            $query = mysqli_query($conx, "INSERT INTO usuario (usuario, password) VALUES ('$user','$pass')");   
                            if ($query) {
                                echo '<span class="msg_ok">successfully registered</span>';
                            }else{
                                $alerta = '<span class="msg_error">unexpected error</span>';
                            }
    
                        }else {
                            $alerta = '<span class="msg_error">passwords do not match</span>';
                            mysqli_close($conx);
                            session_destroy();
                        }
                    }   
                }
            }
        break;
        default:
                echo $alert = '<span class="msg_error">Unexpected error</span>';
                echo $alerta = '<span class="msg_error">Unexpected error</span>';
         break;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIJABOOK</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/pijabook.png" type="image/x-icon">
</head>
<body>
    <?php echo $alert?>
    <form action="" method="POST">
        <div class="form">
            <h1 class="login">LOGIN</h1>
            <input type="text" placeholder="user" required="true" name="user">
            <input type="password" placeholder="password" required="true" name="password">
            <input type="submit" value="Login">
        </div>
    </form>

        <?php echo $alerta ?>

   <form action="" method="POST">
        <div class="form">
            <h1 class="login">SIGN IN</h1>
            <input type="text" placeholder="type username" required="true" name="user">
            <input type="password" placeholder="type password" required="true" name="password">
            <input type="password" placeholder="confirm your password" required="true" name="pass_confirm">
            <input type="submit" value="SING IN">
        </div>
    </form> 
</body>
</html>