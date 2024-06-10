<?php

namespace Onetoweb\TransMission;

use DateTime;

/**
 * TransMission Token.
 */
class Token
{
    /**
     * @var string
     */
    private $value;
    
    /**
     * @var DateTime
     */
    private $expires;
    
    /**
     * @var string
     */
    private $type;
    
    /**
     * @param string $value
     * @param DateTime $expires
     * @param string $type = 'bearer'
     */
    public function __construct(string $value, DateTime $expires, string $type = 'bearer')
    {
        $this->value = $value;
        $this->expires = $expires;
        $this->type = $type;
    }
    
    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
    
    /**
     * @return DateTime
     */
    public function getExpires(): DateTime
    {
        return $this->expires;
    }
    
    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return (new DateTime() > $this->expires);
    }
    
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}