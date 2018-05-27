<?php
	if(empty($LOCAL_ACCESS)){
	    die('direction access not allowed');
	}

	if( empty($_GET['first_name']) ){
		$output['errors'][] = 'No first name to look up';
		output_and_exit($output);
	}
?>