<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta charset="UTF-8">
	<?php
	include ("includes/scripts.php"); ?>
	<title>PUNTO FRIO JL</title>
</head>
<body>
	

	<?php
	include ("includes/header.php");

	include ("../conexion.php");
$query_dash=mysqli_query($mysqli,"CALL dataDashboard();");
$result_dash=mysqli_num_rows($query_dash);

if($result_dash>0){	
	$data_dash =mysqli_fetch_assoc($query_dash);
	mysqli_close($mysqli);
}

	?>
<section id="container"><br><br><br><br><br><br><br>
<center>
	<div class="divContainer">
	<div>
	<h2 class="titulo_panel coffe">Sistema de Ventas</h1>
	</div></center>
	<div class="dashboard">
	
	<a href="lista_usuarios.php">
	<i class="fas fa-users"></i> 
	<p><strong>Usuarios</strong><br>
	<span><?=$data_dash['usuarios'] ?></span></p></a>

	<a href="lista_clientes.php">
	<i class="fas fa-user -tag"></i> 
	<p><strong>clientes</strong><br>
	<span><?=$data_dash['clientes'] ?></span></p></a>

	<a href="lista_productos.php">
	<i class="fas fa-beer"></i> 
	<p><strong>Bebidas</strong><br>
	<span><?=$data_dash['productos'] ?></span></p></a>

	<a href="lista_proveedores.php">
	<i class="fas fa-portrait"></i> 
	<p><strong>proveedores</strong><br>
	<span><?=$data_dash['proveedores'] ?></span></p></a>

	<a href="ventas.php">
	<i class="fa fa-shopping-bag icon-menu"></i> 
	<p><strong>Ventas</strong><br>
	<span><?=$data_dash['ventas'] ?>
	</span></p></a>	

	</div>
	</div>
<center>
	<div class="divInfoSistem">
	<div>
	<h2 class="titulo_panel2 coffe">configuracion</h1></div><br><br>
	<div class="containerPerfil">
		
	<div class="containerDataUser">
	<div class="logoUser">
			<img src="img/user.jpg" >
		</div>
		<div class="dataUser">

		<h4>Informacion Personal</h4>
		<div><label >Nombre:</label> <span><?=$_SESSION['nombre']?></span></div>
		<div><label >Correo:</label><span><?=$_SESSION['email']?></span></div><br>
		<h4>Datos Usuarios</h4>
		<div><label >Rol:</label> <span><?=$_SESSION['rol_name']?></span></div>
		<div><label >Usuario:</label><span><?=$_SESSION['user']?></span></div>
<br>		</div>
		<h4>Cambiar Contraseña</h4>
		<form action="" method="post" name="changePass" id="changePass">
<br>
		<div>
			<input type="password" name="txtPassUser" id="txtPassUser"
			placeholder="Contraseña Actual" required>
		</div>
		<br>
		<div>
			<input class="newPass" type="password" name="txtNewPassUser" id="txtNewPassUser"
			placeholder=" Nueva Contraseña" required>
		</div>
		<br>
		<div>
			<input class="newPass"  type="password" name="txtPassConfirm" id="txtPassConfirm"
			placeholder=" Confirmar Contraseña" required>
		</div>
		<div class="alertChangePass " syle="display:none;">

		</div>
		<div>
			<button type="submit" class="btn_save2 btnChangePass"><i class="fas fa-key"></i> Cambiar</button>
		</div>

		</form>
	</div>
	<div class="containerDataEmpresa">
	
	<div class="logoUser">
			<img src="img/empre.png" >
		</div>
		<h4>Datos de la Empresa</h4>
		<form action="" method="post" name ="frmEmpresa" id="frmEmpresa">
		<input type="hidden" name="action" values="UpdateDataEmpresa">
		<div>
			<label >Nombre:</label><input type="text" name="txtNombre"
			 id="txtNombre" placeholder="Nombre de la Empresa" value="" required>
		</div>

		<div>
			<label >Razon social :</label><input type="text" name="txtSocial"
			 id="txtSocial" placeholder="Razon Social" value="" required>
		</div>

		<div>
			<label >Telefono :</label><input type="number" name="txtTelefono"
			 id="txtTelefono" placeholder="Numero de Telefono" value="" required>
		</div>

		<div>
			<label >Correo Electronico: </label><input type="email" name="txtCorreo"
			 id="txtCorreo" placeholder="Correo Electronico" value="" required>
		</div>

		<div>
			<label >Direccion: </label><input type="text" name="txtDireccion"
			 id="txtDireccion" placeholder="Direccion de la Empresa" value="" required>
		</div>

		<div>
			<label >Iva(%): </label><input type="text" name="txtIva"
			 id="txtIva" placeholder="Impuesto al valor Agregado (IVA)" value="" required>

		</div>

		<div class="alertFormEmpresa" style="display:none;"> </div>
		<div>
			<button type="submit" class="btn_save2 btnChangepass"><i class="far fa-save fa-lg"></i>Guardar </button>
		</div>




		</form>
	</div>
	</div>
	</div>
	</section>	
	</body>
	
</html>