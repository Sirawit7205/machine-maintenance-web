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
    
  
    $sqlInsert = "INSERT INTO contract(contractID,startDate,endDate,price,customerID) VALUES(:contractId,:startDate,:endDate,:price,:customerId);
    UPDATE customer SET customerName=:customerName,address=:address,email=:email,phone=:phone WHERE customerID=:customerId;";
    $sqlUpdate = "UPDATE contract SET startDate = :startDate, endDate = :endDate, price = :price WHERE contractID = :contractId;
    UPDATE customer SET customerName=:customerName,address=:address,email=:email,phone=:phone WHERE customerID=:customerId;";
    $sqlDelete = "DELETE FROM contract WHERE contractID = :contractId";
    
    try {
      $db = new db();
      $db = $db->connect();


      //INSERT
      if($actionType == 0) {
        //prepare template
        $stmt = $db->prepare($sqlInsert);
  
        //bind parameters
        $stmt->bindParam(':contractId', $contractId, PDO::PARAM_STR);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':customerId',$customerId,PDO::PARAM_STR);
        $stmt->bindParam(':customerName', $customerName, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);        
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
      }
      //UPDATE
      else if($actionType == 1) {
        //prepare template
        $stmt = $db->prepare($sqlUpdate);
  
        //bind parameters
        $stmt->bindParam(':contractId', $contractId, PDO::PARAM_STR);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':customerId',$customerId,PDO::PARAM_STR);
        $stmt->bindParam(':customerName', $customerName, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);        
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
      }
      //DELETE
      else {
        //prepare template
        $stmt = $db->prepare($sqlDelete);
  
        //bind parameters
        $stmt->bindParam(':contractId', $contractId, PDO::PARAM_STR);     
      }
  
      //execute SQL statement and get result
    
    $result = $stmt->execute();

    $db = null;
      
      //return result to frontend
    echo $result;

    } catch(PDOException $e) {
      echo '{"error":{"text": '.$e->getMessage().'}}';
    }
  });
  
$app->post("/api/machine/submit", function(Request $request, Response $response) {
    $actionType = $request->getParsedBody()['actionType'];
    $machineId = $request->getParsedBody()['machineId'];
    $modelCode = $request->getParsedBody()['modelCode'];
    $serialNumber = $request->getParsedBody()['serialNumber'];
    $serviceType = $request->getParsedBody()['serviceType'];
    $notes = $request->getParsedBody()['notes'];  
    $status = $request->getParsedBody()['status'];
    $contractId = $request->getParsedBody()['contractId'];
    
  
    $sqlInsert = "INSERT INTO machine(machineID,modelCode,serialNumber,serviceType,notes,status,contractID) VALUES(:machineId,:modelCode,:serialNumber,:serviceType,:notes,:status,:contractId)";
    $sqlUpdate = "UPDATE machine SET modelCode=:modelCode,serialNumber=:serialNumber,serviceType=:serviceType,notes=:notes,status=:status,contractID=:contractId WHERE machineID = :machineId";
    $sqlDelete = "DELETE FROM machine WHERE machineID = :machineId";
    
    try {
      $db = new db();
      $db = $db->connect();


      //INSERT
      if($actionType == 0) {
        //prepare template
        $stmt = $db->prepare($sqlInsert);
  
        //bind parameters
        $stmt->bindParam(':machineId', $machineId, PDO::PARAM_STR);
        $stmt->bindParam(':modelCode', $modelCode, PDO::PARAM_STR);
        $stmt->bindParam(':serialNumber', $serialNumber, PDO::PARAM_STR);
        $stmt->bindParam(':serviceType', $serviceType, PDO::PARAM_STR);
        $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':contractId', $contractId, PDO::PARAM_STR);
      }
      //UPDATE
      else if($actionType == 1) {
        //prepare template
        $stmt = $db->prepare($sqlUpdate);
  
        //bind parameters
        $stmt->bindParam(':machineId', $machineId, PDO::PARAM_STR);
        $stmt->bindParam(':modelCode', $modelCode, PDO::PARAM_STR);
        $stmt->bindParam(':serialNumber', $serialNumber, PDO::PARAM_STR);
        $stmt->bindParam(':serviceType', $serviceType, PDO::PARAM_STR);
        $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':contractId', $contractId, PDO::PARAM_STR);      }
      //DELETE
      else {
        //prepare template
        $stmt = $db->prepare($sqlDelete);
  
        //bind parameters
        $stmt->bindParam(':machineId', $machineId, PDO::PARAM_STR);     
      }
  
      //execute SQL statement and get result
    
    $result = $stmt->execute();

    $db = null;
      
      //return result to frontend
    echo $result;

    } catch(PDOException $e) {
      echo '{"error":{"text": '.$e->getMessage().'}}';
    }
  });

  $app->post("/api/machineModel/submit", function(Request $request, Response $response) {
    $actionType = $request->getParsedBody()['actionType'];
    $modelCode = $request->getParsedBody()['modelCode'];
    $modelNumber = $request->getParsedBody()['modelNumber'];
    $machineType = $request->getParsedBody()['machineType'];    
  
    $sqlInsert = "INSERT INTO machinemodel(modelCode,modelNumber,machineType) VALUES(:modelCode,:modelNumber,:machineType)";
    $sqlUpdate = "UPDATE machinemodel SET modelNumber=:modelNumber,machineType=:machineType WHERE modelCode = :modelCode";
    $sqlDelete = "DELETE FROM machinemodel WHERE modelCode = :modelCode";
    
    try {
      $db = new db();
      $db = $db->connect();


      //INSERT
      if($actionType == 0) {
        //prepare template
        $stmt = $db->prepare($sqlInsert);
  
        //bind parameters
        $stmt->bindParam(':modelCode', $modelCode, PDO::PARAM_STR);
        $stmt->bindParam(':modelNumber', $modelNumber, PDO::PARAM_STR);
        $stmt->bindParam(':machineType', $machineType, PDO::PARAM_STR);
      }
      //UPDATE
      else if($actionType == 1) {
        //prepare template
        $stmt = $db->prepare($sqlUpdate);
  
        //bind parameters
            $sqlUpdate = "UPDATE machinemodel SET modelNumber=:modelNumber,machineType=:machineType WHERE modelCode = :modelCode";

        $stmt->bindParam(':modelCode', $modelCode, PDO::PARAM_STR);
        $stmt->bindParam(':modelNumber', $modelNumber, PDO::PARAM_STR);
        $stmt->bindParam(':machineType', $machineType, PDO::PARAM_STR);
      }
      //DELETE
      else {
        //prepare template
        $stmt = $db->prepare($sqlDelete);
  
        //bind parameters
        $stmt->bindParam(':modelCode', $modelCode, PDO::PARAM_STR);     
      }
  
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