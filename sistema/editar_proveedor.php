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
            $idproveedor=$_POST['id'];
            $proveedor =$_POST['proveedor'];
            $contacto =$_POST['contacto'];
            $telefono =$_POST['telefono'];
            $direccion=$_POST['direccion'];
            
                $sql_update= mysqli_query($mysqli, "UPDATE proveedor set proveedor='$proveedor', contacto='$contacto',telefono='$telefono',direccion='$direccion' where codproveedor=$idproveedor");
                
                if($sql_update){
                    $alert='<p class="msg_save">Proveedor Actualizado correctamente.</p>';  
                }
                else{
                    $alert='<p class="msg_error">Error al Actualizar el Proveedor.</p>';  
                }
            
        }
        
    }


//mostrar datos
if(empty($_REQUEST['id']))
{
    header ('location:lista_proveedores.php');
    mysqli_close($mysqli);
}
$idproveedor= $_REQUEST['id'];
$sql =mysqli_query($mysqli,"SELECT *from proveedor where codproveedor=$idproveedor" );
mysqli_close($mysqli);
$result_sql = mysqli_num_rows($sql);
if($result_sql==0){
    header('location:lista_proveedores.php');
}
else{
    
    while($data = mysqli_fetch_array($sql)){
        $idproveedor=$data['codproveedor'];
        $proveedor=$data['proveedor'];
        $contacto=$data['contacto'];
        $telefono=$data['telefono'];
        $direccion=$data['direccion'];
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Actualizar Proveedor</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
    <div class="modal1">
	<section id="container">
	<div class="form_register">
    <br><br><br><br><br><br><br>
        <h1>Actualizar Proveedor</h1>
        <hr>
        
        <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $idproveedor;?>">
        <label for="proveedor">Proveedor:</label>
            <input type="text" name="proveedor" id="proveedor" placeholder="proveedor" value="<?php echo $proveedor;?>">
            <label for="contacto">Contacto:</label>
            <input type="text"name="contacto" id="contacto" placeholder="Nombre del contacto" value="<?php echo $contacto;?>">
            <label for="telefono">Telefono:</label>
            <input type="number" name="telefono"  id="telefono" placeholder="Telefono" value="<?php echo $telefono;?>">
            <label for="direccion">Direccion:</label>
            <input type="text" name="direccion" id="direccion" placeholder="Direccion" value="<?php echo $direccion;?>">
            <br>
            <div class="alert2">
            <?php   
            echo isset($alert) ? $alert :'';
            ?>
        </div>
            <input type="submit" value="actualizar" class="btn_save" >
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