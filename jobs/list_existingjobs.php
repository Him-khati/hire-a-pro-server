<?php

header("Content-Type:application/json");
include '../connection.php';
	$query = "SELECT * FROM `jobs`ORDER BY job_id;";
	
	mysqli_query($con, $query) or die('Error querying database');
	$result = $con->query($query);
	if ($result->num_rows > 0)
	{
    // output data of each row
    while($row = $result->fetch_assoc()) 
    	{       
		$jobs[] = $row["job_name"];
    	}
    	deliver_response(201,"Jobs Found",$jobs);
	} else  {
    		deliver_response(204,"No Jobs Listed","NULL");
			}
       
                 
function deliver_response($status,$status_message,$jobs)
{
	header("HTTP/1.1 $status $status_message");

	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['jobs'] = $jobs;
	$json_response=json_encode($response);
	echo $json_response;
}

?>