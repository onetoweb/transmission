<?php

namespace Onetoweb\TransMission\Endpoint\Endpoints;

use Onetoweb\TransMission\Endpoint\AbstractEndpoint;
use DateTime;

/**
 * Shipment Endpoint.
 */
class Shipment extends AbstractEndpoint
{
    /**
     * @param array $data
     * 
     * @return array
     */
    public function create(array $data): array
    {
        return $this->client->post('/shipments/shipment', $data);
    }
    
    /**
     * @param string $tx
     * 
     * @return array
     */
    public function finalize(string $tx): array
    {
        return $this->client->put("/shipments/finalize/$tx");
    }
    
    /**
     * @param string $tx
     * 
     * @return array
     */
    public function delete(string $tx): array
    {
        return $this->client->delete("/shipments/shipment/$tx");
    }
    
    /**
     * @param string $tx
     * 
     * @return array
     */
    public function status(string $tx): array
    {
        return $this->client->get("/shipments/shipment_status/transport_number/$tx");
    }
    
    /**
     * @param string $tx
     * @param DateTime $date
     * 
     * @return array
     */
    public function changeDate(string $tx, DateTime $date): array
    {
        return $this->client->put("/shipments/change_date/$tx", [
            'date' => $date->format('Y-m-d')
        ]);
    }
    
    /**
     * @param DateTime $after
     * 
     * @return array
     */
    public function getAfter(DateTime $after): array
    {
        return $this->client->get('/shipments/statuses/processed/'.$after->format(DateTime::ATOM));
    }
}
