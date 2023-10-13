<?php

/**
 * Isotope Multi Alias
 *
 * Copyright (C) 2019-2023 Andrew Stevens Consulting
 *
 * @package    asconsulting/isotope_multialias
 * @link       https://andrewstevens.consulting
 */

 
 
namespace MultiAlias\Model\Product;

use Haste\Generator\RowClass;
use Haste\Units\Mass\Weight;
use Haste\Units\Mass\WeightAggregate;
use Haste\Util\Url;
use Isotope\Interfaces\IsotopeAttribute;
use Isotope\Interfaces\IsotopeAttributeForVariants;
use Isotope\Interfaces\IsotopeAttributeWithOptions;
use Isotope\Interfaces\IsotopeProduct;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Interfaces\IsotopeProductWithOptions;
use Isotope\Isotope;
use Isotope\Model\Attribute;
use Isotope\Model\Gallery;
use Isotope\Model\Gallery\Standard as StandardGallery;
use Isotope\Model\Product;
use Isotope\Model\Product\Standard;
use Isotope\Model\ProductCollectionItem;
use Isotope\Model\ProductPrice;
use Isotope\Model\ProductType;
use Isotope\Template;

/**
 * Standard implementation of an Isotope product.
 */
class MultiAlias extends Standard implements WeightAggregate, IsotopeProductWithOptions
{

	/**
     * Generate url
     *
     * @param \PageModel $objJumpTo A PageModel instance
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function generateUrl(\PageModel $objJumpTo = null)
    {
		global $objPage;
        if (null === $objJumpTo) {
           
            global $objIsotopeListPage;

            $objJumpTo = $objIsotopeListPage ?: $objPage;
        }

        if (null === $objJumpTo) {
            return '';
        }

		$strAlias = $this->arrData['alias'];
		
		// Lookup Root Page
		// If alias override for page, then use that for $strAlias instead
		
		$strAliasField = FALSE;
		$objParents = \PageModel::findParentsById($objPage->id);
		if ($objParents) {
			while ($objParents->next()) {
				if ($objParents->type == "root") {
					$strAliasField = 'alias_' .str_replace('-', '_', $objParents->alias);
				}
			}
						
			if ($this->{$strAliasField} != '') {
				$strAlias = $this->{$strAliasField};
			}
		}
				
        $strUrl = '/' . ($strAlias ?: $this->getProductId());

        if (!$GLOBALS['TL_CONFIG']['useAutoItem'] || !in_array('product', $GLOBALS['TL_AUTO_ITEM'], true)) {
            $strUrl = '/product' . $strUrl;
        }

        return Url::addQueryString(
            http_build_query($this->getOptions()),
            \Controller::generateFrontendUrl($objJumpTo->row(), $strUrl, $objJumpTo->language)
        );
    }
	
	 /**
     * Find a single product by its ID or alias
     *
     * @param mixed $varId      The ID or alias
     * @param array $arrOptions An optional options array
     *
     * @return static|null      The model or null if the result is empty
     */
    public static function findPublishedByIdOrAlias($varId, array $arrOptions = array())
    {
		global $objPage;
		$strAliasField = 'alias';
		$objParents = \PageModel::findParentsById($objPage->id);
		if ($objParents) {
			while ($objParents->next()) {
				if ($objParents->type == "root") {
					$strAliasField = 'alias_' .str_replace('-', '_', $objParents->alias);
				}
			}
		}
		
        $t = static::$strTable;

		if (!\Database::getInstance()->fieldExists($strAliasField, $t)) {
			$strAliasField = 'alias';
		}
		if ($strAliasField == 'alias') {
			$arrColumns = array("($t.id=? OR $t.$strAliasField=?)");
			$arrValues  = array(is_numeric($varId) ? $varId : 0, $varId);
		} else {
			$arrColumns = array("($t.id=? OR $t.$strAliasField=? OR $t.alias=?)");
			$arrValues  = array(is_numeric($varId) ? $varId : 0, $varId, $varId);
		}

        $arrOptions = array_merge(
            array(
                'limit'     => 1,
                'return'    => 'Model'
            ),
            $arrOptions
        );

        return static::findPublishedBy($arrColumns, $arrValues, $arrOptions);
    }
	
}