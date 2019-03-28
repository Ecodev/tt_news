<?php
$tca = [
	'ctrl' => [
		'title' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tt_news',
		'label' => 'title',
		'default_sortby' => 'ORDER BY datetime DESC',
		'prependAtCopy' => '-prependAtCopy',
		'shadowColumnsForNewPlaceholders' => 'sys_language_uid,l18n_parent,starttime, endtime',
		'dividers2tabs' => true,
		'useColumnsForDefaultValues' => 'type',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'languageField' => 'sys_language_uid',
		'crdate' => 'crdate',
		'tstamp' => 'tstamp',
		'delete' => 'deleted',
		'type' => 'type',
		'cruser_id' => 'cruser_id',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		'iconfile' => 'EXT:tt_news/Resources/Public/Images/ext_icon.gif',
	],
	'interface' => [
		'showRecordFieldList' => 'title,hidden,datetime,starttime,archivedate,author,author_email,short,related'
	],
	'columns' => [
		'starttime' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:start',
			'config' => [
				'type' => 'input',
				'size' => '10',
                'renderType' => 'inputDateTime',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0'
			]
		],
		'endtime' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:stop',
			'config' => [
				'type' => 'input',
				'size' => '8',
                'renderType' => 'inputDateTime',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0',
				'range' => [
					'upper' => mktime(0,0,0,12,31,2020),
					'lower' => mktime(0,0,0,date('m')-1,date('d'),date('Y'))
				]
			]
		],
		'hidden' => [
			'l10n_mode' => '',
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:disable',
			'config' => [
				'type' => 'check',
				'default' => '1'
			]
		],
		'fe_group' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:frontendGroup',
			'config' => [
				'type' => 'input',
				'size' => 5,
			]
		],
 		'title' => [
 			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:title',
			'l10n_mode' => 'prefixLangTitle',
 			'config' => [
 				'type' => 'input',
 				'size' => '40',
		    ]
	    ],
		'ext_url' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:externalLink',
			'config' => [
				'type' => 'input',
				'size' => '40',
			]
		],
		'bodytext' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:text',
			'l10n_mode' => 'prefixLangTitle',
			'config' => [
				'type' => 'text',
                'enableRichtext' => true,
				'cols' => '48',
				'rows' => '5',
			]
		],
		'short' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:short',
			'l10n_mode' => 'prefixLangTitle',
			'config' => [
				'type' => 'text',
				'cols' => '40',
				'rows' => '3'
			]
		],
		'type' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:type',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:type.I.0', 0],
					['LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:type.I.1', 1],
					['LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:type.I.2', 2]
				],
				'default' => 0
			]
		],
		'datetime' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:datetime',
			'config' => [
				'type' => 'input',
				'size' => '10',
                'renderType' => 'inputDateTime',
				'eval' => 'datetime',
				'default' => mktime(date("H"),date("i"),0,date("m"),date("d"),date("Y"))
			]
		],
		'archivedate' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:archivedate',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'size' => '10',
				'eval' => 'date',
				'default' => '0'
			]
		],
		'image' => [
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:image',
			'config' => [
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => '10000',
				'uploadfolder' => 'uploads/pics',
				'size' => 3,
				'autoSizeMax' => 15,
				'maxitems' => '99',
				'minitems' => '0'
			]
		],
		'author' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:author',
			'config' => [
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
			]
		],
		'author_email' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:authorEmail',
			'config' => [
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
			]
		],
		'related' => [
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:related',
			'config' => [
				'type' => 'group',
				'internal_type' => 'db',
					'allowed' => 'tt_news,pages',
					'MM' => 'tt_news_related_mm',
				'size' => '3',
				'autoSizeMax' => 10,
				'maxitems' => '200',
				'minitems' => '0',
			]
		],
		'keywords' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:keywords',
			'config' => [
				'type' => 'text',
				'cols' => '40',
				'rows' => '3'
			]
		],
		'links' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:links',
			'config' => [
				'type' => 'text',
				'cols' => '40',
				'rows' => '3'
			]
		],
		'page' => [
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:shortcutPage',
			'config' => [
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => '1',
				'maxitems' => '1',
				'minitems' => '0',
			]
		],
		'news_files' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:media',
			'config' => [
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	// Must be empty for disallowed to work.
				'disallowed' => 'php,php3',
				'max_size' => '10000',
				'uploadfolder' => 'uploads/media',
				'size' => '3',
				'autoSizeMax' => '10',
				'maxitems' => '100',
				'minitems' => '0'
			]
		],
		'sys_language_uid' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:language',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => [
					['-allLanguages',-1],
					['-default_value',0]
				]
			]
		],
		'l18n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'label' => '',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tt_news',
				'foreign_table_where' => 'AND tt_news.pid=###CURRENT_PID### AND tt_news.sys_language_uid IN (-1,0)',
			]
		],
		'l18n_diffsource' => [
			'config'=> [
				'type'=>'passthrough']
		],

		/**
		 * The following fields have to be configured here to get them processed by the listview in the tt_news BE module
		 * they should never appear in the 'showitem' list as editable fields, though.
		 */
		'uid' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:uid',
			'config' => [
				'type' => 'none'
			]
		],
		'pid' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:pid',
			'config' => [
				'type' => 'none'
			]
		],
		'tstamp' => [
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tstamp',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'eval' => 'datetime',
			]
		],

	],
	'types' => [
		'0' => ['showitem' =>
			'hidden, type,title, short,bodytext,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.special, datetime ,archivedate,author,
				keywords ,sys_language_uid,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.media, image, links, news_files,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.relations, related,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.access, starttime, endtime,
			'],

		'1' => ['showitem' =>
			'hidden, type,title ,page,short,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.special, datetime ,archivedate, author,
				keywords ,sys_language_uid,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.media, image,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.categories,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.access, starttime, endtime,
			'],

		'2' => ['showitem' =>
			'hidden, type,title ,ext_url,short,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.special, datetime ,archivedate, author,
				keywords ,sys_language_uid,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.media, image,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.categories,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.access, starttime, endtime,
			']
	],
	'palettes' => [
		'1' => ['showitem' => 'l18n_parent'],
		'3' => ['showitem' => 'author_email'],

	]
];

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('vidi')) {
    $tca['grid'] = [
        'facets' => [
            'uid',
        ],
        'columns' => [
            '__checkbox' => [
                'renderer' => \Fab\Vidi\Grid\CheckBoxRenderer::class,
            ],
            'title' => [
                'visible' => true,
            ],
            'short' => [
                'visible' => true,
            ],
            '__buttons' => [
                'renderer' => \Fab\Vidi\Grid\ButtonGroupRenderer::class,
            ],
        ]
    ];
}
return $tca;
