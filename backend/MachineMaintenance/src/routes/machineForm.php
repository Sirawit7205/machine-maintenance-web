<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/machine/getCurrentIds", function(Request $request, Response $response) {
  $sql = "SELECT machineID AS machineId FROM machine ORDER BY machineId";
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

$app->get("/api/machine/count", function(Request $request, Response $response) {
  $sql = "SELECT COUNT(*) AS count FROM machine";
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

$app->get("/api/machine/getAllModels", function(Request $request, Response $response) {
  $sql = "SELECT modelCode, modelNumber FROM machinemodel";
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

$app->get("/api/machine/all/{machineId}", function(Request $request, Response $response) {
  $machineId = $request->getAttribute('machineId');
  $sqlA = "SELECT serialNumber, serviceType, notes, status FROM machine WHERE machineID = \"$machineId\"";
  $sqlB = "SELECT m.modelCode, mm.modelNumber FROM machine m, machinemodel mm WHERE m.modelCode = mm.modelCode AND m.machineID = \"$machineId\"";
  $sqlC = "SELECT modelCode, modelNumber FROM machinemodel";

  try {
    $db = new db();
    $db = $db->connect();

    $stmtA = $db->query($sqlA);
    $dataA = $stmtA->fetchAll(PDO::FETCH_OBJ);
    $stmtB = $db->query($sqlB);
    $dataB = $stmtB->fetchAll(PDO::FETCH_OBJ);
    $stmtC = $db->query($sqlC);
    $dataC = $stmtC->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    @$dataA[0] -> currentModel = $dataB;
    @$dataA[0] -> allModel = $dataC;

    echo json_encode($dataA);
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

$app->get("/api/machineModel/count", function(Request $request, Response $response) {
  $sql = "SELECT COUNT(*) AS count FROM machinemodel";
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