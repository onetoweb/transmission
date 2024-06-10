<?php

namespace Onetoweb\TransMission\Endpoint\Endpoints;

use Onetoweb\TransMission\Endpoint\AbstractEndpoint;

/**
 * Definition Endpoint.
 */
class Definition extends AbstractEndpoint
{
    /**
     * @return array
     */
    public function list(): array
    {
        return $this->client->get('/definitions');
    }
    
    /**
     * @return array
     */
    public function reference(): array
    {
        return $this->client->get('/definitions/type_reference');
    }
    
    /**
     * @return array
     */
    public function text(): array
    {
        return $this->client->get('/definitions/type_text');
    }
    
    /**
     * @return array
     */
    public function countries(): array
    {
        return $this->client->get('/definitions/countries');
    }
    
    /**
     * @return array
     */
    public function shipment(): array
    {
        return $this->client->get('/definitions/shipment');
    }
    
    /**
     * @return array
     */
    public function status(): array
    {
        return $this->client->get('/definitions/type_status');
    }
}
