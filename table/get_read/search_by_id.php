<?php
	if(empty($LOCAL_ACCESS)){
	    die('direction access not allowed');
	}

	if(empty($_GET['employee_id'])){
		$output['errors'][] = 'No employee ID to look up';
		output_and_exit($output);
	}

	$emp_id = filter_var($_GET['employee_id'], FILTER_SANITIZE_NUMBER_INT);

	$query = 
		"SELECT
			*
		FROM
			employees
		WHERE
			employee_id = ?";

	if(!($stmt = $conn->prepare($query))){
		$output['errors'][] = 'search by ID sql error';
		output_and_exit($output);
	}
	$stmt->bind_param('i', $emp_id);

	if($stmt->execute()){
		$stmt->bind_result($first_name, $last_name, $employee_id, $phone_number, $supervisor);
		// mysqli_stmt_fetch($stmt);

		while($stmt->fetch()){
			$employee['first_name'] = $first_name;
			$employee['last_name'] = $last_name;
			$employee['employee_id'] = $employee_id;
			$employee['phone_number'] = $phone_number;
			$employee['supervisor'] = $supervisor;

			$output['data'][] = $employee;
		}
		if( !empty($output['data']) ){
			$output['success'] = true;
		}else{
			$output['errors'][] = 'no matching employee';
			$output['no_employee_match'] = true;
		}
		$stmt->close();
	}else{
		$output['errors'][] = 'sql error with search by employee ID';
	}

	// $stmt->execute();
	// $result = $stmt->get_result();

	// if($result->num_rows>0){
	// 	$output['success'] = true;
	// 	$row = $result->fetch_assoc();
	// 	$output['data'][] = $row;
	// }else{
	// 	$output['errors'][] = 'no matching employees';
	// 	$output['no_employee_match'] = true;
	// }
?>