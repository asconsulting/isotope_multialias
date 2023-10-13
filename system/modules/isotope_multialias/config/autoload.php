<?php

/**
 * Isotope Multi Alias
 *
 * Copyright (C) 2019-2023 Andrew Stevens Consulting
 *
 * @package    asconsulting/isotope_multialias
 * @link       https://andrewstevens.consulting
 */

 

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    'MultiAlias\Backend\Attribute\MultiAliasCallback' 	=> 'system/modules/isotope_multialias/library/MultiAlias/Backend/Attribute/MultiAliasCallback.php',
	'MultiAlias\Model\Attribute\AlternateAlias' 		=> 'system/modules/isotope_multialias/library/MultiAlias/Model/Attribute/AlternateAlias.php',
	'MultiAlias\Model\Product\MultiAlias' 				=> 'system/modules/isotope_multialias/library/MultiAlias/Model/Product/MultiAlias.php',
	'MultiAlias\Module\MultiAliasProductReader' 		=> 'system/modules/isotope_multialias/library/MultiAlias/Module/MultiAliasProductReader.php'
));
