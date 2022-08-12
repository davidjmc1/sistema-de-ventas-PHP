<?php
session_start();
if($_SESSION['rol']!=1 and $_SESSION['rol']!=2 ){
    header("location:../");
}
include "../conexion.php";


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>Lista de Proveedores</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
    
	<section id="container">
    <center>
        <br><br><br><br><br><br><br>
        <h2 class="coffe" >Lista de Proveedores</h2>
     
        <form action="buscar_proveedor.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" >
        <button type="submit"  class="btn_search" ><i class="fas fa-search"></i></button></form>
        <br><br><br><br>
        <table>  
            <tr>
                <th> ID</th>
                <th>Proveedor</th>
                <th>Nombre del Contacto</th>
                <th>Telefono</th>
                <th>direccion</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
            <?php
            //paginador
            $sql_register= mysqli_query($mysqli,"SELECT COUNT(*) AS total_registro from proveedor where estatus=1");
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

$query= mysqli_query($mysqli,"SELECT * from proveedor where estatus=1 order by codproveedor asc limit $desde,$por_pagina ");
mysqli_close($mysqli);
$result=mysqli_num_rows($query);
if($result>0){
    while($data =mysqli_fetch_array($query)){
        $formato='Y-m-d H:i:s';
        $fecha=datetime::createFromFormat($formato,$data["date_add"]);
        ?>
<tr>
                <td><?php echo $data["codproveedor"];?></td>                
                <td><?php echo $data["proveedor"];?></td>
                <td><?php echo $data["contacto"];?></td>
                <td><?php echo $data["telefono"];?></td>
                <td><?php echo $data["direccion"];?></td>
                <td><?php echo $fecha -> format('d-m-Y');?></td>
                <td>
     
                <a href="editar_proveedor.php?id=<?php echo $data["codproveedor"];?>" class="link_edit"><i class="far fa-edit"></i> Editar</a>

                <?php
                if($_SESSION['rol']==1 ){
                ?>                    
                    
                   <a href="eliminar_proveedor.php?id=<?php echo $data["codproveedor"];?>" class="link_delete"><i class="far fa-trash-alt"></i> Eliminar</a>
                <?php }?>
                </td>
            </tr>
  <?php          
    }
}
            
            ?>
                
            </tr>
        </table>
        <br><br>
        <a href="registro_proveedor.php" class="btn_new"><i class="fas fa-user-plus"></i> Nuevo</a>
        <center>
        <div class="paginador">
            <ul>
                <?php
                if($pagina!=1){
                    ?>
                <li><a href="?pagina=<?php echo 1;?>"><i class="fas fa-fast-backward"></i></a></li>
                <li><a href="?pagina=<?php echo $pagina-1;?>"><i class="fas fa-backward"></i></a></li>
                <?php
                }
                    for ($i=1; $i <=$total_paginas ; $i++) { 
                        if($i==$pagina){
                            echo '<li class="pageselect" >'.$i.'</li>';  
                        }else
                    echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>'; 
                    }
                    if($pagina!=$total_paginas){
                ?>
                
                <li><a href="?pagina=<?php echo $pagina+1;?>"><i class="fas fa-forward"></i></a></li>
                <li><a href="?pagina=<?php echo $total_paginas;?>"><i class="fas fa-fast-forward"></i></a></li>
                <?php
                    }
                ?>
            </ul>
        </div>

      
    </section>
    
	<?php
	include ("includes/footer.php");
	?>
</body>
</html>