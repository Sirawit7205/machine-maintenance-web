<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/log/byLogType", function(Request $request, Response $response) {
  $sql1 = "SELECT COUNT(logType) AS info FROM machinelog WHERE logtype='Info' AND YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp) GROUP BY logType";
  $sql2 = "SELECT COUNT(logType) AS error FROM machinelog WHERE logtype='Error' AND YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp) GROUP BY logType";
  $sql3 = "SELECT COUNT(logType) AS maintenance FROM machinelog WHERE logtype='Maintenance' AND YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp) GROUP BY logType";
  $sql4 = "SELECT COUNT(logType) AS repair FROM machinelog WHERE logtype='Repair' AND YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp) GROUP BY logType";
  $sql5 = "SELECT COUNT(logType) AS other FROM machinelog WHERE logtype='Other' AND YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp) GROUP BY logType";
  $sql6 = "SELECT COUNT(logtype) AS totalLogGenerated FROM machinelog WHERE YEAR(NOW()) = YEAR(timestamp) AND MONTH(NOW()) = MONTH(timestamp)";
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

    @$data1[0]->info = is_null($data1[0]->info) ? 0 : $data1[0]->info;
    @$data1[0]->error = is_null($data2[0]->error) ? 0 : $data2[0]->error;
    @$data1[0]->maintenance = is_null($data3[0]->maintenance) ? 0 : $data3[0]->maintenance;
    @$data1[0]->repair = is_null($data4[0]->repair) ? 0 : $data4[0]->repair;
    @$data1[0]->other = is_null($data5[0]->other) ? 0 : $data5[0]->other;
    @$data1[0]->total = is_null($data6[0]->totalLogGenerated) ? 0 : $data6[0]->totalLogGenerated;

    echo json_encode($data1);

  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->get("/api/log/byMachineType", function(Request $request, Response $response) {
    $sql = "SELECT machineType,COUNT(machineType) AS logCount FROM machinelog,machine,machinemodel WHERE machinelog.machineID=machine.machineID AND machine.modelCode = machinemodel.modelCode GROUP BY machineType";
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
    $sql = "SELECT customerName,COUNT(customerName) AS logCount
    FROM machinelog,customer,contract,machine 
    WHERE machinelog.machineID=machine.machineID AND machine.contractID = contract.contractID AND contract.customerID = customer.customerID
    GROUP BY customer.customerID";
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