<?php
session_start();
require_once ("IController.interface.php");
require ("ControllerBasics.class.php");

/**
 * Class ArticleManagementController ovladac na zobrazeni panelu spravy prispevku
 */
class ArticleManagementController implements IController {
    /** @var ControllerBasics trida slouzici k nacteni dat*/
    private ControllerBasics $tpl;

    /**
     * ArticleManagementController constructor pripojeni k databazi a nacteni dat
     */
    public function __construct() {
        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->tpl = new ControllerBasics();
    }

    /**
     * Vrati obsah stranky slouzici ke sprave prispevku administratorem.
     * @param string $pageTitle Nazev stranky
     * @return string           Vypis v sablone
     */
    public function show(string $pageTitle):string {
        $tplData = $this->tpl->loadData();
        $tplData['title'] = $pageTitle;

        if (!isset($_SESSION['role_id']) or $_SESSION['role_id'] != 1) {
            header('Location: index.php');
            die;
        }
        else {
            ob_start();
            require_once($_SERVER['DOCUMENT_ROOT'] . VIEWS_DIR . "/ArticleManagementTemplate.tpl.php");
        }
        return ob_get_clean();
    }

}