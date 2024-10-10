<?php

if($_POST['loginUsername'] == "admin" && $_POST['loginPassword']=="unach"){
	session_start();
	$_SESSION['login'] = "true";
	$_SESSION['nomusuario'] = $_POST['loginUsername'];
	
	//header("location: menu.php");
	echo json_encode(array('success' => 1));
}
else{
	//header("location: index.php");	
	echo json_encode(array('success' => 0));
}	

?>
