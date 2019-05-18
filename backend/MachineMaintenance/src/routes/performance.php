<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get("/api/staff/performance", function(Request $request, Response $response) {
  $sql = "SELECT staffName,experience,COUNT(jobtype) AS jobCount, AVG(TIMESTAMPDIFF(HOUR,TIMESTAMP(date,startTime),TIMESTAMP(enddate,endTime))) AS averageWorkingHours
        FROM staff,assignment,job
        WHERE staff.staffID = assignment.staffID AND job.jobID = assignment.jobID AND enddate IS NOT NULL
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