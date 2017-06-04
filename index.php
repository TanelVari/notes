<?php

require_once('functions.php');

session_start();
connect_db();

global $errors;

if (!isset($errors)) {
    $errors = array();
}

$page="pealeht";

if (isset($_GET['page']) && $_GET['page']!=""){
	$page = htmlspecialchars($_GET['page']);
}

include_once('views/header.php');

switch($page){
    case "login":
        login();
        break;
    case "add_user":
        add_user();
        break;
    case "logout":
        logout();
        break;
	default:
        show_notes();
	    break;
}

include_once('views/footer.php');

?>