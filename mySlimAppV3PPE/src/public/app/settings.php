<?php

    return [

            'settings' => [

                'displayErrorDetails' => true,
                'view' => [
                    'path' => __DIR__ . '/resources/views',
                    'twig' => [
                    'cache' => false
                    ]
                ],
				'db' => [
					'host' => '172.17.0.2',
					'user' => 'root',
					'pass' => 'btssio',
					'dbname' => 'slimTDBDD'
				]
				
            ]
    ];