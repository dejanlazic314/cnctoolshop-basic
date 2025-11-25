<?php

// Palette
$GLOBALS['TL_DCA']['tl_content']['palettes']['heroSection'] = '{type_legend},type;{layout_legend},layoutType;{headline_legend},overheadline,headline;{text_legend},textOptional;{image_legend},singleSRC;{link_legend},url,linkTitle,secondUrl,secondLinkTitle;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';


// Fields
// Layout Type
$GLOBALS['TL_DCA']['tl_content']['fields']['layoutType'] = [
    'label' => ['Layout', 'Choose layout'],
    'inputType' => 'select',
    'options' => ['background' => 'Image as background', 'two-column' => 'Two columns'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default 'background'"
];

// Text Optional
$GLOBALS['TL_DCA']['tl_content']['fields']['textOptional'] = [
    'search' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'basicEntities' => true, 'rte' => 'tinyMCE', 'helpwizard' => true],
    'explanation' => 'insertTags',
    'sql' => "mediumtext NULL"
];

// Second Button URL
$GLOBALS['TL_DCA']['tl_content']['fields']['secondUrl'] = [
    'label' => ['Second button URL', 'Enter URL for second button'],
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(2048) NOT NULL default ''"
];

// Second Button Text
$GLOBALS['TL_DCA']['tl_content']['fields']['secondLinkTitle'] = [
    'label' => ['Second button text', 'Text for second button'],
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''"
];