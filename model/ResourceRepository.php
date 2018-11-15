<?php
class ResourceRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

      protected function queryList2($sql){
        $connection = self::getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $array= $stmt->fetchAll();
        return $array;
    }

    private function __construct() {

    }

      public function listarUsuarios(){
        $sql = "SELECT id, first_name, last_name, email,activo,username FROM usuario";
        $result= self::queryList2($sql);
        return $result;
    }
    public function cantidadDepaginas(){
        $sql = "SELECT pagina_cant FROM sitio";
        $result= self::queryList2($sql);
        return $result;
    }
     public function listarPacientes(){
        $sql = "SELECT * FROM paciente";
        $result= self::queryList2($sql);
        return $result;
    }
     public function listarRoles(){
        $sql = "SELECT nombre FROM rol";
        $result= self::queryList2($sql);
        $list= [];
        for ($i=0; $i< count($result); $i++){
            $list[$i]= $result[$i]['nombre'];
        }
        return $list;
    }

    public function listRoles(){
        $sql = "SELECT * FROM rol";
        $result= self::queryList2($sql);
        return $result;
     }


    public function buscarUsuario($id){
        $link= self::getConnection();
        $sql = "SELECT * FROM usuario WHERE id=? ";
        $result= $link->prepare($sql);
        $result->execute(array("$id"));
        $arreglo=$result->fetchAll();
        return $arreglo;
     }

    public function buscarUsuarioPorNombre($nombreUsuario, $estadoUsuario){

        $link= self::getConnection();
        if ((!empty($nombreUsuario))and(!is_null($estadoUsuario))) {
          $sql = "SELECT * FROM usuario WHERE username like ? and activo=? ";
          $result= $link->prepare($sql);
          $result->execute(array("%$nombreUsuario%","$estadoUsuario"));
        }elseif (!empty($nombreUsuario)) {
          $sql = "SELECT * FROM usuario WHERE username like ?";
          $result= $link->prepare($sql);
          $result->execute(array("%$nombreUsuario%"));
        }else{
          $sql = "SELECT * FROM usuario WHERE activo=? ";
          $result= $link->prepare($sql);
          $result->execute(array("$estadoUsuario"));
        }
        $arreglo=$result->fetchAll();
        return $arreglo;
    }

     public function buscarRol ($id_user){
        $link= self::getConnection();
        $sql= "SELECT rol_id FROM usuario_tiene_rol WHERE usuario_id=?";
        $result= $link->prepare($sql);
        $result->execute(array("$id_user"));
        $arreglo= $result->fetchAll();
        return $arreglo[0]['rol_id'];
     }

     public function buscarRol_nombre ($idrol){
        $link= self::getConnection();
        $sql = "SELECT nombre FROM rol WHERE id =?";
        $result= $link->prepare($sql);
        $result->execute(array("$idrol"));
        $arreglo=$result->fetchAll();
        return $arreglo[0]['nombre'];
    }

    public function buscarPaciente($id){
        $link= self::getConnection();
        $sql = "SELECT * FROM paciente WHERE id=?";
        $result= $link->prepare($sql);
        $result->execute(array("$id"));
        $arreglo=$result->fetchAll();
        return $arreglo;
    }

     public function obtenerRoles($usuarios){
             for ($i=0; $i < count($usuarios);$i++) {
             		$usuarios[$i]['rol']=self::getRol($usuarios[$i]['id']);
             		$usuarios[$i]['rol_nombre']=self::rolsNombre($usuarios[$i]['rol']);
             	}
             return $usuarios;
     }

     public function rolsNombre($roles){
         $i=0;
     	 foreach ($roles as $rol) {
            $arreglo[$i]=self::getNameRol($rol['rol_id']);
            $i++;
       }
       return $arreglo;
    }

    public function buscarPacientePorNombre($nombrePaciente){
        $link= self::getConnection();
        $sql = "SELECT * FROM paciente WHERE nombre like ? or apellido like ? or numero = ? or tipoDoc = ?";
        $result= $link->prepare($sql);
        $result->execute(array("%$nombrePaciente%","%$nombrePaciente%","$nombrePaciente","$nombrePaciente"));
        $arreglo=$result->fetchAll();
        return $arreglo;
    }

    public function datosDemograficos(){
      $link = self::getConnection();
      $sql = "SELECT d.id, d.heladera, d.electricidad, d.mascota, d.tipo_de_vivienda, d.tipo_de_calefaccion, d.tipo_de_agua, p.nombre, p.apellido, p.numero FROM datos_demograficos d inner join paciente p on (d.id_paciente = p.id)";
      $result = $link->prepare($sql);
      $result->execute();
      $arreglo = $result->fetchAll();
      return $arreglo;
    }

    public function datosDemograficosId($id){
      $paciente= self::buscarPaciente($id);
      $link = self::getConnection();
      $sql = "SELECT * FROM datos_demograficos WHERE id=? ";
      $result = $link->prepare($sql);
      $result->execute(array("$id"));
      $arreglo = $result->fetchAll();
      return $arreglo;
    }

    public function pesosPaciente($id){
      $paciente=self::buscarPaciente($id);
      $link = self::getConnection();
      $fechaDeNacimiento=$paciente[0]['fechaDeNacimiento'];
      $nuevafecha = strtotime ( '+13 week' , strtotime ( $fechaDeNacimiento ) ) ;
      $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
      $sql = "SELECT peso,fecha FROM control_salud WHERE paciente_id=? AND fecha BETWEEN ? AND ? ORDER BY fecha";
      $result= $link->prepare($sql);
      $result->execute(array($id,$fechaDeNacimiento,$nuevafecha)); 
      $arreglo = $result->fetchAll();
    
      $arreglo['paciente']=$paciente[0];

      return $arreglo;

    }
  public function tallasPaciente($id){
      $paciente=self::buscarPaciente($id);
      $link = self::getConnection();
      $fechaDeNacimiento=$paciente[0]['fechaDeNacimiento'];
      $nuevafecha = strtotime ( '+24 month' , strtotime ( $fechaDeNacimiento ) ) ;
      $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
      $sql = "SELECT talla,peso FROM control_salud WHERE paciente_id=? AND fecha BETWEEN ? AND ? ORDER BY fecha";
      $result= $link->prepare($sql);
      $result->execute(array($id,$fechaDeNacimiento,$nuevafecha));
      $arreglo = $result->fetchAll();
      $arreglo['paciente']=$paciente[0];

      return $arreglo;
    }

    public function ppcPaciente($id){
      $paciente=self::buscarPaciente($id);
      $link = self::getConnection();
      $fechaDeNacimiento=$paciente[0]['fechaDeNacimiento'];
      $nuevafecha = strtotime ( '+13 week' , strtotime ( $fechaDeNacimiento ) ) ;
      $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
      $sql = "SELECT ppc,fecha FROM control_salud WHERE paciente_id=? AND fecha BETWEEN ? AND ? ORDER BY fecha";
      $result= $link->prepare($sql);
      $result->execute(array($id,$fechaDeNacimiento,$nuevafecha));
      $arreglo = $result->fetchAll();
      $arreglo['paciente']=$paciente[0];
      return $arreglo;
    }

    public function historiaClinica($id){
      $link= self::getConnection();
      $sql= "SELECT * FROM control_salud WHERE paciente_id=?";
      $result = $link->prepare($sql);
      $result->execute(array("$id"));
      $arreglo= $result->fetchAll();
      return $arreglo;
    }

    public function controlSalud($idControl){
      $link= self::getConnection();
      $sql= "SELECT * FROM control_salud WHERE id=?";
      $result= $link->prepare($sql);
      $result->execute(array("$idControl"));
      $arreglo= $result->fetchAll();
      return $arreglo;
    }

    public function datosDemograficosAgua(){
      $link= self::getConnection();
      $sql= "SELECT tipo_de_agua FROM datos_demograficos";
      $result= $link->prepare($sql);
      $result->execute();
      $arreglo= $result->fetchAll();
      return $arreglo;
    }
}
?>
