<?php
session_start();
require_once ("IController.interface.php");
require ("ControllerBasics.class.php");

/**
 * Class ViewArticleController ovladac na zobrazeni jednotlivych prispevku/clanku
 */
class ViewArticleController implements IController {
    /** @var DatabaseModel databaze */
    private DatabaseModel $db;
    /** @var ControllerBasics trida k nacteni dat */
    private ControllerBasics $tpl;

    /**
     * ViewArticleController constructor pripojeni k databazi a nacteni dat
     */
    public function __construct()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
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

        if(isset($_POST['status'])) {
            if (($_POST['status'] == -1 || $_POST['status'] == 0 ||$_POST['status'] == 1)
                and !empty($_POST['article_id']) and !isset($_POST['delete']) and !isset($_POST['remove'])) {
                if($this->db->changeArticleStatus($_POST['article_id'], $_POST['status']));
                 header("Refresh:0");
            }
        }
        if(!empty($_POST['reviewer_id0']) and !empty($_POST['article_id']) and !isset($_POST['delete'])
            and !isset($_POST['remove'])) {
            if($this->db->insertReview($_POST['article_id'], $_POST['reviewer_id0'])) {
                header("Refresh:0");
            }
        }
        if(!empty($_POST['reviewer_id1']) and !empty($_POST['article_id']) and !isset($_POST['delete'])
            and !isset($_POST['remove'])) {
            if($this->db->insertReview($_POST['article_id'], $_POST['reviewer_id1'])) {
                header("Refresh:0");
            }
        }
        if(!empty($_POST['reviewer_id2']) and !empty($_POST['article_id']) and !isset($_POST['delete'])
            and !isset($_POST['remove'])) {
            if($this->db->insertReview($_POST['article_id'], $_POST['reviewer_id2'])) {
                header("Refresh:0");
            }
        }

        if(isset($_POST['delete']) and !isset($_POST['remove'])){
           $id = trim($_POST['delete'], "Odstranit recenzi s ID: ");
           if($this->db->deleteReview($id)) {
               header("Refresh:0");
           }
        }

        if(isset($_POST['remove']) and isset($_POST['article_id'])){
            if($this->db->deleteArticleReviews($_POST['article_id'])) {
                if ($this->db->deleteArticle($_POST['article_id'])) {
                    header("Location: index.php?page=sprava_clanku");
                }
            }
        }
        ob_start();
        require_once($_SERVER['DOCUMENT_ROOT'] . VIEWS_DIR . "/ViewArticleTemplate.tpl.php");

        return ob_get_clean();
    }
}