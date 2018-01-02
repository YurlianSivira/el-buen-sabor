<?php include_once("funciones.php");

$nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
$apellido = (isset($_POST["apellido"])) ? $_POST["apellido"] : "";
$email = (isset($_POST["email"])) ? $_POST["email"] : "";
$telef = (isset($_POST["telef"])) ? $_POST["telef"] : "";
$comentario =(isset($_POST["comentario"])) ? $_POST["comentario"] : "";


$errores=[];
	if($_POST){
		$errores = validarInformacion($_POST);
			if (count($errores) == 0){
			header("Location:home.php");exit; 
		}
	}

include_once("header.php");
?> 	
	
	<section class="main_contac">
		<div class="contacto">	
			<h2 class="ent" > Formulario de Contacto </h2>
				<form class="ingreso" action="contacto.php" method="post">
					<label>Nombre:</label>
					<br>
					<input type="text" name="nombre" value="">
						<?php if(isset($errores["nombre"])) :?>
						 	<br>
						 	<span style="color:black;">
							<?=$errores["nombre"]?>
							</span>
						<?php endif;?>
					<br>
					
					<label>Apellido:</label>				
					<br>
					<input type="text" name="apellido" value="">
						<?php if(isset($errores["apellido"])) :?>
							<br>
							<span style="color:black;">
							<?=$errores["apellido"]?>
							</span>
						<?php endif;?>
					<br>
					
					<label>Correo Electronico:</label>
					<br>
					<input type="email" name="email" value="">
						<?php if(isset($errores["email"])) :?>
							<br>
							<span style="color:black;">
							<?=$errores["email"]?>
							</span>
						<?php endif;?>
					<br>

					<label>Teléfono:</label>
					<br>
					<input type="number" name="telef" value="">
						<?php if(isset($errores["telef"])) :?>
							<br>
							<span style="color:black;">
							<?=$errores["telef"]?>
							</span>
						<?php endif;?>
					<br>
					<label>Comentario:</label> 
					<br>
					<textarea name=”comentario” cols="30" rows="5" value="">
						<?php if(isset($errores["comentario"])):?>
							<?=$errores["comentario"]?>
						<?php endif;?>	
					 </textarea>
					<br>
					<button type=”submit”>Enviar</button>
					<br>
				</form>
				
		</div>
	</section>

<?php include_once("footer.php");?>