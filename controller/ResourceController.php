<?php
require_once('controller/Api.php');
require ('vendor/autoload.php');
require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;
class ResourceController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {

    }


    public function listResources(){
        $resources = ResourceRepository::getInstance()->listAll();
        $view = new SimpleResourceList();
        $view->show($resources);
    }

    public function home($estados, $mensaje= NULL){
        $view = new Home();
        $view->show($estados,$mensaje);
    }

    public function login($error,$estados){
        $view = new Login();
        $view->show($error,$estados);
    }
    public function altaUsuario($estados,$error){
        $view = new AltaUsuario();
        $roles=ResourceRepository::listRoles();
        $view->show($estados,$roles,$error);
    }
    public function altaPaciente($estados,$error){
        $view = new AltaPaciente();
        $documentos= getElementosApi("tipo-documento");
        $obras= getElementosApi("obra-social");
        $view->show($estados,$error,$documentos,$obras);
    }
    public function areaAdmin($estados, $error,$inicio=1, $nombre=NULL, $filtro=NULL){

        $view = new AreaAdmin();
        if ( (empty($nombre)) and (is_null($filtro)) ) {
            $usuarios=ResourceRepository::getInstance()->listarUsuarios();
        }else {
            $usuarios= ResourceRepository::getInstance()->buscarUsuarioPorNombre($nombre, $filtro);
        }
        $usuarios= ResourceRepository::obtenerRoles($usuarios);
        $cantItempag= ResourceRepository::cantidadDepaginas();
        $cantUser=0;
        foreach ($usuarios as $value){
            $cantUser=$cantUser+1;
        }
        $cantPag=$cantUser/$cantItempag[0]['pagina_cant'];
        if ($cantPag==1) {
            $fin=$cantUser;
        }
        else{
            $fin=$cantItempag[0]['pagina_cant'];
        }
        $cantPag=ceil($cantPag);



        $view->show($estados,$usuarios,$error,$inicio,$fin,$cantPag,$cantItempag[0]['pagina_cant']);

    }
    public function modificarUsuario($estados, $id, $error){
        $view = new ModificarUsuario();
        $controlador = ResourceRepository::getInstance();
        $roles = $controlador->listRoles();
        $usuario= $controlador->buscarUsuario($id);

        $id_rol= $controlador ->buscarRol($usuario[0]['id']);
        $rol= $controlador-> buscarRol_nombre($id_rol);


        $view->show($estados, $roles, $usuario, $rol, $error);
    }
    public function areaPacientes($estados,$error, $nombre=NULL){
        $view = new AreaPacientes();
        if (empty($nombre)) {
            $pacientes = ResourceRepository::getInstance()->listarPacientes();
        }else{
            $pacientes = ResourceRepository::getInstance()->buscarPacientePorNombre($nombre);
        }
        $pacientes=$this->obtenerObras($pacientes);
        $pacientes=$this->obtenerDni($pacientes);
        $view->show($estados,$pacientes,$error);
    }
    private function obtenerObras(&$pacientes){
              foreach ($pacientes as $key => $value) {
                $pacientes[$key]['obraSocial']= getElementoApi('obra-social',$value['obraSocial']);
                if ($pacientes[$key]['genero']==1) {
                    $pacientes[$key]['genero']="Masculino";
                }else{$pacientes[$key]['genero']="Femenino";}
        }
        return $pacientes;
    }
    private function obtenerDni(&$pacientes){

        foreach ($pacientes as $key => $value) {
            $pacientes[$key ]['tipoDoc']=getElementoApi('tipo-documento',$value['tipoDoc']);

        }
        return $pacientes;
    }
    public function modificarPaciente($estados, $id, $error){
        $view = new ModificarPaciente();
        $controlador = ResourceRepository::getInstance();
        $paciente= $controlador->buscarPaciente($id);
        $obraSocial=getElementosApi("obra-social");
        $tipoDoc=getElementosApi("tipo-documento");
        $view->show($estados,$paciente,$error,$obraSocial,$tipoDoc);
    }
    public function Configuracion($estados,$error){
        $view = new Configuracion();
        $view->show($estados,$error);
    }

    public function cargarDatosDemograficos($estados,$error,$id){
        $view = new DatosDemograficos();
         $agua=getElementosApi("tipo-agua");
        $calefacion=getElementosApi("tipo-calefaccion");
        $vivienda=getElementosApi("tipo-vivienda");
        $view->show($estados,$error,$id,$agua,$calefacion,$vivienda);
    }

    public function datosDemograficos($estados,$error){
        $view = new ListaDatosDemograficos();
        $datos = ResourceRepository::getInstance()->datosDemograficos();

         $datos=$this->obtenerVivienda($datos);
         $datos=$this->obtenerCalefacion($datos);
         $datos=$this->obtenerTipoDeAgua($datos);
        $view->show($estados,$error,$datos);
    }
    private function obtenerVivienda(&$datos){
              foreach ($datos as $key => $value) {
                $datos[$key]['tipo_de_vivienda']= getElementoApi('tipo-vivienda',$value['tipo_de_vivienda']);
        }
        return $datos;
    }
    private function obtenerCalefacion(&$datos){

        foreach ($datos as $key => $value) {
            $datos[$key]['tipo_de_calefaccion']=getElementoApi('tipo-calefaccion',$value['tipo_de_calefaccion']);

        }
        return $datos;
    }
     private function obtenerTipoDeAgua(&$datos){

        foreach ($datos as $key => $value) {
            $datos[$key]['tipo_de_agua']=getElementoApi('tipo-agua',$value['tipo_de_agua']);

        }
        return $datos;
    }

    public function modificarDatosDemograficos($estados, $id){
        $view = new ModificarDatos();
        $datos = ResourceRepository::getInstance()->datosDemograficosId($id);
        $agua=getElementosApi("tipo-agua");
        $calefacion=getElementosApi("tipo-calefaccion");
        $vivienda=getElementosApi("tipo-vivienda");
        $view->show($estados, $datos,$agua,$calefacion,$vivienda,$id);
    }

    public function cargarHistoriaClinica($estados, $id, $error){
        $view = new CargarHistoriaClinica();
        $view->show($estados,$id,$error);
    }
    public function verHistoriaClinica($estados, $id){
        $view = new VerHistoriaClinica();
        $paciente = ResourceRepository::getInstance()->buscarPaciente($id);
        $historia = ResourceRepository::getInstance()->historiaClinica($id);
        $view->show($estados,$paciente,$historia);
    }
    public function modificarControlSalud($estados, $idControl){
        $view= new ModificarControlSalud();
        $control= ResourceRepository::getInstance()->controlSalud($idControl);
        $view->show($estados, $control);
    }
     public function fechaEnSemanas($arreglo){
      foreach ($arreglo as $key => $value) {
    
        if (isset($arreglo[$key]['fecha']))  
            $arreglo[$key]['fecha']=(strtotime($arreglo[$key]['fecha'])- strtotime($arreglo['paciente']['fechaDeNacimiento']))/(604800);
      }
      return $arreglo;

    }
    public function dataPaciente($pesos){
        $dataPaciente=array();
        foreach ($pesos as $key => $value) {
            if (isset($pesos[$key]['fecha']))  
            array_push($dataPaciente, array($pesos[$key]['fecha'],(float)$pesos[$key]['peso']));
        }
        $pesos['dataPaciente']=json_encode($dataPaciente);

        return $pesos;
    }
    public function mostrarCurvaDeCrecimiento($estados,$id){
      $pesos= ResourceRepository::getInstance()->pesosPaciente($id);
      $pesos=$this->fechaEnSemanas($pesos);
      $pesos=$this->dataPaciente($pesos);
      $view = new MostrarCurvaDeCrecimiento();
      $view->show($estados,$id,$pesos);
    }
    /* public function fechaEnMeses($arreglo){
      foreach ($arreglo as $key => $value) {
    
        if (isset($arreglo[$key]['fecha']))  
            $arreglo[$key]['fecha']=(strtotime($arreglo[$key]['fecha'])- strtotime($arreglo['paciente']['fechaDeNacimiento']))/(2592000);
      }
      return $arreglo;

    }*/
    public function dataPacienteT($tallas){
        $dataPaciente=array();
        foreach ($tallas as $key => $value) {
            if (isset($tallas[$key]['talla']))  
            array_push($dataPaciente, array((float)$tallas[$key]['talla'],(float)$tallas[$key]['peso']));
        }
        $tallas['dataPaciente']=json_encode($dataPaciente);
        
        return $tallas;
    }
    public function mostrarCurvaDeTalla($estados,$id){
      $tallas= ResourceRepository::getInstance()->tallasPaciente($id);
      //$tallas= $this->fechaEnMeses($tallas);
      $tallas= $this->dataPacienteT($tallas);
      $view = new MostrarCurvaDeTalla();
      $view->show($estados,$id,$tallas);
    }
    public function dataPacientePPC($ppc){
        $dataPaciente=array();
        foreach ($ppc as $key => $value) {
            if (isset($ppc[$key]['fecha']))  
            array_push($dataPaciente, array((float)$ppc[$key]['fecha'],(float)$ppc[$key]['ppc']));
        }
        $ppc['dataPaciente']=json_encode($dataPaciente);
        return $ppc;
    }
    public function mostrarCurvaDePPC($estados,$id){
      $ppc= ResourceRepository::getInstance()->ppcPaciente($id);
      $ppc= $this->fechaEnSemanas($ppc);
      $ppc= $this->dataPacientePPC($ppc);
      $view = new MostrarCurvaDePPC();
      $view->show($estados,$id,$ppc);
    }

    public function tiposDeAgua($datos){
         $aguaCorriente = 0;
         $aguaPozo= 0;
         foreach ($datos as $key => $value) {
             if ( $datos[$key]['tipo_de_agua']==1 )
                $aguaCorriente ++;
            else
                $aguaPozo++;
         }
         return array( 'aguaPozo'=> $aguaPozo, 'aguaCorriente'=>$aguaCorriente);
    }
    public function mostrarCurvaDeDatosDemograficos($estados){
      $datos= ResourceRepository::getInstance()->datosDemograficosAgua();
      $datos= $this->tiposDeAgua($datos);
      $view = new MostrarCurvaDeDatosDemograficos();
      $view->show($estados,$datos);
    }


}
?>
