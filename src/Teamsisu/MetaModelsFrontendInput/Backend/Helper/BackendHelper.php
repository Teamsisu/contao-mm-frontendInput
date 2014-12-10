<?php
/**
 * Created by PhpStorm.
 * User: m.treml
 * Date: 17.11.2014
 * Time: 10:42
 */

namespace Teamsisu\MetaModelsFrontendInput\Backend\Helper;


use Contao\DataContainer;

class BackendHelper extends \Controller {

    public function listMetaModels()
    {

        $result = \Database::getInstance()->prepare("SELECT id, name FROM tl_metamodel")->execute()->fetchAllAssoc();

        $return = array();
        foreach($result AS $field){
            $return[$field['id']] = $field['name'];
        }

        return $return;
    }

    public function listInputMasks(DataContainer $dca)
    {

        $mmID = $dca->activeRecord->mmfi_metamodel_id;

        if(!$mmID){
            return false;
        }

        $result = \Database::getInstance()->prepare("SELECT id, name FROM tl_metamodel_dca WHERE pid = ?")->execute($mmID)->fetchAllAssoc();


        $return = array();
        foreach($result AS $field){
            $return[$field['id']] = $field['name'];
        }
        return $return;
    }

} 