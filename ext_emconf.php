<?php

$EM_CONF['cart_news'] = [
    'title' => 'Cart - News',
    'description' => 'Shopping Cart(s) for TYPO3 - News',
    'category' => 'plugin',
    'shy' => false,
    'version' => '1.0.0',
    'dependencies' => '',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'beta',
    'uploadfolder' => false,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => true,
    'lockType' => '',
    'author' => 'Daniel Gohlke',
    'author_email' => 'ext.cart@extco.de',
    'author_company' => 'extco.de UG (haftungsbeschränkt)',
    'CGLcompliance' => null,
    'CGLcompliance_note' => null,
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
            'cart' => '6.6.0-6.99.99',
            'news' => '7.3.0-7.99.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
