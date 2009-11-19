<?php

/* ABOUT THIS FUNCTION:
 *
 * This is a Smarty Function, that returns a String with a Call
 * to Javascript, expecially for callajax in <body>
 *
 * Parameters form tamplate:
 *
 * *	String url: The URL of you want to Call AJAX
 * 		If URL are null, the function will return null.
 *
 * *	String block: The DIV Block by ID where you want to
 *		deploy the content obtained Asynchronusly.
 *
 * Returned values:
 *
 * The String with the Script call (or null).
 *
*/

function callajax_body($params, &$smarty){

	$url = $params['url'];
	$block = $params['block'];

	if($url != null) return " onload=\"callajax('$url', '$block');\"";
	else return null;
}
	
?>
