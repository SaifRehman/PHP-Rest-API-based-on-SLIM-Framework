<?php
$servername = "us-cdbr-azure-central-a.cloudapp.net";// hey are u here???  okk fill
$username = "bdb0f94ba8b580";//one sec let me check saif it seems i forgot or got mixed up
$password = "f18508c6";//does it work? yesss// we are able to ccess database/ since there are no entries it doesnt show anything
// do one thing populate with a entry ok from mysql? yess
$dbname = "wekker";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM userinfo";
$result = $conn->query($sql);
$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}// hey add the detals here
    $outp .= '{"username":"'  . $rs["username"] . '",';
    $outp .= '"bedtype":"'   . $rs["bedtype"]        . '",';
    $outp .= '"bedside":"'. $rs["bedside"]     . '",';
    $outp .= '"token":"'. $rs["token"]     . '"';
}
header('Content-Type: application/json');
$outp ='{"result":['.$outp.']}';
echo json_encode(stripslashes($outp));
$conn->close();
?>
