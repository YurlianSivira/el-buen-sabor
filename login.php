<?php include_once("funciones.php");


//if(logueado()){
//header("Location:home.php");
//}

$errores=[];
	if($_POST){
		$errores = validarLogin($_POST);

		if (count($errores)==0) {
			loguear($_POST["usuario"]);
			if(isset($_POST["recordarme"])){
				recordarme($_POST["usuario"]);
			}
			header("Location:alfin.php");exit; 
		}
	}
include("header.php");
?>

<div class="entrar">
			
				<form class="ingreso" action="login.php" method="post">
					<h3 class="entra">Entra en tu cuenta</h3>
					<br>
					<label>Usuario:</label>
					<br>
					<input type="text" name="username" value="">
						<?php if(isset($errores["username"])) :?>
							<br>
							<span style="color:black;">
							<?=$errores["username"]?>
							</span>
						<?php endif;?>
					<br>

					<label>Contraseña:</label>
					<br>
					<input type="password" name="password" value="">
						<?php if(isset($errores["password"])) :?>
							<br>
							<span style="color:black;">
							<?=$errores["password"]?>
							</span>
						<?php endif;?>
					<br>
					<br>
					<input type="submit" value="Ingresar">
					<br>
					<label>Recordarme</label>
					<input type="checkbox" name="recordarme" value="1">
					<a href="olvido_password.php">¿Olvido contraseña?</a>
				</form>
			</div>


<?php 
include("main.php");
include("footer.php");?>
