<?php



class Home extends TwigView{

	public function show($estados,$mensaje= NULL) {
		echo self::getTwig()->render('home.html.twig', array('estados' => $estados,'mensaje' => $mensaje ));

	}


}
class Login extends TwigView{
	public function show($error,$estados){
		echo self::getTwig()->render('loginTwig.html',array ('error'=> $error , 'estados' => $estados));
	}
}

class AltaUsuario extends TwigView{
	public function show($estados,$roles,$error){
		echo self::getTwig()->render('altaUsuarioTwig.html', array('estados' => $estados ,'roles' => $roles , 'error' =>$error));
	}
}
class AltaPaciente extends TwigView{
	public function show($estados,$error,$documentos,$obras){
		echo self::getTwig()->render('altaPacienteTwig.html', array('estados' => $estados , 'error' =>$error,'documentos'=> $documentos,'obras'=>$obras));
	}
}
class AreaAdmin extends TwigView{
	public function show($estados,$usuarios,$error,$inicio,$fin,$cantPag,$cantItempag){

		echo self::getTwig()->render('areaAdminTwig.html', array('estados' => $estados ,'usuarios' => $usuarios , 'error' =>$error,
			'inicio' =>$inicio,
			'fin'=> $fin,
			'cantPag'=>$cantPag,
			'cantItempag'=>$cantItempag));
	}
}
class AreaPacientes extends TwigView{
	public function show($estados,$pacientes,$error){

		echo self::getTwig()->render('areaPacienteTwig.html', array('estados' => $estados ,'pacientes' => $pacientes , 'error' =>$error));
	}
}
class ModificarUsuario extends TwigView {
    public function show($estados, $roles, $usuario, $rol, $error) {

        echo self::getTwig()->render('modificarUsuarioTwig.html', array ('estados' => $estados, 'roles' => $roles, 'usuario' => $usuario, 'error' => $error, 'rol'=>$rol));

    }

}
class ModificarPaciente extends TwigView {
    public function show($estados, $paciente, $error,$obraSocial,$tipoDoc) {

        echo self::getTwig()->render('modificarPacienteTwig.html', array ('estados' => $estados, 'paciente' => $paciente, 'error' => $error,"obraSocial"=>$obraSocial,"tipoDoc" =>$tipoDoc));

    }

}
class Configuracion extends TwigView {
    public function show($estados,$error) {

        echo self::getTwig()->render('ConfiguracionTwig.html', array ('estados' => $estados,'error' => $error));

    }

}

class DatosDemograficos extends TwigView{
	public function show($estados, $error, $id,$agua,$calefacion,$vivienda){
		echo self::getTwig()->render('datosDemograficosTwig.html',array('estados'=> $estados, 'error'=> $error, 'id'=> $id , 'agua'=>$agua,'calefacion'=>$calefacion,'vivienda'=>$vivienda));
	}
}

class ListaDatosDemograficos extends TwigView{
	public function show($estados, $error, $datos){
		echo self::getTwig()->render('listaDatosDemograficosTwig.html', array('estados'=>$estados, 'error'=> $error, 'datos' => $datos));
	}
}

class ModificarDatos extends TwigView{
	public function show($estados, $datos,$agua,$calefacion,$vivienda,$id){
		echo self::getTwig()->render('modificarDatosDemograficosTwig.html', array('estados'=>$estados, 'datos'=>$datos,'agua'=>$agua,'calefacion'=>$calefacion,'vivienda'=>$vivienda,'id'=>$id));
	}
}

class CargarHistoriaClinica extends TwigView{
	public function show($estados,$id,$error){
		echo self::getTwig()->render('historiaClinicaTwig.html', array('estados' => $estados, 'id' => $id, 'error' => $error));
	}
}
class VerHistoriaClinica extends TwigView{
	public function show($estados,$paciente,$historia){
		echo self::getTwig()->render('verHistoriaClinicaTwig.html', array('estados' => $estados, 'paciente' => $paciente, 'historia'=>$historia));
	}
}
class ModificarControlSalud extends TwigView{
	public function show($estados,$control){
		echo self::getTwig()->render('modificarControlSaludTwig.html', array('estados' => $estados, 'control'=>$control));
	}
}
class MostrarCurvaDeCrecimiento extends TwigView{
	public function show($estados,$id,$pesos){
		echo self::getTwig()->render('curvaCrecimientoTwig.html', array('estados' => $estados,'id'=> $id, 'pesos'=> $pesos));
	}
	public function getHTML($estados,$id,$pesos){
		return self::getTwig()->render('curvaCrecimientoTwig.html', array('estados' => $estados,'id'=> $id, 'pesos'=> $pesos));
	}
}
class MostrarCurvaDeTalla extends TwigView{
	public function show($estados,$id,$talla){
		echo self::getTwig()->render('curvaTallaTwig.html', array('estados' => $estados,'id'=> $id,'talla'=>$talla));
	}
}
class MostrarCurvaDePPC extends TwigView{
	public function show($estados,$id,$ppc){
		echo self::getTwig()->render('curvaPPCTwig.html', array('estados' => $estados,'id'=> $id,'ppc'=>$ppc));
	}

}
class MostrarCurvaDeDatosDemograficos extends TwigView{
	public function show($estados,$datos){
		echo self::getTwig()->render('curvaDeDatosDemograficosTwig.html', array('estados' => $estados, 'datos'=>$datos));
	}
}

?>
