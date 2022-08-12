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
            $idcliente=$_POST['id'];
            $nit =$_POST['nit'];
            $nombre =$_POST['nombre'];
            $telefono =$_POST['telefono'];
            $direccion=$_POST['direccion'];
            
            $result=0;
            if(is_numeric($nit) and $nit !=0){
                $query= mysqli_query($mysqli,"SELECT * FROM cliente
                                                   where (nit ='$nit' and idcliente != $idcliente)" );
            $result =mysqli_fetch_array($query);
            
            }

            
            if($result >  0){
                $alert='<p class="msg_error">El Numero de Identificacion ya existe ,Ingrese otro.</p>';  
            }
            else{
            
                $sql_update= mysqli_query($mysqli, "UPDATE cliente  set nit='$nit', nombre='$nombre',telefono='$telefono',direccion='$direccion' where idcliente=$idcliente");
                
                if($sql_update){
                    $alert='<p class="msg_save">Cliente Actualizado correctamente.</p>';  
                }
                else{
                    $alert='<p class="msg_error">Error al Actualizar el cliente.</p>';  
                }
            }
        }
        
    }


//mostrar datos
if(empty($_REQUEST['id']))
{
    header ('location:lista_clientes.php');
    mysqli_close($mysqli);
}
$idcliente= $_REQUEST['id'];
$sql =mysqli_query($mysqli,"SELECT *from cliente where idcliente=$idcliente" );
mysqli_close($mysqli);
$result_sql = mysqli_num_rows($sql);
if($result_sql==0){
    header('location:lista_clientes.php');
}
else{
    
    while($data = mysqli_fetch_array($sql)){
        $idcliente=$data['idcliente'];
        $nit=$data['nit'];
        $nombre=$data['nombre'];
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
	<title>Actualizar cliente</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
    <div class="modal1">
	<section id="container">
	<div class="form_register">
    <br><br><br><br><br><br><br>
        <h1>Actualizar Cliente</h1>
        <hr>
        
        <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $idcliente;?>">
        <label for="nit">Identificacion:</label>
            <input type="number" name="nit" id="nit" placeholder="Numero de Identificacion" value="<?php echo $nit;?>">
            <label   for="nombre">Nombre:</label>
            <input type="text"name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo $nombre;?>">
            <label for="telefono">Telefono:</label>
            <input type="number" name="telefono"  id="telefono" placeholder="Telefono"value="<?php echo $telefono;?>">
            <label for="direccion">Direccion:</label>
            <input type="text" name="direccion" id="direccion" placeholder="Direccion "value="<?php echo $direccion;?>">
            <div class="alert2">
            <?php
            echo isset($alert) ? $alert :'';
            ?>
        </div>
            <br><input type="submit" value="Actualizar" class="btn_save" >
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