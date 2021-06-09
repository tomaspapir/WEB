<?php
session_start();
require_once ("IController.interface.php");

/**
 * Class InsertReviewController ovladac na zobrazeni stranky slouzici k vlozeni nove recenze/upraveni recenze
 */
class InsertReviewController implements IController {
    /** @var DatabaseModel databaze */
    private DatabaseModel $db;

    /**
     * InsertReviewController constructor pripojeni k databazi
     */
    public function __construct() {
        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * Vrati obsah stranky kde se da vytvorit recenze
     * @param string $pageTitle Nazev stranky
     * @return string           Vypis v sablone
     */
    public function show(string $pageTitle): string {
        if (!isset($_SESSION['role_id']) or $_SESSION['role_id'] != 2) {
            header('Location: index.php');
            die;
        }
        else {
            $tplData['title'] = $pageTitle;
            if (isset($_POST['action']) and $_POST['action'] == "edit_review"
                and !empty($_POST['star']) and !empty($_POST['caption'])
                and !empty($_POST['content']) and !empty($_POST['stylistics']) and !empty($_POST['id_review'])) {
                if (trim($_POST['star']) == '' || trim($_POST['caption']) == ''
                    || trim($_POST['content']) == '' || trim($_POST['stylistics']) == '')
                    echo('All fields are required!');
                else {
                    if ($this->db->editReview($_POST['id_review'], $_POST['star'], $_POST['caption'], $_POST['content'], $_POST['stylistics'])) {
                        header('Location: index.php?page=recenze&status=success');
                    }
                }
            }

            ob_start();
            require_once($_SERVER['DOCUMENT_ROOT'] . VIEWS_DIR . "/InsertReviewTemplate.tpl.php");
        }
        return ob_get_clean();
    }
}
