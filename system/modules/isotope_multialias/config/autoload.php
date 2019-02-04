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
 * Register the classes
 */
ClassLoader::addClasses(array
(
    'IsotopeAsc\Backend\Attribute\MultiAliasCallback' 	=> 'system/modules/isotope_multialias/library/Isotope/Backend/Attribute/MultiAliasCallback.php',
	'IsotopeAsc\Model\Attribute\AlternateAlias' 		=> 'system/modules/isotope_multialias/library/Isotope/Model/Attribute/AlternateAlias.php',
	'IsotopeAsc\Model\Product\MultiAlias' 				=> 'system/modules/isotope_multialias/library/Isotope/Model/Product/MultiAlias.php',
	'IsotopeAsc\Module\MultiAliasProductReader' 		=> 'system/modules/isotope_multialias/library/Isotope/Module/MultiAliasProductReader.php'
));
