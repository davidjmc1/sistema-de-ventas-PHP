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

                   $detalleTabla ='
                   <tr>
                    <td>'.$data['codproducto'].'</td>
                    <td colspan="2">'.$data['descripcion'].'</td>
                    <td class="textcenter">'.$data['cantidad'].'</td>
                    <td class="textright">'.$data['precio_venta'].'</td>
                    <td class="textright">'.$precioTotal.'</td>
                    <td class="">
                        <a href="#" class="link_delete" onclick="event.preventDefault(); del_product_detalle('.$data['codproducto'].');"><i class="far fa-trash-alt"></i></a>
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
               echo 'error3';
           }
           mysqli_close($mysqli);
       }
       exit;
    }
    
    
    }exit;
