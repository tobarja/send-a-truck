<?php

namespace SendATruck\Controllers;

class Settings
{

    /**
     * @var \Slim\Slim
     */
    private $app;

    /**
     * @var \SendATruck\DataLayer\CustomerRepository
     */
    private $settingsRepository;

    /**
     * @var \SendATruck\DataLayer\PermissionRepository;
     */
    private $permissionRepository;

    public function __construct($app)
    {
        $this->app = $app;
        $this->permissionRepository = new \SendATruck\DataLayer\PermissionRepository($this->app->db);
//        $this->settingsRepository = new \SendATruck\DataLayer\SettingsRepository($this->app->db);
    }

    public function index()
    {
        if (!$this->userHasPermission('view_settings')) {
            $this->app->redirect('/');
        }
        $this->app->render('settings.html.twig');
    }

    public function userHasPermission($permission)
    {
        if (!array_key_exists('UserId', $_SESSION)) {
            return false;
        }
        if ($this->permissionRepository->hasPermission($permission,
                $_SESSION['UserId'])) {
            return true;
        }
        return false;
    }
}
