<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require "../vendor/autoload.php";

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
	// should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
	// whitelist of safe domains
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
			header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
			header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

}

$app = new \Slim\App;
$app->get("/hello/{name}", function(Request $request, Response $response) {
	$name = $request->getAttribute('name');
	$response->getBody()->write("Hello, $name");

	return $response;
});

mt_srand(68678);

function rand_color() {
  return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

require "../src/config/dbaccess.php";
require "../src/routes/staff.php";
require "../src/routes/customer.php";
require "../src/routes/parts.php";
require "../src/routes/job.php";
require "../src/routes/transaction.php";
require "../src/routes/machine.php";
require "../src/routes/contract.php";
require "../src/routes/log.php";

$app->run();
?>