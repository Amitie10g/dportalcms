<?php

// These Regular expressions are in PUBLIC DOMAIN. This is marked as them.

$single_string = "/^([\a-z0-9]{1,50})+$/"; // Only alphanumerical characters without spaces or any other characters, up to 50
$name_string = "/([&][\w]{3,6}[;])*([\w\s]{3,50})+/"; // Alphanumeric characters, with HTML characters and ampersand
$email_string = "/^([\w]{3,50})@([a-z]{2,20})\.([a-z]{2,5})*$/"; // Only a valid Email address, with @
$text_string = "/([&][\w]{3,6}[;])*([\w\s\r\n])+/"; // Any ASCII characters, with HTML entities with Ampersand
$num_string = "/^[0-9]+$/"; // Only numbers (integer)
$url_string = "/^((http:\/\/){0,1}(([a-z0-9]{1,20})\.)*(([a-z]{3,50})\.([a-z]{2,5})){1}(\/[a-zA-Z0-9\.\/])*)$/"; // A valid URL([www.]foo.com), with or without http://
$ip_string = "/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/"; // IP address PCRE (half completed)

// Declare Constants

define('PREG_SINGLE_STRING',$single_string);
define('PREG_NAME_STRING',$name_string);
define('PREG_EMAIL_STRING',$email_string);
define('PREG_TEXT_STRING',$text_string);
define('PREG_NUM_STRING',$num_string);
define('PREG_URL_STRING',$url_string);
define('PREG_IP_STRING',$ip_string);

?>
