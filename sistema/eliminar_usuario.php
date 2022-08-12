<?php

session_start();
if($_SESSION['rol']!=1){
    header("location:../");
}
include "../conexion.php";
    if(!empty($_POST)){

        if($_POST['idusuario']==1){
            header("location: lista_usuarios.php");
            mysqli_close($mysqli);
            exit; 
        }
        $idusuario =$_POST['idusuario'];
        $query_delete = mysqli_query($mysqli,"DELETE FROM usuario where idusuario =$idusuario");
        mysqli_close($mysqli);
        if($query_delete){
            header("location: lista_usuarios.php");
        }
        else{
            echo "Error al eliminar";
        }
    
    
    }

    if(empty($_REQUEST['id'])||$_REQUEST['id']==1){
        header("location: lista_usuarios.php");
        mysqli_close($mysqli);
    }
    else{
        
        $idusuario = $_REQUEST['id'];
        $query = mysqli_query($mysqli,"SELECT u.nombre,u.usuario,r.rol from usuario u inner join rol r on u.rol =r.idrol where u.idusuario=$idusuario");
        mysqli_close($mysqli);
        $result =mysqli_num_rows($query);
        if($result>0){
            while($data =mysqli_fetch_array($query)){
                $nombre=$data['nombre'];
                $usuario=$data['usuario'];
                $rol=$data['rol'];
            }
        }
        else{
            header("location: lista_usuarios.php");
        }
    }




?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Eliminar Usuario</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
    <div class="modal1">
	<section id="container">
        <br><br><br>
		<div class="data_delete">
        <form action="" method="post">
        <i class="fas fa-user-times fa-5x" style="color:red"></i>
            <h2>¿Esta seguro de Eliminar el siguiente Registro?</h2>
            <p><b>Nombre:</b><span><?php echo $nombre;?> </span>
            <p><b>Usuario:</b><span><?php echo $usuario;?> </span>
            <p><b>Tipo Usuario:</b><span><?php echo $rol;?> </span>
            </p>
            <input type="hidden" name="idusuario" value="<?php echo $idusuario?>">
            <input type="submit" value="Aceptar" class="btn_ok">    
            <a href="lista_usuarios.php" class="btn_cancel">Cancelar</a>
                
            </form>
        </div>
    </section>
    </div>
	<?php
	include ("includes/footer.php");
	?>
</body>
</html>