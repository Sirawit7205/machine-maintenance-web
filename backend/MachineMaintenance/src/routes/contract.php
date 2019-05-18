<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class pieChartClass {
  var $datasets;
  var $labels;

  function convertToPie($data) {
    foreach($data as $idx=>$item) {
      $this->datasets[0]->data[$idx] = $item->avgContractType;
      $this->datasets[0]->backgroundColor[$idx] = rand_color();
      $this->labels[$idx] = $item->machineType;
    }
  }
}

function rand_color() {
  return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

$app->get("/api/contract/summary", function(Request $request, Response $response) {
  $chartData = new pieChartClass;
  $sqlA = "SELECT COUNT(c.contractID) AS total, AVG(c.price) AS avgContractPrice, ROUND(AVG(DATEDIFF(c.endDate, c.startDate)) /30, 2) AS avgContractDur FROM contract c";
  $sqlB = "SELECT AVG(contractCount) AS avgContractCust FROM ( SELECT COUNT(contractID) AS contractCount FROM contract GROUP BY customerID ) aggTable";
  $sqlC = "SELECT mm.machineType, AVG(c.price) AS avgContractType FROM machine m, machinemodel mm, contract c WHERE m.modelCode = mm.modelCode AND m.contractID = c.contractID GROUP BY mm.machineType";

  try {
    $db = new db();
    $db = $db->connect();

    $stmtA = $db->query($sqlA);
    $stmtB = $db->query($sqlB);
    $stmtC = $db->query($sqlC);

    $dataA = $stmtA->fetchAll(PDO::FETCH_OBJ);
    $dataB = $stmtB->fetchAll(PDO::FETCH_OBJ);
    $dataC = $stmtC->fetchAll(PDO::FETCH_OBJ);

    $db = null;

    $chartData->convertToPie($dataC);
    $dataA[0]->avgContractCust = $dataB[0]->avgContractCust;
    $dataA[0]->avgContractType = $chartData;

    echo json_encode($dataA);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->get("/api/contract/machine/{contractId}", function(Request $request, Response $response) {
  $contractId = $request->getAttribute('contractId');
  $sql = "SELECT m.machineID AS machineId, mm.machineType
  FROM machine m, machinemodel mm
  WHERE m.modelCode = mm.modelCode AND m.contractID = \"$contractId\"";
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

$app->get("/api/contract/list", function(Request $request, Response $response) {
  $sql = "SELECT cn.contractID AS contractId, cs.customerName AS customer, cn.startDate, cn.endDate, cn.price FROM contract cn, customer cs WHERE cn.customerID = cs.customerID";

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