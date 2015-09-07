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

    public function __construct($app)
    {
        $this->app = $app;
        $this->customerTruckRequestRepository = new \SendATruck\DataLayer\CustomerTruckRequestRepository($this->app->db);
    }

    public function index()
    {
        $truckRequests = $this->customerTruckRequestRepository->getAll();
        $this->app->render('truckrequests-list.html.twig',
            array('truckRequests' => $truckRequests));
    }
}
