<?php

namespace SendATruck\Controllers;

class CustomerTruckRequests
{

    /**
     * @var \Slim\Slim
     */
    private $app;

    /**
     * @var \SendATruck\DataLayer\CustomerTruckRequestRepository
     */
    private $customerTruckRequestRepository;

    /**
     * @var SendATruck\DataLayer\PermissionRepository
     */
    private $permissionRepository;

    public function __construct($app)
    {
        $this->app = $app;
        $this->customerTruckRequestRepository = new \SendATruck\DataLayer\CustomerTruckRequestRepository($this->app->db);
        $this->permissionRepository = new \SendATruck\DataLayer\PermissionRepository($this->app->db);
    }

    public function index()
    {
        if (!$this->userHasPermission('view_requests')) {
            $this->app->redirect('/');
        }

        $truckRequests = $this->customerTruckRequestRepository->getAll();
        $this->app->render('truckrequests-list.html.twig',
            array('truckRequests' => $truckRequests));
    }

    public function userHasPermission($permission)
    {
        if (!array_key_exists('UserId', $_SESSION)) {
            return false;
        }
        if ($this->permissionRepository->hasPermission($permission, $_SESSION['UserId'])) {
            return true;
        }
        return false;
    }
}
