<?php

session_start();
if($_SESSION['rol']!=1){
    header("location:../");
}
    INCLUDE "../conexion.php";

    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['nombre']) ||empty($_POST['correo'])||empty($_POST['usuario'])||empty($_POST['rol']))
         {
            $alert='<p class="msg_error">todos los campos son obligatorios.</p>';
        }
        else{
            $idusuario=$_POST['id'];
            $nombre =$_POST['nombre'];
            $email =$_POST['correo'];
            $user =$_POST['usuario'];
            $clave =MD5($_POST['clave']);
            $rol  =$_POST['rol'];

            $query= mysqli_query($mysqli,"SELECT * FROM usuario
                                                   where (usuario ='$user' and idusuario != $idusuario )OR (correo ='$email'and idusuario != $idusuario)" );
            $result =mysqli_fetch_array($query);
            
            if($result >  0){
                $alert='<p class="msg_error">El Correo o Usuario ya existen.</p>';  
            }
            else{
                if(empty($_POST['clave'])){
                    $sql_update= mysqli_query($mysqli, "UPDATE usuario set nombre ='$nombre', correo='$email',usuario='$user',rol='$rol' where idusuario=$idusuario");
                }
                else{
                    $sql_update= mysqli_query($mysqli, "UPDATE usuario set nombre ='$nombre', correo='$email',usuario='$user',clave='$clave',rol='$rol' where idusuario=$idusuario");
                }
                
                if($sql_update){
                    $alert='<p class="msg_save">Usuario Actualizado correctamente.</p>';  
                }
                else{
                    $alert='<p class="msg_error">Error al Actualizar el usuario.</p>';  
                }
            }
        }
        
    }


//mostrar datos
if(empty($_REQUEST['id']))
{
    header ('location:lista_usuarios.php');
    mysqli_close($mysqli);
}
$idUser = $_REQUEST['id'];
$sql =mysqli_query($mysqli,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,(u.rol) as idrol ,(r.rol) as rol from usuario u inner join rol r on u.rol =r.idrol where idusuario=$idUser" );
mysqli_close($mysqli);
$result_sql = mysqli_num_rows($sql);
if($result_sql==0){
    header('location:lista_usuarios.php');
}
else{
    $option='';
    while($data = mysqli_fetch_array($sql)){
        $iduser=$data['idusuario'];
        $nombre=$data['nombre'];
        $correo=$data['correo'];
        $usuario=$data['usuario'];
        $idrol=$data['idrol'];
        $rol=$data['rol'];
        if($idrol==1){
            $option='<option value="'.$idrol.'" select>'.$rol.'</option>';
        }
        else if($idrol==2){
            $option='<option value="'.$idrol.'" select>'.$rol.'</option>';
        }
        else if($idrol==3){
            $option='<option value="'.$idrol.'" select>'.$rol.'</option>';
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
	<title>Actualizar Usuario</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
    <div class="modal1">
	<section id="container">
	<div class="form_register">
    <br><br><br><br><br><br>
        <h1>Actualizar Usuario</h1>
        <hr>
        
        <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $idUser;?>">
            <label for="nombre">Nombre:</label>
            <input type="text"name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo $nombre;?>">
            <label for="Correo">Correo Electronico:</label>
            <input type="email" name="correo" id="correo" placeholder="Correo Electronico" value="<?php echo $correo;?>">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario"  id="usuario" placeholder="Usuario" value="<?php echo $usuario;?>">
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" placeholder="Contraseña">
            <label for="rol">Tipo de Usuario:</label>
                <?php
                include "../conexion.php";
                $query_rol=mysqli_query($mysqli,"SELECT *FROM rol");
                mysqli_close($mysqli);
                $resul_rol=mysqli_num_rows($query_rol);
                
                ?>
            <select name="rol" id="rol" class="notItemOne">
                <?php
                echo $option;
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
            <input type="submit" value="Actualizar" class="btn_save" >
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