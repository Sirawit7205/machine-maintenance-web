<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/transaction/income", function(Request $request, Response $response) {
    $sql = "SELECT timestamp, amount, transType AS Type, details  FROM income";
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
    $sql = "SELECT timestamp, amount, transType AS Type, details  FROM expense";
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
    $sqlA = "SELECT SUM(i.amount) AS TotalIncome, SUM(e.amount) AS TotalExpense, SUM(i.amount)-SUM(e.amount) AS TotalDiff FROM expense e,income i";
    $sqlB = "";
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

?>