<?php

header("Content-Type:application/json");
include '../connection.php';
if(!(empty($_GET['email_id']) || empty($_GET['password'])))
{
	$email_id = $_GET['email_id'];
	$password = $_GET['password'];
        $query =  "SELECT `user_id` FROM `users_primary` WHERE `email_id`='$email_id' AND `password`= MD5(MD5('$password'
		));";
				$result = $con->query($query) or die('Error Querying database');
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) 
						{       
							$o = $row["user_id"];
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
