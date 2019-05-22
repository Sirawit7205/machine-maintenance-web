<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post("/api/job/submit", function(Request $request, Response $response) {
    $actionType = $request->getParsedBody()['actionType'];
    $jobId = $request->getParsedBody()['jobId'];
    $jobType = $request->getParsedBody()['jobType'];    
    $date = $request->getParsedBody()['date'];
    $startTime = $request->getParsedBody()['startTime'];
    $endDate = $request->getParsedBody()['endDate'];
    $endTime = $request->getParsedBody()['endTime'];
    $estimateDuration = $request->getParsedBody()['estimateDuration'];
    $machineId = $request->getParsedBody()['machineId'];
    $details = $request->getParsedBody()['details'];
    $priority = $request->getParsedBody()['priority'];  
    $severity = $request->getParsedBody()['severity'];
    $jobStatus = $request->getParsedBody()['jobStatus']; //job status
    $status = $request->getParsedBody()['status']; //machine status


    $sqlInsert = "INSERT INTO job(jobID,jobType,date,startTime,endDate,endTime,estimateDuration,machineID,details,priority,severity,jobStatus) VALUES(:jobId,:jobType,:date,:startTime,:endDate,:endTime,:estimateDuration,:machineId,:details,:priority,:severity,:jobStatus);
    UPDATE machine SET status=:status WHERE machineID = :machineId;";
    $sqlUpdate = "UPDATE job SET jobType=:jobType,date=:date,startTime=:startTime,endDate=:endDate,endTime=:endTime,estimateDuration=:estimateDuration,machineID=:machineId,details=:details,priority=:priority,severity=:severity,jobStatus=:jobStatus WHERE jobID = :jobId;
    UPDATE machine SET status=:status WHERE machineID = :machineId;";
    $sqlDelete = "DELETE FROM job WHERE jobID = :jobId";
    
    try {
      $db = new db();
      $db = $db->connect();


      //INSERT
      if($actionType == 0) {
        //prepare template
        $stmt = $db->prepare($sqlInsert);
  
        //bind parameters
        $stmt->bindParam(':jobId', $jobId, PDO::PARAM_STR);
        $stmt->bindParam(':jobType', $jobType, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':endTime', $endTime, PDO::PARAM_STR);
        $stmt->bindParam(':estimateDuration', $estimateDuration, PDO::PARAM_INT);
        $stmt->bindParam(':machineId', $machineId, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':priority', $priority, PDO::PARAM_INT);
        $stmt->bindParam(':severity', $severity, PDO::PARAM_INT);
        $stmt->bindParam(':jobStatus', $jobStatus, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

    }
      //UPDATE
      else if($actionType == 1) {
        //prepare template
        $stmt = $db->prepare($sqlUpdate);
  
        //bind parameters
        $stmt->bindParam(':jobId', $jobId, PDO::PARAM_STR);
        $stmt->bindParam(':jobType', $jobType, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':endTime', $endTime, PDO::PARAM_STR);
        $stmt->bindParam(':estimateDuration', $estimateDuration, PDO::PARAM_INT);
        $stmt->bindParam(':machineId', $machineId, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':priority', $priority, PDO::PARAM_INT);
        $stmt->bindParam(':severity', $severity, PDO::PARAM_INT);
        $stmt->bindParam(':jobStatus', $jobStatus, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    }
      //DELETE
      else {
        //prepare template
        $stmt = $db->prepare($sqlDelete);
  
        //bind parameters
        $stmt->bindParam(':jobId', $jobId, PDO::PARAM_STR);     
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


$app->post("/api/assignment/submit", function(Request $request, Response $response) {
    $actionType = $request->getParsedBody()['actionType'];
    $jobId = $request->getParsedBody()['jobId'];
    $staffId = $request->getParsedBody()['staffId'];

    $sqlInsert = "INSERT INTO assignment(jobID,staffID) VALUES(:jobId,:staffId)";
    $sqlDelete = "DELETE FROM assignment WHERE jobID=:jobId AND staffID=:staffId";
    
    try {
      $db = new db();
      $db = $db->connect();


      //INSERT
      if($actionType == 0) {
        //prepare template
        $stmt = $db->prepare($sqlInsert);
  
        //bind parameters
        $stmt->bindParam(':jobId', $jobId, PDO::PARAM_STR);
        $stmt->bindParam(':staffId', $staffId, PDO::PARAM_STR);

        $result = $stmt->execute();
      }
      //UPDATE
      else if($actionType == 1) {
        $staffId = json_decode($staffId);
        $sqlUpdate = "DELETE FROM assignment WHERE jobID=:jobId;";
        foreach($staffId as $idx => $item){
          $sqlUpdate .= "INSERT INTO assignment(jobID,staffID) VALUES(:jobId,'".$item."');";
        }
        echo $sqlUpdate;

        $stmt = $db->prepare($sqlUpdate);
        $stmt->bindParam(':jobId', $jobId, PDO::PARAM_STR);

        $result = $stmt->execute();

      }
      //DELETE
      else {
        //prepare template
        $stmt = $db->prepare($sqlDelete);
  
        //bind parameters
        $stmt->bindParam(':jobId', $jobId, PDO::PARAM_STR);     
        $stmt->bindParam(':staffId', $staffId, PDO::PARAM_STR);     

        $result = $stmt->execute();
      }
  
    $db = null;
      
      //return result to frontend
    echo $result;

    } catch(PDOException $e) {
      echo '{"error":{"text": '.$e->getMessage().'}}';
    }
  });


?>