<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'News',
    'description' => 'Website news with front page teasers and article handling inside.',
    'category' => 'plugin',
    'version' => '4.0.0',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'state' => 'stable',
    'uploadfolder' => 1,
    'createDirs' => '',
    'author' => 'Rupert Germann [wmdb]',
    'author_email' => 'rupi@gmx.li',
    'author_company' => 'www.wmdb.de',
    'constraints' => [
        'depends' => [
            'cms' => '',
            'typo3' => '6.2.0-7.99.99',
        ],
        'conflicts' => [],
        'suggests' => [
            'vidi' => '3.2.0-0.0.0'
        ],
    ],
    'suggests' => [],
];
