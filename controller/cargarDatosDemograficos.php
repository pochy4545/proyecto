<?php
session_start();
include('../model/PDORepository.php');

$patron = "/^[a-zA-Z1-9@\s]+$/";
$letras="/^[a-zA-Z\s]+$/";

if(isset($_POST['heladera'])AND isset($_POST['electricidad'])AND isset($_POST['mascotas'])AND isset($_POST['vivienda'])AND isset($_POST['calefaccion'])AND isset($_POST['agua'])){

        $heladera= $_POST['heladera'];
        $electricidad= $_POST['electricidad'];
        $mascotas= $_POST['mascotas'];
        $vivienda = $_POST['vivienda'];
        $calefaccion= $_POST['calefaccion'];
        $agua= $_POST['agua'];
        $id_paciente=$_POST['id_paciente'];

      //  if(preg_match($letras, $nombre) and preg_match($letras, $apellido)/*and preg_match($patron, $email)*/){



           PDORepository::cargarDatosDemograficos($heladera,$electricidad,$mascotas,$vivienda,$calefaccion,$agua,$id_paciente);



           header("Location: ../index.php?action=areaPaciente");


  //}
}
