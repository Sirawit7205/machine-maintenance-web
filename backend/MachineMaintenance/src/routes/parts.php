<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/parts/compat/{partsId}", function(Request $request, Response $response) {
  $partsId = $request->getAttribute('partsId');
  $sql = "SELECT mm.modelNumber, mm.machineType FROM partscompatible pc, machinemodel mm WHERE pc.modelCode = mm.modelCode AND pc.partsID = \"$partsId\"";
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

$app->get("/api/parts/list", function(Request $request, Response $response) {
  $sql = "SELECT p.partsID AS partsId, p.partsName, p.pricePerUnit AS price, p.amount AS stockAmount, SUM(pt.amount) AS usedAmount
  FROM parts p LEFT JOIN partstransout pt ON p.partsID = pt.partsID
  WHERE YEAR(NOW()) = YEAR(pt.timestamp) AND MONTH(NOW()) = MONTH(pt.timestamp)
  GROUP BY p.partsID";

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