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
 * Load tl_iso_product language file for field legends
 */
\System::loadLanguageFile('tl_iso_product');


/**
 * Table tl_iso_attribute
 */
$GLOBALS['TL_DCA']['tl_iso_attribute']['config']['onsubmit_callback'][] = array('MultiAlias\Backend\Attribute\MultiAliasCallback', 'updateDatabase');

 
// Palettes
$GLOBALS['TL_DCA']['tl_iso_attribute']['palettes']['alternateAlias'] = '{attribute_legend},type,legend,rootPage;{config_legend},minlength,maxlength;{search_filters_legend},fe_search,fe_sorting,be_search,be_filter';


// Fields
$GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['rootPage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_iso_attribute']['rootPage'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'foreignKey'              => 'tl_page.title',
	'eval'                    => array('mandatory' => true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'",
	'relation'                => array('type'=>'hasOne', 'load'=>'lazy'),
	'save_callback' => array
	(
		array('MultiAlias\Backend\Attribute\MultiAliasCallback', 'saveRootPage'),
	),
);

