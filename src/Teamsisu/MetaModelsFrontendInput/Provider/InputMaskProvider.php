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

namespace Teamsisu\MetaModelsFrontendInput\Provider;


use Contao\FilesModel;
use Haste\Form\Form;
use MetaModels\BackendIntegration\InputScreen\InputScreen;
use MetaModels\Item;
use Teamsisu\MetaModelsFrontendInput\DataContainer\Field\BaseField;
use Teamsisu\MetaModelsFrontendInput\DataContainer\Field\FieldCollection;
use Teamsisu\MetaModelsFrontendInput\DataContainer\Field\FieldsetField;
use Teamsisu\MetaModelsFrontendInput\DataContainer\Field\MMAttributeField;


/**
 * Class InputMaskProvider
 * This is the main class for the extension. It takes care about adding fields to the form
 * and binding the forms value to an MetaModels Item
 *
 * @package Teamsisu\MetaModelsFrontendInput\Provider
 * @author     Martin Treml <martin.treml@teamsisu.at>
 */
class InputMaskProvider
{

    /**
     * The MetaModels Instance
     *
     * @var \MetaModels\IMetaModel|null
     */
    protected $objMM;

    /**
     * An Collection of the form fields
     *
     * @var null|FieldCollection
     */
    protected $fields = null;

    /**
     * The MetaModels Item
     *
     * @var \MetaModels\IItem|null
     */
    protected $mmItem = null;

    /**
     * The upload path for file uploads
     *
     * @var null
     */
    protected $uploadPath = null;

    /**
     * An internal boolean to determine if an fieldset is left open
     *
     * @var bool
     */
    private $openFieldset = false;

    /**
     * Instantiate the Input Provider
     *
     * @param int    $mmID The ID of an existing MetaModels
     * @param int    $maskID The ID of an existing InputMask
     * @param string $uploadPath The UUID value of an DBAFS Folder
     * @throws \Exception
     */
    public function __construct($mmID, $maskID, $uploadPath)
    {

        $this->objMM = \MetaModels\Factory::byId($mmID);

        $this->setUploadPath($uploadPath);

        $this->fields = new FieldCollection();

        /**
         * Get fields from the InputMask with given ID
         * and parse it as Item to the FieldCollection
         */
        $result = \Database::getInstance()->prepare("SELECT * FROM tl_metamodel_dcasetting WHERE pid = ? ORDER BY sorting ASC")->execute($maskID);
        $this->parseFields($result->fetchAllAssoc());

        /**
         * Check for last fieldset
         */
        if ($this->openFieldset) {
            $this->openFieldset = false;
            $this->fields->addItem(new FieldsetField(array('legendtitle' => ''), $this->openFieldset));
        }

    }

    /**
     * Parse the results from the database
     *
     * @param array $data Result form the database
     * @throws \Exception When an unknown DCA-Type is used
     */
    protected function parseFields(array $data)
    {

        foreach ($data AS $item) {

            if (!$item['published']) {
                continue;
            }

            switch ($item['dcatype']) {

                case 'legend':
                    $this->parseFieldset($item);
                    break;

                case 'attribute':
                    $this->parseAttribute($item);
                    break;

                default:
                    throw new \Exception('Unrecognized DCA-Type');
                    break;
            }

        }

    }

    /**
     * Parse an legend to an fieldset field item
     *
     * @param array $item One row from the InputMask database result
     */
    protected function parseFieldset(array $item)
    {

        if (!$item['legendhide'] && !$this->openFieldset) {
            $this->openFieldset = true;
        } elseif ($item['legendhide'] && $this->openFieldset) {
            $this->openFieldset = false;
        } else {
            $this->openFieldset = false;
            $this->fields->addItem(new FieldsetField($item, $this->openFieldset));
            $this->openFieldset = true;
        }

        $this->fields->addItem(new FieldsetField($item, $this->openFieldset));

    }

    /**
     * Parse an MetaModels attribute row
     *
     * @param array $item One row form the InputMask database result
     */
    protected function parseAttribute(array $item)
    {
        $attribute = new MMAttributeField($item, $this->objMM);

        /**
         * Set the items upload Path if the fieldType is upload
         */
        if ($attribute->getFieldType() == 'upload') {
            $attribute->setUploadPath($this->uploadPath);
        }

        $this->fields->addItem($attribute);
    }

    /**
     * Get an DCA represant array of the field from the InputMask
     *
     * @return array
     */
    public function getDCArray()
    {

        $this->fields->reset();
        $arrResult = array();

        while ($this->fields->next()) {
            $item = $this->fields->current();
            $arrResult = array_merge($arrResult, $item->getDCADefinition());
        }

        return $arrResult;

    }

    /**
     * Add the FieldCollection to the given hasteForm
     *
     * @param Form $hasteForm
     * @return $this
     */
    public function addFieldsToForm(Form $hasteForm)
    {

        foreach ($this->getDCArray() AS $fieldName => $fieldOptions) {
            $hasteForm->addFormField($fieldName, $fieldOptions);
        }

        return $this;
    }

    /**
     * Bind the form widget values to an MetaModels Item
     *
     * @param Form $hasteForm
     * @throws \Exception When an MetaModels Item is missing
     */
    public function bindFormToItem(Form $hasteForm)
    {

        if (is_null($this->mmItem)) {
            throw new \Exception('Trying to bind fields on non existing mmItem - aborting');

            return false;
        }

        $this->fields->reset();

        while ($this->fields->next()) {

            $field = $this->fields->current();

            $widget = $hasteForm->getWidget($field->getColName());

            if (!is_a($field, 'Teamsisu\MetaModelsFrontendInput\DataContainer\Field\FieldsetField')) {
                $saveHandler = $field->getSaveHandler();
                $saveHandler->setItem($this->mmItem);
                $value = $saveHandler->parseWidget($widget);
                $saveHandler->setValue($value);

            }

        }

    }

    /**
     * Set an MetaModels Item
     *
     * @param \MetaModels\IItem $mmItem
     */
    public function setItem(\MetaModels\IItem $mmItem)
    {
        $this->mmItem = $mmItem;
    }

    /**
     * Get the MetaModels Item
     *
     * @return \MetaModels\IItem|null
     */
    public function getItem()
    {
        return $this->mmItem;
    }

    /**
     * Load the values from given MetaModels Item
     *
     * @throws \Exception When an MetaModels Item is missing
     */
    public function loadValues()
    {

        if (is_null($this->mmItem)) {
            throw new \Exception('Trying to load values from empty mmItem - aborting');

            return false;
        }

        /**
         * Set default values to fields
         */
        $this->fields->reset();
        while ($this->fields->next()) {
            $field = $this->fields->current();
            $value = $this->mmItem->get($field->getColName());

            if ($field->getFieldType() == 'complex') {
                $value = $this->parseComplexValue($field, $value);
            }
            $field->set('value', $value);
        }

    }

    /**
     * Parse an complex MetaModel value to an useable widget value
     *
     * @param BaseField $field
     * @param mixed     $value
     * @return mixed
     */
    protected function parseComplexValue(BaseField $field, $value)
    {
        return $field->mmAttribute->valueToWidget($value);
    }

    /**
     * Set the upload path for file uploads
     *
     * @param sting $uploadPath The UUID Value from an DBAFS Folder
     */
    public function setUploadPath($uploadPath)
    {
        $objFile = FilesModel::findByUuid($uploadPath);
        $this->uploadPath = $objFile->path;
    }

}