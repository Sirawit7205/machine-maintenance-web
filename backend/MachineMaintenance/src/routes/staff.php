<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/staff/salaryList", function(Request $request, Response $response) {
  $sql = "SELECT staffName, position, salary FROM staff";
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

$app->get("/api/staff/salaryPosition", function(Request $request, Response $response) {
  $sql = "SELECT position, MIN(salary) AS minSalary, MAX(salary) AS maxSalary, AVG(salary) AS avgSalary FROM staff GROUP BY position";

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
  // $sqlMin = "SELECT position, MIN(salary) AS minSalary FROM staff GROUP BY position";
  // $sqlMax = "SELECT position, MAX(salary) AS maxSalary FROM staff GROUP BY position";
  // $sqlAvg = "SELECT position, AVG(salary) AS avgSalary FROM staff GROUP BY position";
  // try {
  //   $summarise = [];
  //   $db = new db();
  //   $db = $db->connect();

  //   $stmtMin = $db->query($sqlMin);
  //   $stmtMax = $db->query($sqlMax);
  //   $stmtAvg = $db->query($sqlAvg);

  //   $dataMin = $stmtMin->fetchAll(PDO::FETCH_OBJ);
  //   $dataMax = $stmtMax->fetchAll(PDO::FETCH_OBJ);
  //   $dataAvg = $stmtAvg->fetchAll(PDO::FETCH_OBJ);

  //   $db = null;

  //   foreach($dataMin as $idx=>$item) {
  //     @$summarise[$idx]->position = $item->position;
  //     @$summarise[$idx]->minSalary = $item->minSalary;
  //   }

  //   foreach($dataMax as $idx=>$item)
  //     @$summarise[$idx]->maxSalary = $item->maxSalary;


  //   foreach($dataAvg as $idx=>$item)
  //     @$summarise[$idx]->avgSalary = $item->avgSalary;

  //   echo json_encode($summarise);

  // } catch(PDOException $e) {
  //   echo '{"error":{"text": '.$e->getMessage().'}}';
  // }
});

$app->get("/api/staff/vacationList", function(Request $request, Response $response) {
  $sql = "SELECT staffName, position, status, vacationTotal, vacationLeft FROM staff";

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

$app->get("/api/staff/vacationGiven", function(Request $request, Response $response) {
  $sql = "SELECT position, AVG(vacationTotal) AS avgGiven, MIN(vacationTotal) AS minGiven, MAX(vacationTotal) AS maxGiven FROM staff GROUP BY position";

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

$app->get("/api/staff/vacationUsed", function(Request $request, Response $response) {
  $sql = "SELECT position, AVG(vacationTotal - vacationLeft) AS avgUsed, MIN(vacationTotal - vacationLeft) AS minUsed, MAX(vacationTotal - vacationLeft) AS maxUsed FROM staff GROUP BY position";

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

$app->get("/api/staff/performance", function(Request $request, Response $response) {
  $sql = "SELECT staffName,experience,COUNT(jobtype) AS jobCount, AVG(TIMESTAMPDIFF(HOUR,TIMESTAMP(date,startTime),TIMESTAMP(endDate,endTime))) AS avgTime
        FROM staff,assignment,job
        WHERE staff.staffID = assignment.staffID AND job.jobID = assignment.jobID AND endDate IS NOT NULL AND YEAR(NOW()) = YEAR(TIMESTAMP(date,startTime)) AND MONTH(NOW()) = MONTH(TIMESTAMP(date,startTime))
        GROUP BY assignment.staffID";
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

$app->get("/api/staff/status", function(Request $request, Response $response) {
    $sql = "SELECT COUNT(*) AS totalTechnician,AVG(experience) AS avgExperience FROM staff WHERE position='Technician'";
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