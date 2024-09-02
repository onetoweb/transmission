.. title:: Index

===========
Basic Usage
===========

Setup
        
.. code-block:: php
    
    require 'vendor/autoload.php';
    
    use Onetoweb\TransMission\{Client, Token};
    
    session_start();
    
    // params
    $username = '{username}';
    $password = '{password}';
    $testModus = true;
    
    // setup client
    $client = new Client($username, $password, $testModus);
    
    // set update token callback to store token (optional)
    $client->setUpdateTokenCallback(function(Token $token) {
        
        // store token
        $_SESSION['token'] = [
            'value' => (string) $token,
            'expires' => $token->getExpires(),
            'type' => $token->getType(),
        ];
    });
    
    // load token from storage (optional)
    if (isset($_SESSION['token'])) {
        
        $client->setToken(new Token(
            $_SESSION['token']['value'],
            $_SESSION['token']['expires'],
            $_SESSION['token']['type']
        ));
    }


========
Examples
========

* `Definitions <definition.rst>`_
* `Units <unit.rst>`_
* `Services <service.rst>`_
* `Shipments <shipment.rst>`_
* `Customers <customer.rst>`_
