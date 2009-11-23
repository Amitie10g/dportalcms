<?php

$single_string = '/^([\a-z0-9]{1,50})+$/'; // slo letras minsculas y numeros de 1 a 50 caracteres
$name_string = '/([&][\w]{3,6}[;])*([\w\s]{3,50})+/'; // Caracteres alfanumricos con espacios en blanco y caracteres especiales HTML de valores Ampersand
$email_string = '/^([\w]{3,50})@([a-z]{2,20})\.([a-z]{2,5})*$/'; // Slo una direccin de email vlida
$text_string = '/([&][\w]{3,6}[;])*([\w\s\r\n])+/'; // Texto con cualquier caracter alfanumrico, espacios en blanco, saltos de linea y caracteres especiales HTML de valor Ampersand
$num_string = '/^[0-9]+$/'; // Slo nmeros
$url_string = '/^(([http:\/\/])*(([a-z]{0,5})\.)*([a-z]{3,50})\.([a-z]{2,5})(\/[a-zA-Z0-9])*)+$/' // Una URL valida sin 'http://'.

?>
