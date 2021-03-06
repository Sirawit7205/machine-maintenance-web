<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/customer/mostValued", function(Request $request, Response $response) {
  $sql = "SELECT cn.customerID, cs.customerName AS customer, SUM(cn.price) AS totalContractValue, COUNT(cn.contractID) AS contractCount FROM contract cn, customer cs WHERE cn.customerID = cs.customerID GROUP BY cn.customerID ORDER BY totalContractValue DESC";
  try {
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    echo json_encode($data);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->get("/api/customer/nearlyExpired", function(Request $request, Response $response) {
  $sql = "SELECT cn.customerID, cs.customerName AS customer, cn.contractID AS contractId, cn.price AS contractValue, DATEDIFF(cn.endDate, NOW()) AS daysLeft FROM contract cn, customer cs WHERE cn.customerID = cs.customerID HAVING daysLeft >= 0 ORDER BY daysLeft";
  try {
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    echo json_encode($data);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->get("/api/customer/getName/{customerId}", function(Request $request, Response $response) {
  $customerId = $request->getAttribute('customerId');
  $sql = "SELECT customerName FROM customer WHERE customerId = \"$customerId\"";
  try {
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    @print_r($data[0]->customerName);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

?>