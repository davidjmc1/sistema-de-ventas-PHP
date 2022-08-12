<?php

session_start();
if($_SESSION['rol']==3){
    header("location:../");
}
include "../conexion.php";
    if(!empty($_POST)){
        if(empty($_POST['idcliente'])){
            header("location: lista_clientes.php");
            mysqli_close($mysqli);
        }
        $idcliente =$_POST['idcliente'];
        $query_delete = mysqli_query($mysqli,"DELETE FROM cliente where idcliente =$idcliente");
        mysqli_close($mysqli);
        if($query_delete){
            header("location: lista_clientes.php");

        }
        else{
            echo "Error al eliminar";
        }
    
    
    }

    if(empty($_REQUEST['id'])){
        header("location: lista_clientes.php");
        mysqli_close($mysqli);
    }
    else{
        
        $idcliente= $_REQUEST['id'];
        $query = mysqli_query($mysqli,"SELECT * from cliente where idcliente=$idcliente");
        mysqli_close($mysqli);
        $result =mysqli_num_rows($query);
        if($result>0){
            while($data =mysqli_fetch_array($query)){
                $nit=$data['nit'];
                $nombre=$data['nombre'];
            
            }
        }
        else{
            header("location: lista_clientes.php");
        }
    }




?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Eliminar cliente</title>
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
            <p><b>Nombre:</b><span><?php echo $nombre;?> </span><br><br>
            <p><b>Identificacion:</b><span><?php echo $nit;?> </span><br><br><br>
            
            <input type="hidden" name="idcliente" value="<?php echo $idcliente?>">
            <input type="submit" value="Aceptar" class="btn_ok">    
            <a href="lista_clientes.php" class="btn_cancel">Cancelar</a>
                
            </form>
        </div>
    </section>
    </div>
	<?php
	include ("includes/footer.php");
	?>
</body>
</html>