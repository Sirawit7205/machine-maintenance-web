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

$app->post("/api/staff/submit", function(Request $request, Response $response) {
  $actionType = $request->getParsedBody()['actionType'];
  $staffId = $request->getParsedBody()['staffId'];
  $staffUsername = $request->getParsedBody()['staffUsername'];
  $staffPassword = $request->getParsedBody()['staffPassword'];
  $staffName = $request->getParsedBody()['staffName'];
  $address = $request->getParsedBody()['address'];
  $phone = $request->getParsedBody()['phone'];
  $email = $request->getParsedBody()['email'];
  $position = $request->getParsedBody()['position'];
  $salary = $request->getParsedBody()['salary'];
  $status = $request->getParsedBody()['status'];
  $experience = $request->getParsedBody()['experience'];
  $vacationTotal = $request->getParsedBody()['vacationTotal'];
  $vacationLeft = $request->getParsedBody()['vacationLeft'];

  $hashedPassword = password_hash($staffPassword, PASSWORD_BCRYPT);

  $sqlInsert = "INSERT INTO staff (staffID, staffUsername, staffPassword, staffName, address, phone, email, position, salary, experience, status, vacationTotal, vacationLeft) VALUES (:staffId, :staffUsername, :hashedPassword, :staffName, :address, :phone, :email, :position, :salary, :experience, :status, :vacationTotal, :vacationLeft)";
  $sqlUpdateNoPassword = "UPDATE staff SET staffUsername = :staffUsername, staffName = :staffName, address = :address, phone = :phone, email = :email, position = :position, salary = :salary, experience = :experience, status = :status, vacationTotal = :vacationTotal, vacationLeft = :vacationLeft WHERE staffID = :staffId";
  $sqlUpdateWithPassword = "UPDATE staff SET staffUsername = :staffUsername, staffPassword = :hashedPassword, staffName = :staffName, address = :address, phone = :phone, email = :email, position = :position, salary = :salary, experience = :experience, status = :status, vacationTotal = :vacationTotal, vacationLeft = :vacationLeft WHERE staffID = :staffId";
  $sqlDelete = "DELETE FROM staff WHERE staffID = :staffId";

  try {
    $db = new db();
    $db = $db->connect();

    //INSERT
    if($actionType == 0) {
      //prepare template
      $stmt = $db->prepare($sqlInsert);

      //bind parameters
      $stmt->bindParam(':staffId', $staffId, PDO::PARAM_STR);
      $stmt->bindParam(':staffUsername', $staffUsername, PDO::PARAM_STR);
      $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
      $stmt->bindParam(':staffName', $staffName, PDO::PARAM_STR);
      $stmt->bindParam(':address', $address, PDO::PARAM_STR);
      $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':position', $position, PDO::PARAM_STR);
      $stmt->bindParam(':salary', $salary, PDO::PARAM_STR);
      $stmt->bindParam(':experience', $experience, PDO::PARAM_INT);
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);
      $stmt->bindParam(':vacationTotal', $vacationTotal, PDO::PARAM_INT);
      $stmt->bindParam(':vacationLeft', $vacationLeft, PDO::PARAM_INT);
    }
    //UPDATE without changing staff password
    else if($actionType == 1 && $staffPassword == "") {
      //prepare template
      $stmt = $db->prepare($sqlUpdateNoPassword);

      //bind parameters
      $stmt->bindParam(':staffId', $staffId, PDO::PARAM_STR);
      $stmt->bindParam(':staffUsername', $staffUsername, PDO::PARAM_STR);
      $stmt->bindParam(':staffName', $staffName, PDO::PARAM_STR);
      $stmt->bindParam(':address', $address, PDO::PARAM_STR);
      $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':position', $position, PDO::PARAM_STR);
      $stmt->bindParam(':salary', $salary, PDO::PARAM_STR);
      $stmt->bindParam(':experience', $experience, PDO::PARAM_INT);
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);
      $stmt->bindParam(':vacationTotal', $vacationTotal, PDO::PARAM_INT);
      $stmt->bindParam(':vacationLeft', $vacationLeft, PDO::PARAM_INT);
    }
    //UPDATE and change staff password
    else if($actionType == 1) {
      //prepare template
      $stmt = $db->prepare($sqlUpdateWithPassword);

      //bind parameters
      $stmt->bindParam(':staffId', $staffId, PDO::PARAM_STR);
      $stmt->bindParam(':staffUsername', $staffUsername, PDO::PARAM_STR);
      $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
      $stmt->bindParam(':staffName', $staffName, PDO::PARAM_STR);
      $stmt->bindParam(':address', $address, PDO::PARAM_STR);
      $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':position', $position, PDO::PARAM_STR);
      $stmt->bindParam(':salary', $salary, PDO::PARAM_STR);
      $stmt->bindParam(':experience', $experience, PDO::PARAM_INT);
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);
      $stmt->bindParam(':vacationTotal', $vacationTotal, PDO::PARAM_INT);
      $stmt->bindParam(':vacationLeft', $vacationLeft, PDO::PARAM_INT);      
    }
    //DELETE
    else {
      //prepare template
      $stmt = $db->prepare($sqlDelete);

      //bind parameters
      $stmt->bindParam(':staffId', $staffId, PDO::PARAM_STR);     
    }

    //execute SQL statement and get result
    $result = $stmt->execute();
    $db = null;
    
    //return result to frontend
    echo $result;
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

?>