<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/staff/getCurrentIds", function(Request $request, Response $response) {
  $sql = "SELECT staffID AS staffId, staffName FROM staff ORDER BY staffID";
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

$app->get("/api/staff/count", function(Request $request, Response $response) {
  $sql = "SELECT COUNT(*) AS count FROM staff";
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

$app->get("/api/staff/all/{staffId}", function(Request $request, Response $response) {
  $staffId = $request->getAttribute('staffId');
  $sql = "SELECT staffID AS staffId, staffUsername, staffName, address, phone, email, position, salary, experience, status, vacationTotal, vacationLeft FROM staff WHERE staffId=\"$staffId\"";
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