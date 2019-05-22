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
    $amount = $request->getParsedBody()['amount'];
    $useInModel = $request->getParsedBody()['useInModel'];
    $modelCode = json_decode($useInModel);

    $sqlParts = "INSERT INTO parts (partsID, partsName, pricePerUnit, amount) VALUES (:partsID, :partsName, :pricePerUnit, :amount);";
    $sqlPartsUpdate = "UPDATE parts SET partsName = :partsName, pricePerUnit = :pricePerUnit, amount = :amount WHERE partsID = :partsID";
    $sqlPartsDelete = "DELETE FROM partscompatible WHERE partsID = :partsID;";

    $sqlPartsCompat = "";
    

    try {
        $db = new db();
        $db = $db->connect();

        if($actionType == 0){
            //INSERT

            foreach($modelCode as $idx => $item){
                $sqlPartsCompat .= "INSERT INTO partscompatible (partsID, modelCode) VALUES (:partsID, '".$item."');";
            }

            $stmt = $db->prepare($sqlParts);
            $stmt->bindParam(':partsID', $partsID, PDO::PARAM_STR);
            $stmt->bindParam(':partsName', $partsName, PDO::PARAM_STR);
            $stmt->bindParam(':pricePerUnit', $pricePerUnit, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);

            $stmtA = $db->prepare($sqlPartsCompat);
            $stmtA->bindParam(':partsID', $partsID, PDO::PARAM_STR);

        }
        else if($actionType == 1){
            //UPDATE
            $sqlPartsCompat .= "DELETE FROM partscompatible WHERE partsID = :partsID;";
            foreach($modelCode as $idx => $item){
                $sqlPartsCompat .= "INSERT INTO partscompatible (partsID, modelCode) VALUES (:partsID, '".$item."');";
            }

            $stmt = $db->prepare($sqlPartsUpdate);
            $stmt->bindParam(':partsID', $partsID, PDO::PARAM_STR);
            $stmt->bindParam(':partsName', $partsName, PDO::PARAM_STR);
            $stmt->bindParam(':pricePerUnit', $pricePerUnit, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);

            $stmtA = $db->prepare($sqlPartsCompat);
            $stmtA->bindParam(':partsID', $partsID, PDO::PARAM_STR);
        }
        else{
            //DELETE
            $sqlPartsCompat .= "DELETE FROM parts WHERE partsID = :partsID;";
            
            $stmt = $db->prepare($sqlPartsDelete);
            $stmt->bindParam(':partsID', $partsID, PDO::PARAM_STR);

            $stmtA = $db->prepare($sqlPartsCompat);
            $stmtA->bindParam(':partsID', $partsID, PDO::PARAM_STR);
        }

        //execute SQL statement and get result
        $result = $stmt->execute();
        $result .= $stmtA->execute();
        $db = null;

        //return result to frontend
        echo $result;
    }catch(PDOException $e) {
        echo '{"error":{"text": '.$e->getMessage().'}}';
      }
});

?>