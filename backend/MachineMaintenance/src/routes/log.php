<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/log/byLogType", function(Request $request, Response $response) {
  $sql1 = "SELECT COUNT(logType) AS Info FROM machinelog WHERE logtype='Info' AND YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp) GROUP BY logType";
  $sql2 = "SELECT COUNT(logType) AS Error FROM machinelog WHERE logtype='Error' AND YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp) GROUP BY logType";
  $sql3 = "SELECT COUNT(logType) AS Maintenance FROM machinelog WHERE logtype='Maintenance' AND YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp) GROUP BY logType";
  $sql4 = "SELECT COUNT(logType) AS Repair FROM machinelog WHERE logtype='Repair' AND YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp) GROUP BY logType";
  $sql5 = "SELECT COUNT(logType) AS Other FROM machinelog WHERE logtype='Other' AND YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp) GROUP BY logType";
  $sql6 = "SELECT COUNT(logtype) AS TotalLogGenerated FROM machinelog WHERE YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp)";
  try {
    $db = new db();
    $db = $db->connect();

    $stmt1 = $db->query($sql1);
    $data1 = $stmt1->fetchAll(PDO::FETCH_OBJ);

    $stmt2 = $db->query($sql2);
    $data2 = $stmt2->fetchAll(PDO::FETCH_OBJ);

    $stmt3 = $db->query($sql3);
    $data3 = $stmt3->fetchAll(PDO::FETCH_OBJ);  

    $stmt4 = $db->query($sql4);
    $data4 = $stmt4->fetchAll(PDO::FETCH_OBJ);

    $stmt5 = $db->query($sql5);
    $data5 = $stmt5->fetchAll(PDO::FETCH_OBJ);

    $stmt6 = $db->query($sql6);
    $data6 = $stmt6->fetchAll(PDO::FETCH_OBJ);

    $db = null;

    $data1[0]->Error = $data2[0]->Error;
    $data1[0]->Maintenance = $data3[0]->Maintenance;
    $data1[0]->Repair = $data4[0]->Repair;
    $data1[0]->Other = $data5[0]->Other;
    $data1[0]->TotalLogGenerated = $data6[0]->TotalLogGenerated;

    echo json_encode($data1);

  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->get("/api/log/byMachineType", function(Request $request, Response $response) {
    $sql = "SELECT machineType,COUNT(machineType) AS logGenerated FROM machinelog,machine,machinemodel WHERE machinelog.machineID=machine.machineID AND machine.modelCode = machinemodel.modelCode GROUP BY machineType ORDER BY logGenerated DESC";
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

  $app->get("/api/log/byCustomer", function(Request $request, Response $response) {
    $sql = "SELECT customerName,COUNT(customerName) AS LogGenerated 
    FROM machinelog,customer,contract,machine 
    WHERE machinelog.machineID=machine.machineID AND machine.contractID = contract.contractID AND contract.customerID = customer.customerID
    GROUP BY customerName
    ORDER BY LogGenerated DESC";
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
?>