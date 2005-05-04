<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2003-2004 Ren� Fritz (r.fritz@colorcube.de)
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * This function displays a selector with nested categories.
 * The code is borrowed from the extension "Digital Asset Management" (tx_dam)
 *
 * @author	Ren� Fritz <r.fritz@colorcube.de>
 * @author	Rupert Germann <rupi@gmx.li>
 * @package TYPO3
 * @subpackage tt_news
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   52: class tt_news_tceFunc_selectTreeView extends t3lib_treeview
 *   57:     function wrapTitle($title,$v)
 *
 *
 *   75: class user_treeview
 *   88:     function user_categoryTree($PA, $fobj)
 *
 * TOTAL FUNCTIONS: 2
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

 require_once(PATH_t3lib.'class.t3lib_treeview.php');

class tx_ttnews_tceFunc_selectTreeView extends t3lib_treeview {

	var $TCEforms_itemFormElName='';
	var $TCEforms_nonSelectableItemsArray=array();

	function wrapTitle($title,$v)	{
		if($v['uid']>0) {
			if (in_array($v['uid'],$this->TCEforms_nonSelectableItemsArray)) {
				return '<span style="color:grey">'.$title.'</span>';
			} else {
				$aOnClick = 'setFormValueFromBrowseWin(\''.$this->TCEforms_itemFormElName.'\','.$v['uid'].',\''.$title.'\'); return false;';
				return '<a href="#" onclick="'.htmlspecialchars($aOnClick).'">'.$title.'</a>';
			}
		} else {
			return $title;
		}
	}
}

class tx_ttnews_treeview {

	/**
	 * Generation of TCEform elements of the type "select"
	 * This will render a selector box element, or possibly a special construction with two selector boxes. That depends on configuration.
	 * (this is a copy of the function getSingleField_selectTree() from class tx_dam_tceFunc.
	 *
	 * @param	string		The table name of the record
	 * @param	string		The field name which this element is supposed to edit
	 * @param	array		The record data array where the value(s) for the field can be found
	 * @param	array		An array with additional configuration options.
	 * @return	string		The HTML code for the TCEform field
	 */
	function displayCategoryTree($PA, $fobj)    {

		$table = $PA['table'];
		$field = $PA['field'];
		$row = $PA['row'];

		$this->pObj = &$PA['pObj'];


			// Field configuration from TCA:
		$config = $PA['fieldConf']['config'];
			// it seems TCE has a bug and do not work correctly with '1'
		$config['maxitems'] = ($config['maxitems']==2) ? 1 : $config['maxitems'];

			// Getting the selector box items from the system
		$selItems = $this->pObj->addSelectOptionsToItemArray($this->pObj->initItemArray($PA['fieldConf']),$PA['fieldConf'],$this->pObj->setTSconfig($table,$row),$field);
		$selItems = $this->pObj->addItems($selItems,$PA['fieldTSConfig']['addItems.']);
		#if ($config['itemsProcFunc']) $selItems = $this->pObj->procItems($selItems,$PA['fieldTSConfig']['itemsProcFunc.'],$config,$table,$row,$field);

			// Possibly remove some items:
		$removeItems=t3lib_div::trimExplode(',',$PA['fieldTSConfig']['removeItems'],1);

		foreach($selItems as $tk => $p)	{
			if (in_array($p[1],$removeItems))	{
				unset($selItems[$tk]);
			} else if (isset($PA['fieldTSConfig']['altLabels.'][$p[1]])) {
				$selItems[$tk][0]=$this->pObj->sL($PA['fieldTSConfig']['altLabels.'][$p[1]]);
			}

				// Removing doktypes with no access:
			if ($table.'.'.$field == 'pages.doktype')	{
				if (!($GLOBALS['BE_USER']->isAdmin() || t3lib_div::inList($GLOBALS['BE_USER']->groupData['pagetypes_select'],$p[1])))	{
					unset($selItems[$tk]);
				}
			}
		}

			// Creating the label for the "No Matching Value" entry.
		$nMV_label = isset($PA['fieldTSConfig']['noMatchingValue_label']) ? $this->pObj->sL($PA['fieldTSConfig']['noMatchingValue_label']) : '[ '.$this->pObj->getLL('l_noMatchingValue').' ]';
		$nMV_label = @sprintf($nMV_label, $PA['itemFormElValue']);

			// Prepare some values:
		$maxitems = intval($config['maxitems']);
		$minitems = intval($config['minitems']);
		$size = intval($config['size']);

			// If a SINGLE selector box...
		if ($maxitems<=1 AND !$config['treeView'])	{

		} else {
			$item.= '<input type="hidden" name="'.$PA['itemFormElName'].'_mul" value="'.($config['multiple']?1:0).'" />';

				// Set max and min items:
			$maxitems = t3lib_div::intInRange($config['maxitems'],0);
			if (!$maxitems)	$maxitems=100000;
			$minitems = t3lib_div::intInRange($config['minitems'],0);

				// Register the required number of elements:
			$this->pObj->requiredElements[$PA['itemFormElName']] = array($minitems,$maxitems,'imgName'=>$table.'_'.$row['uid'].'_'.$field);


			if($config['treeView'] AND $config['foreign_table']) {
				global $TCA, $LANG;

				if ($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tt_news']) { // get tt_news extConf array
					$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tt_news']);
				}
				if ($confArr['useStoragePid']) {
					$TSconfig = t3lib_BEfunc::getTCEFORM_TSconfig($table,$row);
					$storagePid = $TSconfig['_STORAGE_PID']?$TSconfig['_STORAGE_PID']:0;
					$SPaddWhere = ' AND tt_news_cat.pid IN (' . $storagePid . ')';

				}
				if ($GLOBALS['BE_USER']->getTSConfigVal('options.useListOfAllowedItems') && !$GLOBALS['BE_USER']->isAdmin()) {
					$notAllowedItems = $this->getNotAllowedItems($PA,$SPaddWhere);
				}

				if($config['treeViewClass'] AND is_object($treeViewObj = &t3lib_div::getUserObj($config['treeViewClass'],'user_',false)))      {
				} else {
					$treeViewObj = t3lib_div::makeInstance('tx_ttnews_tceFunc_selectTreeView');
				}
				$treeViewObj->table = $config['foreign_table'];


				$where = ' '.str_replace('###STORAGE_PID###',$storagePid,$config['foreign_table_where']);
				$treeViewObj->init($where);
				$treeViewObj->backPath = $this->pObj->backPath;
				$treeViewObj->parentField = $TCA[$config['foreign_table']]['ctrl']['treeParentField'];
				$treeViewObj->expandAll = 1;
				$treeViewObj->expandFirst = 1;

				$treeViewObj->ext_IconMode = '1'; // no context menu on icons
				$treeViewObj->title = $LANG->sL($TCA[$config['foreign_table']]['ctrl']['title']);

				$treeViewObj->TCEforms_itemFormElName = $PA['itemFormElName'];
				if ($table==$config['foreign_table']) {
					$treeViewObj->TCEforms_nonSelectableItemsArray[] = $row['uid'];
				}
				
				if (is_array($notAllowedItems) && $notAllowedItems[0]) {
					foreach ($notAllowedItems as $k) {
						$treeViewObj->TCEforms_nonSelectableItemsArray[] = $k;
					}
				}
				$treeContent=$treeViewObj->getBrowsableTree();
				$treeItemC = count($treeViewObj->ids);

				 // find errors
				$errorMsg = array();
				if ($table == 'tt_news_cat' || $table == 'tt_news') {
					if ($table == 'tt_news_cat' && $row['pid'] == $storagePid && intval($row['uid']) && !in_array($row['uid'],$treeViewObj->ids))	{ // if the current category is not empty and not in the array of tree-uids it seems to be part of a chain of recursive categories
						$recursionDetected = 'RECURSIVE CATEGORIES DETECTED!! <br />This record is part of a chain of recursive categories. The affected categories will not be displayed in the category tree.  You should remove the parent category of this record to prevent this.';
					}
					if ($table == 'tt_news' && $row['category']) { // find recursive categories in the tt_news db-record
						$catvals = explode(',',$row['category']); // categories of the current record
						$recursiveCategories = array();
						$showncats = implode($treeViewObj->ids,','); // displayed categories (tree)
						foreach ($catvals as $k) {
							$c = explode('|',$k);
							if(!t3lib_div::inList($showncats,$c[0])) { 
								$recursiveCategories[]=$c;
							}
						}
						if ($recursiveCategories[0])  {
							$rcArr = array();
							foreach ($recursiveCategories as $k => $cat) {
								$rcArr[] = $cat[1].' ('.$cat[0].')'; // format result: title (uid)
							}
							$rcList = implode($rcArr,', ');
							$recursionDetected = 'RECURSIVE CATEGORIES DETECTED!! <br />This record has the following recursive categories assigned: '.$rcList.'<br />Recursive categories will not be shown in the category tree and will be therefor not selectable. To solve this problem mark these categories in the left select field, click on "edit category" and delete the parent category of the recursive category.';
						}
					}
					if ($recursionDetected) {
						$errorMsg[] = '<table class="warningbox" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><img src="gfx/icon_fatalerror.gif" class="absmiddle" alt="" height="16" width="18">'.$recursionDetected.'</td></tr></tbody></table>';
					}
					if ($storagePid && $row['pid'] != $storagePid && $table == 'tt_news_cat') { // if a storagePid is defined but the current category is not stored in storagePid
						$errorMsg[] = '<p style="padding:10px;"><img src="gfx/icon_warning.gif" class="absmiddle" alt="" height="16" width="18"><strong style="color:red;"> Warning:</strong><br />tt_news is configured to display categories only from the "General record storage page" (GRSP). The current category is not located in the GRSP and will so not be displayed. To solve this you should either define a GRSP or disable "Use StoragePid" in the extension manager.</p>';
					}
				}

				$width = 280; // default width for the field with the category tree
				

				if (intval($confArr['categoryTreeWidth'])) { // if a value is set in extConf take this one.
					$width = t3lib_div::intInRange($confArr['categoryTreeWidth'],1,600);
				} elseif ($GLOBALS['CLIENT']['BROWSER']=='msie') { // to suppress the unneeded horizontal scrollbar IE needs a width of at least 320px 
					$width = 320;
				}

				$config['autoSizeMax'] = t3lib_div::intInRange($config['autoSizeMax'],0);
				$height = $config['autoSizeMax'] ? t3lib_div::intInRange($treeItemC+2,t3lib_div::intInRange($size,1),$config['autoSizeMax']) : $size;
					// hardcoded: 16 is the height of the icons
				$height=$height*16;

				$divStyle = 'position:relative; left:0px; top:0px; height:'.$height.'px; width:'.$width.'px;border:solid 1px;overflow:auto;background:#fff;margin-bottom:5px;';
				$thumbnails='<div  name="'.$PA['itemFormElName'].'_selTree" style="'.htmlspecialchars($divStyle).'">';
				$thumbnails.=$treeContent;
				$thumbnails.='</div>';

			} else {

				$sOnChange = 'setFormValueFromBrowseWin(\''.$PA['itemFormElName'].'\',this.options[this.selectedIndex].value,this.options[this.selectedIndex].text); '.implode('',$PA['fieldChangeFunc']);

					// Put together the select form with selected elements:
				$selector_itemListStyle = isset($config['itemListStyle']) ? ' style="'.htmlspecialchars($config['itemListStyle']).'"' : ' style="'.$this->pObj->defaultMultipleSelectorStyle.'"';
				$size = $config['autoSizeMax'] ? t3lib_div::intInRange(count($itemArray)+1,t3lib_div::intInRange($size,1),$config['autoSizeMax']) : $size;
				$thumbnails = '<select style="width:150px;" name="'.$PA['itemFormElName'].'_sel"'.$this->pObj->insertDefStyle('select').($size?' size="'.$size.'"':'').' onchange="'.htmlspecialchars($sOnChange).'"'.$PA['onFocus'].$selector_itemListStyle.'>';
				#$thumbnails = '<select                       name="'.$PA['itemFormElName'].'_sel"'.$this->pObj->insertDefStyle('select').($size?' size="'.$size.'"':'').' onchange="'.htmlspecialchars($sOnChange).'"'.$PA['onFocus'].$selector_itemListStyle.'>';
				foreach($selItems as $p)	{
					$thumbnails.= '<option value="'.htmlspecialchars($p[1]).'">'.htmlspecialchars($p[0]).'</option>';
				}
				$thumbnails.= '</select>';

			}

				// Perform modification of the selected items array:
			$itemArray = t3lib_div::trimExplode(',',$PA['itemFormElValue'],1);
			foreach($itemArray as $tk => $tv) {
				$tvP = explode('|',$tv,2);
				if (in_array($tvP[0],$removeItems) && !$PA['fieldTSConfig']['disableNoMatchingValueElement'])	{
					$tvP[1] = rawurlencode($nMV_label);
				} elseif (isset($PA['fieldTSConfig']['altLabels.'][$tvP[0]])) {
					$tvP[1] = rawurlencode($this->pObj->sL($PA['fieldTSConfig']['altLabels.'][$tvP[0]]));
				} else {
					$tvP[1] = rawurlencode($this->pObj->sL(rawurldecode($tvP[1])));
				}
				$itemArray[$tk]=implode('|',$tvP);
			}
			$sWidth = 150; // default width for the left field of the category select
			if (intval($confArr['categorySelectedWidth'])) {
				$sWidth = t3lib_div::intInRange($confArr['categorySelectedWidth'],1,600);
			}
			$params=array(
				'size' => $size,
				'autoSizeMax' => t3lib_div::intInRange($config['autoSizeMax'],0),
				#'style' => isset($config['selectedListStyle']) ? ' style="'.htmlspecialchars($config['selectedListStyle']).'"' : ' style="'.$this->pObj->defaultMultipleSelectorStyle.'"',
				'style' => ' style="width:'.$sWidth.'px;"',
				'dontShowMoveIcons' => ($maxitems<=1),
				'maxitems' => $maxitems,
				'info' => '',
				'headers' => array(
					'selector' => $this->pObj->getLL('l_selected').':<br />',
					'items' => $this->pObj->getLL('l_items').':<br />'
				),
				'noBrowser' => 1,
				'thumbnails' => $thumbnails
			);
			$item.= $this->pObj->dbFileIcons($PA['itemFormElName'],'','',$itemArray,'',$params,$PA['onFocus']);
		}
		#debug (array($PA));

			// Wizards:
		$altItem = '<input type="hidden" name="'.$PA['itemFormElName'].'" value="'.htmlspecialchars($PA['itemFormElValue']).'" />';
		$item = $this->pObj->renderWizards(array($item,$altItem),$config['wizards'],$table,$row,$field,$PA,$PA['itemFormElName'],$specConf);

		return $this->NA_Items.implode($errorMsg,chr(10)).$item;

	}

	function getNotAllowedItems($PA,$SPaddWhere) {
		$fTable = $PA['fieldConf']['config']['foreign_table'];
		$allowedItemsList=$GLOBALS['BE_USER']->getTSConfigVal('tt_newsPerms.'.$fTable.'.allowedItems');

		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', $fTable, '1=1' .$SPaddWhere. t3lib_BEfunc::BEenableFields($fTable));
		$itemArr = array();
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			if(!t3lib_div::inList($allowedItemsList,$row['uid'])) {
				$itemArr[]=$row['uid'];
			}
		}
		$catvals = explode(',',$PA['row']['category']);
		$notAllowedItems = array();
		foreach ($catvals as $k) {
			$c = explode('|',$k);
			if(!t3lib_div::inList($allowedItemsList,$c[0])) {
				$notAllowedItems[]=$c[0];
			}
		}

		if ($notAllowedItems[0]) {
			$this->NA_Items = '<table class="warningbox" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><img src="gfx/icon_fatalerror.gif" class="absmiddle" alt="" height="16" width="18">SAVING DISABLED!! <br />This record has one or more categories assigned that are not defined in your BE usergroup (tablename.allowedItems).</td></tr></tbody></table>';
		}
		return $itemArr;

	}
}
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/class.tx_ttnews_treeview.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/class.tx_ttnews_treeview.php']);
}
?>