<?php 
  session_start();
  include('../model/PDORepository.php');

$patron = "/^[a-zA-Z1-9@\s]+$/";
$letras="/^[a-zA-Z\s]+$/";

  $id = $_GET['id'];

if(isset($_POST['nombre'])AND isset($_POST['apellido'])AND isset($_POST['FechadeNacimiento'])AND isset($_POST['numero'])AND isset($_POST['telefono'])){

        $nombre= $_POST['nombre'];
        $apellido= $_POST['apellido'];
        $fechadeNacimiento= $_POST['FechadeNacimiento'];
        $tipoDoc = $_POST['tipoDoc'];
        $dni= $_POST['numero'];
        $telefono= $_POST['telefono'];
        $obraSocial= $_POST['obraSocial'];
        $genero = $_POST['genero'];
        $domicilio = $_POST['domicilio'];

        

        if(preg_match($letras, $nombre) and preg_match($letras, $apellido)/*and preg_match($patron, $email)*/){

            PDORepository::updatePaciente($nombre, $apellido, $fechadeNacimiento, $tipoDoc, $dni, $telefono, $obraSocial, $genero, $domicilio, $id);
			      header ("Location: ../index.php?action=areaPaciente&error=0");

		}

}
	
  ?>