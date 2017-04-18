<?php
header("Content-Type:application/json");
include 'generate_review_id.php';

$generate_review_id;

if (isset($_SESSION['generated_review_id'])) {

    // it does; output the message
    $generated_review_id =  $_SESSION["generated_review_id"];

    // remove the key so we don't keep outputting the message
    unset($_SESSION['generated_review_id']);
}

session_destroy();

if(!(empty($_GET['pro_id']) || empty($_GET['user_id']) || empty($_GET['rating']) || empty($_GET['review'])))
{
  if (isset($_GET['pro_id']) && isset($_GET['user_id']) && isset($_GET['rating']) && isset($_GET['review'])) {

  $pro_reviewed_id = $_GET['pro_id'];
  $reviewer_id = $_GET['user_id'];
  $rating = $_GET['rating'];
  $review = $_GET['review'];
      }

      $query =  "INSERT INTO pro_reviews   
            (`review_id`,`pro_reviewed_id`,`reviewer_id`,`rating`,`review`,`review_date`,`helpful up`,`helpful_down`)
            VALUES    
            (?,?,?,?,?,CURRENT_TIMESTAMP(),0,0);";

         $sql = mysqli_prepare($con,$query);
            if($sql != FALSE)
            {
              mysqli_stmt_bind_param($sql, "sssis", $generated_review_id, $pro_reviewed_id,$reviewer_id,$rating,$review);         
                if(mysqli_stmt_execute($sql))
                   {
                       deliver_response(201,"Professional Reviewed",$generated_review_id);
                   } else {
                              deliver_response(400,"Review Failed","NULL");
                          } 
                        }
                        else{
                              deliver_response(400,mysqli_error($con),"NULL"); 
                                }
            
}
 else
    {
  deliver_response(400,"Bad Request","NULL");
    }

function deliver_response($status,$status_message,$generated_review_id)
{
  header("HTTP/1.1 $status $status_message");
  $response['status'] = $status;
  $response['status_message'] = $status_message;
  $response['generated_review_id'] = $generated_review_id;
  $json_response=json_encode($response);
  echo $json_response;
}

?>