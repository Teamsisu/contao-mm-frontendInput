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

namespace Teamsisu\MetaModelsFrontendInput\DataContainer\Field;

/**
 * Class FieldsetField
 * This class represents an field of the type fieldset
 *
 * @package Teamsisu\MetaModelsFrontendInput\DataContainer\Field
 */
class FieldsetField extends BaseField {

    /**
     * Instantiate a fieldset item
     * @param array $item
     * @param bool $fieldsetStart
     */
    public function __construct($item, $fieldsetStart){

        if($fieldsetStart){
            $this->set('fsType', 'fsStart');
        }
        $this->set('inputType', 'fieldset');
        $this->set('label', $item['legendtitle']);
        $this->colName = 'fieldset_'.$item['id'];

    }

} 