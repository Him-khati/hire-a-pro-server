<?php
header("Content-Type:application/json");
include 'generatenew_proid.php';
$generated_pro_id =  $_SESSION["generated_pro_id"];
$job_id = "JOB102";
session_destroy();

if(!(empty($_GET['name']) || empty($_GET['phone_no']) || empty($_GET['password']) || empty($_GET['aadhar_card'])))
{
  $name = $_GET['name'];
  $phone_no = $_GET['phone_no'];
  $password = $_GET['password'];
        $aadhar_card = $_GET['aadhar_card'];

      $query =  "INSERT INTO professionals_primary   
            (`pro_id`,`name`,`phone_no`,`date_pro_added`,`time_pro_added`,`password`,`job_id`,`aadhar_card`)
            VALUES    
            (?,?,?,CURDATE(),CONVERT_TZ(curtime(),'+00:00','+05:30'),MD5(MD5(?)),'JOB101',?);";

         $sql = mysqli_prepare($con,$query);
            if($sql != FALSE)
            {
              mysqli_stmt_bind_param($sql, "ssisi", $generated_pro_id, $name,$phone_no,$password,$aadhar_card);         
                if(mysqli_stmt_execute($sql))
                   {
                       deliver_response(201,"Account Created",$generated_pro_id);
                   } else {
                              deliver_response(400,"Account Creation Failed","NULL");
                          } 
                        }
                        else{
                              deliver_response(400,mysqli_error($conn),"NULL"); 
                                }
            
}
 else
    {
  deliver_response(400,"Bad Request","NULL");
    }

function deliver_response($status,$status_message,$generated_pro_id)
{
  header("HTTP/1.1 $status $status_message");
  $response['status'] = $status;
  $response['status_message'] = $status_message;
  $response['generated_pro_id'] = $generated_pro_id;
  $json_response=json_encode($response);
  echo $json_response;
}

?>