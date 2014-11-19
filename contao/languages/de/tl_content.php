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

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_content']['mmfi_mm_legend'] = 'MetaModel Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['mmfi_upload_legend'] = 'Upload Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['mmfi_form_legend'] = 'Formular Einstellungen';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_content']['mmfi_metamodel_id'] = array('MetaModel ID', 'Geben Sie hier das MetaModel an');
$GLOBALS['TL_LANG']['tl_content']['mmfi_inputMask_id'] = array('MetaModel Eingabemasken ID', 'Wählen Sie hier die Eingabe Maske aus welche als Grundlage der Formularfelder verwendet werden soll');
$GLOBALS['TL_LANG']['tl_content']['mmfi_uploadPath'] = array('Upload Pfad', 'Wählen Sie hier den Default Upload Pfad aus welcher für Dateiuploads verwendet werden soll');
$GLOBALS['TL_LANG']['tl_content']['mmfi_useMemberHome'] = array('Benutze Mitglieder Benutzerverzeichnis', 'Wenn diese Option aktiviert wird wird anstatt des Default Upload Pfades der des Benutzerverzeichnises verwendet wenn vorhanden');
$GLOBALS['TL_LANG']['tl_content']['mmfi_noHtmlValidation'] = array('Deaktiviere die HTML 5 Validierung', 'Wählen Sie diese Option wenn das Formular nicht per HTML5 validiert werden soll');