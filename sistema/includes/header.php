<?php

if(empty($_SESSION['active'])){
    header('location: ../');
}
?>



	<header>

    <div class="header1">
			
		<img  src="img/ti.png" >
			<img  src="img/logo.png" width="100">
			<div class="optionsBar">
                <p>Colombia,<?php echo fechaC();?></p>
				<span>|</span>
                <span class="user"><?php
               echo $_SESSION['user'].'-'.$_SESSION['rol'];?></span>
				<img class="photouser" src="img/user.png"  alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
		<span id="button-menu"> Menu</span>

		<nav class="navegacion">
			<ul class="menu">
				
				<li class="title-menu"><i class="fas fa-cog"></i> Opciones</li>
				

				<li><a href="index.php"><span class="fa fa-home icon-menu"></span> Inicio</a></li>

				<?php
					
					if($_SESSION['rol']==1){
						
						?>
				<li class="item-submenu" menu="1">
					<a href="#"><i class="fas fa-users"></i> Usuarios</a>
					<ul class="submenu">
						<li class="title-menu"><i class="fas fa-users"></i> Usuarios</li>
						<li class="go-back">Atras</li>

						<li><a href="registro_usuario.php">Nuevo usuario</a></li>
						<li><a href="lista_usuarios.php">Lista de Usuarios</a></li>
						
					</ul>
				</li>
				<?php
			}?>

				<li class="item-submenu" menu="2">
					<a href="#"><i class="fas fa-user-tag"></i> Cliente</a>
					<ul class="submenu">
						<li class="title-menu"><i class="fas fa-user-tag"></i> Cliente</li>
						<li class="go-back">Atras</li>

						<li><a href="registro_cliente.php">Nuevo Cliente</a></li>
						<li><a href="lista_clientes.php">Listado de Clientes</a></li>
		
					</ul>
                </li>
                <?php
                if($_SESSION['rol']==1||$_SESSION['rol']==2){
						
						?>
				<li class="item-submenu" menu="3">
					<a href="#"><i class="fas fa-portrait"></i> Proveedores</a>
					<ul class="submenu">
						<li class="title-menu"><i class="fas fa-portrait"></i> Proveedores</li>
						<li class="go-back">Atras</li>

						<li><a href="registro_proveedor.php">Nuevo Proveedor</a></li>
						<li><a href="lista_proveedores.php">Listado de Proveedores</a></li>
		
					</ul>
                </li>
                <?php
			}?>
			<li class="item-submenu" menu="4">
					<a href="#"> <i class="fas fa-beer"></i> Bebidas</a>
					<ul class="submenu">
						<li class="title-menu"><span class="fa fa-shopping-bag icon-menu"></span> Bebidas</li>
						<li class="go-back">Atras</li>

						<li><a href="registro_producto.php">Nueva Bebida</a></li>
						<li><a href="lista_productos.php">Listado de Bebidas</a></li>
		
					</ul>
                </li>
				<li class="item-submenu" menu="5">
					<a href="#"><span class="fa fa-shopping-bag icon-menu"></span> Ventas</a>
					<ul class="submenu">
						<li class="title-menu"><span class="fa fa-shopping-bag icon-menu"></span>Ventas</li>
						<li class="go-back">Atras</li>

						<li><a href="nueva_ventas.php">Nueva venta</a></li>
						<li><a href="ventas.php">Lista de Ventas</a></li>
		
					</ul>
				</li>

				
			</ul>
		</nav>
	</header>
	<div class="modal">

	<div class="bodyModal">
		<form action="" method="post" name="form_add_product" id="form_add_product"  onsubmit="event.preventDefault(); sendDataProduct();">
		
		<h2 class="c2"><i class="fas fa-wine-bottle" style="font-size:45pt;"></i><br> Agregar Bebida</h2>
			<br><h2 class="nameProducto"></h2><br><br>
			<input type="number" name="cantidad" id="txtcantidad" placeholder="Cantidad del Articulo" required><br><br>
			<input type="text" name="precio" id="txtprecio" placeholder="Precio del Articulo" required>
			<input type="hidden" name="producto_id" id="producto_id" required>
			<input type="hidden" name="action" value="addProduct" required>
			<div class="alert2 alertAddProduct"></div>
			<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>
			<a href="#" class ="btn_cancel closeModal" onclick="closeModal();"> <i class="fas fa-ban"></i> Cerrar</a>

		</form>
	</div>
	</div>
			
				
			



	
