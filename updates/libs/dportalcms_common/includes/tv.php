<?php
	#########################################################################
	# 	DPortal Light							#
	# CMS ligero, 'rudimentario' y sin bases de datos,			#
	# para una implementación fácil y rápida en sitios pequños.		#
	# Desarrollado especialmente para Ojamajo Web				#
	#									#
	# Copyright (c) Davod y colaboradores. All rights reserved		#
	#########################################################################
	#									#
	# Este programa es Software Libre. Puede ser modificado y redistribuido	#
	# bajo los términos y condiciones de la Licencia Pública general GNU	#
	# versión 3 o posterior, o la que estime conveniente			#
	#									#
	# Este programa se distribuye con la esperanza de ser útil,		#
	# PERO SIN GARANTÍA ALGUNA, salvo algunas garantías explícitas		#
	#									#
	# LOS AUTORES Y/O COLABORADORES DE ESTE PROGRAMA NO SON RESPONSABLES	#
	# ANTE DAÑOS Y PERJUICIOS, PÉRDIDA DE DATOS VALIOSOS O CUALQUIER	#
	# OTRA CONSECUENCIA PRODUCTO DEL USO DE ESTE PROGRAMA.			#
	# Este programa se ha construido de buena fe y está libre de código	#
	# malicioso, e intenta estar en lo más posible, libre de Bugs.		#
	# Sin embargo USTED ES RESPONSABLE DE IMPLEMENTAR CORRECTAMENTE ESTE	#
	# PROGRAMA Y REVISAR QUE ESTÉ LIBRE DE BUGS QUE PUDIERAN COMPROMETER	#
	# SU SISTEMA.								#
	#									#
	#########################################################################
	#									#
	# Por favor refiérase a la Documentación.				#
	# Si no entiende este archivo o no tiene idea de programación en PHP,	#
	# por favor no lo toque y refiérase a las Plantillas o los Contenidos.	#
	#									#
	#########################################################################

// Inicia la Sesión
session_start();

// Obtine la Configuración
require('config/config.php');

// Obtiene el ID del Video por GET y si es en Alta calidad
$video = $_GET['video'];
$hq = $_GET['HQ'];

// Comprueba si el Archivo de video existe y si es leible. Si no, es HOME
if(is_readable("video/$seccion")){
	$video = $video;
}else{
	// Si no se ha proporcionado un Video váilido, redirigir al Playlist
	header("location:index.php?seccion=playlist');die(); 
}

// Obtiene los datos para la Sección y otros elementos
$affiliates = file_get_contents("content/affiliates");

// Declara las variables Smarty
$smarty->assign('SITENAME',$sitename);
//$smarty->assign('SECTION',$section_name);
$smarty->assign('VIDEO',$video);
$smarty->assign('AFFILIATES',$affiliates);

// Las salidas
$smarty->display('header.tpl');
$smarty->display('menu.tpl');
$smarty->display('sidebar.tpl');
$smarty->display('player.tpl');
$smarty->display('footer.tpl');

?>
