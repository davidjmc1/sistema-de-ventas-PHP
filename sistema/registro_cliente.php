<?php
  session_start();
    INCLUDE "../conexion.php";
    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['nit']) ||empty($_POST['nombre'])||empty($_POST['telefono'])||empty($_POST['direccion']))
         {
            $alert='<p class="msg_error">todos los campos son obligatorios.</p>';
        }
        else{
            $nit =$_POST['nit'];
            $nombre =$_POST['nombre'];
            $telefono =$_POST['telefono'];
            $direccion =$_POST['direccion'];
            $usuario_id =$_SESSION['idUser'];

            $result=0;
            if(is_numeric($nit)){
                $query= mysqli_query($mysqli,"SELECT * FROM cliente where nit ='$nit'" );
                $result =mysqli_fetch_array($query);
            }
            if($result>0){
                $alert='<p class="msg_error">El Numero de Identificacion ingresado  ya existe.</p>';  
            }
            else{
                $query_insert = mysqli_query($mysqli,"INSERT INTO cliente(nit,nombre,telefono,direccion,usuario_id) values('$nit','$nombre','$telefono','$direccion','$usuario_id')");

                if($query_insert){
                    $alert='<p class="msg_save">Cliente guardado correctamente.</p>';  
                }
                else{
                    $alert='<p class="msg_error">Error al guardar  el Cliente.</p>';  
                }
            }
         
        }
        mysqli_close($mysqli);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Registro Cliente</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
    <div class="modal1">
	<section id="container">
	<div class="form_register">
    <br><br><br><br><br><br><br>
    <div class="cen">
        <h1 class="re">Registro Cliente</h1></div>
        <hr>
        <div class="alert2">
            <?php
            echo isset($alert) ? $alert :'';
            ?>
        </div>
        <form action="" method="post"><br>
        <label for="nit">Identificacion:</label>
            <input type="number" name="nit" id="nit" placeholder="Numero de Identificacion">
            <label for="nombre">Nombre:</label>
            <input type="text"name="nombre" id="nombre" placeholder="Nombre Completo">
            <label for="telefono">Telefono:</label>
            <input type="number" name="telefono"  id="telefono" placeholder="Telefono">
            <label for="direccion">Direccion:</label>
            <input type="text" name="direccion" id="direccion" placeholder="Direccion">
            <br>
            <input type="submit" value="Guardar" class="btn_save" >
            <a href="lista_clientes.php" class="btn_new3"><i class="fas fa-sign-out-alt"></i></a>
        </form>
    </div>
    </section>
    </div>
	<?php
	include ("includes/footer.php");
	?>
</body>
</html>