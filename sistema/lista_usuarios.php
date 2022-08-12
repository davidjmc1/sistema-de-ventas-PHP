<?php

session_start();
if($_SESSION['rol']!=1){
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
	<title>Lista de usuarios</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
    
	<section id="container">
    <center>
        <br><br><br><br><br><br><br>
        <h2 class="coffe" >Lista de Usuarios</h2>
     
        <form action="buscar_usuario.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" >
        <button type="submit"  class="btn_search" ><i class="fas fa-search"></i></button></form>
        <br><br><br><br>
        <table>  
            <tr>
                <th> ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <?php
            //paginador
            $sql_register= mysqli_query($mysqli,"SELECT COUNT(*) AS total_registro from usuario where estatus=1");
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

$query= mysqli_query($mysqli,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.rol from usuario u inner join rol r on u.rol =r.idrol order by idusuario asc limit $desde,$por_pagina ");
mysqli_close($mysqli);
$result=mysqli_num_rows($query);
if($result>0){
    while($data =mysqli_fetch_array($query)){
        ?>

        <tr>
                <td><?php echo $data["idusuario"];?></td>
                <td><?php echo $data["nombre"];?>
                </td>
                <td><?php echo $data["correo"];?></td>
                <td><?php echo $data["usuario"];?></td>
                <td><?php echo $data["rol"];?></td>
                <td>
                    <a href="editar_usuario.php?id=<?php echo $data["idusuario"];?>" class="link_edit"> <i class="far fa-edit"></i> Editar</a>
                <?php
                
                    if($data["idusuario"]!=1){

                    
                ?>
                    |<a href="eliminar_usuario.php?id=<?php echo $data["idusuario"];?>" class="link_delete"><i class="far fa-trash-alt"></i> Eliminar</a>
                    <?php
                    }
    ?>
                </td>
            </tr>
  <?php          
    }
}
            
            ?>
                
            </tr>
        </table>
        <br>
        <br><br>
        <a href="registro_usuario.php" class="btn_new"><i class="fas fa-user-plus"></i> Crear Usuario</a>
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