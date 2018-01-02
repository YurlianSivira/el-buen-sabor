<?php 
require_once("funciones.php");

//if(logueado()){
//header("Location:home.php");
//}
//PERSISTENCIA	

$nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
$apellido = (isset($_POST["apellido"])) ? $_POST["apellido"] : "";
$usuario = (isset($_POST["username"])) ? $_POST["username"] : "";
$email = (isset($_POST["email"])) ? $_POST["email"] : "";
$telef = (isset($_POST["telef"])) ? $_POST["telef"] : "";
$direccion = (isset($_POST["direccion"])) ? $_POST["direccion"] : "";

$arrayErrores = [];
$usernameDefault = "";
$emailDefault = "";

	if($_POST){
		$arrayErrores = validarInformacion($_POST);
			if (count($arrayErrores) == 0){
				$usuario = armarUsuario($_POST);
				guardarUsuario($usuario);
				$archivo = $_FILES["foto-perfil"]["tmp_name"];
				$nombreDeFoto = $_FILES["foto-perfil"]["name"];
				$extension = pathinfo($nombreDeFoto, PATHINFO_EXTENSION);
				$nombre = dirname(__FILE__) . "\imagen_usuarios\ " . $_POST["email"] . ".$extension";
				move_uploaded_file($archivo, $nombre);
				header("Location:home.php");exit;
			}
		$emailDefault = $_POST["email"];
		$usernameDefault = $_POST["username"];
	}
include_once("header.php");
?>

<section class="reg">
	<div class="contacto1">	
			<h2 class="ent" > Formulario de registro </h2>
				<form class="registro" action="registro.php" method="post" enctype="multipart/form-data">
					<label>Nombre:</label>
					<br>
					<input type="text" name="nombre" value="<?=$nombre?>">
						<?php if(isset($arrayErrores["nombre"])) :?>
						 	<br>
						 	<span style="color:black;">
							<?=$arrayErrores["nombre"]?>
							</span>
						<?php endif;?>
					<br>
					
					<label>Apellido:</label>				
					<br>
					<input type="text" name="apellido" value="<?=$apellido?>">
						<?php if(isset($arrayErrores["apellido"])) :?>
							<br>
							<span style="color:black;">
							<?=$arrayErrores["apellido"]?>
							</span>
						<?php endif;?>
					<br>
					
					<label>Usuario:</label>
					<br>
					<input type="text" name="username" value="<?=$usernameDefault?>">
						<?php if(isset($arrayErrores["username"])) :?>
							<br>
							<span style="color:black;">
							<?=$arrayErrores["username"]?>
							</span>
						<?php endif;?>
					<br>

					<label>Contraseña:</label>
					<br>
					<input type="password" name="password" value="">
						<?php if(isset($arrayErrores["password"])) :?>
							<br>
							<span style="color:black;">
							<?=$arrayErrores["password"]?>
							</span>
						<?php endif;?>
					<br>

					<label>Confirmar Contraseña:</label>
					<br>
					<input type="password" name="cpassword" value="">   
						<?php if(isset($arrayErrores["cpassword"])) :?>
							<br>
							<span style="color:black;">
							<?=$arrayErrores["cpassword"]?>
							</span>
						<?php endif;?>
					<br>

					<label>Correo Electronico:</label>
					<br>
					<input type="email" name="email" value="<?=$email?>">
						<?php if(isset($arrayErrores["email"])) :?>
							<br>
							<span style="color:black;">
							<?=$arrayErrores["email"]?>
							</span>
						<?php endif;?>
					<br>

					<label>Teléfono:</label>
					<br>
					<input type="number" name="telef" value="<?=$telef?>">
						<?php if(isset($arrayErrores["telef"])) :?>
							<br>
							<span style="color:black;">
							<?=$arrayErrores["telef"]?>
							</span>
						<?php endif;?>
					<br>
					
					<label>Direccion:</label>
					<br>
					
					<input type="text" name="direccion" value="<?=$direccion?>">
						<?php if(isset($arrayErrores["direccion"])) :?>
							<br>
							<span style="color:black;">
							<?=$arrayErrores["direccion"]?>
							</span>
						<?php endif;?>
					<br>
					<br>
					
				    <label>Foto de Perfil</label>
          				<?php if (isset($arrayErrores["foto-perfil"])) : ?>
          	 		<input type="file" name="foto-perfil">
          	 			<br>
          	 			<span style="color:black;">
          	 			<?=$arrayErrores["foto-perfil"]?>
          				<?php else: ?>
            		<input type="file" name="foto-perfil">
           				<?php endif; ?>
     
					<br>
					<br>
					<button type="submit" name="button">REGISTRARSE</button>
					
					<br>
					<br>
				</form>	
	</div>
</section>

<?php include_once("footer.php");?>
