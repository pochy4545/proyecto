<?php
session_start();
include('../model/PDORepository.php');

if (isset($_POST['id'])) {
   $id=$_POST['id'];
   PDORepository::eliminarControlSalud($id);
}
header("Location: ../?action=areaPaciente");

?>
