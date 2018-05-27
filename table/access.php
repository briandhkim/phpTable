<?php
session_start();
$LOCAL_ACCESS = true;

require_once('mysql_connect.php');

$output = [
	'success' => false,
	'errors' => [],
];

if(empty($_POST['action'])){
	$output['errors'][] = 'action not provided';
	output_and_exit($output);
}

function output_and_exit($output){
	$json_output = json_encode($output);

	print($json_output);
	exit();
}

switch($_POST['action']){
	
	default:
		$output['errors'][] = 'invalid action';
}
output_and_exit($output);
?>