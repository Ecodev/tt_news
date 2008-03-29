<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2004-2008 Rupert Germann <rupi@gmx.li>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   54: class tx_ttnews_div
 *   87:     function getAllowedCategories()
 *  119:     function getSubCategories($catlist, $cc = 0)
 *  146:     function getCategoryTreeIDs()
 *
 * TOTAL FUNCTIONS: 3
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */




/**
 * tt_news misc functions
 *
 * $Id: class.tx_ttnews_TCAform_selectTree.php 8670 2008-03-21 15:28:49Z rupertgermann $
 *
 * @author	Rupert Germann <rupi@gmx.li>
 * @package TYPO3
 * @subpackage tt_news
 */
class tx_ttnews_div {
	function useAllowedCategories () {
		global $BE_USER;
		if (!$BE_USER->isAdmin()) {
			if ($BE_USER->user['tt_news_categorymounts']) {
				$this->allowedItemsFromTreeSelector = TRUE;
				return TRUE;
			} else { // no categorymounts set in be_user record - check groups
				if (is_array($BE_USER->userGroups)) {
					$cmounts = array();
					foreach ($BE_USER->userGroups as $group) {
						if ($group['tt_news_categorymounts']) {
							$cmounts[] = $group['tt_news_categorymounts'];
						}
					}
					$cMountList = implode(',',$cmounts);
					if ($cMountList) {
						$this->allowedItemsFromTreeSelector = TRUE;
						return TRUE;
					}
				}
			}
			if ($BE_USER->getTSConfigVal('options.useListOfAllowedItems')) {
				return TRUE;
			}
		}
	}

	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function getAllowedCategories() {
		global $BE_USER;

		$cmounts = array();

		if (is_array($BE_USER->userGroups)) {
			foreach ($BE_USER->userGroups as $group) {
				if ($group['tt_news_categorymounts']) {
					$cmounts[] = $group['tt_news_categorymounts'];
				}
			}
		}
		if ($BE_USER->user['tt_news_categorymounts']) {
			$cmounts[] = $BE_USER->user['tt_news_categorymounts'];
		}
		$categoryMounts = implode(',',$cmounts);

		if ($categoryMounts) {
			$subcats = $this->getSubCategories($categoryMounts);
			$categoryMounts = implode(',', array_unique(explode(',', $categoryMounts.($subcats?','.$subcats:''))));
		}
		return $categoryMounts;
	}


	/**
	 * extends a given list of categories by their subcategories
	 *
	 * @param	string		$catlist: list of categories which will be extended by subcategories
	 * @param	integer		$cc: counter to detect recursion in nested categories
	 * @return	string		extended $catlist
	 */
	function getSubCategories($catlist, $cc = 0) {
		$sCatArr = array();
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'uid',
			'tt_news_cat',
			'tt_news_cat.parent_category IN ('.$catlist.') AND deleted=0');

		while (($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
			$cc++;
			if ($cc > 10000) {
				$GLOBALS['TT']->setTSlogMessage('tt_news: one or more recursive categories where found');
				return implode(',', $sCatArr);
			}
			$subcats = $this->getSubCategories($row['uid'], $cc);
			$subcats = $subcats?','.$subcats:'';
			$sCatArr[] = $row['uid'].$subcats;
		}
		$catlist = implode(',', $sCatArr);
		return $catlist;
	}


	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function getCategoryTreeIDs() {
		global $BE_USER;

		// get include/exclude items
		$excludeList = $BE_USER->getTSConfigVal('tt_newsPerms.tt_news_cat.excludeList');
		$includeList = $BE_USER->getTSConfigVal('tt_newsPerms.tt_news_cat.includeList');
		$catmounts = $this->getAllowedCategories();
		if ($catmounts) {
			$includeList = $catmounts;
		}

		if ($excludeList) {
			$catlistWhere = ' AND tt_news_cat.uid NOT IN ('.implode(t3lib_div::intExplode(',',$excludeList),',').')';
		}
		if ($includeList) {
			$catlistWhere = ' AND tt_news_cat.uid IN ('.implode(t3lib_div::intExplode(',',$includeList),',').')';
		}

		$treeIDs = array();
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', 'tt_news_cat', '1=1' .$catlistWhere. ' AND deleted=0');
		while (($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
			$treeIDs[]=$row['uid'];
		}
		return implode(',',$treeIDs);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/lib/class.tx_ttnews_div.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/lib/class.tx_ttnews_div.php']);
}
?>