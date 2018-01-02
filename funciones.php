<?php 
session_start();

if (!logueado() && isset($_COOKIE["usuarioLogueado"])) {
  loguear($_COOKIE["usuarioLogueado"]);
 }

/*MYSQL
$dns = 'mysql:host=localhost;dbname=clientesEBS;charset=utf8mb4;port=3306';
$db_user="root";
$db_pass= "root";

try{
  $db = new PDO($dns, $db_user, $db_pass);
} catch(Exception $e){
  echo "Conexion a la base de datos fallida: " . $e->getMessage();
}
*/

function  validarInformacion($usuarios){
  $errores =[];

  foreach ($usuarios as $key => $value) {
    $usuarios[$key] = trim($value);
  }

    if (strlen($usuarios["nombre"]) == '' ) {
	     $errores["nombre"] = "El nombre no puede estar vacio";
    }else if (strlen($usuarios["nombre"])< 3) {
      $errores["nombre"] = "El nombre debe tener al menos 3 caracteres";
    }
    
    if (strlen($usuarios["apellido"]) == '' ) {
	     $errores["apellido"] = "El apellido no puede estar vacio";
    }else if (strlen($usuarios["apellido"])< 3) {
      $errores["apellido"] = "El apellido debe tener al menos 3 caracteres";
    }
    
    if (strlen($usuarios["username"]) == '' ) {
	     $errores["username"] = "El usuario no puede estar vacio";
    }else if (strlen($usuarios["username"])< 3) {
      $errores["username"] = "El usuario debe tener al menos 3 caracteres";
    }

    if ($usuarios["password"] == '' ) {
	     $errores["password"] = "La contraseña no puede estar vacia";
    }

    if ($usuarios["cpassword"] == ''){
        $errores["cpassword"]= "La contraseña no puede estar vacia";
    }

    if (strlen($usuarios["password"]) < 6) {
        $errores["password"] = "La contraseña tiene que tener al menos 6 caracteres";
    } else if ($usuarios["password"] != $usuarios["cpassword"]) {
    $errores["password"] = "Las contraseñas no son iguales";
    }
    
    if ($usuarios["email"] == '' ) {
	     $errores["email"] = "El correo no puede estar vacio";
    }else if(filter_var($usuarios["email"], FILTER_VALIDATE_EMAIL) == false) {
        $errores["email"] = "Correo electronico invalido";
    }else if (buscarPorEmail($usuarios["email"]) != NULL) {
    $errores["email"] = "El mail ya existe";
  }

    if (is_numeric($usuarios["telef"] )!= true ) {
        $errores["telef"] = "Los caracteres deben ser numericos";
    }
    
    if ($usuarios["telef"] == '' ) {
	     $errores["telef"] = "El número telefonico no puede estar vacio";
    }

    if ($usuarios["direccion"] == '' ) {
	     $errores["direccion"] = "La direccion no puede estar vacia";
    }

    $errorDeFoto = $_FILES["foto-perfil"]["error"];
    $nombreDeFoto = $_FILES["foto-perfil"]["name"];
    $extension = pathinfo($nombreDeFoto, PATHINFO_EXTENSION);

    if ($errorDeFoto != UPLOAD_ERR_OK) {
      $errores["foto-perfil"] = "Hubo un error al cargar la foto";
    }
      else if ($extension != "jpg" && $extension != "jpeg" && $extension != "png" && $extension != "gif") {
      $errores["foto-perfil"] = "El archivo no corresponde a una imagen";
    }
    /*if ($usuarios["comentario"] == ''){
      $errores["comentario"] = "El comentario debe tener al menos 10 caracteres...";
    }*/

  return $errores;
}


function armarUsuario($data) {
  return [
	   "nombre" => $data["nombre"],
	   "apellido" => $data["apellido"],
	   "usuario" => $data["username"],
     "email" => $data["email"],
     "telefono" => $data["telef"],
     "direccion" => $data["direccion"],
     "password" => password_hash($data["password"], PASSWORD_DEFAULT)
  ];
}

function guardarUsuario($usuario) {
   $usuarioJSON = json_encode($usuario);
    file_put_contents("usuarios.json", $usuarioJSON . PHP_EOL, FILE_APPEND);
}
  
  /*MYSQL
  function guardarUsuario($usuario) {

  global $db;

  $sql = "Insert into usuarios values (default,:nombre,:apellido,:usuario,:email,:telef,:direccion,:password    )";

  $query = $db->prepare($sql);
  
  $query->bindValue(":nombre",$usuario["nombre"]);
  $query->bindValue(":apellido",$usuario["apellido"]);
  $query->bindValue(":usuario",$usuario["usuario"]);
  $query->bindValue(":telef",$usuario["telef"]);
  $query->bindValue(":direccion",$usuario["direccion"]);
  $query->bindValue(":password",$usuario["password"]);

  $query->execute();

  $usuario["id"] = $db->lastInserId();

  return $usuario;
}
  */    

function traerUsuarios(){
  $archivo = file_get_contents("usuarios.json");
  $array = explode(PHP_EOL, $archivo);
  array_pop($array);

  $arrayDefinitivo =[];
  foreach ($array as $usuario) {
    $arrayDefinitivo[] = json_decode($usuario, true);
  } 
return $arrayDefinitivo;
}

 /*MYSQL
function traerusuarios(){

  global $db;

  $sql = "Select * from usuarios";

  $query = $db->prepare($sql);

  $query->execute();

  $arrayDefinitivo = $query->fetchAll(PDO::FECTH_ASSOC);

  return $arrayDefinitivo;
 
}
 */

  
function buscarPorEmail($email){
 $todos = traerUsuarios();

  foreach ($todos as $usuario) {
    if ($usuario["email"] == $email){
      return $usuario;
    }else{
  }
  return NULL;

}

/*MYSQL
function buscarPorEmail($email){
  global $db;

  $aql= "Select * from usuarios where email = :email";

  $query = $db->prepare($sql);

  $query->bindValue(":email", $email);

  $query->execute();

  $usuario = $query->fecht(PDO::FECTH_ASSOC);

  return $usuario;
}
*/

function validarLogin($usuarios){
  $errores=[];

  if(strlen($usuarios["username"])==0){
    $errores["username"] = "Usuario invalido";
  }else if (buscarPorEmail($usuarios["username"])==NULL) {
    $errores["usuario"]= "Usuario no existe";
  }

  $cliente = buscarPorEmail($usuarios["username"]);
    if (password_verify($usuarios["password"], $cliente["password"])==false){
      $errores["password"]= "Contraseña incorrecta"; 
    }
  return $errores;
}
function traerTodos() {
  $archivo = file_get_contents("usuarios.json");
  $array = explode(PHP_EOL, $archivo);
  array_pop($array);

  $arrayFinal = [];
  foreach ($array as $usuario) {
    $arrayFinal[] = json_decode($usuario, true);
  }

  return $arrayFinal;
}



function loguear($usuario){
  $_SESSION["usuarioLogueado"]= $usuario;
}

function logueado(){
  if(isset($_SESSION["usuarioLogueado"])){
    return true;
  }else{
    return false;
  }
}

function usuarioLogueado(){
  if(logueado()){
    return buscarPorEmail($_SESSION["usuarioLogueado"]);
  }else{
    return NULL;
  }
}

function recordarme($email){
  setcookie("usuarioLogueado", $email, time() + 60*60*24*7);
 }


?>

