<?php
	if(empty($LOCAL_ACCESS)){
	    die('direction access not allowed');
	}

	if( empty($_GET['first_name']) AND empty($_GET['last_name']) ){
		$output['errors'][] = 'No name to look up';
		output_and_exit($output);
	}

	if( !(empty($_GET['first_name'])) AND !(empty($_GET['last_name'])) ){
		include('search_by_first_and_last_name.php');
	}else{
		$f_name = filter_var($_GET['first_name'], FILTER_SANITIZE_STRING);
		$l_name = filter_var($_GET['last_name'], FILTER_SANITIZE_STRING);

		$query = 
			"SELECT 
				*
			FROM
				employees
			WHERE
				first_name = ? OR last_name = ?";

		if( !($stmt = $conn->prepare($query)) ){
			$output['errors'][] = 'search by name sql error';
			output_and_exit($output);
		}
		$stmt->bind_param('ss', $f_name, $l_name);

		if( $stmt->execute() ){
			$stmt->bind_result($employee_id, $first_name, $last_name, $phone_number, $supervisor);

			while( $stmt->fetch() ){
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
			$output['errors'][] = 'sql error with search by name';
		}
	}

?>