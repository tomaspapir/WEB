<?php
session_start();
require_once ("IController.interface.php");
require ("ControllerBasics.class.php");

/**
 * Class DownloadController ovladac na stazeni PDF článku
 */
class DownloadController implements IController
{
    /** @var DatabaseModel databaze */
    private DatabaseModel $db;
    /** @var ControllerBasics trida slouzici k nacteni dat */
    private ControllerBasics $tpl;

    /**
     * DownloadController constructor pripojeni k databazi a nacteni dat
     */
    public function __construct()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
        $this->tpl = new ControllerBasics();
    }


    /**
     * Pokud je PDF soubor dostupny, tak ho stahne
     * @param string $pageTitle Nazev stranky
     * @return string           Vypis v sablone
     */
    public function show(string $pageTitle): string
    {
        global $tplData;
        $tplData = $this->tpl->loadData();
        if (isset($_GET['file'])) {
            foreach ($tplData['articles'] as $article) {
                if ($article['id_articles'] == $_GET['file']) {
                    if ($article['approved'] == 1 or (isset($_SESSION) and $article['id_users'] == $_SESSION['user_id'])) {
                        $UPLOAD_DIR = getcwd() . DIRECTORY_SEPARATOR . "uploads\\";
                        $file = basename($_GET['file']);
                        $file = $UPLOAD_DIR . $file . ".pdf";
                        echo $file;
                        if (!file_exists($file)) { // file does not exist
                            header("Location: index.php?download=failed");
                        } else {
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: attachment; filename="'.basename($file).'"');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            header('Content-Length: ' . filesize($file));
                            readfile($file);//"@" is an error control operator to suppress errors
                        }

                    } else {
                        header("Location: index.php?download=failed");
                        die;
                    }
                }
            }
            return '';
        }
        return '';
    }
}