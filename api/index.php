<?php
require '../vendor/autoload.php';
require_once './controller/apiTurnosController.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new \Slim\App($config);

$app->get('/',  function ($request, $response, $args) {
	$response->withStatus(200);
	$body = $response->getBody();
	$body->write('<html><body><h1>API Turnos</h1></body></html>');
	$response->withHeader('Content-Type', 'text/html');
	return $response;
});

$app->get('/turnos/{fecha}', function ($request, $response, $args) {
	return apiTurnosController::getTurnosDisponibles($request, $response, $args);
});

$app->post('/turnos/{dni}/fecha/{fecha}/hora/{hora}', function ($request, $response, $args) {

	return apiTurnosController::setTurno($request, $response, $args);
});

$app->any('/turnos', function ($request, $response, $args) {
	return 	$response->withJson("Faltan parametros",400);
});

$app->run();

?>

