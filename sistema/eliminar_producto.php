<?php

session_start();
if($_SESSION['rol']!=1 and $_SESSION['rol']!=2 ){
    header("location:../");
}

include "../conexion.php";
    if(!empty($_POST)){
        if(empty($_POST['codproducto'])){
            header("location: lista_productos.php");
            mysqli_close($mysqli);
        }
        $idproducto =$_POST['codproducto'];
        $query_delete = mysqli_query($mysqli,"DELETE FROM producto where codproducto =$idproducto");
        mysqli_close($mysqli);
        if($query_delete){
            header("location: lista_productos.php");

        }
        else{
            echo "Error al eliminar";
        }
    
    
    }

    if(empty($_REQUEST['id'])){
        header("location: lista_productos.php");
        mysqli_close($mysqli);
    }
    else{
        
        $idproducto= $_REQUEST['id'];
        $query = mysqli_query($mysqli,"SELECT * from producto where codproducto=$idproducto");
        mysqli_close($mysqli);
        $result =mysqli_num_rows($query);
        if($result>0){
            while($data =mysqli_fetch_array($query)){
                $producto=$data['descripcion'];
                
            
            }
        }
        else{
            header("location: lista_productos.php");
        }
    }




?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Eliminar Articulor</title>
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
        <<i class="fas fa-cubes" style="font-size:45pt; color:red;"></i>
            <h2>¿Esta seguro de Eliminar el siguiente Articulo?</h2>
            <p><b>Articulo:</b><span><?php echo $producto;?> </span><br><br>
            
            <input type="hidden" name="codproducto" value="<?php echo $idproducto?>">
            <input type="submit" value="Aceptar" class="btn_ok">    
            <a href="lista_productos.php" class="btn_cancel">Cancelar</a>
                
            </form>
        </div>
    </section>
    </div>
	<?php
	include ("includes/footer.php");
	?>
</body>
</html>