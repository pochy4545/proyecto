<?php

abstract class PDORepository {

	const USERNAME = "grupo16";
	const PASSWORD = "NjA5OTgyNGQyNGI3";
	const HOST ="localhost";
	const DB = "grupo16";


	protected function getConnection(){
		$u=self::USERNAME;
		$p=self::PASSWORD;
		$db=self::DB;
		$host=self::HOST;
		$connection = new PDO("mysql:dbname=$db;host=$host", $u, $p);
		return $connection;
	}

  public function autenticar($usuario,$contraseña)
  {

      $link= self::getConnection();
      $sql = "select * from usuario where username = ? and password = ? ";
      $result= $link->prepare($sql);
      $result->execute(array("$usuario", "$contraseña"));
      $row=$result->rowCount();
      $arreglo=$result->fetchAll();

      if ($row>0){
          $rol = self::getRol($arreglo[0]['id']);

          return array(true,$rol);
      }
      else{
          return array(false,false);
      }

}

    public function getRol($idUser){
			      $link= self::getConnection();
            $sql = "select rol_id from usuario_tiene_rol where usuario_id = ?";
            $res = $link->prepare($sql);
            $res->execute(array("$idUser"));
            $row=$res->rowCount();
            $arreglo=$res->fetchAll();

            if ($row>0){
                return $arreglo;
            }
            else {
                return false;
            }

       }


    public function getNameRol($idrol){
           $link= self::getConnection();
            $sql = "select * from rol where id = ?";
            $res = $link->prepare($sql);
            $res->execute(array("$idrol"));
            $row=$res->rowCount();
            $arreglo=$res->fetchAll();
            if ($row>0){
               $rol = $arreglo[0]['nombre'];
                return $rol;
            }
            else {
                return false;
            }

       }

    public function habilitacion ($usuario, $contraseña){
        $link= self::getConnection();
        $sql = "select activo from usuario where username = ? and password = ?";
        $result= $link->prepare($sql);
        $result->execute(array("$usuario","$contraseña"));
        $array= $result->fetchAll();
        if ($array[0]['activo'] == 1){
          return true;
        }
       else{
         return false;
       }
  }
 public function existeUsuario ($nombreUsuario){
        $link= self::getConnection();
        $sql = "select id from usuario where ?";
        $result= $link->prepare($sql);
        $result->execute(array("$nombreUsuario"));
        $row=$result->rowCount();
       if ($row>0){
         $array= $result->fetchAll();
         return $array[0]['id'];
        }
       else{
         return 0;
       }
  }

   public function existePaciente ($dni){
        $link= self::getConnection();
        $sql = "select id from paciente where numero = ?";
        $result= $link->prepare($sql);
        $result->execute(array("$dni"));
        $row=$result->rowCount();
       if ($row>0){
         $array= $result->fetchAll();
         return $array[0]['id'];
        }
       else{
         return 0;
       }
  }

    public function cargarRol($idRol, $idUser){

      $link= self::getConnection();
      $sql = "INSERT into usuario_tiene_rol (usuario_id, rol_id)  VALUES (?, ?)";
      $result = $link->prepare($sql);
      $result->execute(array("$idUser","$idRol"));
    }

    public function idUsuario($nombreUsuario){

      $link= self::getConnection();
      $sql = "SELECT id from usuario where username = ? ";
      $result = $link->prepare($sql);
      $result->execute(array("$nombreUsuario"));
      $array= $result->fetchAll();
      return $array[0]['id'];

    }

    public function cargarUsuario($nombre, $apellido,  $email, $nombreUsuario, $contraseña, $habilitado){

        $link= self::getConnection();
        $sql = "INSERT INTO usuario (first_name, last_name, email, username, password,activo)
            VALUES (?, ?, ?, ?, ?, ?)";
        $result = $link->prepare($sql);
        $result->execute(array("$nombre", "$apellido", "$email", "$nombreUsuario", "$contraseña", "$habilitado"));

  }

    public function updateUsuario ($id, $nombre, $apellido, $email, $nombreUsuario, $rol,$habilitado){
      $link= self::getConnection();
      $sql = "UPDATE usuario SET first_name=?, last_name=? ,email=?, username=? ,activo=? WHERE id=? ";
      $result = $link->prepare($sql);
      $result->execute(array("$nombre", "$apellido", "$email", "$nombreUsuario", "$habilitado", "$id"));
}

  public function updatePaciente($nombre, $apellido, $fechadeNacimiento, $tipoDoc, $numero, $telefono, $obraSocial, $genero, $domicilio, $id){

    $link = self::getConnection();
    $sql = "UPDATE paciente SET nombre=?, apellido=?, fechaDeNacimiento=?, tipoDoc=?, numero=?, telefono=?, obraSocial=?, genero=?, domicilio=? WHERE id=? ";
    $result = $link->prepare($sql);
    $result->execute(array("$nombre", "$apellido", "$fechadeNacimiento", "$tipoDoc", "$numero", "$telefono", "$obraSocial", "$genero", "$domicilio", "$id"));
  }


  public function eliminarUsuario ($id){
        $link= self::getConnection();
        $sql1 ="DELETE  FROM usuario_tiene_rol where usuario_id=? ";
        $sql2 = "DELETE FROM usuario WHERE id=? ";
        $result = $link->prepare($sql1);
        $result->execute(array("$id"));
        $result = $link->prepare($sql2);
        $result->execute(array("$id"));


    }

		public function eliminarPaciente ($id){
					$link= self::getConnection();
					$sql1 ="DELETE FROM datos_demograficos where id_paciente = ? ";
					$sql2 = "DELETE FROM paciente WHERE id=? ";
					$result = $link->prepare($sql1);
					$result->execute(array("$id"));
					$result = $link->prepare($sql2);
					$result->execute(array("$id"));

			}

		private function obtenerIdPaciente($dni){
			$link= self::getConnection();
			$sql= "SELECT id from paciente where numero=?";
			$result=$link->prepare($sql);
			$result->execute(array("$dni"));
			$arreglo=$result->fetchAll();
      return $arreglo[0]['id'] ;

		}
    public function cargarPaciente($nombre, $apellido, $fechadeNacimiento, $tipoDoc, $dni, $telefono, $obraSocial, $genero, $domicilio){

        $link= self::getConnection();
        $sql = "INSERT INTO paciente (nombre, apellido, fechaDeNacimiento, tipoDoc, numero, telefono, obraSocial, genero, domicilio)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $result = $link->prepare($sql);
        $result->execute(array("$nombre", "$apellido", "$fechadeNacimiento","$tipoDoc","$dni","$telefono", "$obraSocial", "$genero", "$domicilio"));
				return self::obtenerIdPaciente($dni);
  }

	public function cargarDatosDemograficos($heladera,$electricidad,$mascotas,$vivienda,$calefaccion,$agua,$id_paciente){
				$link= self::getConnection();
				$sql = "INSERT INTO datos_demograficos (heladera, electricidad, mascota, tipo_de_vivienda, tipo_de_calefaccion, tipo_de_agua, id_paciente)
				               VALUES (?, ?, ?, ?, ?, ?, ?)";
				$result = $link->prepare($sql);
        $result->execute(array("$heladera","$electricidad","$mascotas","$vivienda","$calefaccion","$agua","$id_paciente"));
	}

   public function rolAdmin($roles){

       foreach ($roles as $rol) {
            if (self::getNameRol($rol['rol_id']) == "administrador") {
              return true;
            }
       }
       return false;
   }
   public function rolRecep($roles){

       foreach ($roles as $rol) {
            if (self::getNameRol($rol['rol_id']) == "recepcionista") {
              return true;
            }
       }
       return false;
   }
   public function rolPdia($roles){

       foreach ($roles as $rol) {
            if (self::getNameRol($rol['rol_id']) == "pediatra") {
              return true;
            }
       }
       return false;
     }

    public function sitio(){

            $link= self::getConnection();
            $sq="SELECT * FROM sitio";
            $res = $link->prepare($sq);
            $res->execute();
            $arreglo=$res->fetchAll();
            return $arreglo;
       }

    public function tienePermiso($rol,$permiso){
        $link=self::getConnection();
        $sq="SELECT P.nombre FROM rol R INNER JOIN rol_tiene_permiso RP on(R.id=RP.rol_id)INNER JOIN permiso P ON(RP.permiso_id=P.id) WHERE R.id=? and P.nombre=?";
        $res= $link -> prepare($sq);
        $res->execute(array("$rol","$permiso"));
        $ress= $res->fetchAll();
        return $ress[0]["nombre"]=="$permiso"; //?  true : false;

    }


    public function obtenerIdrol($rol){
      $link=self::getConnection();
        $sq="SELECT id FROM rol where nombre=?";
        $res= $link->prepare($sq);
        $res->execute(array("$rol"));
        $ress= $res->fetchAll();
        return $ress[0]["id"];
    }



    public function incluyeRol($rol,$id){
      $link=self::getConnection();
      $sq="SELECT * From usuario_tiene_rol WHERE usuario_id=? and rol_id=?";
      $res= $link->prepare($sq);
      $res->execute(array("$id","$rol"));
      $row=$res->rowCount();
      if ($row>0){
         return true;
        }
       else{
         return false;
       }
    }
    public function refreshRols($id){
       $link=self::getConnection();
      $sq="DELETE From usuario_tiene_rol WHERE usuario_id=?";
      $res= $link->prepare($sq);
      $res->execute(array("$id"));
    }

    public function updateConfiguracion($titulo, $descripcion, $cant_paginas, $email, $habilitado, $id){

    $link = self::getConnection();
    $sql = "UPDATE sitio SET titulo=?, descripcion=?, pagina_cant=?, email=?, activo=? WHERE  id=?";
    $result = $link->prepare($sql);
    $result->execute(array("$titulo", "$descripcion", "$cant_paginas", "$email", "$habilitado", "$id"));

  }

  public function modificarDatosDemograficos($heladera, $electricidad, $mascota, $tipo_de_vivienda, $tipo_de_calefaccion, $tipo_de_agua, $id){
      $link = self::getConnection();
      $sql = "UPDATE datos_demograficos SET heladera=?, electricidad=?, mascota=?, tipo_de_vivienda=?, tipo_de_calefaccion=?, tipo_de_agua=? WHERE id=?";
      $result = $link->prepare($sql);
      $result->execute(array("$heladera", "$electricidad", "$mascota", "$tipo_de_vivienda", "$tipo_de_calefaccion", "$tipo_de_agua", "$id"));

  }

  public function cargarHistoriaClinica($fecha, $peso, $vacunas, $vacunasObs, $maduracion, $maduracionObs, $fisico, $fisicoObs, $pc, $ppc, $talla, $alimentacion, $observaciones_generales, $paciente, $usuario){

    $link = self::getConnection();
    $sql = "INSERT INTO control_salud (fecha, peso, vacunas_completas, vacunas_obs, maduracion_acorde, maduracion_obs, ex_fisico_normal, ex_fisico_observaciones, pc, ppc, talla, alimentacion, observaciones_generales, paciente_id, usuario_id) 
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $result = $link->prepare($sql);
    $result->execute(array("$fecha", "$peso", "$vacunas", "$vacunasObs", "$maduracion", "$maduracionObs", "$fisico", "$fisicoObs", "$pc", "$ppc", "$talla", "$alimentacion", "$observaciones_generales", "$paciente", "$usuario"));
  }

    public function editarHistoriaClinica($fecha, $peso, $vacunas, $vacunasObs, $maduracion, $maduracionObs, $fisico, $fisicoObs, $pc, $ppc, $talla, $alimentacion, $observaciones_generales, $id){

    $link = self::getConnection();
    $sql = "UPDATE control_salud set fecha=?, peso=?, vacunas_completas=?, vacunas_obs=?, maduracion_acorde=?, maduracion_obs=?, ex_fisico_normal=?, ex_fisico_observaciones=?, pc=?, ppc=?, talla=?, alimentacion=?, observaciones_generales=? WHERE id=?";
    $result = $link->prepare($sql);
    $result->execute(array("$fecha", "$peso", "$vacunas", "$vacunasObs", "$maduracion", "$maduracionObs", "$fisico", "$fisicoObs", "$pc", "$ppc", "$talla", "$alimentacion", "$observaciones_generales", "$id"));
  }

  public function eliminarControlSalud($id){
    $link = self::getConnection();
    $sql= "DELETE FROM control_salud WHERE id=?";
    $result= $link->prepare($sql);
    $result->execute(array("$id"));
  }

}
