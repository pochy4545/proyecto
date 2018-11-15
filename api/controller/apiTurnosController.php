<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;
require_once './model/apiTurnos.php';

use \Slim\Exception\NotFoundException as NotFoundException ;

class ApiTurnosController{
	
	function __construct(){}

	public static function getTurnosDisponibles($request, $response, $args){
		$fecha = $args['fecha'];
		$turnos = Turnos::getTurnosDisponibles($fecha);
		$turnosDisponibles=array('Turnos disponibles' => $turnos);
		return $response->withJson($turnosDisponibles,200);
	}

	public static function setTurno($request, $response, $args){
		$dni = $args['dni'];
		$fecha= $args['fecha'];
		$hora= $args['hora'];
		$resul= Turnos::setTurno($dni, $fecha, $hora);
		return $response->withJson($resul,200);
	}
}


?>