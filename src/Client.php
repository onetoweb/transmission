<?php

namespace Onetoweb\TransMission;

use Onetoweb\TransMission\Endpoint\Endpoints;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client as GuzzleCLient;
use DateTime;

/**
 * TransMission Api Client.
 */
#[\AllowDynamicProperties]
class Client
{
    /**
     * Base href.
     */
    public const BASE_HREF = 'https://staging.trans-mission.nl/api';
    
    /**
     * Methods
     */
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';
    
    /**
     * @var string
     */
    private $username;
    
    /**
     * @var string
     */
    private $password;
    
    /**
     * @var callable
     */
    private $updateTokenCallback;
    
    /**
     * @var Token
     */
    private $token;
    
    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        
        // load endpoints
        $this->loadEndpoints();
    }
    
    /**
     * @return void
     */
    private function loadEndpoints(): void
    {
        foreach (Endpoints::list() as $name => $class) {
            $this->{$name} = new $class($this);
        }
    }
    
    /**
     * @param callable $updateTokenCallback
     */
    public function setUpdateTokenCallback(callable $updateTokenCallback): void
    {
        $this->updateTokenCallback = $updateTokenCallback;
    }
    
    /**
     * @param Token $token
     */
    public function setToken(Token $token): void
    {
        $this->token = $token;
    }
    
    /**
     * @return Token
     */
    public function getToken(): ?Token
    {
        return $this->token;
    }
    
    /**
     * @param array $tokenArray
     */
    private function updateToken(array $tokenArray): void
    {
        // get expires
        $expires = (new DateTime())->setTimestamp(time() + $tokenArray['expires_in'] - 10);
        
        // create new token
        $this->token = new Token(
            $tokenArray['access_token'],
            $expires,
            $tokenArray['token_type']
        );
        
        // call update token callback
        if ($this->updateTokenCallback !== null) {
            ($this->updateTokenCallback)($this->token);
        }
    }
    
    /**
     * @param string $endpoint
     * 
     * @return string
     */
    public function getUrl(string $endpoint): string
    {
        return self::BASE_HREF . '/' . ltrim($endpoint, '/');
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return ?array
     */
    public function get(string $endpoint, array $query = []): ?array
    {
        return $this->request(self::METHOD_GET, $endpoint, [], $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * 
     * @return ?array
     */
    public function post(string $endpoint, array $data = []): ?array
    {
        return $this->request(self::METHOD_POST, $endpoint, $data);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * 
     * @return ?array
     */
    public function put(string $endpoint, array $data = []): ?array
    {
        return $this->request(self::METHOD_PUT, $endpoint, $data);
    }
    
    /**
     * @param string $endpoint
     * 
     * @return ?array
     */
    public function delete(string $endpoint): ?array
    {
        return $this->request(self::METHOD_DELETE, $endpoint);
    }
    
    /**
     * @return void
     */
    private function login(): void
    {
        // login request
        $response = (new GuzzleCLient())->post(self::BASE_HREF.'/login', [
            RequestOptions::FORM_PARAMS => [
                'user' => $this->username,
                'password' => $this->password,
            ]
        ]);
        
        // json decode
        $json = json_decode($response->getBody()->getContents(), true);
        
        // update token
        $this->updateToken($json);
    }
    
    /**
     * @param string $method
     * @param string $endpoint
     * @param array $data = []
     * @param array $query = []
     * 
     * @return ?array
     */
    public function request(string $method, string $endpoint, array $data = [], array $query = []): ?array
    {
        if ($this->token === null or $this->token->isExpired()) {
            $this->login();
        }
        
        // build options
        $options = [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . (string) $this->token
            ],
            RequestOptions::JSON => $data,
            RequestOptions::QUERY => $query,
        ];
        
        // request
        $response = (new GuzzleCLient())->request($method, $this->getUrl($endpoint), $options);
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        // decode json
        $json = json_decode($contents, true);
        
        return $json;
    }
}
