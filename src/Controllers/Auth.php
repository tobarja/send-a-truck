<?php

namespace SendATruck\Controllers;

class Auth
{

    /**
     * @var \Slim\Slim
     */
    private $app;

    /**
     * @var SendATruck\DataLayer\PermissionRepository
     */
    private $permissionRepository;

    /**
     * @var SendATruck\DataLayer\UserRepository
     */
    private $userRepository;

    public function __construct($app)
    {
        $this->app = $app;
        $this->permissionRepository = new \SendATruck\DataLayer\PermissionRepository($this->app->db);
        $this->userRepository = new \SendATruck\DataLayer\UserRepository($this->app->db);
    }

    public function login()
    {
        if ($this->isLoggedIn()) {
            $this->app->redirect('/home');
        }
        $this->app->render('login.html.twig');
    }

    public function login_post()
    {
        $userName = $this->app->request->post('username');
        $password = $this->app->request->post('password');

        $user = $this->userRepository->getByUserName($userName);
        if ($user->isPassword($password)) {
            $_SESSION['UserId'] = $user->getId();
            $_SESSION['UserName'] = $user->getUserName();
            $this->app->redirect('/home');
        } else {
            $this->app->redirect('/');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->app->redirect('/');
    }

    public function isLoggedIn()
    {
        return (array_key_exists('UserId', $_SESSION));
    }
}
