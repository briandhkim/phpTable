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
		$output['errors'][] = 'action not provided for GET';
		output_and_exit($output);
	}
	switch($_GET['action']){
		case 'get_all_data':
			include('get_read/get_all_data.php');
			break;
		case 'search_by_id':
			include('get_read/search_by_id.php');
			break;
		case 'search_by_name':
			include('get_read/search_by_name.php');
			break;
		default:
			$output['errors'][] = 'invalid action';
	}

}else if($_SERVER['REQUEST_METHOD'] === 'POST'){	//create new
	if(empty($_POST['action'])){
		$output['errors'][] = 'action not provided for POST';
		output_and_exit($output);
	}

	switch($_POST['action']){
		case 'add_employee':
			include('post_create/add_employee.php');
			break;
		default:
			$output['errors'][] = 'invalid action';
	}

}else if($_SERVER['REQUEST_METHOD'] === 'PUT'){		//update existing
	parse_str(file_get_contents("php://input"), $post_vars);

	if(empty($post_vars['action'])){
		$output['errors'][] = 'action not provided for PUT';
		output_and_exit($output);
	}


}else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
	parse_str(file_get_contents("php://input"), $post_vars);

	if(empty($post_vars['action'])){
		$output['errors'][] = 'action not provided for DELETE';
		output_and_exit($output);
	}

	switch($post_vars['action']){
		case 'delete_by_id':
			include('delete/delete_by_id.php');
			break;
		default:
			$output['errors'][] = 'invalid action';
	}

}else{
	$output['errors'][] = 'invalid method';
	output_and_exit($output);
}


output_and_exit($output);
?>