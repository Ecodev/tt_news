<?php
return [
	'ctrl' => [
		'title' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tt_news',
		'label' => 'title',
		'default_sortby' => 'ORDER BY datetime DESC',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.php:LGL.prependAtCopy',
		'shadowColumnsForNewPlaceholders' => 'sys_language_uid,l18n_parent,starttime, endtime, fe_group',

		'dividers2tabs' => TRUE,
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
			'fe_group' => 'fe_group',
		],
		'typeicon_column' => 'type',
		'typeicons' => [
			'1' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tt_news').'Resources/Public/Images/tt_news_article.gif',
			'2' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tt_news').'Resources/Public/Images/tt_news_exturl.gif',
		],
//		'mainpalette' => '10',
		'thumbnail' => 'image',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tt_news').'Resources/Public/Images/ext_icon.gif',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('tt_news').'tca.php'
	],
	'interface' => [
		'showRecordFieldList' => 'title,hidden,datetime,starttime,archivedate,author,author_email,short,image,links,related,news_files'
	],
	'columns' => [
		'starttime' => [
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.starttime',
			'config' => [
				'type' => 'input',
				'size' => '10',
				'max' => '20',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0'
			]
		],
		'endtime' => [
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.endtime',
			'config' => [
				'type' => 'input',
				'size' => '8',
				'max' => '20',
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
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.hidden',
			'config' => [
				'type' => 'check',
				'default' => '1'
			]
		],
		'fe_group' => [
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.fe_group',
			'config' => [
				'type' => 'select',
				'size' => 5,
				'maxitems' => 20,
				'items' => [
					['LLL:EXT:lang/locallang_general.php:LGL.hide_at_login', -1],
					['LLL:EXT:lang/locallang_general.php:LGL.any_login', -2],
					['LLL:EXT:lang/locallang_general.php:LGL.usergroups', '--div--']
				],
				'exclusiveKeys' => '-1,-2',
				'foreign_table' => 'fe_groups'
			]
		],
 		'title' => [
 			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.title',
			'l10n_mode' => 'prefixLangTitle',
 			'config' => [
 				'type' => 'input',
 				'size' => '40',
 				'max' => '256'
		    ]
	    ],
		'ext_url' => [
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.external',
			'config' => [
				'type' => 'input',
				'size' => '40',
				'max' => '256',
				'wizards' => [
					'link' => [
						'type' => 'popup',
						'title' => 'Link',
						'icon' => 'link_popup.gif',
						'module' => [
							'name' => 'wizard_element_browser',
						],
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
					]
				]
			]
		],
		'bodytext' => [
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.text',
			'l10n_mode' => 'prefixLangTitle',
			'config' => [
				'type' => 'text',
				'cols' => '48',
				'rows' => '5',
				'softref' => 'typolink_tag,images,email[subst],url',
			]
		],
		'short' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.subheader',
			'l10n_mode' => 'prefixLangTitle',
			'config' => [
				'type' => 'text',
				'cols' => '40',
				'rows' => '3'
			]
		],
		'type' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.type',
			'config' => [
				'type' => 'select',
				'items' => [
					['LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:type.I.0', 0],
					['LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:type.I.1', 1],
					['LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:type.I.2', 2]
				],
				'default' => 0
			]
		],
		'datetime' => [
			'l10n_mode' => 'mergeIfNotBlank',
			'exclude' => 1,
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:datetime',
			'config' => [
				'type' => 'input',
				'size' => '10',
				'max' => '20',
				'eval' => 'datetime',
				'default' => mktime(date("H"),date("i"),0,date("m"),date("d"),date("Y"))
			]
		],
		'archivedate' => [
			'l10n_mode' => 'mergeIfNotBlank',
			'exclude' => 1,
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:archivedate',
			'config' => [
				'type' => 'input',
				'size' => '10',
				'max' => '20',
				'eval' => 'date',
				'default' => '0'
			]
		],
		'image' => [
			'exclude' => 1,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.images',
			'config' => [
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => '10000',
				'uploadfolder' => 'uploads/pics',
				'show_thumbs' => '1',
				'size' => 3,
				'autoSizeMax' => 15,
				'maxitems' => '99',
				'minitems' => '0'
			]
		],
		'author' => [
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.author',
			'config' => [
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '80'
			]
		],
		'author_email' => [
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.email',
			'config' => [
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '80'
			]
		],
		'related' => [
			'exclude' => 1,
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
				'show_thumbs' => '1',
				'wizards' => [
					'suggest' => [
						'type' => 'suggest'
					]
				]
			]
		],
		'keywords' => [
			'l10n_mode' => 'mergeIfNotBlank',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.keywords',
			'config' => [
				'type' => 'text',
				'cols' => '40',
				'rows' => '3'
			]
		],
		'links' => [
			'l10n_mode' => 'mergeIfNotBlank',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.links',
			'config' => [
				'type' => 'text',
				'cols' => '40',
				'rows' => '3'
			]
		],
		'page' => [
			'exclude' => 1,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.shortcut_page',
			'config' => [
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => '1',
				'maxitems' => '1',
				'minitems' => '0',
				'show_thumbs' => '1'
			]
		],
		'news_files' => [
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:media',
			'config' => [
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	// Must be empty for disallowed to work.
				'disallowed' => 'php,php3',
				'max_size' => '10000',
				'uploadfolder' => 'uploads/media',
				'show_thumbs' => '1',
				'size' => '3',
				'autoSizeMax' => '10',
				'maxitems' => '100',
				'minitems' => '0'
			]
		],
		'sys_language_uid' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => [
					['LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1],
					['LLL:EXT:lang/locallang_general.php:LGL.default_value',0]
				]
			]
		],
		'l18n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
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
				'eval' => 'datetime',
			]
		],

	],
	'types' => [
		'0' => ['showitem' =>
			'hidden, type;;;;1-1-1,title, short,bodytext;;2;richtext:rte_transform[flag=rte_enabled|mode=ts];4-4-4,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.special, datetime ,archivedate,author;;3;;  ,
				keywords ,sys_language_uid;;1;;3-3-3,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.media, image;;;;1-1-1, links, news_files,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.relations, related,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.access, starttime, endtime, fe_group,
			'],

		'1' => ['showitem' =>
			'hidden, type;;;;1-1-1,title ,page,short,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.special, datetime ,archivedate, author;;3;;  ,
				keywords ,sys_language_uid;;1;;3-3-3,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.media, image;;;;1-1-1,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.categories,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.access, starttime, endtime, fe_group,
			'],

		'2' => ['showitem' =>
			'hidden, type;;;;1-1-1,title ,ext_url,short,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.special, datetime ,archivedate, author;;3;;  ,
				keywords ,sys_language_uid;;1;;3-3-3,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.media, image;;;;1-1-1,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.categories,
			--div--;LLL:EXT:tt_news/Resources/Private/Language/tt_news.xlf:tabs.access, starttime, endtime, fe_group,
			']
	],
	'palettes' => [
		'1' => ['showitem' => 'l18n_parent'],
		'3' => ['showitem' => 'author_email'],

	]
];