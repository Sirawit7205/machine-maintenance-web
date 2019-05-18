<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class pieChartTransClass {
  var $datasets;
  var $labels;

  function convertToPie($data) {
    foreach($data as $idx=>$item) {
      $this->datasets[0]->data[$idx] = $item->totalAmount;
      $this->datasets[0]->backgroundColor[$idx] = rand_color();
      $this->labels[$idx] = $item->transType;
    }
  }
}

$app->get("/api/transaction/income", function(Request $request, Response $response) {
    $sql = "SELECT timestamp, amount, transType AS type, details FROM income";
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

$app->get("/api/transaction/expense", function(Request $request, Response $response) {
    $sql = "SELECT timestamp, amount, transType AS type, details FROM expense";
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

$app->get("/api/transaction/summary", function(Request $request, Response $response) {
  $sqlA = "SELECT SUM(i.amount) AS totalIncome, SUM(e.amount) AS totalExpense, SUM(i.amount)-SUM(e.amount) AS totalDiff FROM expense e, income i";
  try {
    $db = new db();
    $db = $db->connect();

    $stmtA = $db->query($sqlA);
    $dataA = $stmtA->fetchAll(PDO::FETCH_OBJ);
    
    $db = null;

    echo json_encode($dataA);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->get("/api/transaction/incomeChart", function(Request $request, Response $response) {
  $chartData = new pieChartTransClass;
  $sql = "SELECT transType, SUM(amount) AS totalAmount FROM income GROUP BY transType";
  try {
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    $db = null;

    $chartData->convertToPie($data);

    echo json_encode($chartData);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->get("/api/transaction/expenseChart", function(Request $request, Response $response) {
  $chartData = new pieChartTransClass;
  $sql = "SELECT transType, SUM(amount) AS totalAmount FROM expense GROUP BY transType";
  try {
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    $db = null;

    $chartData->convertToPie($data);

    echo json_encode($chartData);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});
?>