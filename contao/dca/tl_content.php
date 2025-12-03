<?php

use Contao\DataContainer;


// Palette selector - ovo mora biti na početku
array_push($GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'], 'addImage', 'useFrame');


// Palettes
$GLOBALS['TL_DCA']['tl_content']['palettes']['heroSection'] = 
    '{type_legend},type;'.
    '{layout_legend},layoutType;'.
    '{headline_legend},overheadline,headline;'.
    '{text_legend},textOptional;'.
    '{image_legend},singleSRC;'.
    '{link_legend},url,linkTitle,secondUrl,secondLinkTitle;'.
    '{protected_legend:hide},protected;'.
    '{expert_legend:hide},cssID;'.
    '{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['gridSection'] = 
    '{type_legend},type,headline,subheadline;'.
    '{text_legend},textOptional;'.
    '{items_legend},gridItems;'.
    '{protected_legend:hide},protected;'.
    '{expert_legend:hide},cssID;'.
    '{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['processSteps'] = 
    '{type_legend},type,headline,subheadline;'.
    '{text_legend},textOptional;'.
    '{items_legend},stepsCards;'.
    '{protected_legend:hide},protected;'.
    '{expert_legend:hide},cssID;'.
    '{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['textMedia'] = 
    '{type_legend},type;'.
    '{layout_legend},textPosition,backgroundColor;'.
    '{headline_legend},overheadline,headline;'.
    '{text_legend},textOptional;'.
    '{link_legend},url,linkTitle,secondUrl,secondLinkTitle;'.
    '{media_legend},addImage,useFrame;'.
    '{protected_legend:hide},protected;'.
    '{expert_legend:hide},cssID;'.
    '{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['faqSection'] = 
    '{type_legend},type;'.
    '{headline_legend},headline;'.
    '{text_legend},textOptional;'.
    '{items_legend},accordion;'.
    '{protected_legend:hide},protected;'.
    '{expert_legend:hide},cssID;'.
    '{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['textImage'] = 
    '{type_legend},type;'.
    '{layout_legend},textPosition,backgroundColor;'.
    '{headline_legend},overheadline,headline;'.
    '{text_legend},textOptional;'.
    '{image_legend},singleSRC;'.
    '{protected_legend:hide},protected;'.
    '{expert_legend:hide},cssID;'.
    '{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['imageShowcase'] = 
    '{type_legend},type;'.
    '{headline_legend},headline;'.
    '{text_legend},textOptional;'.
    '{gallery_legend},multiSRC;'.
    '{protected_legend:hide},protected;'.
    '{expert_legend:hide},cssID;'.
    '{invisible_legend:hide},invisible,start,stop'; 

$GLOBALS['TL_DCA']['tl_content']['palettes']['logoClients'] = 
    '{type_legend},type;'.
    '{gallery_legend},multiSRC;'.
    '{protected_legend:hide},protected;'.
    '{expert_legend:hide},cssID;'.
    '{invisible_legend:hide},invisible,start,stop';  

$GLOBALS['TL_DCA']['tl_content']['palettes']['contactForm'] = 
'{type_legend},type,headline,subheadline;'.
'{text_legend},textOptional;'.
'{items_legend},formpicker;'.
'{protected_legend:hide},protected;'.
'{expert_legend:hide},cssID;'.
'{invisible_legend:hide},invisible,start,stop';

// Subpalettes - dinamički prikazuje polja
// Override add image subpallete
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['addImage'] = 'singleSRC';
// Add add html subpallete
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['useFrame'] = 'frameHtml';

// Override Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['url']['eval']['mandatory'] = false;

# Callbacks
$GLOBALS['TL_DCA']['tl_content']['fields']['multiSRC']['load_callback'][] = array('tl_content_ab', 'setMultiSrcFlags');

// Fields
// Form Picker
$GLOBALS['TL_DCA']['tl_content']['fields']['formpicker'] = array
(
    'inputType' => 'picker',
    'sql' => [
        'type' => 'integer',
        'unsigned' => true,
        'default' => 0,
    ],
    'relation' => [
        'type' => 'hasOne',
        'load' => 'lazy',
        'table' => 'tl_form',
    ],
);
// Layout Type
$GLOBALS['TL_DCA']['tl_content']['fields']['layoutType'] = [
    'label' => ['Layout', 'Choose layout'],
    'inputType' => 'select',
    'options' => ['two-column' => 'Two columns', 'background' => 'Image as background'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default 'background'"
];

// Text Position
$GLOBALS['TL_DCA']['tl_content']['fields']['textPosition'] = [
    'label' => ['Text position', 'Choose where the text should be displayed'],
    'inputType' => 'select',
    'options' => [
        'left' => 'Left',
        'right' => 'Right'
    ],
    'eval' => ['tl_class' => 'w50', 'includeBlankOption' => false],
    'sql' => "varchar(10) NOT NULL default 'left'"
];

// Background Color
$GLOBALS['TL_DCA']['tl_content']['fields']['backgroundColor'] = [
    'label' => ['Background color', 'Choose background color for text section'],
    'inputType' => 'select',
    'options' => [
        '' => 'None (Transparent)',
        'light-blue' => 'Light Blue',
    ],
    'eval' => ['tl_class' => 'w50', 'includeBlankOption' => true],
    'sql' => "varchar(32) NOT NULL default ''"
];

// Use Frame Checkbox
$GLOBALS['TL_DCA']['tl_content']['fields']['useFrame'] = [
    'label' => ['Use iframe/HTML', 'Use custom HTML (iframe, map, video) instead of image'],
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true, 'tl_class' => 'w50 m12'],
    'sql' => "char(1) NOT NULL default ''"
];

// Frame HTML
$GLOBALS['TL_DCA']['tl_content']['fields']['frameHtml'] = [
    'label' => ['HTML code', 'Enter HTML code (iframe, embed, etc.)'],
    'inputType' => 'textarea',
    'eval' => [
        'mandatory' => false,
        'allowHtml' => true,
        'preserveTags' => true,
        'decodeEntities' => true,
        'class' => 'monospace',
        'rte' => false,
        'tl_class' => 'clr'
    ],
    'sql' => "text NULL"
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

// Services Cards
$GLOBALS['TL_DCA']['tl_content']['fields']['gridItems'] = [
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
    ],
    'min' => 1,
    'max' => 999,
    'sql' => [
        'type' => 'blob',
        'notnull' => false,
    ],
];

// Accordion Cards
$GLOBALS['TL_DCA']['tl_content']['fields']['accordion'] = [
    'inputType' => 'group',
    'palette' => ['headline', 'text'],
    'fields' => [
        '&headline' => [
            'label' => &$GLOBALS['TL_LANG']['MSCGRP']['title'],
            'eval' => ['tl_class' => "clr"]
        ],
        '&text' => [
            'eval' => ['tl_class' => "clr"]
        ],
    ],
    'min' => 1,
    'max' => 999,
    'sql' => [
        'type' => 'blob',
        'notnull' => false,
    ],
];

// Steps Cards
$GLOBALS['TL_DCA']['tl_content']['fields']['stepsCards'] = [
    'inputType' => 'group',
    'palette' => ['headline', 'text','icon'],
    'fields' => [
        '&headline' => [
            'label' => &$GLOBALS['TL_LANG']['MSCGRP']['title'],
            'eval' => ['tl_class' => "clr"]
        ],
        '&text' => [
            'eval' => ['tl_class' => "clr"]
        ],
        'icon' => [
            'label' => array('Icon'),
            'inputType' => 'fileTree',
            'eval' => array('filesOnly'=>true, 'extensions'=>'svg,png', 'fieldType'=>'radio')
        ],
    ],
    'min' => 1,
    'max' => 999,
    'sql' => [
        'type' => 'blob',
        'notnull' => false,
    ],
];

class tl_content_ab extends tl_content
{

    /**
     * Add sorting functionality to multiSRC field for exact type
     * @param mixed $varValue
     * @param Contao\DataContainer $dc
     * @return mixed
     */
    public function setMultiSrcFlags($varValue, DataContainer $dc)
    {
        if ($dc->activeRecord) {
            switch ($dc->activeRecord->type) {
                case 'imageShowcase':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = '%contao.image.valid_extensions%';
                    break;
                case 'logoClients':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = '%contao.image.valid_extensions%';
                    break;                    
            }

            return $varValue;
        }
    }
}
