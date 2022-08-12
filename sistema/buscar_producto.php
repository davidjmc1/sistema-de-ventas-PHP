<?php
session_start();

include "../conexion.php";


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Lista de Articulos</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
    
	<section id="container">
        <?php
        
        $busqueda= strtolower($_REQUEST['busqueda']);
        if(empty($busqueda)){
            header("location: lista_productos.php");
            mysqli_close($mysqli);
        }
        
        
        
        ?>
    <center>
        <br><br><br><br>
        <h1 >Lista de Productos</h1>
     
        <form action="buscar_producto.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar"value="<?php echo $busqueda;?>" >
        <button type="submit"  class="btn_search" ><i class="fas fa-search"></i></button></form>
        <br><br><br>
        <table>  
            <tr>
            <th> Codigo</th>
                <th>Proveedor</th>
                <th>Articulo</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            <?php
            //paginador
            $rol='';
            if($busqueda=='administrador')
            {
                $rol=" OR rol LIKE '%1%'";
            }else if($busqueda=='supervisor')
            {
                $rol=" OR rol LIKE '%2%'";
            }
            if($busqueda=='vendedor')
            {
                $rol=" OR rol LIKE '%3%'";
            }
            
            $sql_register= mysqli_query($mysqli,"SELECT COUNT(*) AS total_registro from producto  where( codproducto LIKE '%$busqueda%'  OR descripcion LIKE '%$busqueda%'OR proveedor LIKE '%$busqueda%') AND estatus=1");
            $result_register=mysqli_fetch_array($sql_register);
            $total_registro= $result_register['total_registro'];
            $por_pagina=5;
            if(empty($_GET['pagina'])){
                $pagina=1;
            }
            else{
                $pagina=$_GET['pagina'];
            }
            $desde =($pagina-1)*$por_pagina;
            $total_paginas =ceil($total_registro/$por_pagina);

$query= mysqli_query($mysqli,"SELECT *from producto  where ( codproducto LIKE '%$busqueda%'  OR descripcion LIKE '%$busqueda%' )
 and estatus=1  order by codproducto asc limit $desde,$por_pagina ");
mysqli_close($mysqli);
$result=mysqli_num_rows($query);
if($result>0){
    while($data =mysqli_fetch_array($query)){
        
        ?>

        <tr>
                <td><?php echo $data["codproducto"];?></td>
                <td><?php echo $data["proveedor"];?>
                </td>
                <td><?php echo $data["descripcion"];?></td>
                <td><?php echo "$ ".$data["precio"];?></td>
                <td><?php echo $data["existencia"];?></td>
                <td>
                <a href="editar_producto.php?id=<?php echo $data["codproducto"];?>" class="link_edit"><i class="far fa-edit"></i> Editar</a>
                    <?php if($_SESSION['rol']==1 ){
?>
                    <a href="eliminar_producto.php?id=<?php echo $data["codproducto"];?>" class="link_delete"><i class="far fa-trash-alt"></i> Eliminar</a>
              <?php }?>
                </td>
            </tr>
  <?php          
    }
}
            
            ?>
                
            </tr>
        </table>
        <br>
        <a href="registro_producto.php" class="btn_new"><i class="fas fa-user-plus"></i> Crear Articulo</a>
        <?php
        if($total_registro!=0){
        ?>
        <center>
        <div class="paginador">
            <ul>
                <?php
                if($pagina!=1){
                    ?>
                <li><a href="?pagina=<?php echo 1;?>&busqueda=<?php echo $busqueda;?>">|<</a></li>
                <li><a href="?pagina=<?php echo $pagina-1;?>&busqueda=<?php echo $busqueda;?>"><<</a></li>
                <?php
                }
                    for ($i=1; $i <=$total_paginas ; $i++) { 
                        if($i==$pagina){
                            echo '<li class="pageselect" >'.$i.'</li>';  
                        }else
                    echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>'; 
                    }
                    if($pagina!=$total_paginas){
                ?>
                
                <li><a href="?pagina=<?php echo $pagina+1;?>&busqueda=<?php echo $busqueda;?>">>></a></li>
                <li><a href="?pagina=<?php echo $total_paginas;?>&busqueda=<?php echo $busqueda;?>">>|</a></li>
                <?php
                    }
                ?>
            </ul>
        </div>
        <?php
                }
                ?>

      
    </section>
    
	<?php
	include ("includes/footer.php");
	?>
</body>
</html>