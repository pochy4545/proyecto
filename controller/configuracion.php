<?php
include('../model/PDORepository.php');

if(isset($_POST['nombre'])AND isset($_POST['descripcion'])AND isset($_POST['email'])AND isset($_POST['pagina_cant'])){
	
	$nombre=$_POST['nombre'];
	$descripcion=$_POST['descripcion'];
	$email=$_POST['email'];
	$pagina_cant=$_POST['pagina_cant'];
	$activo=$_POST['activo'];
     //"falta isset"
	if ($activo == 'on') {
		$activo= 1;
		
	}else{
		$activo= 0;
	}
    
    $id = 1;
	PDORepository::updateConfiguracion($nombre, $descripcion, $pagina_cant, $email, $activo, $id);
	header("Location: ../index.php"); 
}


 ?>