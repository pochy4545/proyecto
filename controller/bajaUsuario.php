<?php
session_start();
include('../model/PDORepository.php'); 

$error="yes";
if (isset($_POST['id'])) {
   $id=$_POST['id'];
   PDORepository::eliminarUsuario($id);
	$error="no";
}
header("Location: /?action=areaAdmin&error=$error");

?>