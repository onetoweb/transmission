<?php

namespace Onetoweb\TransMission\Endpoint\Endpoints;

use Onetoweb\TransMission\Endpoint\AbstractEndpoint;

/**
 * Unit Endpoint.
 */
class Unit extends AbstractEndpoint
{
    /**
     * @return array
     */
    public function list(): array
    {
        return $this->client->get('/units');
    }
}
