.. _top:
.. title:: Customers

`Back to index <index.rst>`_

=========
Customers
=========

.. contents::
    :local:


List customers
``````````````

.. code-block:: php
    
    $results = $client->customer->list();


Get customer
````````````

.. code-block:: php
    
    $customerNumber = 100;
    $results = $client->customer->get($customerNumber);


`Back to top <#top>`_