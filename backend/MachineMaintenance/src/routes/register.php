<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/customer/count", function(Request $request, Response $response) {
  $sql = "SELECT COUNT(*) AS count FROM customer";
  try {
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query($sql);
    $data = $stmt->fetchColumn();
    $db = null;
    
    echo sprintf('%04d', $data + 1);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->post("/api/register/submit", function(Request $request, Response $response) {
  $customerId = $request->getParsedBody()['customerId'];
  $customerUsername = $request->getParsedBody()['customerUsername'];
  $customerPassword = $request->getParsedBody()['customerPassword'];
  $customerName = $request->getParsedBody()['customerName'];
  $address = $request->getParsedBody()['address'];
  $phone = $request->getParsedBody()['phone'];
  $email = $request->getParsedBody()['email'];

  $hashedPassword = password_hash($customerPassword, PASSWORD_BCRYPT);

  $sqlInsert = "INSERT INTO customer (customerID, customerUsername, customerPassword, customerName, address, phone, email) VALUES (:customerID, :customerUsername, :customerPassword, :customerName, :address, :phone, :email)";

  try {
    $db = new db();
    $db = $db->connect();

    //INSERT
    $stmt = $db->prepare($sqlInsert);
    $stmt->bindParam(':customerID', $customerId, PDO::PARAM_STR);
    $stmt->bindParam(':customerUsername', $customerUsername, PDO::PARAM_STR);
    $stmt->bindParam(':customerPassword', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(':customerName', $customerName, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    //execute SQL statement and get result
    $result = $stmt->execute();
    $db = null;
    
    //return result to frontend
    echo $result;
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

?>