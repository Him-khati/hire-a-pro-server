<?php
include '../connection.php';
session_start();
$query = "SELECT user_id FROM users_primary ORDER BY user_id desc limit 1;";
$result = $con->query($query) or die('Error Querying database');
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {       
$o = $row["user_id"];
    }
} else {
    echo "0 results";
}
$generated_id = substr($o,2);
$generated_id++;
$generated_id = "ID".$generated_id;
$_SESSION["generated_id"] = $generated_id;
?>