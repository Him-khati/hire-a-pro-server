<?php
include '../connection.php';
session_start();
$id_head = "UID";
$o;
$query = "SELECT user_id FROM users_primary ORDER BY user_id desc limit 1;";
$result = $con->query($query) or die('Error Querying database');
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {       
$o = $row["user_id"];
    }
} else {
    $o = "UID100";
}
$generated_id = substr($o,3);
$generated_id++;
$generated_id = $id_head.$generated_id;
$_SESSION["generated_id"] = $generated_id;
?>