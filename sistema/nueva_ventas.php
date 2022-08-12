
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
    <title>Nueva ventas</title>
    
</head>
<body>
    <?php include "includes/header.php";?><br><br><br><br><br><br><br>
<section id="container">
    <div class="title_page">
        <h1><i class="fas fa-cart-plus"></i> Nueva Venta</h1><br><br>
    </div>
    <div class="datos_cliente">
        <div class="action_cliente">
            <h1>Datos del cliente</h1>
            
        </div>
        <form action="" name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos">
            <input type="hidden" name="action" value="addCliente">
            <input type="hidden" id="idcliente"name="idcliente" value="" required>
            
            <div class="wd30">
                <label for="">Identificacion:</label>

                <input type="text" name="nit_cliente" id="nit_cliente" >
            </div>
            <div class="wd30">
                <label for="">Nombre</label>
                <input type="text" name="nom_cliente" id="nom_cliente" disabled required>
            </div>

            <div class="wd30">
                <label for="">Telefono</label>
                <input type="number" name="tel_cliente" id="tel_cliente" disabled required>
            </div>
            
            <div class="wd100">
                <label for="">Direccion
                </label>
                <input type="text" name="dir_cliente" id="dir_cliente" disabled required>
            </div><br>
            <div id="div_registro_cliente" class=" wd60">
                <button type="submit" class="btn_save3" ><i class="far fa-save fa-lg"></i>Guardar</button>
            </div>
        
            <a href="#" class="btn_save2 btn_new_cliente"><i class="fas fa-plus"></i> Nuevo cliente</a>
        </form>
    </div>
    
            
            <br><br>
        

    <div class="datos_cliente">

        <h1>Datos  de venta</h1><br><br>
        <div class="datos">
        <div class="wd50"> 
            <label for="" style="color:blue">Vendedor :<?php echo"<br><br>".$_SESSION['nombre']?></label>
            <p></p>
        </div>
            <div class="wd50">
                <label for="">acciones</label>
                <div id="acciones_venta">
                    <a href="#" class="btn_cancel textcenter" id="btn_anular_venta"><i class=" fas fa-ban"></i>Anular</a>
                    <a href="#" class="btn_new textcenter" id="btn_facturar_venta" style="display:none;"><i class=" fas fa-edit"></i>procesar</a>
                </div>
            </div>       
        </div>
    </div>
    <center>
        <br><br>
    <table class="tbl_venta">
        <thead>
        <tr>
            <th width="100px"> Codigo</th>
            <th>Descripcion</th>
            <th>existencia</th>
            <th width="100px">cantidad</th>
            <th class="textright">precio</th>
            <th class="textright">precio Total</th>
            <th>Accion</th>

        </tr>
        <tr>
            <td>
            <input type="text" name="txt_cod_producto" id="txt_cod_producto">
            </td>
            <td id="txt_descripcion">-</td>
            <td id="txt_existencia">-</td>
            <td><input type="text"name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>
            <td id="txt_precio" class="textright">0,00</td>
            <td id="txt_precio_total" class="textright">0,00</td>
            <td><a href="#" id="add_product_venta" class="link_add" ><i class="fas fa-plus"></i>Agregar</a></td>
            
        </tr>
        
<br>
        </thead>
        <tbody id="detalle_venta">
       <!-- contenido ajax-->
        </tbody>
        <tfoot id="detalle_totales">
            
        </tfoot>
    </table>
</section>
<script type="text/javascript">
$(document).ready(function(){

    var usuarioid ='<?php echo $_SESSION['idUser'];?>';
    serchForDetalle(usuarioid);
});
</script>

</body>
</html>

