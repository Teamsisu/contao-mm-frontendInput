<?php
/**
 * The MetaModels FrontendInput Extension allows you to easily create frontend forms
 * from an MetaModels backend InputMask.
 * It takes care of simple/complex/upload values and it is also possible to change the
 * saveHandler from an specific field to fit your special needs of prePost value manipulation
 *
 * PHP version 5
 *
 * @package    MetaModelsFrontendInput
 * @author     Martin Treml <martin.treml@teamsisu.at>
 * @copyright  Teamsisu GmbH <www.teamsisu.at>
 * @license    LGPL.
 * @filesource
 */

/**
 * Palette
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['mmfi'] = '{mmfi_mm_legend},mmfi_metamodel_id,mmfi_inputMask_id;{mmfi_form_legend},mmfi_noHtmlValidation;{mmfi_upload_legend},mmfi_uploadPath,mmfi_useMemberHome';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['mmfi_metamodel_id'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['mmfi_metamodel_id'],
    'inputType' => 'select',
    'options_callback' => array('\Teamsisu\MetaModelsFrontendInput\Backend\Helper\BackendHelper', 'listMetaModels'),
    'eval' => array('mandatory' => true, 'tl_class' => 'w50', 'submitOnChange' => true),
    'sql' => "int(11) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['mmfi_inputMask_id'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['mmfi_inputMask_id'],
    'inputType' => 'select',
    'options_callback' => array('\Teamsisu\MetaModelsFrontendInput\Backend\Helper\BackendHelper', 'listInputMasks'),
    'eval' => array('mandatory' => true, 'tl_class' => 'w50'),
    'sql' => "int(11) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['mmfi_uploadPath'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['mmfi_uploadPath'],
    'inputType' => 'fileTree',
    'eval' => array('fieldType'=>'radio', 'mandatory' => true, 'tl_class' => 'w50'),
    'sql' => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['mmfi_useMemberHome'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['mmfi_useMemberHome'],
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'w50 m12'),
    'sql' => "char(1) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['mmfi_noHtmlValidation'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['mmfi_noHtmlValidation'],
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'w50 m12'),
    'sql' => "char(1) NOT NULL default '0'"
);