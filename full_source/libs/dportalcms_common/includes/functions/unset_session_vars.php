<?php

// void unset_global_var(string name)
function unset_global_var($name){
	unset($_SESSION[$name]);
}

?>