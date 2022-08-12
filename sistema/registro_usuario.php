<?php
session_start();
if($_SESSION['rol']!=1){
    header("location:../");
}
    INCLUDE "../conexion.php";
    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['nombre']) ||empty($_POST['correo'])||empty($_POST['usuario'])||empty($_POST['clave'])||empty($_POST['rol']))
         {
            $alert='<p class="msg_error">todos los campos son obligatorios.</p>';
        }
        else{
            
            $nombre =$_POST['nombre'];
            $email =$_POST['correo'];
            $user =$_POST['usuario'];
            $clave =MD5($_POST['clave']);
            $rol  =$_POST['rol'];

            $query= mysqli_query($mysqli,"SELECT * FROM usuario where usuario ='$user' OR correo ='$email'" );
            $result =mysqli_fetch_array($query);
            if($result >  0){
                $alert='<p class="msg_error">El Correo o Usuario ya existen.</p>';  
            }
            else{
                $query_insert = mysqli_query($mysqli,"INSERT INTO usuario (nombre,correo,usuario,clave,rol) values('$nombre','$email','$user','$clave','$rol')");

                if($query_insert){
                    $alert='<p class="msg_save">Usuario Creado correctamente.</p>';  
                }
                else{
                    $alert='<p class="msg_error">Error al crear el usuario.</p>';  
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Registro Usuario</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
    <div class="modal1">
	<section id="container">
	<div class="form_register">
    <br><br><br><br><br><br><br>
        <h1>Registro Usuario</h1>
        <hr>
        
        <form action="" method="post">
        
            <label for="nombre">Nombre:</label>
            <input type="text"name="nombre" id="nombre" placeholder="Nombre Completo">
            <label for="Correo">Correo Electronico:</label>
            <input type="email" name="correo" id="correo" placeholder="Correo Electronico">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario"  id="usuario" placeholder="Usuario">
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" placeholder="Contraseña">
            <label for="rol">Tipo de Usuario:</label>
                <?php
                
                $query_rol=mysqli_query($mysqli,"SELECT *FROM rol");
                $resul_rol=mysqli_num_rows($query_rol);
                
                ?>
            <select name="rol" id="rol" >
                <?php
                if($resul_rol>0){
                    while($rol=mysqli_fetch_array($query_rol)){
        
                ?> <option value="<?php echo $rol["idrol"];?>"><?php echo $rol["rol"];?></option>
                <?php
                    }
                }?>
               
             
            </select>
            <br>
            <div class="alert2">
            <?php
            echo isset($alert) ? $alert :'';
            ?>
        </div>
            <input type="submit" value="Crear Usuario" class="btn_save" >
            <a href="lista_usuarios.php" class="btn_new3"><i class="fas fa-sign-out-alt"></i></a>
            
        </form>
    </div>
    </section>
    </div>
	<?php
	include ("includes/footer.php");
	?>
</body>
</html>