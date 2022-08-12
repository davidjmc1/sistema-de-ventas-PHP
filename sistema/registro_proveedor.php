<?php
  session_start();
  if($_SESSION['rol']!=1 and $_SESSION['rol']!=2 ){
    header("location:../");
}
    INCLUDE "../conexion.php";
    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['proveedor']) ||empty($_POST['contacto'])||empty($_POST['telefono'])||empty($_POST['direccion']))
         {
            $alert='<p class="msg_error">todos los campos son obligatorios.</p>';
        }
        else{
            $proveedor =$_POST['proveedor'];
            $contacto=$_POST['contacto'];
            $telefono =$_POST['telefono'];
            $direccion =$_POST['direccion'];
            $usuario_id =$_SESSION['idUser'];

            $query_insert = mysqli_query($mysqli,"INSERT INTO proveedor(proveedor,contacto,telefono,direccion,usuario_id) values('$proveedor','$contacto','$telefono','$direccion','$usuario_id')");

            if($query_insert){
                    $alert='<p class="msg_save">Proveedor guardado correctamente.</p>';  
                }
                else{
                    $alert='<p class="msg_error">Error al guardar  el Proveedor.</p>';  
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
	<title>Registro Proveedor</title>
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
        <h1 class="re"> Registro Proveedor <i class="fas fa-address-book fa-2x" style="color:#5CAFE2"></i></h1></div>
        <hr>
        
        <form action="" method="post">
        <label for="proveedor">Proveedor:</label>
            <input type="text" name="proveedor" id="proveedor" placeholder="proveedor">
            <label for="contacto">Contacto:</label>
            <input type="text"name="contacto" id="contacto" placeholder="Nombre del contacto">
            <label for="telefono">Telefono:</label>
            <input type="number" name="telefono"  id="telefono" placeholder="Telefono">
            <label for="direccion">Direccion:</label>
            <input type="text" name="direccion" id="direccion" placeholder="Direccion">
            <div class="alert2">
            <?php
            echo isset($alert) ? $alert :'';
            ?>
        </div>
            <input type="submit" value="Guardar" class="btn_save" >
            <a href="lista_proveedores.php" class="btn_new3"><i class="fas fa-sign-out-alt"></i></a>
        </form>
    </div>
    </section>
    </div>
	<?php
	include ("includes/footer.php");
	?>
</body>
</html>