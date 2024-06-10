<?php

namespace Onetoweb\TransMission\Endpoint\Endpoints;

use Onetoweb\TransMission\Endpoint\AbstractEndpoint;

/**
 * Service Endpoint.
 */
class Service extends AbstractEndpoint
{
    /**
     * @return array
     */
    public function list(): array
    {
        return $this->client->get('/services');
    }
}
