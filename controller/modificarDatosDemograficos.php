<?php 
  session_start();
  include('../model/PDORepository.php');

$id = $_POST['id'];
if (isset($_POST['heladera']) and isset($_POST['electricidad']) and isset($_POST['mascotas']) and isset($_POST['vivienda']) and isset($_POST['calefaccion']) and isset($_POST['agua']) ) {


	$heladera =$_POST['heladera'];
	$electricidad =$_POST['electricidad'];
	$mascotas = $_POST['mascotas'];
	$vivienda = $_POST['vivienda'];
	$calefaccion = $_POST['calefaccion'];
	$agua = $_POST['agua'];
   
	PDORepository::modificarDatosDemograficos($heladera, $electricidad, $mascotas, $vivienda, $calefaccion, $agua, $id);
	header ("Location: ../index.php?action=datosDemograficos&error=0");

}