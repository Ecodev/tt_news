<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "tt_news".
 *
 * Auto generated 06-04-2014 16:50
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'News',
	'description' => 'Website news with front page teasers and article handling inside.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '3.6.0',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => 'mod1',
	'state' => 'beta',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'be_groups,be_users',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Rupert Germann [wmdb]',
	'author_email' => 'rupi@gmx.li',
	'author_company' => 'www.wmdb.de',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'typo3' => '4.5.0-6.2.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
);
