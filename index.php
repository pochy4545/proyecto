<?php
session_start();


require_once('controller/Api.php');
require_once('model/PDORepository.php');
require_once('model/ResourceRepository.php');

require_once('controller/ResourceController.php');
require_once('view/TwigView.php');
require_once('view/clases.php');
include_once('controller/Verificacion.php');

if (isset ($_SESSION['log'])){
$estados = array('log' => 'true', 'permiso'=> true, 'rolAdm' => PDORepository::rolAdmin($_SESSION['rol']), 'rolRecep' => PDORepository::rolRecep($_SESSION['rol']), 'rolPdia' => PDORepository::rolPdia($_SESSION['rol']), 'error' => "false" ,'sitio'=> PDORepository::sitio());
}
else{
	$estados = array('log' => 'false','permiso'=> false,'error' => "false" ,'sitio'=> PDORepository::sitio(),'rolAdm' => false, 'rolRecep' => false, 'rolPdia' => false);
}
if (!isset($_POST['filtro'])) {
	$_POST['filtro']=NULL;
}
if (!isset($_GET['error'])) {
	$_GET['error']="none";
}
if (!isset($_GET['id'])) {
	$_GET['id']="none";
}
if ($estados['sitio'][0]['activo'] == '1'){
$mensaje=array();
if(isset($_GET["action"])){
	switch ($_GET["action"]){
			case 'areaAdmin':
				if (isset($_GET['inicio'])) {
					$inicio=$_GET['inicio'];
				}else{
				 $inicio=0;				}
				$mensaje =array('mensaje' => "Acceso no autorizado, debe ser administrador");
				accesoAutorizadoAdminIndex($estados)? ResourceController::getInstance()->areaAdmin($estados,$_GET['error'],$inicio) : ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'buscarUsuario':
				if (isset($_GET['inicio'])) {
					$inicio=$_GET['inicio'];
				}else{$inicio=0;}
				$mensaje =array('mensaje' => "Acceso no autorizado, debe ser administrador");

				accesoAutorizadoAdminIndex($estados)? ResourceController::getInstance()->areaAdmin($estados,$_GET['error'],$inicio,$_POST['nombre'], $_POST['filtro']) : ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'areaPaciente':
				$mensaje =array('mensaje' => "Acceso no autorizado, debe ser pediatra o recepcionista");
				(accesoAutorizadoPediatraIndex($estados) | accesoAutorizadoRecepcionistaIndex($estados)) ?ResourceController::getInstance()->areaPacientes($estados,$_GET['error']) : ResourceController::getInstance()->home($estados, $mensaje);
				break;
			case 'buscarPaciente':
				$mensaje =array('mensaje' => "Acceso no autorizado, debe ser pediatra o recepcionista");
				(accesoAutorizadoPediatraIndex($estados) | accesoAutorizadoRecepcionistaIndex($estados)) ?ResourceController::getInstance()->areaPacientes($estados,$_GET['error'], $_POST['nombre']) : ResourceController::getInstance()->home($estados, $mensaje);
				break;
			case 'login':
				ResourceController::getInstance()->login($_GET['error'],$estados);
				break;
			case 'altaUsuario':
				$mensaje =array('mensaje' => "Acceso no autorizado, debe ser administrador");
				accesoAutorizadoAdminNew($estados)?
				ResourceController::getInstance()->altaUsuario($estados,$_GET['error']) : ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'altaPaciente':
				$mensaje =array('mensaje' => "Acceso no autorizado, debe ser pediatra o recepcionista");
				(accesoAutorizadoPediatraNew($estados) | accesoAutorizadoRecepcionistaNew($estados)) ?
				ResourceController::getInstance()->altaPaciente($estados,$_GET['error']): ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'modificarUsuario':
				$mensaje =array('mensaje' => "Acceso no autorizado, debe ser administrador");
				accesoAutorizadoAdminUpdate($estados)? ResourceController::getInstance()->modificarUsuario($estados,$_GET['id'], $_GET['error']): ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'modificarPaciente':
				ResourceController::getInstance()->modificarPaciente($estados,$_GET['id'], $_GET['error']);
				break;
			case 'Configuracion':
				$mensaje =array('mensaje' => "Acceso no autorizado, debe ser administrador");
				accesoAutorizadoAdminConfi($estados)?
				ResourceController::getInstance()->Configuracion($estados, $_GET['error']): ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'cargarDatosDemograficos':
			    $mensaje =array('mensaje' => "Acceso no autorizado, debe ser pediatra o recepcionista");
				(accesoAutorizadoPediatraNew($estados) | accesoAutorizadoRecepcionistaNew($estados)) ?
				ResourceController::getInstance()->cargarDatosDemograficos($estados,$_GET['error'],$_GET['idPaciente']): ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'datosDemograficos':
			    $mensaje =array('mensaje' => "Acceso no autorizado, debe ser pediatra o recepcionista");
				(accesoAutorizadoPediatraNew($estados) | accesoAutorizadoRecepcionistaNew($estados)) ?
				ResourceController::getInstance()->datosDemograficos($estados,$_GET['error']): ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'modificarDatosDemograficos':
			    $mensaje =array('mensaje' => "Acceso no autorizado, debe ser pediatra o recepcionista");
				(accesoAutorizadoPediatraNew($estados) | accesoAutorizadoRecepcionistaNew($estados)) ?
				ResourceController::getInstance()->modificarDatosDemograficos($estados,$_GET['id']): ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'cargarHistoriaClinica':
				$mensaje =array('mensaje' => "Acceso no autorizado, debe ser pediatra");
				accesoAutorizadoPediatraNew($estados) ? ResourceController::getInstance()->cargarHistoriaClinica($estados, $_GET['id'], $_GET['error']) : ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'verHistoriaClinica':
				$mensaje =array('mensaje' => "Acceso no autorizado, debe ser pediatra");
				accesoAutorizadoPediatraNew($estados) ? ResourceController::getInstance()->verHistoriaClinica($estados, $_GET['id']) : ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'modificarControlSalud':
				$mensaje= array('mensaje'=>"Acceso no autorizado, debe ser pediatra");
				accesoAutorizadoPediatraNew($estados) ? ResourceController::getInstance()->modificarControlSalud($estados, $_GET['id']) : ResourceController::getInstance()->home($estados,$mensaje);
				break;
			case 'curvaDeCrecimiento':
				ResourceController::getInstance()->mostrarCurvaDeCrecimiento($estados,$_GET["id"]);
				break;
			case 'curvaDeTalla':
				ResourceController::getInstance()->mostrarCurvaDeTalla($estados,$_GET["id"]);
				break;
			case 'curvaDePPC':
	 			 ResourceController::getInstance()->mostrarCurvaDePPC($estados,$_GET["id"]);
	 			 break;
	 	    case 'curvaDeDatosDemograficos':
	 	         ResourceController::getInstance()->mostrarCurvaDeDatosDemograficos($estados);
	 	         break;
	 	    case 'descargarPDF':
	 	    	ResourceController::getInstance()->descargarPDF($estados,$_POST["id"], $_POST['curva']);
	 	    	break;

		}


}

else {
    ResourceController::getInstance()->home($estados);
}
}else{
   ?>
   <div class="text-center">
   <h1>El sitio se encuentra mantenimiento
   <i class="fa fa-wrench" aria-hidden="true"></i>
   </h1>
   </div>
   <?php
}
?>
