<?php

header("Content-Type:application/json");
include '../connection.php';
if(!(empty($_GET['type']) || empty($_GET['user_latitude'])|| empty($_GET['user_longitude'])|| empty($_GET['distance'])))
{
	$type = $_GET['type'];
	$user_latitude = $_GET['user_latitude'];
	$user_longitude = $_GET['user_longitude'];
	$distance = $_GET['distance'];
        $query =  "SELECT A.pro_id,A.name,A.base_rate,B.`base_location_latitude`,B.`base_location_longitude`,111.111 *
										DEGREES(ACOS(COS(RADIANS($user_latitude))
										* COS(RADIANS(B.`base_location_latitude`))
										* COS(RADIANS($user_longitude - B.`base_location_longitude`))
										+ SIN(RADIANS($user_latitude))
										* SIN(RADIANS(B.`base_location_latitude`)))) AS distance
										FROM professionals_primary A ,professionals_secondary B,jobs C
										WHERE A.pro_id=B.pro_id AND A.job_id=C.job_id AND C.job_name='$type';";
		echo $query;
				$result = $con->query($query) or die('Error Querying database');
				$temp_array = array();
				$row_count=mysqli_num_rows($result);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) 
						{       
							$temp_array[] = $row;
						}
						
						deliver_response(201,"Professionals Found",$row_count,$temp_array);
											} 
												else {
									deliver_response(400,"No Professionals Found",0,"NULL");
													}
	 
          
}
else
{
deliver_response(400,"Bad Request",0,"NUll");
}
function deliver_response($status,$status_message,$row_count,$professional_list_array)
{
	header("HTTP/1.1 $status $status_message");

	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['row_count'] = $row_count;
	$response['professional_list'] = $professional_list_array;
	$json_response=json_encode($response);
	echo $json_response;
}

?>