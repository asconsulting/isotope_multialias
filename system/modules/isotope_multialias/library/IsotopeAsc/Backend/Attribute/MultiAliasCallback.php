<?php

/**
 * Isotope Multi Alias
 *
 * Copyright (C) 2019 Andrew Stevens Consulting
 *
 * @package    asconsulting/isotope_multialias
 * @link       https://andrewstevens.consulting
 */

 
 
namespace IsotopeAsc\Backend\Attribute;

use Isotope\Model\Attribute;
use Isotope\Model\AttributeOption;
use Isotope\DatabaseUpdater;

class MultiAliasCallback extends \Backend
{
    /**
     * Alter attribute columns in tl_iso_product table
     *
     * @param object $dc
     */
    public function updateDatabase($dc)
    {
		if ($dc->activeRecord->type == 'alternateAlias') {
			$objPage = \PageModel::findByPk($dc->activeRecord->rootPage);
			$strAlias = 'alias_' .str_replace('-', '_', $objPage->alias);
			$dc->activeRecord->alias = $strAlias;
			\Database::getInstance()->prepare('UPDATE tl_iso_attribute SET name=?, field_name=? WHERE id=?')->execute("Alias for " .$objPage->title, $strAlias, $dc->activeRecord->id);
			
			// Make sure the latest SQL definitions are written to the DCA
			$GLOBALS['TL_CONFIG']['bypassCache'] = true;
			$this->loadDataContainer('tl_iso_product', true);

			$objUpdater = new DatabaseUpdater();
			$objUpdater->autoUpdateTables(array('tl_iso_product'));
			
		}
    }

	public function saveRootPage($varValue, $dc)
    {
		$isRoot = FALSE;
		$objRootPages = \PageModel::findPublishedRootPages();
		
		foreach ($objRootPages as $objPage) {
			if ($objPage->id == $varValue) {
				$isRoot = TRUE;
			}
		}
		
		if (!$isRoot) {
			throw new \LogicException('Root Pages only!');
		} else {
			return $varValue;
		}
	}
}
