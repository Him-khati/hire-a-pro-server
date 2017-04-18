<?php
include '../../connection.php';
session_start();
$query = "SELECT review_id FROM pro_reviews ORDER BY review_id desc limit 1;";
$o;$id_head ="REV";
$result = $con->query($query) or die('Error Querying database');
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {       
$o = $row["review_id"];
    }
} else {
    $o = "REV100";
}
$generated_review_id = substr($o,3);
$generated_review_id++;
$generated_review_id = $id_head.$generated_review_id;
$_SESSION["$generated_review_id"] = $generated_review_id;
?>
