<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->get("/api/customer/info/{customerId}", function(Request $request, Response $response) {
    $customerId = $request->getAttribute('customerId');
    $sql = "SELECT customerID AS customerId, customerName, address,phone,email FROM customer WHERE customerId=\"$customerId\"";
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
  
$app->post("/api/contract/submit", function(Request $request, Response $response) {
    $actionType = $request->getParsedBody()['actionType'];
    $contractId = $request->getParsedBody()['contractId'];
    $startDate = $request->getParsedBody()['startDate'];
    $endDate = $request->getParsedBody()['endDate'];
    $price = $request->getParsedBody()['price'];
    $customerId = $request->getParsedBody()['customerId'];  
    $customerName = $request->getParsedBody()['customerName'];
    $address = $request->getParsedBody()['address'];
    $email = $request->getParsedBody()['email'];
    $phone = $request->getParsedBody()['phone'];
    
  
    $sqlInsertContract = "INSERT INTO contract(contractId,startDate,endDate,price) VALUES(:contractId,:startDate,endDate,price);INSERT INTO customer(customerID AS customerId,customerName,address,phone,email) VALUES(:customerId,:customerName,:address,:phone,:email);";
    //$sqlInsertCustomer = "INSERT INTO customer(customerID AS customerId,customerName,address,phone,email) VALUES(:customerId,:customerName,:address,:phone,:email)";
    $sqlUpdate = "UPDATE contract SET contractId = :contractId, startDate = :startDate, endDate = :endDate, price = :price WHERE contractId = :contractId";
    $sqlDelete = "DELETE FROM contract WHERE contractId = :contractId";
    
    try {
      $db = new db();
      $db = $db->connect();


      //INSERT
      if($actionType == 0) {
        //prepare template
        $stmt1 = $db->prepare($sqlInsertContract);
        //$stmt2 = $db->prepare($sqlInsertCustomer);
  
        //bind parameters
        $stmt1->bindParam(':contractId', $contractId, PDO::PARAM_STR);
        $stmt1->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt1->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt1->bindParam(':price', $price, PDO::PARAM_STR);

        $stmt1->bindParam(':customerId', $customerId, PDO::PARAM_STR);
        $stmt1->bindParam(':customerName', $customerName, PDO::PARAM_STR);
        $stmt1->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt1->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt1->bindParam(':email', $email, PDO::PARAM_STR);
      }
      //UPDATE
      else if($actionType == 1) {
        //prepare template
        $stmt1 = $db->prepare($sqlUpdate);
  
        //bind parameters
        $stmt1->bindParam(':contractId', $startDate, PDO::PARAM_STR);
        $stmt1->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt1->bindParam(':endDate', $staffName, PDO::PARAM_STR);
        $stmt1->bindParam(':price', $address, PDO::PARAM_STR);
      }
      //DELETE
      else {
        //prepare template
        $stmt1 = $db->prepare($sqlDelete);
  
        //bind parameters
        $stmt1->bindParam(':contractId', $contractId, PDO::PARAM_STR);     
      }
  
      //execute SQL statement and get result
    $result1 = $stmt1->execute();

    $db = null;
      
      //return result to frontend
    echo $result1;    

    } catch(PDOException $e) {
      echo '{"error":{"text": '.$e->getMessage().'}}';
    }
  });
  


?>