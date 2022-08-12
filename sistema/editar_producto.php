<?php
  session_start();
  
    INCLUDE "../conexion.php";
    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['proveedor']) ||empty($_POST['producto'])||empty($_POST['precio'])||empty($_POST['cantidad']||empty($_POST['id'])))
         {
            $alert='<p class="msg_error">todos los campos son obligatorios.</p>';
        }
        else{
            $codproducto=$_POST['id'];
            $proveedor =$_POST['proveedor'];
            $producto=$_POST['producto'];
            $precio =$_POST['precio'];
            $cantidad=$_POST['cantidad'];
            
                $sql_update= mysqli_query($mysqli, "UPDATE producto set proveedor='$proveedor', descripcion='$producto',precio='$precio',existencia='$cantidad' where codproducto=$codproducto");
                
                if($sql_update){
                    $alert='<p class="msg_save">Articulo Actualizado correctamente.</p>';  
                }
                else{
                    $alert='<p class="msg_error">Error al Actualizar el Proveedor.</p>';  
                }
            
        }
        
    }


  
  
  
    //validar producro
    if(empty($_REQUEST['id'])){
        header("location:lista_productos.php");
    }
    else{
        $id_producto= $_REQUEST['id'];
        if(!is_numeric($id_producto)){
            header("location: lista_productos.php");
        }
        $query_producto=mysqli_query($mysqli,"SELECT p.codproducto,p.descripcion,p.precio,p.existencia ,pr.codproveedor,pr.proveedor
         FROM producto p inner join proveedor pr on p.proveedor=pr.codproveedor  where p.codproducto=$id_producto");
        $result_product=mysqli_num_rows($query_producto);
        if($result_product > 0){
            $data_producto=mysqli_fetch_assoc($query_producto);

        }
        else{
            header("location: lista_productos.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Actualizar  Articulo</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
        <div class="modal1">
	<section id="container">
	<div class="form_register">
    <br><br><br><br>

          <div class="cen">
        <br><br>
        <h1 class="re"> <i class="fas fa-cubes" style="font-size:45pt;"></i> Actualizar Bebida </h1></div>
        <hr> 
      
        <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data_producto['codproducto'];?>">
        <label for="proveedor">Proveedor:</label>
        <?php

        $query_proveedor=mysqli_query($mysqli,"SELECT*FROM proveedor where estatus=1 order by proveedor asc");
        $result_proveedor=mysqli_num_rows($query_proveedor);
        mysqli_close($mysqli);
        ?>
        <select name="proveedor" id="proveedor">
            <option value="<?php echo $data_producto['codproveedor'];?>" selected ><?php echo $data_producto['proveedor'];?></option>
            <?php
                if($result_proveedor>0){

                    while($proveedor=mysqli_fetch_array($query_proveedor)){

            ?>
                    <option value="<?php echo $proveedor['codproveedor'];?>"><?php echo $proveedor['proveedor'];?></option>
            <?php
                    }    
                   
                }
            ?>
            
</select>
            <label for="producto">Bebida:</label>
            <input type="text"name="producto" id="producto" placeholder="Nombre de la Bebida" value="<?php echo $data_producto['descripcion'];?>">
            <label for="precio">Precio:</label>
            <input type="number" name="precio"  id="precio" placeholder="Precio de la Bebida" value="<?php echo $data_producto['precio'];?>">
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad del Articulo" value="<?php echo $data_producto['existencia'];?>">
            <div class="alert2">
            <?php
            echo isset($alert) ? $alert :'';
            ?>
        </div>
            <input type="submit" value="actualizar" class="btn_save" >
            <a href="lista_productos.php" class="btn_new3"><i class="fas fa-sign-out-alt"></i></a>
        </form>
    </div>
    </div>
  
	</section>
	<?php
	include ("includes/footer.php");
	?>
</body>
</html>  