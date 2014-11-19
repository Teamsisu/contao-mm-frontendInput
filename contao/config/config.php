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
 * An array of the allowed eval types
 */
$GLOBALS['MetaModelsFrontendInput']['allowedEvals'] = array(
    'mandatory' => 'mandatory',
    'readonly' => 'readonly',
    'allowHtml' => 'allowHtml',
    'preserveTags' => 'preserveTags',
    'decodeEntities' => 'decodeEntities',
    'tl_class' => 'class'
);

/**
 * Set the form url widget
 */
$GLOBALS['TL_FFL']['url'] = 'Teamsisu\MetaModelsFrontendInput\FrontendIntegration\Form\FormURLField';