<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/machine/details", function(Request $request, Response $response) {
    $sqlA = "SELECT mc.machineID, mc.serialNumber, md.modelNumber, md.machineType FROM machine mc, machinemodel md WHERE mc.modelCode = md.modelCode ORDER BY mc.machineID";
    $sqlB = "SELECT mc.machineID, COUNT(ml.machineID) AS TotalBreakdown FROM machinelog ml,machine mc WHERE ml.machineID = mc.machineID AND ml.logType = 'error' AND YEAR(ml.timestamp) = YEAR(NOW()) GROUP BY ml.machineID ORDER BY mc.machineID";
    $sqlC = "SELECT details FROM machinelog WHERE timestamp IN (SELECT MAX(timestamp) FROM machinelog WHERE logType = 'Error' GROUP BY machineID) GROUP BY machineID ORDER BY machineID";
    $sqlD = "SELECT MAX(severity) AS maxSeverity, AVG(severity) AS avgSeverity FROM job GROUP BY machineID ORDER BY machineID";
    $sqlE = "SELECT timestamp AS lastCheck FROM machinelog WHERE timestamp IN (SELECT MAX(timestamp) FROM machinelog WHERE logType = 'Maintenance' GROUP BY machineID) GROUP BY machineID ORDER BY machineID";
    $sqlF = "SELECT AVG(TIMESTAMPDIFF(HOUR,TIMESTAMP(date,startTime),TIMESTAMP(endDate,endTime))) AS avgDowntime FROM job GROUP BY machineID ORDER by machineID";
    try {
      $db = new db();
      $db = $db->connect();
  
      $stmtA = $db->query($sqlA);
      $dataA = $stmtA->fetchAll(PDO::FETCH_OBJ);
      $stmtB = $db->query($sqlB);
      $dataB = $stmtB->fetchAll(PDO::FETCH_OBJ);
      $stmtC = $db->query($sqlC);
      $dataC = $stmtC->fetchAll(PDO::FETCH_OBJ);
      $stmtD = $db->query($sqlD);
      $dataD = $stmtD->fetchAll(PDO::FETCH_OBJ);
      $stmtE = $db->query($sqlE);
      $dataE = $stmtE->fetchAll(PDO::FETCH_OBJ);
      $stmtF = $db->query($sqlF);
      $dataF = $stmtF->fetchAll(PDO::FETCH_OBJ);
      $db = null;

      foreach($dataA as $idx => $item){
          @$item -> totalBreakdown = $dataB[$idx] -> TotalBreakdown;
          $item -> lastBreakReason = $dataC[$idx] -> details;
          $item -> maxSeverity = $dataD[$idx] -> maxSeverity;
          $item -> avgSeverity = $dataD[$idx] -> avgSeverity;
          @$item -> lastCheck = $dataE[$idx] -> lastCheck;
          $item -> avgDowntime = $dataF[$idx] -> avgDowntime;
      }

      echo json_encode($dataA);
    } catch(PDOException $e) {
      echo '{"error":{"text": '.$e->getMessage().'}}';
    }
  });

?>