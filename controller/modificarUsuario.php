<?php 
  session_start();
  $id = $_GET['id'];

	header ("Location: /?action=modificarUsuario&id=$id&error=0");
	
   ?>