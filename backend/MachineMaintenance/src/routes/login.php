<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class loginResponse {
  var $authResult;
  var $accessLevel;
  var $userId;
}

$app->post("/api/loginCheck", function(Request $request, Response $response) {
  $respDetails = new loginResponse;
  $username = $request->getParsedBody()['username'];
  $password = $request->getParsedBody()['password'];
  $sqlUsrCheckStaff = "SELECT EXISTS(SELECT * FROM staff WHERE staffUsername = :username) AS exist";
  $sqlUsrCheckCustr = "SELECT EXISTS(SELECT * FROM customer WHERE customerUsername = :username) AS exist";
  $sqlPswCheckStaff = "SELECT staffPassword, staffID, position FROM staff WHERE staffUsername = :username";
  $sqlPswCheckCustr = "SELECT customerPassword, customerID FROM customer WHERE customerUsername = :username";

  try {
    $db = new db();
    $db = $db->connect();

    //prepare template
    $stmtUsrCheckStaff = $db->prepare($sqlUsrCheckStaff);
    $stmtUsrCheckCustr = $db->prepare($sqlUsrCheckCustr);
    $stmtPswCheckStaff = $db->prepare($sqlPswCheckStaff);
    $stmtPswCheckCustr = $db->prepare($sqlPswCheckCustr);

    //bind params
    $stmtUsrCheckStaff->bindParam(':username', $username, PDO::PARAM_STR);
    $stmtUsrCheckCustr->bindParam(':username', $username, PDO::PARAM_STR);
    $stmtPswCheckStaff->bindParam(':username', $username, PDO::PARAM_STR);
    $stmtPswCheckCustr->bindParam(':username', $username, PDO::PARAM_STR);

    //query
    $stmtUsrCheckStaff->execute();
    $stmtUsrCheckCustr->execute();
    $stmtPswCheckStaff->execute();
    $stmtPswCheckCustr->execute();

    $dataUsrCheckStaff = $stmtUsrCheckStaff->fetchColumn();
    $dataUsrCheckCustr = $stmtUsrCheckCustr->fetchColumn();
    $dataPswCheckStaff = $stmtPswCheckStaff->fetchAll(PDO::FETCH_OBJ);
    $dataPswCheckCustr = $stmtPswCheckCustr->fetchAll(PDO::FETCH_OBJ);

    $db = null;
    
    //check if staff
    if ($dataUsrCheckStaff == "1") {
      if(password_verify($password, $dataPswCheckStaff[0]->staffPassword)) {
        //echo "staff passed";
        $respDetails->authResult = 1;
        $respDetails->accessLevel = $dataPswCheckStaff[0]->position;
        $respDetails->userId = $dataPswCheckStaff[0]->staffID;
      } else {
        //echo "staff failed";
        $respDetails->authResult = 0;
      }
    }
    //check if customer
    elseif ($dataUsrCheckCustr == "1") {
      if(password_verify($password, $dataPswCheckCustr[0]->customerPassword)) {
        //echo "customer passed";
        $respDetails->authResult = 1;
        $respDetails->accessLevel = "Customer";
        $respDetails->userId = $dataPswCheckCustr[0]->customerID;
      } else {
        //echo "customer failed";
        $respDetails->authResult = 0;
      }
    }
    else {
      //echo "user not found";
      $respDetails->authResult = 0;
    }

  echo json_encode($respDetails);  
  } catch(PDOException $e) {
    echo '{"error":{"text": '.$e->getMessage().'}}';
  }
});

?>