<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/job/open", function(Request $request, Response $response) {
  $sql = "SELECT j.machineID, mm.modelNumber, mm.machineType, j.jobStatus AS status, j.severity, j.priority FROM job j, machine m, machinemodel mm WHERE j.machineID = m.machineID AND m.modelCode = mm.modelCode AND j.jobStatus != \"Finished\"";
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
$app->get("/api/job/resource", function(Request $request, Response $response) {
  $sqlA = "SELECT AVG(priority) AS avgPriority, AVG(priority) + AVG(severity) AS stressScore FROM job WHERE jobStatus != \"Finished\"";
  $sqlB = "SELECT COUNT(DISTINCT a.staffID) AS assignedTech, COUNT(DISTINCT s.staffID) - COUNT(DISTINCT a.staffID) AS availTech FROM assignment a, staff s WHERE s.position = \"Technician\"";
  try {
    $db = new db();
    $db = $db->connect();

    $stmtA = $db->query($sqlA);
    $stmtB = $db->query($sqlB);

    $dataA = $stmtA->fetchAll(PDO::FETCH_OBJ);
    $dataB = $stmtB->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    $dataA[0]->assignedTech = $dataB[0]->assignedTech;
    $dataA[0]->availTech = $dataB[0]->availTech;

    echo json_encode($dataA);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

?>