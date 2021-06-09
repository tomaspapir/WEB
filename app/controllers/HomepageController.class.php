<?php
session_start();
require_once ("IController.interface.php");
require ("ControllerBasics.class.php");

/**
 * Class HomepageController ovladac na zobrazeni hlavni domovske stranky
 */
class HomepageController implements IController {
    /** @var ControllerBasics trida slouzici k nacteni dat*/
    private ControllerBasics $tpl;

    /**
     * HomepageController constructor pripojeni k databazi a nacteni dat
     */
    public function __construct() {
        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->tpl = new ControllerBasics();
    }

    /**
     * Vrati obsah hlavni domovske stranky
     * @param string $pageTitle Nazev stranky
     * @return string           Vypis v sablone
     */
    public function show(string $pageTitle): string {
        global $tplData;
        $tplData = $this->tpl->loadData();
        $tplData['title'] = $pageTitle;

        ob_start();
        require_once($_SERVER['DOCUMENT_ROOT'] . VIEWS_DIR . "/HomepageTemplate.tpl.php");

        return ob_get_clean();
    }
}
