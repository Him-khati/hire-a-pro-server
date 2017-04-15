<?php

header("Content-Type:application/json");
include 'generate_userid.php';
$generated_id =  $_SESSION["generated_id"];
session_destroy();
if(!(empty($_GET['name']) || empty($_GET['phone_no']) || empty($_GET['password'])))
{
	$name = $_GET['name'];
	$phone_no = $_GET['phone_no'];
	$password = $_GET['password'];
        $query =  "INSERT INTO users_primary   
            (`user_id`,`name`,`phone_no`,`date_user_added`,`time_user_added`,`password`)
            VALUES    
            (?,?,?,CURDATE(),CONVERT_TZ(curtime(),'+00:00','+05:30'),                                       
             MD5(MD5(?)));";
	$sql = mysqli_prepare($con,$query);

        if($sql !== FALSE){
              mysqli_stmt_bind_param($sql, "ssis", $generated_id, $name,$phone_no,$password);
              if(mysqli_stmt_execute($sql)){
          deliver_response(201,"Account Created",$generated_id);
         } else {
            deliver_response(400,"Account Creation Failed","NULL");
          }
         } else{
          deliver_response(400,mysqli_error($conn),"NULL");
         
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