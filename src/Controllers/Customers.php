<?php

namespace SendATruck\Controllers;

use SendATruck\DataLayer\CustomerRepository;

class Customers
{

    /**
     * @var \Slim\Slim
     */
    private $app;

    /**
     * @var SendATruck\DataLayer\CustomerRepository
     */
    private $customerRepository;

    /**
     * @var SendATruck\DataLayer\PermissionRepository
     */
    private $permissionRepository;

    public function __construct($app)
    {
        $this->app = $app;
        $this->customerRepository = new CustomerRepository($this->app->db);
        $this->permissionRepository = new \SendATruck\DataLayer\PermissionRepository($this->app->db);
    }

    public function index()
    {
        if (!$this->userHasPermission('view_customers')) {
            $this->app->redirect('/');
        }

        $customers = $this->customerRepository->getAll();
        $this->app->render('customers-list.html.twig',
            array('customers' => $customers));
    }

    public function show($id)
    {
        if (!$this->userHasPermission('view_customers')) {
            $this->app->redirect('/');
        }

        $customer = $this->customerRepository->getById($id);
        if ($customer->getId() != $id) {
            $this->app->redirect('/');
        }

        $this->app->render('customers-view.html.twig', array('customer' => $customer));
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
