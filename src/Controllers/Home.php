<?php

namespace SendATruck\Controllers;

class Home
{

    /**
     * @var \Slim\Slim
     */
    private $app;

    /**
     * @var \SendATruck\DataLayer\PermissionRepository;
     */
    private $permissionRepository;

    public function __construct($app)
    {
        $this->app = $app;
        $this->permissionRepository = new \SendATruck\DataLayer\PermissionRepository($this->app->db);
    }

    public function index()
    {
        if (!$this->isLoggedIn()) {
            $this->app->redirect('/');
        }
        $this->app->render('home.html.twig');
    }

    public function isLoggedIn()
    {
        return (array_key_exists('UserId', $_SESSION));
    }
}
