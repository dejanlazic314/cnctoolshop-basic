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
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => array('type' => 'boolean', 'default' => false)
    );

// Add image for header
$GLOBALS['TL_DCA']['tl_page']['fields']['addImageForHeader'] = array(
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50','submitOnChange'=>true,),
    'sql'                     => array('type' => 'boolean', 'default' => false)
);

// Image
$GLOBALS['TL_DCA']['tl_page']['fields']['singleSRC'] = array(
    'inputType'               => 'fileTree',
    'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory'=>true, 'tl_class'=>'clr'),
    'sql'                     => "binary(16) NULL"
);

// Description
$GLOBALS['TL_DCA']['tl_page']['fields']['descriptiontitle'] = array
(
    'search'                  => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50 clr'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

// Icon select
$GLOBALS['TL_DCA']['tl_page']['fields']['iconselect'] = [
    'inputType' => 'select',
    'options' => [
        'agorum-core-open' => 'agorum core open',
        'agorum-core-cloud' => 'agorum core cloud',
        'agorum-core-pro' => 'agorum core pro',
        'comparison' => 'Comparison',
        'changelog' => 'Changelog',
        'biz-partner-gear-light' => 'Business Partner Users Light',
        'biz-partner-gear-regular' => 'Business Partner Users Regular',
        'dl-portal-arrow-light' => 'Download Portal Light',
        'dl-portal-arrow-regular' => 'Download Portal Regular',
        'innov-partner-light' => 'Innovation Partner Users Light',
        'innov-partner-regular' => 'Innovation Partner Users Regular',
        'career-people-light' => 'Karriere People Line Light',
        'career-people-regular' => 'Karriere People Line Regular',
        'contact-msg-light' => 'Kontakt Message Smile Light',
        'contact-msg-regular' => 'Kontakt Message Smile Regular',
        'mission-rocket-light' => 'Mission Rocket Launch Light',
        'mission-rocket-regular' => 'Mission Rocket Launch Regular',
        'find-partner-light' => 'Partner Finden User Light',
        'find-partner-regular' => 'Partner Finden User Regular',
        'become-partner-light' => 'Partner Werden Handshake Light',
        'become-partner-regular' => 'Partner Werden Handshake Regular',
        'tech-partner-light' => 'Technology Partner Users Light',
        'tech-partner-regular' => 'Technology Partner Users Regular',
        'tools-wrench-light' => 'Tools Screwdriver Wrench Light',
        'tools-wrench-regular' => 'Tools Screwdriver Wrench Regular',
        'about-partner-light' => 'Ueber Partner Users Light',
        'about-partner-regular' => 'Ueber Partner Users Regular',
        'use-cases-light' => 'Use Cases Lightbulb Light',
        'use-cases-regular' => 'Use Cases Lightbulb Regular',
        'calendar-days-light' => 'Calendar Days Light',
        'calendar-days-regular' => 'Calendar Days Regular',
        'file-circle-info-light' => 'File Circle Info Light',
        'file-circle-info-regular' => 'File Circle Info Regular',
        'gear-sharp-light' => 'Gear Sharp Light',
        'gear-sharp-regular' => 'Gear Sharp Regular',
        'plug-sharp-light' => 'Plug Sharp Light',
        'plug-sharp-regular' => 'Plug Sharp Regular',
        'solar-system-light' => 'Solar System Light',
        'solar-system-regular' => 'Solar System Regular',
        'user-secret-light' => 'User Secret Light',
        'user-secret-regular' => 'User Secret Regular', 
        'industry-sharp-regular' => 'Industry Sharp Regular',        
        'logo-agorum-albert-ai' => 'Logo Agorum Albert AI',
        'logo-agorum-nora-360' => 'Logo Agorum Nora 360',
        'piggy-bank-sharp-regular' => 'Piggy Bank Sharp Regular',
        'sitemap-sharp-regular' => 'Sitemap Sharp Regular',
        'users-sharp-regular' => 'Users Sharp Regular',
    ],
    'eval' => [
        'includeBlankOption' => true,
        'tl_class' => 'w50 clr'
    ],
    'sql' => [
        'type' => 'string',
        'length' => 30, // Must be large enough to store all possible values
        'default' => '',
    ],
];
