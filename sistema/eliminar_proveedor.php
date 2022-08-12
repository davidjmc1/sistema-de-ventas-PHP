<?php

session_start();
if($_SESSION['rol']!=1 and $_SESSION['rol']!=2 ){
    header("location:../");
}

include "../conexion.php";
    if(!empty($_POST)){
        if(empty($_POST['codproveedor'])){
            header("location: lista_proveedores.php");
            mysqli_close($mysqli);
        }
        $idproveedor =$_POST['codproveedor'];
        $query_delete = mysqli_query($mysqli,"DELETE FROM proveedor where codproveedor =$idproveedor");
        mysqli_close($mysqli);
        if($query_delete){
            header("location: lista_proveedores.php");

        }
        else{
            echo "Error al eliminar";
        }
    
    
    }

    if(empty($_REQUEST['id'])){
        header("location: lista_proveedores.php");
        mysqli_close($mysqli);
    }
    else{
        
        $idproveedor= $_REQUEST['id'];
        $query = mysqli_query($mysqli,"SELECT * from proveedor where codproveedor=$idproveedor");
        mysqli_close($mysqli);
        $result =mysqli_num_rows($query);
        if($result>0){
            while($data =mysqli_fetch_array($query)){
                $proveedor=$data['proveedor'];
                $contacto=$data['contacto'];
            
            }
        }
        else{
            header("location: lista_proveedores.php");
        }
    }




?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Eliminar Proveedor</title>
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
            <p><b>Proveedor:</b><span><?php echo $proveedor;?> </span><br><br>
            <p><b>contacto:</b><span><?php echo $contacto;?> </span><br><br><br>
            
            <input type="hidden" name="codproveedor" value="<?php echo $idproveedor?>">
            <input type="submit" value="Aceptar" class="btn_ok">    
            <a href="lista_proveedores.php" class="btn_cancel">Cancelar</a>
                
            </form>
        </div>
    </section>
</div>
    
	<?php
	include ("includes/footer.php");
	?>
</body>
</html>