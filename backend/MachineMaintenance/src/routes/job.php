<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class pieChartJobClass {
  var $datasets;
  var $labels;

  function convertToPie($data) {
    foreach($data as $idx=>$item) {
      $this->datasets[0]->data[$idx] = $item->hoursPerType;
      $this->datasets[0]->backgroundColor[$idx] = rand_color();
      $this->labels[$idx] = $item->machineType;
    }
  }
}

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

$app->get("/api/job/currentAssignment", function(Request $request, Response $response) {
  $sqlA = "SELECT COUNT(jobID) AS openJob FROM job WHERE jobStatus != 'Finished' ";
  $sqlB = "SELECT COUNT(jobID) AS unassignedJob FROM job WHERE jobStatus = 'Pending'";
  $sqlC = "SELECT COUNT(jobID) AS assignedJob FROM job WHERE jobStatus NOT IN ('Pending','Finished')";
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
    
    $dataA[0]-> unassignedJob = $dataB[0]->unassignedJob;
    $dataA[0]-> assignedJob = $dataC[0]->assignedJob;

    echo json_encode($dataA);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

$app->get("/api/job/techStats", function(Request $request, Response $response) {
  $sql = "SELECT AVG(JobCount) AS avgPerTechnician, MAX(JobCount) AS maxPerTechnician, MIN(JobCount) AS minPerTechnician FROM (SELECT COUNT(jobID) AS JobCount, staffID FROM assignment GROUP BY staffID) JobByStaff";
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

$app->get("/api/job/topRepair", function(Request $request, Response $response) {
  $sql = "";
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

$app->get("/api/job/assignment/{staffId}", function(Request $request, Response $response) {
  $staffId = $request->getAttribute('staffId');
  $sql = "SELECT TIMESTAMP(date,startTime) AS startTime, machine.machineID AS machineId, machineType, modelNumber, customerName, priority, severity, details
  FROM job,machine,machinemodel,contract,customer,staff,assignment
  WHERE machine.modelCode=machinemodel.modelCode AND job.machineID = machine.machineID AND machine.contractID=contract.contractID AND customer.customerID = contract.customerID AND staff.staffID = assignment.staffID AND assignment.jobID = job.jobID AND staff.staffID = \"$staffId\"";
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

$app->get("/api/job/repairDuration", function(Request $request, Response $response) {
  $chartDataA = new pieChartJobClass;
  $sqlA = "SELECT SUM(TIMESTAMPDIFF(HOUR,TIMESTAMP(date,startTime),TIMESTAMP(endDate,endTime))) AS maintenanceHours FROM job WHERE jobType = 'Maintenance' AND MONTH(endDate) = MONTH(NOW())";
  $sqlB = "SELECT SUM(TIMESTAMPDIFF(HOUR,TIMESTAMP(date,startTime),TIMESTAMP(endDate,endTime))) AS repairHours FROM job WHERE jobType = 'Repair' AND MONTH(endDate) = MONTH(NOW())";
  $sqlC = "SELECT md.machineType,SUM(TIMESTAMPDIFF(HOUR,TIMESTAMP(date,startTime),TIMESTAMP(endDate,endTime))) AS hoursPerType FROM job j, machine mc, machinemodel md WHERE j.machineID = mc.machineID AND mc.modelCode = md.modelCode GROUP BY machineType";
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

    $chartDataA->convertToPie($dataC);

    $dataA[0] -> repairHours = $dataB[0] -> repairHours;
    $dataA[0] -> hoursPerType = $chartDataA;

    echo json_encode($dataA);
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

?>