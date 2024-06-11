.. _top:
.. title:: Shipments

`Back to index <index.rst>`_

=========
Shipments
=========

.. contents::
    :local:


Create shipment
```````````````

.. code-block:: php
    
    $results = $client->shipment->create([
        'type' => 'T',
        'depot_number' => 1000,
        'customer_number' => 193,
        'date' => '2023-07-13',
        'addresses' => [
            [
                'type' => 'consignor',
                'name' => 'Afzender naam',
                'name2' => '',
                'address1' => 'WORMERWEG',
                'housenumber' => '6',
                'postalcode' => '1311XB',
                'city' => 'ALMERE',
                'country_code' => 'NL',
                'contact' => [
                    'language' => 'NL',
                    'name' => 'contactpersoon'
                ]
            ], [
                'type' => 'delivery',
                'name' => 'Ontvanger',
                'name2' => '',
                'address1' => 'Straatnaam',
                'housenumber' => '1',
                'postalcode' => '1358DC',
                'city' => 'ALMERE',
                'country_code' => 'NL',
                'contact' => [
                    'language' => 'NL',
                    'name' => 'contactpersoon'
                ],
                'date' => '2023-07-13'
            ]
        ],
        'text_messages' => [[
            'type' => 'AFLINFO',
            'remarks' => 'Sleutel ligt onder de deurmat bij de buren, pas op voor de poes'
        ]],
        'shipment_services' => [[
            'service_code' => '1100'
        ]],
        'shipment_units' => [
            [
                'unit_number' => '1',
                'description' => '',
                'contains_packages' => '10',
                'unit_type' => 'COL',
                'measurements' => [
                    'weight' => '22',
                    'width' => '80',
                    'height' => '0',
                    'volume' => '0.0000',
                    'loading_meter' => '0.00'
                ],
                'exchange_unit' => 1
            ], [
                'unit_number' => '2',
                'description' => '',
                'contains_packages' => '10',
                'unit_type' => 'EP',
                'measurements' => [
                    'weight' => '567.00',
                    'length' => '120',
                    'width' => '80',
                    'height' => '0',
                    'volume' => '0.0000',
                    'loading_meter' => '0.00'
                ],
                'exchange_unit' => 1
            ]
        ],
        'labels' => 'PDF'
    ]);
    
    // store label
    $filename = '/path/to/label.pdf';
    \Onetoweb\TransMission\Utils::storeLabel($filepath, $results);


Create shipment including dangerous goods
`````````````````````````````````````````

.. code-block:: php
    
    $results = $client->shipment->create([
        'type' => 'T',
        'depot_number' => '2700',
        'customer_number' => '193',
        'customer_name' => 'TEST',
        'date' => '2024-08-22',
        'references' => [
            [
                'type' => 'NRORDER',
                'reference' => '7050061'
            ]
        ],
        'addresses' => [
            [
                'type' => 'consignor',
                'name' => 'AFZENDER NAAM',
                'name2' => '',
                'address1' => 'VIERLINGHWG',
                'housenumber' => '1',
                'postalcode' => '4612PN',
                'city' => 'BERGEN OP ZOOM',
                'country_code' => 'NL',
                'contact' => [
                    'language' => 'NL',
                    'name' => '',
                    'phonenumber' => '',
                    'email_address' => ''
                ]
            ], [
                'type' => 'delivery',
                'name' => 'ONTVANGER NAAM',
                'name2' => '',
                'address1' => 'DORPSPLEIN',
                'housenumber' => '1',
                'postalcode' => '9695DA',
                'city' => 'BELLINGWOLDE',
                'country_code' => 'NL',
                'contact' => [
                    'language' => 'NL',
                    'name' => '',
                    'phonenumber' => '',
                    'email_address' => ''
                ],
                'date' => '2020-10-28',
                'depot_number' => 9800
            ]
        ],
        'text_messages' => [[
            'type' => 'AFLINFO',
            'remarks' => '/'
        ]],
        'shipment_units' => [
            [
                'unit_number' => 1,
                'barcode' => 'T46460772001592001',
                'unit_type' => 'COL',
                'contains_packages' => 0,
                'description' => 'HANDWASHING INSTANT HAND SANIT',
                'exchange_unit' => 0,
                'references' => [
                    [
                        'type' => 'delivery_note',
                        'reference' => 'Z100291924500031'
                    ], [
                        'type' => 'carrier_reference',
                        'reference' => '7050061'
                    ]
                ],
                'measurements' => [
                    'weight' => 7,
                    'length' => 0,
                    'width' => 0,
                    'height' => 0,
                    'volume' => 0,
                    'loading_meter' => 0
                ],
                'dangerous_goods' => [
                    [
                        'un_number' => '1993',
                        'un_name' => 'UN 1993 - FLAMMABLE LIQUID, N.O.S.(ETHANOL(ETHYL ALCOHOL SOLUTION)),3,pg III,(D/E),,  LQTY UN 1993 - BRANDBARE VLOEISTOF, N.E.G.(ETHANOL (ETHYLALCOHOL)),3,pg III,(D/E),,  LQTY',
                        'un_class' => 3,
                        'quantity' => 6,
                        'weight' => 1,
                        'chemical_description' => 'UN 1993 - FLAMMABLE LIQUID, N.O.S.(ETHANOL(ETHYL ALCOHOL SOLUTION)),3,pg III,(D/E),,  LQTY UN 1993 - BRANDBARE VLOEISTOF, N.E.G.(ETHANOL (ETHYLALCOHOL)),3,pg III,(D/E),,  LQTY',
                        'packing_description' => 'Piece',
                        'packing_group' => 'III',
                        'danger_label_main' => '3',
                        'danger_label_add_1' => '',
                        'danger_label_add_2' => '',
                        'danger_label_add_3' => '',
                        'transport_category' => 3,
                        'tunnel_code' => 'D/E'
                    ]
                ]
            ], [
                'unit_number' => 2,
                'barcode' => 'T46460772001592002',
                'unit_type' => 'COL',
                'contains_packages' => 0,
                'description' => 'HANDWASHING INSTANT HAND SANIT',
                'exchange_unit' => 0,
                'references' => [
                    [
                        'type' => 'delivery_note',
                        'reference' => 'Z100291924500032'
                    ], [
                        'type' => 'carrier_reference',
                        'reference' => '7050061'
                    ]
                ],
                'measurements' => [
                    'weight' => 7,
                    'length' => 0,
                    'width' => 0,
                    'height' => 0,
                    'volume' => 0,
                    'loading_meter' => 0
                ],
                'dangerous_goods' => [
                    [
                        'un_number' => '1993',
                        'un_name' => 'UN 1993 - FLAMMABLE LIQUID, N.O.S.(ETHANOL(ETHYL ALCOHOL SOLUTION)),3,pg III,(D/E),,  LQTY UN 1993 - BRANDBARE VLOEISTOF, N.E.G.(ETHANOL (ETHYLALCOHOL)),3,pg III,(D/E),,  LQTY',
                        'un_class' => 3,
                        'quantity' => 6,
                        'weight' => 1,
                        'chemical_description' => 'UN 1993 - FLAMMABLE LIQUID, N.O.S.(ETHANOL(ETHYL ALCOHOL SOLUTION)),3,pg III,(D/E),,  LQTY UN 1993 - BRANDBARE VLOEISTOF, N.E.G.(ETHANOL (ETHYLALCOHOL)),3,pg III,(D/E),,  LQTY',
                        'packing_description' => 'Piece',
                        'packing_group' => 'III',
                        'danger_label_main' => '3',
                        'danger_label_add_1' => '',
                        'danger_label_add_2' => '',
                        'danger_label_add_3' => '',
                        'transport_category' => 3,
                        'tunnel_code' => 'D/E'
                    ]
                ]
            ], [
                'unit_number' => 3,
                'barcode' => 'T46460772001592003',
                'unit_type' => 'COL',
                'contains_packages' => 0,
                'description' => 'HANDWASHING SOAP DISPENSER',
                'exchange_unit' => 0,
                'references' => [
                    [
                        'type' => 'delivery_note',
                        'reference' => 'Z100291924500027'
                    ], [
                        'type' => 'carrier_reference',
                        'reference' => '7050061'
                    ]
                ],
                'measurements' => [
                    'weight' => 8,
                    'length' => 0,
                    'width' => 0,
                    'height' => 0,
                    'volume' => 0,
                    'loading_meter' => 0
                ]
            ]
        ],
        'labels' => 'zpl'
    ]);
    
    // store label
    $filepath = '/path/to/label.zpl';
    \Onetoweb\TransMission\Utils::storeLabel($filepath, $results);


Finalize shipment
`````````````````

.. code-block:: php
    
    $tx = 'T99999999999999';
    $results = $client->shipment->finalize($tx);


Change shipment date
````````````````````

.. code-block:: php
    
    $tx = 'T99999999999999';
    $date = (new DateTime())->modify('+1 day');
    $results = $client->shipment->changeDate($tx, $date);


Delete shipment
```````````````

.. code-block:: php
    
    $tx = 'T99999999999999';
    $results = $client->shipment->delete($tx);


Get shipment
````````````

.. code-block:: php
    
    $tx = 'T99999999999999';
    $results = $client->shipment->status($tx);


Get shipments created after date
````````````````````````````````

.. code-block:: php
    
    $after = (new DateTime())->modify('-1 month');
    $results = $client->shipment->getAfter($after);


`Back to top <#top>`_