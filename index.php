<?php
$alert='';
session_start();
if(!empty($_SESSION['active'])){
    header('location: sistema/');
}else{
if(!empty($_POST)){
   if(empty($_POST['usuario'])||empty($_POST['clave'])){

    $alert ="Ingrese su Usuario y Contraseña";
   }
   else{
       require_once "conexion.php";
       $user= mysqli_real_escape_string($mysqli,$_POST['usuario']);
       $pass= md5(mysqli_real_escape_string($mysqli,$_POST['clave']));
       
       $query=mysqli_query($mysqli,"SELECT u.idusuario, u.nombre ,u.correo,u.usuario,r.idrol,r.rol FROM usuario u inner join rol r on u.rol= r.idrol   WHERE u.usuario='$user'and u.clave='$pass'");
       mysqli_close($mysqli);
        $result= mysqli_num_rows($query);
        if($result>0){
            $data =mysqli_fetch_array($query);
     
            $_SESSION['active']=true;
            $_SESSION['idUser']=$data['idusuario'];
            $_SESSION['nombre']=$data['nombre'];
            $_SESSION['email']=$data['correo'];
            $_SESSION['user']=$data['usuario'];
            $_SESSION['rol']=$data['idrol'];
            $_SESSION['rol_name']=$data['rol'];
            header('location:sistema/');
        }
        else{
            $alert= 'El usuario contraseña son incorrectos';
            session_destroy();
       
        }
   }
}
}
?>
<html lang ="es">
<head>
<meta charset="utf-8">
<title> Punto Frio JL</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<section id="contenedor">
<form action="" method="post">
<h3>LOGIN<br>PUNTO FRIO JL</h3>
<img src="img/log2.png" alt="login">
<input type="text" name="usuario" placeholder="Usuario" required>
<input type="password" name="clave" placeholder="Contraseña"required>
<div class="alert"><?php
echo isset($alert)? $alert:'';
?></div>
<input type="submit" value="Ingresar">
</form>
</section>
</body>
</html>

