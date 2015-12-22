<?php


$configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tt_news']);


if (isset($configuration['activateCategories']) && $configuration['activateCategories']) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable('tt_news', 'tt_news');
}

