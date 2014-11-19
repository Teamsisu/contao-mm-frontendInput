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

use MetaModels\MetaModel;
use Teamsisu\MetaModelsFrontendInput\Handler\Save\ComplexSaveHandler;
use Teamsisu\MetaModelsFrontendInput\Handler\Save\SaveHandler;
use Teamsisu\MetaModelsFrontendInput\Handler\Save\UploadSaveHandler;
use Teamsisu\MetaModelsFrontendInput\Handler\Save\SimpleSaveHandler;

/**
 * Class MMAttributeField
 * This field class represents an MetaModels\Attribute
 *
 * @package Teamsisu\MetaModelsFrontendInput\DataContainer\Field
 */
class MMAttributeField extends BaseField
{

    /**
     * The Attribute the field relies on
     *
     * @var \MetaModels\Attribute\IAttribute|null
     */
    public $mmAttribute;

    /**
     * Instantiate the field an set all values
     *
     * @param array     $data
     * @param MetaModel $objMM
     */
    public function __construct(array $data, MetaModel $objMM)
    {

        $this->mmAttribute = $objMM->getAttributeById($data['attr_id']);

        $this->colName = $this->mmAttribute->get('colname');

        $dcaArray = $this->mmAttribute->getFieldDefinition($data);

        $this->eval = $dcaArray['eval'];
        unset($dcaArray['eval']);

        $this->data = $dcaArray;

        if ($data['tl_class']) {
            $this->addEval('class', $data['tl_class']);
        }

        /**
         * Check for inputType and convert if necessary
         */
        switch ($this->get('inputType')) {
            case 'fileTree':
                $this->set('inputType', 'upload');
                $this->fieldType = 'upload';
                break;
        }

        if (is_a($this->mmAttribute, '\MetaModels\Attribute\Url\Url')) {
            $this->set('inputType', 'url');
            $this->fieldType = 'complex';
        }

        if (is_a($this->mmAttribute, '\MetaModels\Attribute\IComplex')) {
            $this->fieldType = 'complex';
        }

        /**
         * Get option values from non mm databases
         */
        if (is_a($this->mmAttribute, '\MetaModels\Attribute\Select\Select')) {

            $objDatabase = \Database::getInstance();

            $key = $this->mmAttribute->get('select_alias');
            $value = $this->mmAttribute->get('select_column');
            $table = $this->mmAttribute->get('select_table');
            $where = $this->mmAttribute->get('select_where');

            $sql = "SELECT $key AS `key`, $value AS `value` FROM $table";

            if (!empty($where)) {
                $sql .= " WHERE " . $where;
            }

            $result = $objDatabase->prepare($sql)->execute();

            $options = array();

            while ($result->next()) {
                $options[$result->key] = $result->value;
            }

            $this->set('options', $options);

        }

        /**
         * Add Save Handler
         */

        switch ($this->fieldType) {

            case 'upload':
                $this->setSaveHandler(new UploadSaveHandler($this));
                break;

            default:
                $this->setSaveHandler(new SaveHandler($this));
                break;
        }
    }


    /**
     * Set the upload path which is needed for the UploadSaveHandler
     *
     * @param string $uploadPath
     */
    public function setUploadPath(&$uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

}