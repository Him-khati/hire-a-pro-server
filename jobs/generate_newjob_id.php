<?php
require '../connection.php';
session_start();
$query = "SELECT job_id FROM jobs ORDER BY job_id desc limit 1;";
mysqli_query($con, $query) or die('Error querying database');
$result = $con->query($query);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {       
$o = $row["job_id"];
    }
} else {
    echo "0 results";
}
$gen_job_id = substr($o,3);
$gen_job_id++;
$gen_job_id = "JOB".$gen_job_id;
echo "$gen_job_id";
$_SESSION["gen_job_id"] = $gen_job_id;
?>