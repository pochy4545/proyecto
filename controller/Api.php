<?php

 function transform($tipo,$campo){
   foreach ($tipo as $key => $value) {
            $a[$value->{"id"}]= $value->{$campo};
        }
        return $a;
}

 function getElementosApi($path){
	$tipo=file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/".$path);
	$t=json_decode($tipo);
	return transform($t,"nombre");

     
}
function getElementoApi($path,$id){
	$tipo=file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/".$path."/".$id);
	$t=json_decode($tipo);

	return($t ->{"nombre"});

     
}




 ?>