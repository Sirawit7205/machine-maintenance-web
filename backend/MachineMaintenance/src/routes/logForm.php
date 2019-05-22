<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post("/api/log/submit", function(Request $request, Response $response) {
  $actionType = $request->getParsedBody()['actionType'];
  $logType = $request->getParsedBody()['logType'];
  $subLogType = $request->getParsedBody()['subLogType'];
  $details = $request->getParsedBody()['details'];

  if($logType == "case"){
    $jobID = $request->getParsedBody()['jobId'];
    $startDate = $request->getParsedBody()['startDate'];
    $startTime = $request->getParsedBody()['startTime'];
    $endDate = $request->getParsedBody()['endDate'];
    $endTime = $request->getParsedBody()['endTime'];
    $estDuration = $request->getParsedBody()['estDuration'];
    $machineID = $request->getParsedBody()['machineId'];
    $priority = $request->getParsedBody()['priority'];
    $severity = $request->getParsedBody()['severity'];
    $jobStatus = $request->getParsedBody()['jobStatus'];
  }
  else if($logType == "mach"){
    $logID = $request->getParsedBody()['logId'];
    $machineID = $request->getParsedBody()['machineId'];
  }
  else if($logType == "main"){
    $logID = $request->getParsedBody()['logId'];
    $jobID = $request->getParsedBody()['jobId'];
  }
  
  
  //$machine = $request->getParsedBody()['machine'];
  //$details = $request->getParsedBody()['details'];
  //$startDate = $request->getParsedBody()['startDate'];
  //$startTime = $request->getParsedBody()['startTime'];

  //not in frontend
  //$machineID = $request->getParsedBody()['machineId'];
  //$jobID = $request->getParsedBody()['jobId'];
  //$logID = $request->getParsedBody()['logId'];
  //$priority = $request->getParsedBody()['priority'];
  //$severity = $request->getParsedBody()['severity'];
  //$endDate = $request->getParsedBody()['endDate'];
  //$endTime = $request->getParsedBody()['endTime'];
  //$estDuration = $request->getParsedBody()['estDuration'];
  //$jobStatus = $request->getParsedBody()['jobStatus'];

  $sqlCaseReport = "INSERT INTO job (jobID, jobType, date, startTime, endDate, endTime, estimateDuration, machineID, details, priority, severity, jobStatus) VALUES (:jobID, :subLogType, :startDate, :startTime, NULL, NULL, :estDuration, :machineID, :details, :priority, :severity, 'Pending')";
  $sqlMachineLog = "INSERT INTO machinelog (logID, timestamp, logType, details, machineID) VALUES (:logID, CURRENT_TIMESTAMP, :subLogType, :details, :machineID)";
  $sqlOperationLog = "INSERT INTO operationlog (logID, timestamp, logType, details, jobID) VALUES (:logID, CURRENT_TIMESTAMP, :subLogType, :details, :jobID)";
  $sqlCaseUpdate = "UPDATE job SET jobType = :subLogType, date = :startDate, startTime = :startTime, endDate = :endDate, endTime = :endTime, estimateDuration = :estimateDuration, machineID = :machineID, details = :details, priority = :priority, severity = :severity, jobStatus = :jobStatus WHERE jobID = :jobID";
  $sqlMachLogUpdate = "UPDATE machinelog SET timestamp = CURRENT_TIMESTAMP, logType = :subLogType, details = :details, machineID = :machineID WHERE logID = :logID";
  $sqlOperationUpdate = "UPDATE operationlog SET timestamp = CURRENT_TIMESTAMP, logType = :subLogType, details = :details, jobID = :jobID WHERE logID = :lodID";
  $sqlCaseDelete = "DELETE FROM job WHERE jobID = :jobID";
  $sqlMachLogDelete = "DELETE FROM machinelog WHERE logID = :logID";
  $sqlOperationDelete = "DELETE FROM operationlog WHERE logID = :logID";

  try {
    $db = new db();
    $db = $db->connect();

    if($actionType == 0) {
      //INSERT
      if($logType == "case"){
        $stmt = $db->prepare($sqlCaseReport);
        $stmt->bindParam(':jobID', $jobID, PDO::PARAM_STR);
        $stmt->bindParam(':subLogType', $subLogType, PDO::PARAM_STR);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
        $stmt->bindParam(':estDuration', $estDuration, PDO::PARAM_STR);
        $stmt->bindParam(':machineID', $machineID, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':priority', $priority, PDO::PARAM_INT);
        $stmt->bindParam(':severity', $severity, PDO::PARAM_INT);
      }
      else if($logType == 'mach'){
        $stmt = $db->prepare($sqlMachineLog);
        $stmt->bindParam(':logID', $logID, PDO::PARAM_STR);
        $stmt->bindParam(':subLogType', $subLogType, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':machineID', $machineID, PDO::PARAM_STR);
      }
      else if($logType == 'main'){
        $stmt = $db->prepare($sqlOperationLog);
        $stmt->bindParam(':logID', $logID, PDO::PARAM_STR);
        $stmt->bindParam(':subLogType', $subLogType, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':jobID', $jobID, PDO::PARAM_STR);
      }

    }
    else if($actionType == 1) {
      //UPDATE
      if($logType == "case"){
        $stmt = $db->prepare($sqlCaseUpdate);
        $stmt->bindParam(':jobID', $jobID, PDO::PARAM_STR);
        $stmt->bindParam(':subLogType', $subLogType, PDO::PARAM_STR);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':endTime', $endTime, PDO::PARAM_STR);
        $stmt->bindParam(':estDuration', $estDuration, PDO::PARAM_STR);
        $stmt->bindParam(':machineID', $machineID, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':priority', $priority, PDO::PARAM_STR);
        $stmt->bindParam(':severity', $severity, PDO::PARAM_STR);
        $stmt->bindParam(':jobStatus', $jobStatus, PDO::PARAM_STR);
      }
      else if($logType == "mach"){
        $stmt = $db->prepare($sqlMachLogUpdate);
        $stmt->bindParam(':logID', $logID, PDO::PARAM_STR);
        $stmt->bindParam(':subLogType', $subLogType, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':machineID', $machineID, PDO::PARAM_STR);
      }
      else if($logType == "main"){
        $stmt = $db->prepare($sqlOperationUpdate);
        $stmt->bindParam(':logID', $logID, PDO::PARAM_STR);
        $stmt->bindParam(':subLogType', $subLogType, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':jobID', $jobID, PDO::PARAM_STR);
      }
    }
    else {
      //DELETE
      if($logType == "case"){
        $stmt = $db->prepare($sqlCaseDelete);
        $stmt->bindParam(':jobID', $jobID, PDO::PARAM_STR);
      }
      else if($logType == "mach"){
        $stmt = $db->prepare($sqlMachLogDelete);
        $stmt->bindParam(':logID', $logID, PDO::PARAM_STR);
      }
      else if($logType == "main"){
        $stmt = $db->prepare($sqlOperationDelete);
        $stmt->bindParam(':logID', $logID, PDO::PARAM_STR);
      }
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