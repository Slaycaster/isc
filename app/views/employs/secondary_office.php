<?php

$value = $_POST['value'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iscdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, UnitOfficeSecondaryName FROM unit_office_secondaries WHERE UnitOfficeID = '".$value."'";
$result = $conn->query($sql);

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"id":"'  . $rs["id"] . '",';
    $outp .= '"UnitOfficeSecondaryName":"'   . $rs["UnitOfficeSecondaryName"]        . '",';
}
$outp .="]";

$conn->close();

echo($outp)

?>