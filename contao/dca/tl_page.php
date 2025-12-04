<?php

// Palletes
$GLOBALS['TL_DCA']['tl_page']['palettes']['forward'] = str_replace(["alwaysForward;",'noSearch'],["alwaysForward,dontredirect;{navigation_legend},addImageForHeader;",'noSearch,iconselect'],$GLOBALS['TL_DCA']['tl_page']['palettes']['forward']);
$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] = str_replace(["canonicalKeepParams;",'noSearch'],["canonicalKeepParams;{navigation_legend},addImageForHeader,descriptiontitle;",'noSearch,iconselect'],$GLOBALS['TL_DCA']['tl_page']['palettes']['regular']);

// Subpalletes
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['addImageForHeader'] = 'singleSRC';

// Add selector for fields
array_push($GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'], 'addImageForHeader');

// Fields
// Don't redirect page if its set
$GLOBALS['TL_DCA']['tl_page']['fields']['dontredirect'] = array(
    'label'     => array('Do not redirect', 'Prevent redirect after form submission'),
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => array('tl_class' => 'w50'),
    'sql'       => array('type' => 'boolean', 'default' => false),
);

// Add image for header
$GLOBALS['TL_DCA']['tl_page']['fields']['addImageForHeader'] = array(
    'label' => array('Show page icon', 'Show an icon for this page in the navigation menu'),
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class'=>'w50','submitOnChange'=>true,),
    'sql' => array('type' => 'boolean', 'default' => false)
);

// Image
$GLOBALS['TL_DCA']['tl_page']['fields']['singleSRC'] = array(
    'label' => array('Page icon image', 'Choose the image or SVG used as an icon for this page in the navigation'),
    'inputType' => 'fileTree',
    'eval' => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory'=>true, 'tl_class'=>'clr'),
    'sql' => "binary(16) NULL"
);

// Description
$GLOBALS['TL_DCA']['tl_page']['fields']['descriptiontitle'] = array
(
    'label' => array('Page description', 'Short description of this page for internal use'),
    'search' => true,
    'inputType' => 'text',
    'eval' => array('maxlength'=>255, 'tl_class'=>'w50 clr'),
    'sql' => "varchar(255) NOT NULL default ''"
);
