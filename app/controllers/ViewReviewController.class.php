<?php
session_start();
require_once ("IController.interface.php");
require ("ControllerBasics.class.php");

/**
 * Class ViewReviewController ovladac na zobrazeni recenzi uzivatele
 */
class ViewReviewController implements IController
{
    /** @var ControllerBasics trida k nacteni dat */
    private ControllerBasics $tpl;

    /**
     * ViewReviewController constructor nacteni dat
     */
    public function __construct()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->tpl = new ControllerBasics();
    }

    /**
     * Vrati obsah stranky s recenzemi uzivatele
     * @param string $pageTitle Nazev stranky
     * @return string           Vypis v sablone
     */
    public function show(string $pageTitle): string
    {
        if (!isset($_SESSION['role_id']) or $_SESSION['role_id'] != 2) {
            header('Location: index.php');
            die;
        }
        else {
            $tplData = $this->tpl->loadData();
            $tplData['title'] = $pageTitle;

            ob_start();
            require_once($_SERVER['DOCUMENT_ROOT'] . VIEWS_DIR . "/ViewReviewTemplate.tpl.php");
        }
        return ob_get_clean();
    }
}
