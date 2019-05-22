<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/partsInOut/getCurrentId", function(Request $request, Response $response) {
    $sql = "SELECT partsID AS partsId, partsName FROM parts ORDER BY partsID";
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

$app->get("/api/partsInOut/count", function(Request $request, Response $response) {
  $sql = "SELECT COUNT(DISTINCT pi.partsinID) AS piCount, COUNT(DISTINCT po.partsOutID) AS poCount, COUNT(DISTINCT e.transID) AS toCount FROM partstransin pi, partstransout po, expense e";
  try {
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    $data[0]->piCount = sprintf('%04d', $data[0]->piCount + 1);
    $data[0]->poCount = sprintf('%04d', $data[0]->poCount + 1);
    $data[0]->toCount = sprintf('%04d', $data[0]->toCount + 1);

    echo json_encode($data);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->post("/api/partsInOut/submit", function(Request $request, Response $response){
    $partsID = $request->getParsedBody()['partsId'];
    $partsInID = $request->getParsedBody()['partsInId'];
    $partsOutID = $request->getParsedBody()['partsOutId'];
    $transOutID = $request->getParsedBody()['transOutId'];
    $partsType = $request->getParsedBody()['partsType'];
    $amount = $request->getParsedBody()['amount'];
    $details = $request->getParsedBody()['details'];
    $staffID = $request->getParsedBody()['staffId'];

    $sqlPartIn = "INSERT INTO partstransin (partsinID, timestamp, partsID, details, amount, staffID) VALUES (:partsInID, CURRENT_TIMESTAMP, :partsID, :details, :amount, :staffID); UPDATE parts SET amount = amount + :amount WHERE partsID = :partsID;
                  INSERT INTO expense (transID, transType, details, amount, partsID, staffID) VALUES (:transOutID, \"Parts\", \"Parts Purchase\", (SELECT pricePerUnit FROM parts WHERE partsID = :partsID) * :amount, :partsID, :staffID)";
    $sqlPartOut = "INSERT INTO partstransout (partsOutID, timestamp, partsID, details, amount, staffID) VALUES (:partsOutID, CURRENT_TIMESTAMP, :partsID, :details, :amount, :staffID); UPDATE parts SET amount = amount - :amount WHERE partsID = :partsID";

    try {
        $db = new db();
        $db = $db->connect();

        if($partsType == "in"){
            $stmt = $db->prepare($sqlPartIn);
            $stmt->bindParam(':partsInID', $partsInID, PDO::PARAM_STR);
            $stmt->bindParam(':partsID', $partsID, PDO::PARAM_STR);
            $stmt->bindParam(':details', $details, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
            $stmt->bindParam(':staffID', $staffID, PDO::PARAM_STR);
            $stmt->bindParam(':transOutID', $transOutID, PDO::PARAM_STR);
        }
        else if($partsType == "out"){
            $stmt = $db->prepare($sqlPartOut);
            $stmt->bindParam(':partsOutID', $partsOutID, PDO::PARAM_STR);
            $stmt->bindParam(':partsID', $partsID, PDO::PARAM_STR);
            $stmt->bindParam(':details', $details, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
            $stmt->bindParam(':staffID', $staffID, PDO::PARAM_STR);
        }

        //execute SQL statement and get result
        $result = $stmt->execute();
        $db = null;

        //return result to frontend
        echo $result;
    }catch(PDOException $e) {
        echo '{"error":{"text": '.$e->getMessage().'}}';
      }
});

?>