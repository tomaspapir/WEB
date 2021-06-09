<?php

/**
 * Vstupni bod webove aplikace.
 */
class LaunchApplication {

    /**
     * Inicializace webove aplikace.
     */
    public function __construct()
    {
        require_once($_SERVER['DOCUMENT_ROOT'].CONTROLLERS_DIR."/IController.interface.php");
    }

    /**
     * Spusteni webove aplikace.
     */
    public function launchApp(){
        if(isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES)){
            $pageKey = $_GET["page"];
        } else {
            $pageKey = DEFAULT_WEB_PAGE_KEY;
        }

        $pageInfo = WEB_PAGES[$pageKey];

        //// nacteni odpovidajiciho kontroleru, jeho zavolani a vypsani vysledku
        // pripojim souboru ovladace
        require_once($_SERVER['DOCUMENT_ROOT'].CONTROLLERS_DIR ."/". $pageInfo["file_name"]);

        // nactu ovladac a bez ohledu na prislusnou tridu ho typuju na dane rozhrani
        /** @var IController $controller  Ovladac prislusne stranky. */
        $controller = new $pageInfo["class_name"];
        // zavolam prislusny ovladac a vypisu jeho obsah
        echo $controller->show($pageInfo["title"]);
    }
}

?>

