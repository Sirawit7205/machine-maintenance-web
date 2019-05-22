<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/partsEdit/getCurrentId", function(Request $request, Response $response) {
    $sqlA = "SELECT partsName, pricePerUnit FROM parts WHERE partsID = \"$partsId\"";
    $sqlB = "SELECT modelCode FROM partscompatible WHERE partsID = \"$partsId\"";

    try {
      $db = new db();
      $db = $db->connect();
  
      $stmtA = $db->query($sqlA);
      $dataA = $stmtA->fetchAll(PDO::FETCH_OBJ);
      $stmtB = $db->query($sqlB);
      $dataB = $stmtB->fetchAll(PDO::FETCH_OBJ);
      $db = null;

      $dataA[0] -> usedModel = $dataB -> modelCode;

      echo json_encode($dataA);
    } catch(PDOException $e) {
      echo '{"error":{"text": '.$e->getMessage().'}}';
    }
  });

$app->post("/api/partsEdit/submit", function(Request $request, Response $response){
    $actionType = $request->getParsedBody()['actionType'];
    $partsID = $request->getParsedBody()['partsId'];
    $partsName = $request->getParsedBody()['partsName'];
    $pricePerUnit = $request->getParsedBody()['pricePerUnit'];
    $useInModel = $request->getParsedBody()['useInModel'];
    
    try {
        $db = new db();
        $db = $db->connect();

        if($actionType == 0){
            //INSERT
            
        }
        else if($actionType == 1){
            //UPDATE
            
        }
        else{
            //DELETE
            
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