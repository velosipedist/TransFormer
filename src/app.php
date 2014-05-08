<?php
require __DIR__ . "/../src/init.php";
$app = new \Slim\Slim();

$app->post(
	'/validate/:form_name',
	function ($formName) use ($app) {
		$fieldValues = $app->request->post($formName);
	}
);

$app->hook('slim.after.dispatch', function() use ($app) {
	if (!$app->response->header('content-type')) {
		$app->response->header('content-type', 'application/json');
	}
});

$app->error(
	function ($exception)  use ($app) {
		print json_encode((array) $exception);
	}
);