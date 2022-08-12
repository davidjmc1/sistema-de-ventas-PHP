<?php
    session_start();
    include "../conexion.php";

//print_r($_POST);exit;
    if(!empty($_POST)){
        //estraer datos del producto
        if($_POST['action']=='infoProducto')
        {
            $producto_id= $_POST['producto'];
            $query=mysqli_query($mysqli,"SELECT codproducto,descripcion,existencia,precio from producto
            where codproducto=$producto_id");
            mysqli_close($mysqli);
            $result = mysqli_num_rows($query);
            if($result>0){
                $data=mysqli_fetch_assoc($query);
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                exit;
            }
            echo "error";
            exit;
          
        } 
        if($_POST['action']=='addProduct')
        {
            if(!empty($_POST['cantidad'])||!empty($_POST['precio'])||!empty($_POST['producto_id']) ){
                $cantidad=$_POST['cantidad'];
                $precio=$_POST['precio'];
                $producto_id=$_POST['producto_id'];
                $usuario_id = $_SESSION['idUser'];

                $query_insert =mysqli_query($mysqli,"INSERT INTO entradas(codproducto,cantidad,precio,usuario_id) values($producto_id,$cantidad,$precio,$usuario_id)");

                if($query_insert){
                    $query_upd=mysqli_query($mysqli,"CALL actualizar_precio_producto($cantidad,$precio,$producto_id)");
                    $result_pro=mysqli_num_rows($query_upd);
                    if($result_pro>0){

                        $data=mysqli_fetch_assoc($query_upd);
                        $data['producto_id']=$producto_id;
                        echo json_encode($data,JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                }else{
                    echo"error";
                }
                mysqli_close($mysqli);
                
            }else{
                echo"error";
            }
            exit;
    } 
    if($_POST['action']=='searchCliente'){
        if(!empty($_POST['cliente'])){
            $nit =$_POST['cliente'];
            $query=mysqli_query($mysqli,"SELECT*FROM cliente where nit like '$nit' and estatus=1" );
            mysqli_close($mysqli);
            $result =mysqli_num_rows($query);
            $data='';
            if($result>0){
                $data =mysqli_fetch_assoc($query);
            }
            else{
                $data=0;
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }

    }
    //registrar cliente - ventas
    if($_POST['action'] =='addCliente'){
        $nit=$_POST['nit_cliente'];
        $nombre=$_POST['nom_cliente'];
        $telefono=$_POST['tel_cliente'];
        $direccion=$_POST['dir_cliente'];
        $usuario_id=$_SESSION['idUser'];
        $query_insert = mysqli_query($mysqli,"INSERT INTO cliente(nit,nombre,telefono,direccion,usuario_id)
         values('$nit','$nombre','$telefono','$direccion','$usuario_id')");
         
         if($query_insert){
             $codCliente=mysqli_insert_id($mysqli);
             $msg=$codCliente;
         }
         else{
             $msg='error';
         }
         mysqli_close($mysqli);
         echo$msg;
         exit;
    }
//agregar producto al detalle
    if($_POST['action'] =='addProductoDetalle'){
       if(empty($_POST['producto'])||empty($_POST['cantidad'])){
           echo'error';
       }
       else{
           $codproducto=$_POST['producto'];
           $cantidad=$_POST['cantidad'];
           $token=md5($_SESSION['idUser']);

           $query_iva= mysqli_query($mysqli,"SELECT iva from configuracion");
           $result_iva= mysqli_num_rows($query_iva);

           $query_detalle_temp= mysqli_query($mysqli,"CALL add_detalle_temp($codproducto,$cantidad,'$token')");
           $result = mysqli_num_rows($query_detalle_temp);

           $detalleTabla ='';
           $sub_total=0;
           $iva=0;
           $total=0;
           $arrayDate= array();
           if($result>0){
               if($result_iva>0){
                   $info_va=mysqli_fetch_assoc($query_iva);
                   $iva=$info_va['iva'];

               }
               while($data =mysqli_fetch_assoc($query_detalle_temp)){
                   $precioTotal=round($data['cantidad'] * $data['precio_venta'],2);
                   $sub_total=round($sub_total+$precioTotal,2);
                   $total=round($total+$precioTotal,2);

                   $detalleTabla .='
                   <tr>
                    <td>'.$data['codproducto'].'</td>
                    <td colspan="2">'.$data['descripcion'].'</td>
                    <td class="textcenter">'.$data['cantidad'].'</td>
                    <td class="textright">'.$data['precio_venta'].'</td>
                    <td class="textright">'.$precioTotal.'</td>
                    <td class="">
                        <a href="#" class="link_delete" onclick="event.preventDefault(); del_product_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a>
                    </td>
            </tr>';

               }
               $impuesto=round($sub_total * ($iva/100),2);
               $tl_sniva=round($sub_total - $impuesto,2);
               $total=round($tl_sniva+ $impuesto,2);

               $detalleTotales='
               <tr>
               <td colspan="5" class="textright">subtotal $</td>
            <td class="textright">'.$tl_sniva.'</td>
        </tr>
        <tr><td colspan="5" class="textright">iva('.$iva.'%) </td>
            <td class="textright">'.$impuesto.'</td>
        </tr>
        <tr><td colspan="5" class="textright">total $</td>
            <td class="textright">'.$total.'</td>
        </tr>           
               
               ';
               $arrayDate['detalle']=$detalleTabla;
               $arrayDate['totales']=$detalleTotales;
               echo json_encode($arrayDate,JSON_UNESCAPED_UNICODE);
           }
           else{
               echo 'error';
           }
           mysqli_close($mysqli);
       }
       exit;
    }

//extraer datos del detalle_temp
    if($_POST['action'] =='serchForDetalle'){
        if(empty($_POST['user'])){
            echo'error';
        }
        else{
            $token=md5($_SESSION['idUser']);
            
            $query=mysqli_query($mysqli,"SELECT tmp.correlativo,tmp.token_user,tmp.cantidad,tmp.precio_venta,p.codproducto,p.descripcion 
            from detalle_temp tmp  inner join producto p on tmp.codproducto =p.codproducto where token_user ='$token'");

            $result = mysqli_num_rows($query); 
            $query_iva= mysqli_query($mysqli,"SELECT iva from configuracion");
            $result_iva= mysqli_num_rows($query_iva);
            
 
            $detalleTabla ='';
            $sub_total=0;
            $iva=0;
            $total=0;
            $arrayDate= array();
            if($result>0){
                if($result_iva>0){
                    $info_va=mysqli_fetch_assoc($query_iva);
                    $iva=$info_va['iva'];
 
                }
                while($data =mysqli_fetch_assoc($query)){
                    $precioTotal=round($data['cantidad'] * $data['precio_venta'],2);
                    $sub_total=round($sub_total+$precioTotal,2);
                    $total=round($total+$precioTotal,2);
 
                    $detalleTabla .='
                    <tr>
                     <td>'.$data['codproducto'].'</td>
                     <td colspan="2">'.$data['descripcion'].'</td>
                     <td class="textcenter">'.$data['cantidad'].'</td>
                     <td class="textright">'.$data['precio_venta'].'</td>
                     <td class="textright">'.$precioTotal.'</td>
                     <td class="">
                         <a href="#" class="link_delete" onclick="event.preventDefault(); del_product_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a>
                     </td>
             </tr>';
 
                }
                $impuesto=round($sub_total * ($iva/100),2);
                $tl_sniva=round($sub_total - $impuesto,2);
                $total=round($tl_sniva+ $impuesto,2);
 
                $detalleTotales='
                <tr>
                <td colspan="5" class="textright">subtotal $</td>
             <td class="textright">'.$tl_sniva.'</td>
         </tr>
         <tr><td colspan="5" class="textright">iva('.$iva.'%) </td>
             <td class="textright">'.$impuesto.'</td>
         </tr>
         <tr><td colspan="5" class="textright">total $</td>
             <td class="textright">'.$total.'</td>
         </tr>           
                
                ';
                $arrayDate['detalle']=$detalleTabla;
                $arrayDate['totales']=$detalleTotales;
                echo json_encode($arrayDate,JSON_UNESCAPED_UNICODE);
            }
            else{
                echo 'error';
            }
            mysqli_close($mysqli);
        }
        exit;

     }
     //eliminar 
     if($_POST['action'] =='del_product_detalle'){
         
        if(empty($_POST['id_detalle'])){
            echo'error';
        }
        else{
            $id_detalle=$_POST['id_detalle'];
            $token=md5($_SESSION['idUser']);
           
            $query_iva= mysqli_query($mysqli,"SELECT iva from configuracion");
            $result_iva= mysqli_num_rows($query_iva);

            $query_detalle_temp=mysqli_query($mysqli,"CALL del_detalle_temp($id_detalle,'$token')");
            $result=mysqli_num_rows($query_detalle_temp);
            
 
            $detalleTabla ='';
            $sub_total=0;
            $iva=0;
            $total=0;
            $arrayDate= array();
            
            if($result>0){
                if($result_iva>0){
                    $info_va=mysqli_fetch_assoc($query_iva);
                    $iva=$info_va['iva'];
 
                }
                while($data =mysqli_fetch_assoc($query_detalle_temp)){
                    $precioTotal=round($data['cantidad'] * $data['precio_venta'],2);
                    $sub_total=round($sub_total+$precioTotal,2);
                    $total=round($total+$precioTotal,2);
 
                    $detalleTabla .='
                    <tr>
                     <td>'.$data['codproducto'].'</td>
                     <td colspan="2">'.$data['descripcion'].'</td>
                     <td class="textcenter">'.$data['cantidad'].'</td>
                     <td class="textright">'.$data['precio_venta'].'</td>
                     <td class="textright">'.$precioTotal.'</td>
                     <td class="">
                         <a href="#" class="link_delete" onclick="event.preventDefault(); del_product_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a>
                     </td>
             </tr>';
 
                }
                $impuesto=round($sub_total * ($iva/100),2);
                $tl_sniva=round($sub_total - $impuesto,2);
                $total=round($tl_sniva+ $impuesto,2);
 
                $detalleTotales='
                <tr>
                <td colspan="5" class="textright">subtotal $</td>
             <td class="textright">'.$tl_sniva.'</td>
         </tr>
         <tr><td colspan="5" class="textright">iva('.$iva.'%) </td>
             <td class="textright">'.$impuesto.'</td>
         </tr>
         <tr><td colspan="5" class="textright">total $</td>
             <td class="textright">'.$total.'</td>
         </tr>           
                
                ';
                $arrayDate['detalle']=$detalleTabla;
                $arrayDate['totales']=$detalleTotales;
                echo json_encode($arrayDate,JSON_UNESCAPED_UNICODE);
            }
            else{
                echo 'error';
            }
            mysqli_close($mysqli);
        }
        exit;

     }
//anular venta
    if($_POST['action']=='anularVenta'){
        $token=md5($_SESSION['idUser']);
        $query_del= mysqli_query($mysqli,"DELETE FROM  detalle_temp where  token_user = '$token'");
        mysqli_close($mysqli);
        if($query_del){
            echo 'ok';
        }
        else{
            echo 'error';
        }
        exit;

    }
//cambiar contraseña
    if($_POST['action']=='changePassword'){
       if(!empty($_POST['passActual'])&&!empty($_POST['passNuevo'])){
           $password=md5($_POST['passActual']);
           $newPass=md5($_POST['passNuevo']);
           $idUser=$_SESSION['idUser'];

           $code='';
           $msg='';
           $arrData='';

           $query_user = mysqli_query($mysqli,"SELECT *FROM usuario where clave='$password' and idusuario =$idUser");
            $result=mysqli_num_rows($query_user);
            if ($result>0){
                $query_update=mysqli_query($mysqli,"UPDATE usuario set clave ='$newPass' where idusuario=$idUser");
                mysqli_close($mysqli);
                if($query_update){
                    $code='00';
                    $msg='Su Contraseña se ha Actualizado Correctamente';
                }
                else{
                    $code='2';
                    $msg='no hes posible Cambiar su Contraseña';  
                }
            }
            else{
                $code='1';
                $msg='la Contraseña Actual es incorrecta';  
            }
            $arrData=array('cod'=>$code,'msg'=>$msg);
             echo json_encode($arrData,JSON_UNESCAPED_UNICODE);

       }else{
           echo 'error';    
       }
       exit;

    }
    //precesar venta
    if($_POST['action']=='procesarVenta'){
        if(empty($_POST['codcliente'])){
            $codcliente =1;
        }else{
            $codcliente =$_POST['codcliente'];
        }
        $token= md5($_SESSION['idUser']);
        $usuario= $_SESSION['idUser'];
        $query =mysqli_query($mysqli,"SELECT *FROM detalle_temp where token_user ='$token'");
        $result = mysqli_num_rows($query);
        if ($result>0){
            $query_procesar=mysqli_query($mysqli,"CALL procesar_venta($usuario,$codcliente,'$token')");
            $result_detalle=mysqli_num_rows($query_procesar);
            if($result_detalle>0){
                $data =mysqli_fetch_assoc($query_procesar);
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }else{
                echo 'error';
            }
        }
        else{
            echo 'error';
        }
        mysqli_close($mysqli);
        exit;
        
    }

    }exit;

?>