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
 * Class Collection
 * The collection class provides you an easy way to iterate and access items
 * and is used as base class for every items
 *
 * @package Teamsisu\MetaModelsFrontendInput\DataContainer\Field
 */
class Collection implements \Iterator, \ArrayAccess
{

    /**
     * The cursor
     *
     * @var int
     */
    protected $intCursor = -1;

    /**
     * The array where all items are stored
     *
     * @var array
     */
    protected $items = array();

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->intCursor;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return ($this->offsetExists($this->intCursor));
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->first();
    }


    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->getItem();
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        if ($this->getCount() == $this->intCursor) {
            return false;
        }
        // We must advance over the last element.
        $this->intCursor += 1;

        // Check the index again, see #461.
        return ($this->getCount() == $this->intCursor) ? false : $this;
    }

    /**
     * {@inheritdoc}
     */
    public function prev()
    {
        if ($this->intCursor == 0) {
            return false;
        }

        $this->intCursor--;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function first()
    {
        if ($this->getCount() > 0) {
            $this->intCursor = 0;

            return $this;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        $this->intCursor = ($this->getCount() - 1);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->intCursor = -1;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function getItem()
    {
        // Implicitly call first when not within "while ($obj->next())" scope.
        if ($this->intCursor < 0) {
            $this->first();
        }

        // Beyond bounds? return null.
        if (!$this->valid()) {
            return null;
        }

        return $this->items[$this->intCursor];
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        if (!is_numeric($offset)) {
            return false;
        }

        return (($this->getCount() > $offset) && ($offset > -1));
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->items[$offset];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        throw new \Exception('This Method is not implemented - use addItem instead');
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        throw new \Exception('This Method is not implemented');
    }


} 