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
    $paciente = $_POST['id_paciente'];
    $usuario = $_POST['id_usuario'];

	if ( preg_match($letras, $vacunasObs) and preg_match($letras, $maduracionObs) and preg_match($letras,$fisicoObs) ) {
		
		PDORepository::cargarHistoriaClinica($fecha, $peso, $vacunas, $vacunasObs, $maduracion, $maduracionObs, $fisico, $fisicoObs, $pc, $ppc, $talla, $alimentacion, $observaciones, $paciente, $usuario);

		header('Location: ../index.php?action=areaPaciente');
	}
}elseif ( !isset($_POST['vacunas']) or !isset($_POST['maduracion']) or !isset($_POST['fisico']) ) {

    $paciente = $_POST['id_paciente'];
	header("Location: ../index.php?action=cargarHistoriaClinica&id=$paciente&error=1");
}