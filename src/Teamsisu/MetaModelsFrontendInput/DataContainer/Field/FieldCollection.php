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
 * Class FieldCollection
 * The field collection extends the original collection to iterate/access field items
 *
 * @package Teamsisu\MetaModelsFrontendInput\DataContainer\Field
 */
class FieldCollection extends Collection
{

    /**
     * Instantiate an field collection with an existing array of BaseField Items (optional)
     *
     * @param array $arrItems
     */
    public function __construct($arrItems = array())
    {
        $this->items = $arrItems;
    }

    /**
     * Add an item of type BaseField to the field collection
     *
     * @param BaseField $objItem
     */
    public function addItem(BaseField $objItem)
    {
        $this->items[] = $objItem;
    }


}