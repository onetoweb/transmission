<?php

namespace Onetoweb\TransMission;

use Onetoweb\TransMission\Endpoint\Endpoints;
use Onetoweb\TransMission\Config\{Method, BaseHref};
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client as GuzzleCLient;
use DateTime;
use Closure;

/**
 * TransMission Api Client.
 */
#[\AllowDynamicProperties]
class Client
{
    /**
     * @var Closure|null
     */
    private ?Closure $updateTokenCallback = null;
    
    /**
     * @var Token|null
     */
    private ?Token $token = null;
    
    /**
     * @param string $username
     * @param string $password
     * @param bool $testModus = true
     */
    public function __construct(
        
        #[\SensitiveParameter]
        private string $username,
        
        #[\SensitiveParameter]
        private string $password,
        
        private bool $testModus = true
    ) {
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
     * @param Closure $updateTokenCallback
     */
    public function setUpdateTokenCallback(Closure $updateTokenCallback): void
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
     * @return string
     */
    public function getBaseHref(): string
    {
        if ($this->testModus) {
            return BaseHref::STAGING->value;
        } else {
            return BaseHref::LIVE->value;
        }
    }
    
    /**
     * @param string $endpoint
     * 
     * @return string
     */
    public function getUrl(string $endpoint): string
    {
        return $this->getBaseHref() . '/' . ltrim($endpoint, '/');
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return ?array
     */
    public function get(string $endpoint, array $query = []): ?array
    {
        return $this->request(Method::GET, $endpoint, [], $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * 
     * @return ?array
     */
    public function post(string $endpoint, array $data = []): ?array
    {
        return $this->request(Method::POST, $endpoint, $data);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * 
     * @return ?array
     */
    public function put(string $endpoint, array $data = []): ?array
    {
        return $this->request(Method::PUT, $endpoint, $data);
    }
    
    /**
     * @param string $endpoint
     * 
     * @return ?array
     */
    public function delete(string $endpoint): ?array
    {
        return $this->request(Method::DELETE, $endpoint);
    }
    
    /**
     * @return void
     */
    private function login(): void
    {
        // login request
        $response = (new GuzzleCLient())->post($this->getUrl('/login'), [
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
     * @param Method $method
     * @param string $endpoint
     * @param array $data = []
     * @param array $query = []
     * 
     * @return ?array
     */
    public function request(Method $method, string $endpoint, array $data = [], array $query = []): ?array
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
        $response = (new GuzzleCLient())->request($method->value, $this->getUrl($endpoint), $options);
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        // decode json
        $json = json_decode($contents, true);
        
        return $json;
    }
}
