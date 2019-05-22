<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/partsInOut/getCurrentId", function(Request $request, Response $response) {
    $sql = "SELECT partsName FROM parts WHERE partsID = \"$partsID\"";
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

$app->post("/api/partsInOut/submit", function(Request $request, Response $response){
    $partsType = $request->getParsedBody()['partsType'];
    $partsID = $request->getParsedBody()['partsId'];
    $partsName = $request->getParsedBody()['partsName'];
    $amount = $request->getParsedBody()['amount'];
    $details = $request->getParsedBody()['details'];
    $staffID = $request->getParsedBody()['staffId'];

    if($partsType == "in") $partsinID = $request->getParsedBody()['partsinId'];
    else if($partsType == "out") $partsOutID = $request->getParsedBody()['partsOutId'];

    $sqlPartIn = "INSERT INTO partstransin (partsinID, timestamp, partsID, details, amount, staffID) VALUES (:partsinID, CURRENT_TIMESTAMP, :partsID, :details, :amount, :staffID); UPDATE parts SET amount = amount + :amount WHERE partsID = :partsID";
    $sqlPartOut = "INSERT INTO partstransout (partsOutID, timestamp, partsID, details, amount, staffID) VALUES (:partsOutID, CURRENT_TIMESTAMP, :partsID, :details, :amount, :staffID); UPDATE parts SET amount = amount - :amount WHERE partsID = :partsID";

    try {
        $db = new db();
        $db = $db->connect();

        if($partsType == "in"){
            $stmt = $db->prepare($sqlPartIn);
            $stmt->bindParam(':partsinID', $partsinID, PDO::PARAM_STR);
            $stmt->bindParam(':partsID', $partsID, PDO::PARAM_STR);
            $stmt->bindParam(':details', $details, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
            $stmt->bindParam(':staffID', $staffID, PDO::PARAM_STR);
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