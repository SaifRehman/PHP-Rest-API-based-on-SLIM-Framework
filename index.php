<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
$app = new \Slim\App;
//                                              Reading Json Parameters                                               \\
$app->post('/post', function (Request $request, Response $response) {
  $servername = "localhost";
  $username = "username";
  $password = "password";
  $dbname = "dbname";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }
  $stmt = $conn->prepare("INSERT INTO tablename (x,y,z,a) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $x, $y, $z, $a);
  header("Content-Type: application/json");
    $paramValue = $request->getParsedBody();
    $x = $paramValue['x'];
    $y = $paramValue['y'];
    $z = $paramValue['z'];
    $a = $paramValue['a'];
    $stmt->execute();
    echo "inserted";
});

$app->post('/update', function (Request $request, Response $response) {
  $servername = "localhost";
  $username = "username";
  $password = "password";
  $dbname = "dbname";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }
  $stmt = $conn->prepare("UPDATE tablename SET status = ? where id = ?");
  $stmt->bind_param("si",$status, $id );
  header("Content-Type: application/json");
  $paramValue = $request->getParsedBody();
    $id= $paramValue['id'];
    $status= $paramValue['status'];
    $stmt->execute();
    return "updated";
});


$app->get('/get', function (Request $request, Response $response) {
  $servername = "localhost";
  $username = "username";
  $password = "password";
  $dbname = "dbname";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }
  $token = $request->getAttribute('token');
  $result = $conn->query("SELECT * FROM wekkeralarm ");
  $outp = array();
  while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    array_push($outp, array(
      'x' => $rs["x"],
      'y' => $rs["y"],
      'z' => $rs["z"],
      'a' => $rs["a"]
    ));
  }
  $conn->close();
  return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array('result' => $outp)));
});

$app->get('/GetByLinkParams/{username}/{token}', function (Request $request, Response $response) {
  $servername = "localhost";
  $username = "username";
  $password = "password";
  $dbname = "dbname";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }
  $token = $request->getAttribute('token');
  $username = $request->getAttribute('username');
  $sqlQ1 = "SELECT * FROM wekkeralarm where token='" . $token . "' AND username ='" . $username . "'" ;
  $result = $conn->query($sqlQ1);
  $outp = array();
  while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    array_push($outp, array(
      'x' => $rs["x"],
      'y' => $rs["y"],
      'z' => $rs["z"]
    ));
  }
  $conn->close();
  return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array('result' => $outp)));
});
$app->run();
?>
