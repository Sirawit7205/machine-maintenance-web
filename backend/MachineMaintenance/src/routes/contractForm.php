<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/contract/getCurrentIds", function(Request $request, Response $response) {
  $sql = "SELECT contractID AS contractId FROM contract ORDER BY contractId";
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

$app->get("/api/contract/count", function(Request $request, Response $response) {
  $sql = "SELECT COUNT(*) AS count FROM contract";
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

$app->get("/api/customer/getCurrentIds", function(Request $request, Response $response) {
  $sql = "SELECT customerID AS customerId, customerName FROM customer ORDER BY customerId";
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

$app->get("/api/existsCustomer/count", function(Request $request, Response $response) {
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
$app->get("/api/contract/all/{contractId}", function(Request $request, Response $response) {
  $contractId = $request->getAttribute('contractId');
  $sql = "SELECT startDate, endDate, price, customerID FROM contract WHERE contractID = \"$contractId\"";
  $sqlCurrentMachineList = "SELECT machineID FROM machine WHERE contractID = \"$contractId\"";
  $sqlAllMachineList = "SELECT machineID FROM machine WHERE contractID = \"$contractId\" OR contractID IS NULL";

  try {
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query($sql);
    $stmtM = $db->query($sqlCurrentMachineList);
    $stmtAM = $db->query($sqlAllMachineList);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    $dataM = $stmtM->fetchAll(PDO::FETCH_OBJ);
    $dataAM = $stmtAM->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    
    @$data[0]->machineList = $dataM;
    @$data[0]->allMachineList = $dataAM;

    echo json_encode($data);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->get("/api/customer/all/{customerId}", function(Request $request, Response $response) {
    $customerId = $request->getAttribute('customerId');
    $sql = "SELECT customerName, address, phone, email FROM customer WHERE customerId=\"$customerId\"";
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
    $contActionType = $request->getParsedBody()['contActionType'];
    $custActionType = $request->getParsedBody()['custActionType'];
    $contractId = $request->getParsedBody()['contractId'];
    $startDate = $request->getParsedBody()['startDate'];
    $endDate = $request->getParsedBody()['endDate'];
    $price = $request->getParsedBody()['price'];
    $customerId = $request->getParsedBody()['customerId'];
    $customerName = $request->getParsedBody()['customerName'];
    $address = $request->getParsedBody()['address'];
    $email = $request->getParsedBody()['email'];
    $phone = $request->getParsedBody()['phone'];
    $transId = $request->getParsedBody()['transId'];
    $transType = $request->getParsedBody()['transType'];
    $details = $request->getParsedBody()['details'];
    $amount = $request->getParsedBody()['amount'];
    $staffId = $request->getParsedBody()['staffId'];



  
    $sqlInsertInsert = "INSERT INTO customer (customerID, customerName, address, phone, email) VALUES (:customerId, :customerName, :address, :phone, :email);
    INSERT INTO contract(contractID,startDate,endDate,price,customerID) VALUES(:contractId,:startDate,:endDate,:price,:customerId);
    INSERT INTO income(transID,timestamp,transType,details,amount,contractID,staffID) VALUES(:transId,CURRENT_TIMESTAMP,:transType,:details,:amount,:contractId,:staffId);";
    $sqlInsertUpdate = "INSERT INTO contract(contractID,startDate,endDate,price,customerID) VALUES(:contractId,:startDate,:endDate,:price,:customerId);
    UPDATE customer SET customerName=:customerName,address=:address,email=:email,phone=:phone WHERE customerID=:customerId;
    INSERT INTO income(transID,timestamp,transType,details,amount,contractID,staffID) VALUES(:transId,CURRENT_TIMESTAMP,:transType,:details,:amount,:contractId,:staffId);";
    $sqlUpdate = "UPDATE contract SET startDate = :startDate, endDate = :endDate, price = :price WHERE contractID = :contractId;
    UPDATE customer SET customerName=:customerName,address=:address,email=:email,phone=:phone WHERE customerID=:customerId;
    UPDATE income SET timestamp=CURRENT_TIMESTAMP,transType=:transType,details=:details,amount=:amount,staffID=:staffId WHERE transID=:transId;";
    $sqlDelete = "DELETE FROM income WHERE transID=:transId;
    DELETE FROM contract WHERE contractID = :contractId;";
    
    try {
      $db = new db();
      $db = $db->connect();


      //INSERT BOTH
      if($contActionType == 0 && $custActionType == 0) {
        //prepare template
        $stmt = $db->prepare($sqlInsertInsert);
  
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
        $stmt->bindParam(':transId', $transId, PDO::PARAM_STR);
        $stmt->bindParam(':transType', $transType, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindParam(':staffId',$staffId,PDO::PARAM_STR);

      }
      //INSERT CONT UPDATE CUST
      else if($contActionType == 0 && $custActionType == 1) {
        //prepare template
        $stmt = $db->prepare($sqlInsertUpdate);
  
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
      //UPDATE CONT UPDATE CUST
      else if($contActionType == 1) {
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
        $stmt->bindParam(':transId', $transId, PDO::PARAM_STR);
        $stmt->bindParam(':transType', $transType, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindParam(':staffId',$staffId,PDO::PARAM_STR);

      }
      //DELETE
      else {
        //prepare template
        $stmt = $db->prepare($sqlDelete);
  
        //bind parameters
        $stmt->bindParam(':transId', $transId, PDO::PARAM_STR);     
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
  
    $sqlInsert = "INSERT INTO machine(machineID,modelCode,serialNumber,serviceType,notes,status) VALUES(:machineId,:modelCode,:serialNumber,:serviceType,:notes,:status)";
    $sqlUpdate = "UPDATE machine SET modelCode=:modelCode,serialNumber=:serialNumber,serviceType=:serviceType,notes=:notes,status=:status WHERE machineID = :machineId";
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
      }
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