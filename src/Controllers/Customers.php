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

        $companyName = $this->app->request->post('company_name');
        $firstName = $this->app->request->post('first_name');
        $lastName = $this->app->request->post('last_name');
        $email = $this->app->request->post('email');
        $telephone = $this->app->request->post('telephone');
        $address1 = $this->app->request->post('address1');
        $address2 = $this->app->request->post('address2');
        $city = $this->app->request->post('city');
        $state = $this->app->request->post('state');
        $zip = $this->app->request->post('zip');

        $customer = new Customer($companyName, $firstName, $lastName, $email,
            $telephone, $address1, $address2, $city, $state, $zip);
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
