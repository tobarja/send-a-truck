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

    public function __construct($app)
    {
        $this->app = $app;
        $this->customerRepository = new CustomerRepository($this->app->db);
    }

    public function index()
    {
        $customers = $this->customerRepository->getAll();
        $this->app->render('customers-list.html.twig',
            array('customers' => $customers));
    }

    public function show($id)
    {
        $customer = $this->customerRepository->getById($id);
        if ($customer) {
            var_dump($customer);
        }
    }
}
