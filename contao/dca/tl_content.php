<?php

// Palette
$GLOBALS['TL_DCA']['tl_content']['palettes']['heroSection'] = '{type_legend},type;{layout_legend},layoutType;{headline_legend},overheadline,headline;{text_legend},textOptional;{image_legend},singleSRC;{link_legend},url,linkTitle,secondUrl,secondLinkTitle;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['services'] = '{type_legend},type,headline,subheadline;{text_legend},textOptional;{items_legend},servicesCards;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';

// Override
$GLOBALS['TL_DCA']['tl_content']['fields']['url']['eval']['mandatory'] = false;

// Fields
// Layout Type
$GLOBALS['TL_DCA']['tl_content']['fields']['layoutType'] = [
    'label' => ['Layout', 'Choose layout'],
    'inputType' => 'select',
    'options' => ['two-column' => 'Two columns', 'background' => 'Image as background'],
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

$GLOBALS['TL_DCA']['tl_content']['fields']['servicesCards'] = [
    'inputType' => 'group',
    'palette' => ['singleSRC', 'headline', 'text', 'url', 'linkTitle'],
    'fields' => [
        '&headline' => [
            'label' => &$GLOBALS['TL_LANG']['MSCGRP']['title'],
            'eval' => ['tl_class' => "clr"]
        ],
        '&text' => [
            'eval' => ['tl_class' => "clr"]
        ],
        'category' => [
            'label' => &$GLOBALS['TL_LANG']['MSCGRP']['category'],
            'search' => true,
            'inputType' => 'text',
            'eval' => array('maxlength' => 255, 'tl_class' => 'w50 clr'),
            'sql' => "varchar(255) NOT NULL default ''"
        ],
    ],
    'min' => 1,
    'max' => 999,
    'sql' => [
        'type' => 'blob',
        'notnull' => false,
    ],
];;