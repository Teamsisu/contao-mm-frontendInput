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

use MetaModels\Item;

/**
 * Class SaveHandler
 * The base class for saveHandler, all saveHandlers must extend these
 *
 * @package Teamsisu\MetaModelsFrontendInput\Handler\Save
 */
class SaveHandler
{

    /**
     * The MetaModelItem
     *
     * @var Item
     */
    public $item;

    protected $field;

    public function __construct(&$field)
    {
        $this->field = $field;
    }

    /**
     * Setter for the Item
     *
     * @param Item $item
     */
    public function setItem(Item &$item)
    {
        $this->item = $item;
    }

    /**
     * This function is for the manipulation of the attribute value
     * Must return the value in the format what is needed for MetaModels
     *
     * @param $widget
     * @return mixed
     */
    public function parseWidget($widget)
    {
        return $widget->value;
    }

    /**
     * Set the value of the Attribute from given MetaModels Item
     */
    public function setValue($value)
    {
        $this->item->set($this->field->getColName(), $value);
    }

} 