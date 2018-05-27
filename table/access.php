<?php
session_start();
$LOCAL_ACCESS = true;

require_once('mysql_connect.php');

$output = [
	'success' => false,
	'errors' => [],
];

// if(empty($_POST['action']) or empty($_GET['action']) ){
// 	$output['errors'][] = 'action not provided';
// 	output_and_exit($output);
// }

function output_and_exit($output){
	$json_output = json_encode($output);

	print($json_output);
	exit();
}

if($_SERVER['REQUEST_METHOD'] === 'GET'){
	if(empty($_GET['action']) ){
		$output['errors'][] = 'action not provided';
		output_and_exit($output);
	}
	switch($_GET['action']){
		case 'get_all_data':
			include('get_all_data.php');
			break;
		default:
			$output['errors'][] = 'invalid action';
	}
	

}else if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(empty($_POST['action'])){
		$output['errors'][] = 'action not provided';
		output_and_exit($output);
	}

	switch($_POST['action']){
		// case 'get_all_data':
		// include('get_all_data.php');
		// 	break;
		default:
			$output['errors'][] = 'invalid action';
	}

}else{
	$output['errors'][] = 'invalid method';
	output_and_exit($output);
}


output_and_exit($output);
?>