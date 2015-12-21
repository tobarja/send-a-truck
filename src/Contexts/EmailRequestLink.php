<?php

namespace SendATruck\Contexts;

class EmailRequestLink
{
    /**
     * @var \SendATruck\Services\EmailService
     */
    private $emailService;
    private $requestUrl;
    /**
     * @var \SendATruck\Objects\Customer
     */
    private $customer;

    public function __construct($emailService, $requestUrl, $customer)
    {
        $this->emailService = $emailService;
        $this->requestUrl = $requestUrl;
        $this->customer = $customer;
    }

    public function send()
    {

        $requestLink = BASEURL.$this->requestUrl.'/'.$this->customer->getRequestKey();
        $message = "{$this->customer->getFirstName()},

Use this link to request a pickup:

{$requestLink}
";
        $this->emailService->mail(array(SMTP_FROM), array($this->customer->getEmail()), 'Your Request Link', $message);
    }
}
