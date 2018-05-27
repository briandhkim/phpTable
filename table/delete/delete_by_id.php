<?php
if(empty($LOCAL_ACCESS)){
    die('no direct access allowed');
}

if(empty($post_vars['employee_id'])){
	$output['error'][] = 'missing employee ID';
	output_and_exit($output);
}

$employee_id = filter_var($post_vars['employee_id'], FILTER_SANITIZE_NUMBER_INT);

$query = 
	"DELETE 
	FROM
		employees
	WHERE
		employee_id = ?";

if(!($stmt = $conn->prepare($query))){
    $output['errors'][] = 'query error';
    output_and_exit($output);
}

$stmt->bind_param("i", $employee_id);
$stmt->execute();

if($conn->affected_rows>0){
	$output['success'] = true;
	$output['messages'][] = 'Employee deleted';
}else{
	$output['error'] = 'Wrong ID or no employee to delete';
}
?>