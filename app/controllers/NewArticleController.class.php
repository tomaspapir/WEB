<?php
session_start();
require_once ("IController.interface.php");

$uploadOk = 1;

/**
 * Class NewArticleController ovladac na zobrazeni stranky slouzici k vlozeni noveho prispevku
 */
class NewArticleController implements IController {
    /** @var DatabaseModel databaze */
    private DatabaseModel $db;

    /**
     * NewArticleController constructor pripojeni k databazi
     */
    public function __construct() {
        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * Vrati obsah stranky na vkladani prispevku
     * @param string $pageTitle Nazev stranky
     * @return string           Vypis v sablone
     */
    public function show(string $pageTitle): string {
        $UPLOAD_DIR = getcwd().DIRECTORY_SEPARATOR . "uploads\\";
        if (!isset($_SESSION['role_id'])) {
            header('Location: index.php');
            die;
        }
        else {
            $tplData['title'] = $pageTitle;

            if (isset($_POST['action']) and $_POST['action'] == "edit"
                and !empty($_POST['title']) and !empty($_POST['content'])
                and !empty($_POST['article_id'])  and $_FILES['fileToUpload']['type'] == 'application/pdf') {

                if (trim($_POST['title']) == '' || trim($_POST['content']) == '')
                    echo('All fields are required!');

                else {
                    if ($this->db->editArticle($_POST['article_id'], $_POST['title'], $_POST['content'])) {
                        $id = $_POST['article_id'];
                        $target_file = $UPLOAD_DIR . basename($id . ".pdf");
                        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                        header("Location: index.php?page=sprava");
                    }
                }
            }

            if (isset($_POST['action']) and $_POST['action'] == "insert"
                and !empty($_POST['title']) and !empty($_POST['content']) and $_FILES['fileToUpload']['type'] == 'application/pdf') {

                if (trim($_POST['title']) == '' || trim($_POST['content']) == '')
                    echo('All fields are required!');

                else {
                    if ($this->db->insertArticle($_POST['title'], $_POST['content'], $_SESSION['user_id'])) {
                        $id = $this->db->getArticleID($_POST['title']);
                        $target_file = $UPLOAD_DIR . basename($id . ".pdf");
                        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                        header("Location: index.php?page=sprava");
                    }
                }
            }

            ob_start();
            require_once($_SERVER['DOCUMENT_ROOT'] . VIEWS_DIR . "/NewArticleTemplate.tpl.php");
        }
        return ob_get_clean();
    }
}
