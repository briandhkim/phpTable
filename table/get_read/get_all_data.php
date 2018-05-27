<?php
if(empty($LOCAL_ACCESS)){
	die('no direct access');
}

// $stmt = $conn->prepare(
	// "SELECT
	// 	*
	// FROM 
	// 	employees AS e
	// ORDER BY
	// 	e.employee_id");
// $stmt->execute();
// $result = $stmt->get_result();
$sql = "SELECT
			*
		FROM 
			employees AS e
		ORDER BY
			e.employee_id";
$result = $conn->query($sql);

if($result->num_rows>0){
	$output['success'] = true;
	while($row = $result->fetch_assoc()){
		$output['data'][] = $row;
	}
}else{
	$output['nothing_to_read'] = true;
}

?>