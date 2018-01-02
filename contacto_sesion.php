<?php include_once("header_sesion.php");?>
	

	
	<section class="main_contac">
		<div class="contacto">	
			<h2 class="ent" > Formulario de Contacto </h2>
				<form class="ingreso" action=”#” method=”post”>
					<label>Nombre y apellido:</label>
					<br>
					<input  type=”name” name=”Nombre_y_Apellido”>
					<br>
					<label>Correo Electronico:</label>
					<br>
					<input type=”email” name=”Correo_Electronico”>
					<br>
					<label>Numero telefónico:</label>
					<br>
					<input type=”num” name=”Numero_telefonico”>
					<br>		
					<label>Comentario:</label> 
					<br>
					<textarea name=”Comentario” cols="30" rows="5"> </textarea>
					<br>
					<button type=”submit”>Enviar</button>
					<button type=”reset”>Borrar</button>
					<br>
				</form>
		</div>
	</section>

<?php include_once("footer_sesion.php");?>