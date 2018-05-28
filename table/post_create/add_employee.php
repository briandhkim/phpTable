<?php
if(empty($LOCAL_ACCESS)){
    die('direction access not allowed');
}

if(empty($_POST['first_name'])){
	$output['errors'][] = 'Missing first name';
	output_and_exit($output);
}
if(empty($_POST['last_name'])){
	$output['errors'][] = 'Missing last name';
	output_and_exit($output);
}
if(empty($_POST['phone_number'])){
	$output['errors'][] = 'Missing phone number';
	output_and_exit($output);
}
if(empty($_POST['supervisor'])){
	$output['errors'][] = 'Missing supervisor';
	output_and_exit($output);
}

$first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
$last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
$phone_number = filter_var($_POST['phone_number'], FILTER_SANITIZE_NUMBER_INT);
$supervisor = filter_var($_POST['supervisor'], FILTER_SANITIZE_STRING);

//duplicate check
$query =
	"SELECT
		*
	FROM
		employees
	WHERE
		first_name = ? AND last_name = ? AND phone_number = ? AND supervisor = ?";
if(!($stmt = $conn->prepare($query))){
	$output['errors'][] = 'duplicate check query error for adding employees';
	output_and_exit($output);
}
$stmt->bind_param('ssis', $first_name, $last_name, $phone_number, $supervisor);
// $stmt->execute();
// $results = $stmt->get_result();
// if($results->num_rows>0){
// 	$output['errors'][] = 'duplicate person found';
// 	output_and_exit($output);
// }
if( $stmt->execute() ){
	$stmt->bind_result($f_name, $l_name, $emp_id, $p_number, $sup);
	mysqli_stmt_fetch($stmt);

	$employee['first_name'] = $f_name;
	$employee['last_name'] = $l_name;
	$employee['employee_id'] = $emp_id;
	$employee['phone_number'] = $p_number;
	$employee['supervisor'] = $sup;

	$stmt->close();
	if(!empty($f_name)){
		// foreach($employee as $e){
		// 	echo $e, '<br>';
		// }
		$output['errors'][] = 'This employee is already registered';
		output_and_exit($output);
	}
}
//end of duplicate check

$sqli = 
	"INSERT INTO
		employees
	SET 
		first_name = ?,
		last_name = ?,
		phone_number = ?,
		supervisor = ?";
if(!($stmt = $conn->prepare($sqli))){
	$output['errors'][] = 'error adding employee';
	output_and_exit($output);
}
$stmt->bind_param('ssis', $first_name, $last_name, $phone_number, $supervisor);
$stmt->execute();
if($conn->affected_rows>0){
	$output['success'] = true;
	$output['messages'][] = 'employee added successfully';
}else{
	$output['errors'][] = 'Wrong input for adding employees';
}

?>