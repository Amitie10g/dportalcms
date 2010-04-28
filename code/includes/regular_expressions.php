<?php

// These Regular expressions are in PUBLIC DOMAIN. This is marked as them.

$single_string = '/^([\a-z0-9]{1,50})+$/'; // Only alphanumerical characters without spaces or any other characters, up to 50
$name_string = '/([&][\w]{3,6}[;])*([\w\s]{3,50})+/'; // Alphanumeric characters, with HTML characters and ampersand
$email_string = '/^([\w]{3,50})@([a-z]{2,20})\.([a-z]{2,5})*$/'; // Only a valid Email address, with @
$text_string = '/([&][\w]{3,6}[;])*([\w\s\r\n])+/'; // Any ASCII characters, with HTML entities with Ampersand
$num_string = '/^[0-9]+$/'; // Only numbers
$url_string = '/^(([http:\/\/])*(([a-z]{1,5})\.)*([a-z]{3,50})\.([a-z]{2,5})(\/[a-zA-Z0-9])*)+$/' // A valid URL([www.]foo.com), without http://

?>
