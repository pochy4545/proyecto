<?php  
require_once '../model/PDORepository.php';
require_once '../model/ResourceRepository.php';

class Turnos extends ResourceRepository   {
	
	function __construct(){}

	public static function getTurnos($fecha){
		$connection = self::getConnection();
		$sql="SELECT * FROM turno WHERE fechaTurno=?";
        $stmt = $connection->prepare($sql);
		$stmt->execute(array($fecha));
		$turnos=$stmt->fetch();
		$turnosReservados=array();
		while($turnos){
			$elem=$turnos['hora'] . ':' . $turnos['minutos'];
			array_push($turnosReservados,$elem);
			$turnos=$stmt->fetch();
		}
		return $turnosReservados;
	}

	public static function getTurnosDisponibles($fecha){
		$fechaexp = explode('-',$fecha);
		if ((DateTime::createFromFormat('Y-m-d', $fecha) != FALSE) && ($fecha>date('Y-m-d')) && ($fechaexp[1]<=12) && ($fechaexp[2]<=31)){
			$turnosReservados = self::getTurnos($fecha);
			$hora=8;
			$min=0;
			$turnosDisponibles=array();
			for($i=0; $i<=23; $i++){
				$elem = $hora . ':' . $min;
				if(!in_array($elem,$turnosReservados,true)){
					array_push($turnosDisponibles,$elem);
				}
				if($min!=30){
					$min+=30;
				}else{
					$hora+=1;
					$min=0;
				}
			}
		}
		else{
			$turnosDisponibles="No es una fecha valida";
		}
		return $turnosDisponibles;
		
	}


	public static function setTurno($dni, $fecha, $hora){
		$connection = self::getConnection();
		$fechaexp = explode('-',$fecha);
		if ((DateTime::createFromFormat('Y-m-d', $fecha) != FALSE) && $fecha>date('Y-m-d') && ($fecha>date('Y-m-d')) && ($fechaexp[1]<=12) && ($fechaexp[2]<=31)){
			$horaAux= explode(":", $hora);
			$minutos= (int)$horaAux[1];
			$hora= (int)$horaAux[0];
			$dni=(int)$dni;
			$horaTotal=$hora.":".$minutos;
			if (!in_array($horaTotal,self::getTurnos($fecha),true)) {
				if (( ($hora >= 8) && ($hora < 20)) && (($minutos==0) || ($minutos==30))) {
					$sql=("INSERT INTO turno (fechaTurno,hora,minutos,dniPaciente) VALUES (?,?,?,?)");
					$stmt = $connection->prepare($sql);
					if ($stmt->execute(array($fecha,$hora,$minutos,$dni)))
						return ("Tu turno ha sido reservado para el $fecha a las $hora:$minutos" );
					else return "Hubo un error, su turno no pudo ser reservado, intente nuevamente";
				}
				else return "La hora ingresada no es valida";	
			}
			return "El turno no esta disponible, por favor elija otro";
		}
		else{
			return "Fecha no valida";
		}
	}


}





?>
