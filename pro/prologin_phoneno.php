<?php

header("Content-Type:application/json");
include '../connection.php';
if(!(empty($_GET['phone_no']) || empty($_GET['password'])))
{
	$phone_no = $_GET['phone_no'];
	$password = $_GET['password'];
        $query =  "SELECT `pro_id` FROM `professionals_primary` WHERE `phone_no`='$phone_no' AND `password`= MD5(MD5('$password'
		));";
		
				$result = $con->query($query) or die('Error Querying database');
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) 
						{       
							$o = $row["pro_id"];
							deliver_response(201,"Account Found",$o);
						}
											} 
												else {
									deliver_response(400,"Account Creation Failed","NULL");
													}
	 
          
}
else
{
deliver_response(400,"Bad Request","NULL");
}
function deliver_response($status,$status_message,$user_id)
{
	header("HTTP/1.1 $status $status_message");

	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['user_id'] = $user_id;
	$json_response=json_encode($response);
	echo $json_response;
}

?>
