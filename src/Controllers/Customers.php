<?php

namespace SendATruck\Controllers;

use SendATruck\DataLayer\CustomerRepository;
use SendATruck\Objects\Customer;

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

    public function newCustomer()
    {
        if (!$this->userHasPermission('edit_customers')) {
            $this->app->redirect('/');
        }

        $this->app->render('customers-new.html.twig');
    }

    public function newCustomerPost()
    {
        if (!$this->userHasPermission('edit_customers')) {
            $this->app->redirect('/');
        }

        $customer = new Customer($this->app->request->post());
        $id = $this->customerRepository->add($customer);
        if ($id) {
            $this->app->redirect('/customers/' . $id);
        } else {
            $this->app->redirect('/customers/');
        }
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

        $this->app->render('customers-view.html.twig',
            array('customer' => $customer));
    }

    public function emailLink($id)
    {
        if (!$this->userHasPermission('view_customers')) {
            $this->app->redirect('/');
        }

        $customer = $this->customerRepository->getById($id);

        $emailService = new \SendATruck\Services\EmailService();
        $linkSender = new \SendATruck\Contexts\EmailRequestLink($emailService, $this->app->truckRequestUrl, $customer);
        $linkSender->send();
        $this->app->redirect('/customers/'.$id);

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
