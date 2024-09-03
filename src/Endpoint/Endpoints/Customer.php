<?php

namespace Onetoweb\TransMission\Endpoint\Endpoints;

use Onetoweb\TransMission\Endpoint\AbstractEndpoint;

/**
 * Customer Endpoint.
 */
class Customer extends AbstractEndpoint
{
    /**
     * @return array
     */
    public function list(): array
    {
        return $this->client->get('/customers');
    }
    
    /**
     * @param int $customerNumber
     * 
     * @return array
     */
    public function get(int $customerNumber): array
    {
        return $this->client->get("/customers/$customerNumber");
    }
}
