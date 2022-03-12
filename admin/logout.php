<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
$_SESSION = array();
session_destroy();
go_to_page(AUTH);

?>