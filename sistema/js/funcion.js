$(document).ready(function(){
  
    ///modal

     $('.add_product').click(function(e){
        e.preventDefault();
        var producto =$(this).attr('product');  
        var action ='infoProducto';

        $.ajax({
            url:'ajax.php',
            type:'POST',
            async:true,
            data:{action:action,producto:producto},

            success:function(response){
                
                if(response!='error'){
                    var info=JSON.parse(response);
                
                    $('#producto_id').val(info.codproducto);
                    $('.nameProducto').html(info.descripcion);
                }
            },
            error:function(error){
                console.log(error);
            }
        
        });
        $('.modal').fadeIn();

    });
    
    $('.btn_new_cliente').click(function(e){
        e.preventDefault();
        $('#nom_cliente').removeAttr('disabled');
        $('#tel_cliente').removeAttr('disabled');
        $('#dir_cliente').removeAttr('disabled');

        $('#div_registro_cliente').slideDown();
    });


    $('#nit_cliente').keyup(function(e){
        e.preventDefault();
        var cl= $(this).val();
        var action ='searchCliente';
        $.ajax({
            url:'ajax.php',
            type:'POST',
            async:true,
            data:{action:action,cliente:cl},
             success:function(response){
             
             if(response==0){
                 $('#idcliente').val('');
                 $('#nom_cliente').val('');
                 $('#tel_cliente').val('');
                 $('#dir_cliente').val('');
                 $('.btn_new_cliente').slideDown();
                             }
                else{
                    var data =$.parseJSON(response);
                    $('#idcliente').val(data.idcliente);
                    $('#nom_cliente').val(data.nombre);
                    $('#tel_cliente').val(data.telefono);
                    $('#dir_cliente').val(data.direccion);
                    $('#idcliente').val(data.idcliente);

                    $('.btn_new_cliente').slideUp();
                    $('#nom_cliente').attr('disabled','disabled');
                    $('#tel_cliente').attr('disabled','disabled');
                    $('#dir_cliente').attr( 'disabled','disabled');

                    $('#div_registro_cliente').slideUp();
                }
         },
         error:function(error){
             console.log(error);
         }
        });
    });
    
    //CREAR CLIENTE - VENTAS
$('#form_new_cliente_venta').submit(function(e){
    e.preventDefault();

    $.ajax({
        url:'ajax.php',
        type:'POST',
        async:true,
        data:$('#form_new_cliente_venta').serialize(),

         success:function(response){
             if(response!='error'){
                 $('#idcliente').val(response);
                 $('#nom_cliente').attr('disabled','disabled');
                 $('#tel_cliente').attr('disabled','disabled');
                 $('#dir_cliente').attr('disabled','disabled');

                 $('.btn_new_cliente').slideUp();
                 $('#div_registro_cliente').slideUp();
             }
        
        },
     error:function(error){
     }

});
});

$('#txt_cod_producto').keyup(function(e){
    e.preventDefault();
    var producto =$(this).val();
    var action='infoProducto';
    if(producto!=''){
    $.ajax({
        url:'ajax.php',
        type:'POST',
        async:true,
        data:{action:action,producto:producto},

         success:function(response){

        if(response!='error'){
            var info =JSON.parse(response);
            $('#txt_descripcion').html(info.descripcion);
            $('#txt_existencia').html(info.existencia);
            $('#txt_cant_producto').val('1');
            $('#txt_precio').html(info.precio);
            $('#txt_precio_total').html(info.precio);
            $('#txt_cant_producto').removeAttr('disabled');

            $('#add_product_venta').slideDown();
        }else{
            $('#txt_descripcion').html('-');
            $('#txt_existencia').html('-');
            $('#txt_cant_producto').val('0');
            $('#txt_precio').html(0.00);
            $('#txt_precio_total').html(0.00);

            $('#txt_cant_producto').attr('disabled','disabled');
            $('#add_product_venta').slideUp();
        }
        },
     error:function(error){
     }
    });

    }
});

//calcular cantidad de producto

$('#txt_cant_producto').keyup(function(e){
    e.preventDefault();
    var precio_total=$(this).val()*$('#txt_precio').html();
    var existencia= parseInt($('#txt_existencia').html());
    $('#txt_precio_total').html(precio_total);
    if(($(this).val() <1 || isNaN($(this).val()))|| ($(this).val() > existencia) ){
        $('#add_product_venta').slideUp();
    }
    else{
        $('#add_product_venta').slideDown();
    }
});

$('#add_product_venta').click(function(e){
    e.preventDefault();
    if($('#txt_cant_producto').val()>0){
        var codproducto= $('#txt_cod_producto').val();
        var cantidad= $('#txt_cant_producto').val();
        var action = 'addProductoDetalle';
        $.ajax({
            url:'ajax.php',
            type:'POST',
            async:true,
            data:{action:action,producto:codproducto,cantidad:cantidad},
    
             success:function(response){
                 if (response!='error'){
                    var info =JSON.parse(response);
                    $('#detalle_venta').html(info.detalle);
                    $('#detalle_totales').html(info.totales);
                    $('#txt_cod_producto').val('');
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant_producto').val(0);
                    $('#txt_precio').html('0.0 0');
                    $('#txt_precio_total').html('0.00');

                    $('#txt_cant_producto').attr('disabled','disabled');
                    $('#add_product_venta').slideUp;

                 }
                 else{
                     console.log('no data');

                 }
                 viewProcesar();
             },
         error:function(error){
         }
        });
    }
});
$('#btn_anular_venta').click(function(e){
    e.preventDefault();
    var rows =$('#detalle_venta tr').length;
    if(rows>0){
        var action = 'anularVenta';
        $.ajax({
            url:'ajax.php',
            type:'POST',
            async:true,
            data:{action:action},
           
            success:function(response){
                console.log(response);
              if(response !='error'){
                  location.reload();
              } 
            },
            error:function(error){
                console.log(error);
            }
        
        });
    }

});

$('#btn_facturar_venta').click(function(e){
    e.preventDefault();
    var rows =$('#detalle_venta tr').length;
    if(rows>0){
        var action = 'procesarVenta';
        var codcliente=$('#idcliente').val();
        $.ajax({
            url:'ajax.php',
            type:'POST',
            async:true,
            data:{action:action, codcliente:codcliente},
           
            success:function(response){
                
             if(response !='error'){
                var info =JSON.parse(response);
                generarPDF(info.codcliente,info.nofactura);
                location.reload();
              }
              else{
                  console.log('no data');
              } 
            },
            error:function(error){
                console.log(error);
            }
        
        });
    }

});

//ver factura
$('.view_factura').click(function(e){
    e.preventDefault();
    var codCliente=$(this).attr('cl');
    var noFactura=$(this).attr('f');
    generarPDF(codCliente,noFactura);
});
//cambiar password
$('.newPass').keyup(function(){
    validPass();
});

$('#changePass').submit(function(e){
e.preventDefault();
var passActual=$('#txtPassUser').val();
var passNuevo=$('#txtNewPassUser').val();
var confirmPass=$('#txtPassConfirm').val();
var action="changePassword";
if(passNuevo!=confirmPass){
    $('.alertChangePass').html('<p style="color:red;">las contraseñas no son Iguales . </p>');
    $('.alertChangePass').slideDown();
    return false;

}
if(passNuevo.length<6){
    $('.alertChangePass').html('<p style="color:red;">la Nueva contraseña debe contener como minimo 6 caracteres . </p>');
    $('.alertChangePass').slideDown();
    return false;
    
}
$.ajax({
    url:'ajax.php',
    type:'POST',
    async:true,
    data:{action:action,passActual:passActual,passNuevo:passNuevo},

    success:function(response){
        if(response!='error'){
            var info=JSON.parse(response);
            if(info.cod=='00'){
                $('.alertChangePass').html('<p style="color:green;">'+info.msg+' </p>');
                $('#changePass')[0].reset();

            }
            else{
                $('.alertChangePass').html('<p style="color:red;">'+info.msg+' </p>');
            }
            $('.alertChangePass').slideDown();
        }
        
    },
    error:function(error){
        console.log(error);
    }

});
});
});
function validPass(){
    var passNuevo=$('#txtNewPassUser').val();
    var confirmPass=$('#txtPassConfirm').val();
    if(passNuevo!=confirmPass){
        $('.alertChangePass').html('<p style="color:red;">las contraseñas no son Iguales . </p>');
        $('.alertChangePass').slideDown();
        return false;

    }
    if(passNuevo.length<6){
        $('.alertChangePass').html('<p style="color:red;">la Nueva contraseña debe contener como minimo 6 caracteres . </p>');
        $('.alertChangePass').slideDown();
        return false;
        
    }
    $('.alertChangePass').html('');
        $('.alertChangePass').slideUp();
}
function generarPDF(cliente,factura){
    var ancho= 1000;
    var alto = 800;
    var x= parseInt((window.screen.width/2)-(ancho/2));
    var y= parseInt((window.screen.height/2)-(alto/2));
    $url='factura/generaFactura.php?cl='+cliente+'&f='+factura;
    window.open($url,"Factura","left="+x+",top"+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no.,resizable=si,menubar=no");
}
function sendDataProduct(){
    $('.alertAddProduct').html('');
    $.ajax({
        url:'ajax.php',
        type:'POST',
        async:true,
        data:$('#form_add_product').serialize(),

        success:function(response){
            
          if(response =='error'){
              $('.alertAddProduct').html('<p style="color:red;">Error al Agregar Producto.</p>')
          } 
          else{
            var info=JSON.parse(response);
            $('.row'+info.producto_id+' .celPrecio').html(info.nuevo_precio);
            $('.row'+info.producto_id+' .celExistencia').html(info.nueva_existencia);
            $('#txtcantidad').val('');
            $('#txtprecio').val('');
            $('.alertAddProduct').html('<p>Producto Guardado Correctamente.</p>');
          }
        },
        error:function(error){
            console.log(error);
        }
    
    });
}

function viewProcesar(){
    if($('#detalle_venta tr').length >0){
        $('#btn_facturar_venta').show();
    }
    else{
        $('#btn_facturar_venta').hide();
    }
}

function closeModal()
{
    $('.alertAddProduct').html('');
    $('#txtcantidad').val('');
    $('#txtprecio').val('');
    $('.modal').fadeOut();
} 
function del_product_detalle(correlativo){
    var action ='del_product_detalle';
    var id_detalle = correlativo;
    $.ajax({
        url:'ajax.php',
        type:'POST',
        async:true,
        data:{action:action,id_detalle:id_detalle},

         success:function(response){

            if (response!='error'){
                var info =JSON.parse(response);  
                $('#detalle_venta').html(info.detalle);
                    $('#detalle_totales').html(info.totales);
                    $('#txt_cod_producto').val('');
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant_producto').val(0);
                    $('#txt_precio').html('0.0 0');
                    $('#txt_precio_total').html('0.00');

                    $('#txt_cant_producto').attr('disabled','disabled');
                    $('#add_product_venta').slideUp;
            }
            else{
                $('#detalle_venta').html('');
                $('#detalle_totales').html('');
            }
           
           
             
         },
     error:function(error){
     }
    });

}     
function serchForDetalle(id){
    var action ='serchForDetalle';
    var user = id;
    $.ajax({
        url:'ajax.php',
        type:'POST',
        async:true,
        data:{action:action,user:user},

         success:function(response){
             
        
            if (response!='error'){
                var info =JSON.parse(response);
                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);
               

             }
             else{
                 console.log('no data');

             }
             viewProcesar();

             
         },
     error:function(error){
     }
    });

}  
