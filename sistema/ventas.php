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
	<title>Lista de Ventas</title>
</head>
<body>
	<?php
	include ("includes/header.php");
    ?>
    
	<section id="container">
    
        <br><br><br><br><br><br><br>
        <center><h2 class="coffe"><i class="far fa-newspaper"></i> Lista de Ventas</h2></center>
     
        
        <center>
        <br><br><br>
        <table>  
            <tr>
                <th> No</th>
                <th>Fecha/Hora</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Estado</th>
                <th class="textright">Total Factura</th>
                <th class="textright">vista</th>
                
            </tr>
            <?php
            //paginador
            $sql_register= mysqli_query($mysqli,"SELECT COUNT(*) AS total_registro from factura where estatus !=10 ");
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

$query= mysqli_query($mysqli,"SELECT f.nofactura, f.fecha,f.totalfactura,f.codcliente,f.estatus, u.nombre as  vendedor ,cl.nombre as cliente
 from factura f inner join usuario u on f.usuario=u.idusuario inner join cliente cl on f.codcliente = cl.idcliente where f.estatus!=10 order by f.fecha desc limit $desde,$por_pagina ");
mysqli_close($mysqli);
$result=mysqli_num_rows($query);
if($result>0){
    while($data =mysqli_fetch_array($query)){
        if($data['estatus']==1){
            $estado='<span class="pagada">Pagada</span>';
        }
        else{
            $estado='<span class="anulada">Anulada</span>';
        }
    
        ?>
        <tr id ="row_<?php echo $data['nofactura'];?>" >

                <td><?php echo $data["nofactura"];?></td>                
                <td><?php echo $data["fecha"];?></td>
                <td><?php echo $data["cliente"];?></td>
                <td><?php echo $data["vendedor"];?></td>
                <td><?php echo $estado;?></td>
                <td class="textright totalfactura"><?php echo $data['totalfactura'];?></td>
                <td>
                  <div class="div_acciones">
                      <div>
                          <button class="btn_view view_factura" type="button" cl="<?php echo $data['codcliente'];?>" f="<?php echo $data['nofactura'];?>"><i class="fas fa-eye"></i></button>
                      </div>
                  </div>
                </td>
            </tr>
  <?php          
    }
}
            
            ?>
                
            
        </table>
        <br>
        <a href="nueva_ventas.php" class="btn_new"><i class="fas fa-plus"></i> Nueva Venta</a>
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