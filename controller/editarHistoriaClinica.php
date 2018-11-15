<?php 
  session_start();
  include('../model/PDORepository.php');

  $letras="/^[a-zA-Z\s]+$/";

  if ( isset($_POST['fecha']) and isset($_POST['peso']) and isset($_POST['vacunas']) and isset($_POST['vacunasObs']) and isset($_POST['maduracion']) and isset($_POST['maduracionObs']) and isset($_POST['fisico']) and isset($_POST['fisicoObs']) ) {
	
	$fecha = $_POST['fecha'];
	$peso = $_POST['peso'];
	$vacunas = $_POST['vacunas'];
	$vacunasObs = $_POST['vacunasObs'];
	$maduracion = $_POST['maduracion'];
	$maduracionObs = $_POST['maduracionObs'];
	$fisico = $_POST['fisico'];
	$fisicoObs = $_POST['fisicoObs'];
	$pc = $_POST['pc'];
	$ppc = $_POST['ppc'];
    $talla = $_POST['talla'];
    $alimentacion = $_POST['alimentacion'];
    $observaciones = $_POST['observaciones'];
    $id = $_POST['id'];
    $paciente = $_POST['paciente_id'];

	if ( preg_match($letras, $vacunasObs) and preg_match($letras, $maduracionObs) and preg_match($letras,$fisicoObs) ) {
		
		PDORepository::editarHistoriaClinica($fecha, $peso, $vacunas, $vacunasObs, $maduracion, $maduracionObs, $fisico, $fisicoObs, $pc, $ppc, $talla, $alimentacion, $observaciones, $id);

		//header("Location: ../index.php?action=verHistoriaClinica&id=$paciente");
		header("Location: ../index.php?action=areaPaciente");
	}
}elseif ( !isset($_POST['vacunas']) or !isset($_POST['maduracion']) or !isset($_POST['fisico']) ) {

	header('Location: ../index.php?action=cargarHistoriaClinica');
}