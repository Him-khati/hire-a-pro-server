<?php
header("Content-Type:application/json");
include '../../connection.php';



if(!(empty($_GET['review_id']) || empty($_GET['user_id'])))
{
  if (isset($_GET['review_id']) && isset($_GET['user_id'])) {

  $review_id = $_GET['review_id'];
  $helpful_up_user_id = $_GET['user_id'];
  
      }

      $query =  "INSERT INTO reviews_ups   
            (`review_id`,`up_date`,`helpful_up_user_id`)
            VALUES    
            (?,CURRENT_TIMESTAMP(),?);";

      $query2 =  "UPDATE pro_reviews   
            SET helpful_up = helpful_up + 1 WHERE review_id = ?;";

         $sql = mysqli_prepare($con,$query);
         $sql2 = mysqli_prepare($con,$query2);
            if($sql != FALSE || $sql2 != FALSE)
            {
              mysqli_stmt_bind_param($sql, "ss", $review_id, $helpful_up_user_id);
              mysqli_stmt_bind_param($sql2, "s", $review_id);           
                if(mysqli_stmt_execute($sql))
                   {
                        mysqli_stmt_execute($sql2);
                       deliver_response(201,"Review Upvoted");
                   } else {
                              deliver_response(400,"Upvoting Failed");
                          } 
                        }
                        else{
                              deliver_response(400,mysqli_error($con)); 
                                }
            
}
 else
    {
  deliver_response(400,"Bad Request","NULL");
    }

function deliver_response($status,$status_message)
{
  header("HTTP/1.1 $status $status_message");
  $response['status'] = $status;
  $response['status_message'] = $status_message;
  $json_response=json_encode($response);
  echo $json_response;
}

?>