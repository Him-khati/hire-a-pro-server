<?php
include '../connection.php';
$id_head="PRO";
$o;
$query = "SELECT pro_id FROM professionals_primary ORDER BY pro_id desc limit 1;";
mysqli_query($con, $query) or die('Error querying database');
$result = $con->query($query);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {       
$o = $row["pro_id"];
    }
} else {
    $o= "PRO100";
}
$generated_pro_id = substr($o,3);
$generated_pro_id++;
$generated_pro_id = "PRO".$generated_pro_id;
session_start();
$_SESSION["generated_pro_id"] = $generated_pro_id;
?>