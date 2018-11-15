<?php 
  session_start();
  include('../model/PDORepository.php');


  $patron = "/^[a-zA-Z1-9@\s]+$/";
  $letras="/^[a-zA-Z\s]+$/";
  $id=$_GET['id'];

  if(isset($_POST['nombre'])AND isset($_POST['apellido'])AND isset($_POST['email'])AND isset($_POST['nombreUsuario'])AND isset($_POST['rol'])){
        $nombre= $_POST['nombre'];
        $apellido= $_POST['apellido'];
        $email= $_POST['email'];
        $nombreUsuario= $_POST['nombreUsuario'];
        $rol=$_POST['rol'];

        if (isset ($_POST['activo'])){
            $habilitado= '1';
        }
        else{
          $habilitado= '0';
        } 

        if(preg_match($letras, $nombre) and preg_match($letras, $apellido)/*and preg_match($patron, $email)*/and preg_match($patron, $nombreUsuario) /*and preg_match($letras, $rol)*/){
      
          		PDORepository::updateUsuario($id, $nombre, $apellido, $email, $nombreUsuario, $rol, $habilitado); 
              PDORepository::refreshRols($id);
              
                foreach ($rol as $r) {
                  if (!PDORepository::incluyeRol($r,$id)) { PDORepository::cargarRol($r,$id);
                    
                  }
            }
          		header("Location: ../index.php?action=areaAdmin&error=2");
          		exit;

        }

   }

?>