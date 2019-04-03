<?php

/**
 * Isotope Multi Alias
 *
 * Copyright (C) 2019 Andrew Stevens Consulting
 *
 * @package    asconsulting/isotope_multialias
 * @link       https://andrewstevens.consulting
 */

 
 
namespace IsotopeAsc\Model\Attribute;

use Isotope\Model\Attribute;

/**
 * Attribute to implement AlternateAlias widget
 */
class AlternateAlias extends Attribute
{
    /**
     * @inheritdoc
     */
    public function saveToDCA(array &$arrData)
    {
        parent::saveToDCA($arrData);

        $arrData['fields'][$this->field_name]['rgxp'] 				= "alias";
        $arrData['fields'][$this->field_name]['eval']['tl_class'] 	= "clr w50";
        $arrData['fields'][$this->field_name]['sql'] 				= "varchar(255) NOT NULL default ''";
    }
}
