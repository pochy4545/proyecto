<?php 
  session_start();
  include('../model/PDORepository.php');


  $patron = "/^[a-zA-Z1-9@\s]+$/";
  $letras="/^[a-zA-Z\s]+$/";

  if(isset($_POST['nombre'])AND isset($_POST['apellido'])AND isset($_POST['email'])AND isset($_POST['nombreUsuario'])AND isset($_POST['contraseña'])AND isset($_POST['rol'])){
        
        $nombre= $_POST['nombre'];
        $apellido= $_POST['apellido'];
        $email= $_POST['email'];
        $nombreUsuario= $_POST['nombreUsuario'];
        $contraseña= $_POST['contraseña'];
        $roles_array=$_POST['rol'];
        
        if (isset ($_POST['activo'])){
            $habilitado= '1';
        }else{
          $habilitado= '0';
        } 
       
        if(preg_match($letras, $nombre) and preg_match($letras, $apellido) /*and preg_match($patron, $email) */and preg_match($patron, $nombreUsuario) and preg_match($patron, $contraseña) ){
          $result=PDORepository::existeUsuario($nombreUsuario);

          if ($result <> 0){ 

              $error=1;
              header("Location: ../index.php?action=altaUsuario&error=$error"); 

           }else{

              PDORepository::cargarUsuario($nombre, $apellido, $email, $nombreUsuario, $contraseña,$habilitado);
              $id = PDORepository::idUsuario($nombreUsuario);
              foreach ($roles_array as $rol) {
                 PDORepository::cargarRol($rol,$id);
              }
           
           
              header("Location: ../index.php?action=areaAdmin&error=3");
            } 
        } 
    
      }elseif (!isset($_POST['rol'])) {
        header("Location: ../index.php?action=altaUsuario&error=2");
      }
  
?>