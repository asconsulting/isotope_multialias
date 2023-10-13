<?php

/**
 * Isotope Multi Alias
 *
 * Copyright (C) 2019 Andrew Stevens Consulting
 *
 * @package    asconsulting/isotope_multialias
 * @link       https://andrewstevens.consulting
 */

 

/**
 * Frontend modules
 */
$GLOBALS['FE_MOD']['isotope']['iso_productreader'] = 'MultiAlias\Module\MultiAliasProductReader';


/**
 * Products
 */
\Isotope\Model\Product::registerModelType('multiAlias', 'MultiAlias\Model\Product\MultiAlias');


/**
 * Attributes
 */
\Isotope\Model\Attribute::registerModelType('alternateAlias', 'MultiAlias\Model\Attribute\AlternateAlias');


/**
 * Backend form fields
 */
$GLOBALS['BE_FFL']['alternateAlias'] = 'TextField';