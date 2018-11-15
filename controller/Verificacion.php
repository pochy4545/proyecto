<?php 
 

	function accesoAutorizadoAdminIndex($estados){
    if ($estados['rolAdm']) {
       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("administrador"),"usuario_index");

 	 }	
	}

	function accesoAutorizadoAdminNew($estados){
    if ($estados['rolAdm']) {
       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("administrador"),"usuario_new");

 	 }
	}
	function accesoAutorizadoPediatraIndex($estados){
	if ($estados['rolPdia']) {
		return PDORepository::tienePermiso(PDORepository::obtenerIdrol("pediatra"),"paciente_index");
		}
	}

	function accesoAutorizadoRecepcionistaIndex($estados){
	if ($estados['rolRecep']) {
		return PDORepository::tienePermiso(PDORepository::obtenerIdrol("recepcionista"),"paciente_index");
		}

	}
	function accesoAutorizadoPediatraNew($estados){
	if ($estados['rolPdia']) {
		return PDORepository::tienePermiso(PDORepository::obtenerIdrol("pediatra"),"paciente_new");	
		}
	}
	function accesoAutorizadoRecepcionistaNew($estados){
		if ($estados['rolRecep']) {
			 return PDORepository::tienePermiso(PDORepository::obtenerIdrol("recepcionista"),"paciente_new");	
		}

	}
	function accesoAutorizadoAdminUpdate($estados){
	if ($estados['rolAdm']) {
       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("administrador"),"usuario_update");

 	 }

	}
	function accesoAutorizadoAdminDestroy($estados){
	if ($estados['rolAdm']) {
       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("administrador"),"usuario_destroy");
 	 }
	}
	function accesoAutorizadoAdminConfi($estados){
    if ($estados['rolAdm']){

       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("administrador"),"configuracion");

 	 }
	}
	function accesoAutorizadoRecepcionistaIndexDatos($estados){
    if ($estados['rolRecep']){

       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("recepcionista"),"datos_index");

 	 }
	}
	function accesoAutorizadoPediatraIndexDatos($estados){
    if ($estados['rolPdia']){

       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("pediatra"),"datos_index");

 	 }
	}

	function accesoAutorizadoRecepcionistaShowDatos($estados){
    if ($estados['rolRecep']){

       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("recepcionista"),"datos_show");

 	 }
	}
	function accesoAutorizadoPediatraShowDatos($estados){
    if ($estados['rolPdia']){

       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("pediatra"),"datos_show");

 	 }
	}
	function accesoAutorizadoRecepcionistaUpdateDatos($estados){
    if ($estados['rolRecep']){

       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("recepcionista"),"datos_update");

 	 }
	}
	function accesoAutorizadoPediatraUpdateDatos($estados){
    if ($estados['rolPdia']){

       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("pediatra"),"datos_update");

 	 }
	}
	function accesoAutorizadoAdminDestroyDatos($estados){
    if ($estados['rolAdm']){

       return PDORepository::tienePermiso(PDORepository::obtenerIdrol("administrador"),"datos_destroy");

 	 }
	}
#faltan las vistas de los show
?>
