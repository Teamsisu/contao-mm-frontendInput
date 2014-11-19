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
 * Class UploadSaveHandler
 * This saveHandler is a specified for upload attributes
 * It moves the uploaded file to the given destination and add it to the DBAFS
 *
 * @package Teamsisu\MetaModelsFrontendInput\Handler\Save
 */
class UploadSaveHandler extends SaveHandler
{

    /**
     * Parses the widget and returns either the uuid of the file or false if moving the file failed
     *
     * @param $widget
     * @return mixed
     * @throws \Exception
     */
    public function parseWidget($widget)
    {

        /**
         * Rename the file (move) to the new location with the new name
         */
        $ext = pathinfo($_SESSION['FILES'][$this->field->getColName()]['name'], PATHINFO_EXTENSION);
        $name = $this->field->uploadPath . '/' . $this->item->get('id') . '_' . $this->field->getColName() . '.' . $ext;

        if (move_uploaded_file($_SESSION['FILES'][$this->field->getColName()]['tmp_name'], TL_ROOT . '/' . $name)) {

            /**
             * Add File to the DBAFS
             */
            $dbafsFile = \Dbafs::addResource($name);

            /**
             * Return UUID
             */

            return $dbafsFile->uuid;

        }

        return false;

    }

}