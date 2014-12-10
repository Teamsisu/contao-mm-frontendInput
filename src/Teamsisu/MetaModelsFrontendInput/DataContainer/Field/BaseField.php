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


use Teamsisu\MetaModelsFrontendInput\Handler\Save\SaveHandler;

/**
 * Class BaseField
 * The base class for form fields, every special field must extend this class
 *
 * @package Teamsisu\MetaModelsFrontendInput\DataContainer\Field
 * @author     Martin Treml <martin.treml@teamsisu.at>
 */
class BaseField
{

    /**
     * The column name
     *
     * @var string
     */
    protected $colName = '';

    /**
     * Holds the data from the object
     *
     * @var array
     */
    protected $data = array();

    /**
     * This array hold all eval options
     *
     * @var array
     */
    protected $eval = array();

    /**
     * The SaveHandler Object
     *
     * @var SaveHandler
     */
    protected $saveHandler = null;

    /**
     * Type identifier of the field
     *
     * @var string
     */
    protected $fieldType = 'simple';

    /**
     * Add an key,value pair to the eval array
     *
     * @param string $key
     * @param mixed  $value
     */
    public function addEval($key, $value)
    {
        $this->eval[$key] = $value;
    }

    /**
     * Remove an entry vom the eval array
     * Returns true if entry was removed and false if key was not found
     *
     * @param string $key
     * @return bool
     */
    public function removeEval($key)
    {

        if ($key = array_search($key, $this->eval)) {
            unset($this->eval[$key]);

            return true;
        }

        return false;
    }

    /**
     * Set a new value to an existing eval entry
     *
     * @param string $key
     * @param mixed  $value
     */
    public function modifyEval($key, $value)
    {

        if (in_array($key, $this->eval)) {
            $this->eval[$key] = $value;
        }

    }

    /**
     * Get an entry from the eval array
     * Returns the entry or false if key not found
     *
     * @param string $key
     * @return mixed|bool
     */
    public function getEval($key)
    {
        if (in_array($key, $this->eval)) {
            return $this->eval[$key];
        }

        return false;
    }

    /**
     * An restricted setter for an special list of keys
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {

        switch ($key) {
            case 'colName':
                $this->colName = $value;
                break;

            case 'inputType':
            case 'options':
            case 'value':
            case 'label':
                $this->data[$key] = $value;
                break;

        }

    }

    /**
     * Get an value from the instance
     * Returns the value or false if not found
     *
     * @param string $key
     * @return mixed|bool
     */
    public function get($key)
    {

        switch ($key) {
            case 'colName':
                return $this->colName;
                break;

            default:
                if (isset($this->data[$key])) {
                    return $this->data[$key];
                }
        }

        return false;
    }

    /**
     * Returns a DCA represent array of the field
     *
     * @return array
     */
    public function getDCADefinition()
    {

        $return = array(
            $this->colName => array_merge($this->data, array('eval' => $this->eval))
        );

        return $return;
    }

    /**
     * Set an SaveHandler for current field
     *
     * @param SaveHandler $saveHandler
     */
    public function setSaveHandler(SaveHandler $saveHandler)
    {
        $this->saveHandler = $saveHandler;
    }

    /**
     * Get the SaveHandler from current field
     *
     * @return SaveHandler
     */
    public function getSaveHandler()
    {
        return $this->saveHandler;
    }

    /**
     * Deprecated Version to retrieve the column name of the current field
     *
     * @return bool|string
     */
    public function getColName()
    {
        return $this->get('colName');
    }

    /**
     * Return the type identifier of the current field
     *
     * @return string
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }
} 