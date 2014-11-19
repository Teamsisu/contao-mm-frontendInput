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

namespace Teamsisu\MetaModelsFrontendInput\Handler\Save;

/**
 * Class ComplexSaveHandler
 * This class handles complex MetaModels Attribute value saving
 *
 * @package Teamsisu\MetaModelsFrontendInput\Handler\Save
 */
class ComplexSaveHandler extends SaveHandler {

    /**
     * Set the given value to the MetaModels Item
     * @param mixed $value
     */
    public function setValue($value)
    {
        parent::setValue($this->field->mmAttribute->widgetToValue($value, null));
    }

}