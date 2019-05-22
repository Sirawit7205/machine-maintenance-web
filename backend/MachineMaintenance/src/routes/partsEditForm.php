<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/partsEdit/getCurrentIds", function(Request $request, Response $response) {
    $sql = "SELECT partsID AS partsId, partsName FROM parts ORDER BY partsId";
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
  
  $app->get("/api/partsEdit/count", function(Request $request, Response $response) {
    $sql = "SELECT COUNT(*) AS count FROM parts";
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

$app->get("/api/partsEdit/all/{partsId}", function(Request $request, Response $response) {
    $partsId = $request->getAttribute('partsId');
    $sqlA = "SELECT partsName, pricePerUnit FROM parts WHERE partsID = \"$partsId\"";
    $sqlB = "SELECT pc.modelCode, mm.modelNumber FROM partscompatible pc, machinemodel mm WHERE pc.modelCode = mm.modelCode AND partsID = \"$partsId\"";
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

      @$dataA[0] -> useInModel = $dataB;
      @$dataA[0] -> allModel = $dataC;

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
    $modelCode = json_decode(json_encode($useInModel), true);

    $sqlParts = "INSERT INTO parts (partsID, partsName, pricePerUnit, amount) VALUES (:partsID, :partsName, :pricePerUnit, 0);";
    $sqlPartsUpdate = "UPDATE parts SET partsName = :partsName, pricePerUnit = :pricePerUnit WHERE partsID = :partsID";
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