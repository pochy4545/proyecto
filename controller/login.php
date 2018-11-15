<?php
  session_start();
  include('../model/PDORepository.php');

  $patron = "/^[a-zA-Z0-9\s]+$/";
  if (isset($_POST['usuario']) and isset ($_POST['contraseña'])){
      $usuario= $_POST['usuario'];
      $contraseña= $_POST['contraseña'];
      if(preg_match($patron, $usuario) and preg_match($patron, $contraseña)){

          $logueado = PDORepository::autenticar($_POST['usuario'],$_POST['contraseña']);
          
           if ($logueado[0]){

            if (PDORepository::habilitacion($_POST['usuario'],$_POST['contraseña'])){
                   $_SESSION['usuario']= $usuario;
                    $_SESSION['log']= true;
                    $_SESSION['rol']= $logueado[1];
                   
                    if(PDORepository::rolAdmin($_SESSION['rol'])){
                      header ('Location:/index.php?action=areaAdmin');
                    }else{
                     header ('Location: /index.php');
                 }
            }
            else{
              $error=2;
               header ("Location: /index.php?action=login&error=$error");

            }
          }
          else{
              $error=1;
              header ("Location: /index.php?action=login&error=$error");
          } 
      }
      else{
            $error=1;
            ("Location: index.php/?action=login&error=$error");
      }
  }
  else{
            $error=1;
           ("Location: ../?action=login&error=$error");
  }

 
