<?php

namespace SendATruck\Controllers;

use SendATruck\Objects\TruckRequest;

class TruckRequests
{

    /**
     * @var \Slim\Slim
     */
    private $app;

    /**
     * @var \SendATruck\DataLayer\CustomerRepository
     */
    private $customerRepository;

    /**
     * @var \SendATruck\DataLayer\TruckRequestRepository
     */
    private $truckRequestRepository;

    public function __construct($app)
    {
        $this->app = $app;
        $this->customerRepository = new \SendATruck\DataLayer\CustomerRepository($this->app->db);
        $this->truckRequestRepository = new \SendATruck\DataLayer\TruckRequestRepository($this->app->db);
    }

    public function requestById($custId)
    {
        $customer = $this->customerRepository->getById($custId);
        if ($customer->getId() != $custId) {
            $this->app->redirect('/');
        }

        $this->app->render('sendatruck-request.html.twig',
            array('postAction' => $this->app->truckRequestUrl,
                'id' => $custId));
    }

    public function submitTruckRequest()
    {
        $custId = $this->app->request->post('id');
        $customer = $this->customerRepository->getById($custId);
        if ($customer->getId() != $custId) {
            $this->app->redirect('/');
        }

        $truckRequest = new TruckRequest();
        $truckRequest->setCustomerId($custId);
        $truckRequest->setTimestamp();
        $this->truckRequestRepository->save($truckRequest);
        $this->app->redirect('/');
    }
}
