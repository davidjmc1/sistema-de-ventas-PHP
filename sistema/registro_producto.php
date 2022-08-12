<?php
  session_start();
  if($_SESSION['rol']!=1 and $_SESSION['rol']!=2 ){
    header("location:../");
}
    INCLUDE "../conexion.php";
    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['proveedor']) ||empty($_POST['producto'])||empty($_POST['precio'])||empty($_POST['cantidad']))
         {
            $alert='<p class="msg_error">todos los campos son obligatorios.</p>';
        }
        else{
            $proveedor =$_POST['proveedor'];
            $producto=$_POST['producto'];
            $precio =$_POST['precio'];
            $cantidad =$_POST['cantidad'];
            $usuario_id =$_SESSION['idUser'];

            $query_insert = mysqli_query($mysqli,"INSERT INTO producto(proveedor,descripcion,precio,existencia,usuario_id)
             values('$proveedor','$producto','$precio','$cantidad','$usuario_id')");

            if($query_insert){
                    $alert='<p class="msg_save">Producto guardado correctamente.</p>';  
                }
                else{
                    $alert='<p class="msg_error">Error al guardar  el Producto.</p>';  
                }
            
            
        }
      
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Registro Articulo</title>
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
        <h1 class="re"> <i class="fas fa-mobile-alt fa-2x" style="color:#5CAFE2"></i> Registro Bebida </h1></div>
        <hr>
        <div class="alert2">
            <?php
            echo isset($alert) ? $alert :'';
            ?>
        </div>
        <form action="" method="post" enctype="multipart/form-data">

        <label for="proveedor">Proveedor:</label>
        <?php

        $query_proveedor=mysqli_query($mysqli,"SELECT codproveedor ,proveedor FROM proveedor where estatus=1 order by proveedor asc");
        $result_proveedor=mysqli_num_rows($query_proveedor);
        mysqli_close($mysqli);
        ?>
        <select name="proveedor" id="proveedor">
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
            <input type="text"name="producto" id="producto" placeholder="Nombre del Articulo">
            <label for="precio">Precio:</label>
            <input type="number" name="precio"  id="precio" placeholder="Precio del Articulo">
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad del Articulo">
        
            <input type="submit" value="Guardar" class="btn_save" >
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