<?php
$app->group('/customers',
    function () use ($app) {
    $customersController = new SendATruck\Controllers\Customers($app);

    $app->get('/',
        function () use ($customersController) {
        $customersController->index();
    });
    $app->get('/:id',
        function ($id) use ($customersController) {
        $customersController->show($id);
    });
});

$app->group('/sendatruck',
    function () use ($app) {
    $truckRequestsController = new SendATruck\Controllers\TruckRequests($app);

    $app->get('/:id',
        function ($id) use ($truckRequestsController) {
        $truckRequestsController->requestById($id);
    });
    $app->post('/',
        function () use ($truckRequestsController) {
        $truckRequestsController->submitTruckRequest();
    });
});

$app->group('/requests',
    function () use ($app) {
    $customerTruckRequestsController = new SendATruck\Controllers\CustomerTruckRequests($app);

    $app->get('/',
        function () use ($customerTruckRequestsController) {
        $customerTruckRequestsController->index();
    });
});
