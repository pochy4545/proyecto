<?php
session_start();
include('../model/PDORepository.php');

$patron = "/^[a-zA-Z1-9@\s]+$/";
$letras="/^[a-zA-Z\s]+$/";

if(isset($_POST['nombre'])AND isset($_POST['apellido'])AND isset($_POST['fechadeNacimiento'])AND isset($_POST['numero'])AND isset($_POST['telefono'])){

        $nombre= $_POST['nombre'];
        $apellido= $_POST['apellido'];
        $fechadeNacimiento= $_POST['fechadeNacimiento'];
        $tipoDoc = $_POST['tipoDoc'];
        $dni= $_POST['numero'];
        $telefono= $_POST['telefono'];
        
        $obraSocial = $_POST['obraSocial'];
        $genero = $_POST['genero'];
        $domicilio = $_POST['domicilio'];

        if(preg_match($letras, $nombre) and preg_match($letras, $apellido)/*and preg_match($patron, $email)*/){

          $result=PDORepository::existePaciente($dni);

          if ($result <> 0){

              header("Location: ../index.php?action=altaPaciente&error=1");

           }else{

           $id=PDORepository::cargarPaciente($nombre,$apellido,$fechadeNacimiento,$tipoDoc,$dni,$telefono,$obraSocial,$genero,$domicilio);



           header("Location: ../index.php?action=cargarDatosDemograficos&idPaciente=$id");

        }
  }
}
