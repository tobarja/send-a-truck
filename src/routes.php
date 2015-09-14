<?php
$app->get('/',
    function() use ($app) {
    $authController = new SendATruck\Controllers\Auth($app);
    $authController->login();
});

$app->get('/home',
    function() use ($app) {
    $homeController = new SendATruck\Controllers\Home($app);
    $homeController->index();
});

$app->post('/login',
    function() use ($app) {
    $authController = new SendATruck\Controllers\Auth($app);
    $authController->login_post();
});

$app->get('/logout',
    function() use ($app) {
    $authController = new SendATruck\Controllers\Auth($app);
    $authController->logout();
});

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

$app->group('/users',
    function () use ($app) {
    $usersController = new SendATruck\Controllers\Users($app);

    $app->get('/',
        function () use ($usersController) {
        $usersController->index();
    });
    $app->get('/new',
        function () use ($usersController) {
        $usersController->newUser();
    });
    $app->post('/new',
        function () use ($usersController) {
        $usersController->newUserPost();
    });
    $app->get('/:id',
        function ($id) use ($usersController) {
        $usersController->show($id);
    });
    $app->post('/addPermission',
        function () use ($usersController) {
        $usersController->addPermission();
    });
    $app->get('/removePermission/:id',
        function ($id) use ($usersController) {
        $usersController->removePermission($id);
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

$app->group('/settings',
    function () use ($app) {
    $settingsController = new SendATruck\Controllers\Settings($app);

    $app->get('/',
        function () use ($settingsController) {
        $settingsController->index();
    });
});
