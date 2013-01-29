<?php

require 'Core\Flerovium.php';

if (isset($_GET["url"]) && !empty($_GET["url"])) {
	$url = explode("/", $_GET["url"]);
} else {
	$url = array();
}

switch(sizeof($url)){
	case 0:
			$f = new Flerovium();
		break;
	case 1:
			$f = new Flerovium($url[0]);
		break;
	case 2:
			$f = new Flerovium($url[0],$url[1]);
		break;
    default:
    		$f = new Flerovium($url[0],$url[1]);
    	break;
}

$f->run();