<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////

//// Pripojeni k databazi ////

/** Adresa serveru. */
define("DB_SERVER","localhost");
/** Nazev databaze. */
define("DB_NAME","papirniksp_v2");
/** Uzivatel databaze. */
define("DB_USER","root");
/** Heslo uzivatele databaze */
define("DB_PASS","");


//// Nazvy tabulek v DB ////

/** Tabulka s uzivateli. */
define("TABLE_USERS", "users");
/** Tabulka s clanky. */
define("TABLE_ARTICLES", "articles");
/** Tabulka s hodnocenim. */
define("TABLE_REVIEWS", "reviews");
/** Tabulka s pravomocemi. */
define("TABLE_ROLES", "roles");


//// Dostupne stranky webu ////

/** Adresar kontroleru. */
const CONTROLLERS_DIR = "/V2/app/controllers";
/** Adresar modelu. */
const MODELS_DIR = "/V2/app/models";
/** Adresar sablon */
const VIEWS_DIR = "/V2/app/views";
/** Adresar obrazku */
const IMG_DIR = "/V2/img";


/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "uvod";

/** Dostupne webove stranky. */
const WEB_PAGES = array(
    //// Uvodni stranka ////
    "uvod" => array(
        "title" => "Články",

        //// kontroler
        "file_name" => "HomepageController.class.php",
        "class_name" => "HomepageController",
    ),
    //// KONEC: Uvodni stranka ////


    //// Login uzivatelu ////
    "login" => array(
        "title" => "Přihlášení",

        //// kontroler
        "file_name" => "LoginController.class.php",
        "class_name" => "LoginController",
    ),
    //// KONEC: Login uzivatelu ////


    //// Registrace uzivatelu ////
    "registrace" => array(
        "title" => "Registrace",

        //// kontroler
        "file_name" => "RegistrationController.class.php",
        "class_name" => "RegistrationController",
    ),
    //// KONEC: Registrace uzivatelu ////


    //// Sprava uzivatelu ////
    "sprava" => array(
        "title" => "Správa uživatelů",

        //// kontroler
        "file_name" => "UserManagementController.class.php",
        "class_name" => "UserManagementController",
    ),
    //// KONEC: Sprava uzivatelu ////


    //// Vlozeni clanku ////
    "prispevek" => array(
        "title" => "Vložit nový článek",

        //// kontroler
        "file_name" => "NewArticleController.class.php",
        "class_name" => "NewArticleController",
    ),
    //// KONEC: Vlozeni clanku ////

    //// Recenze clanku ////
    "recenze" => array(
        "title" => "Recenze článku",

        //// kontroler
        "file_name" => "ViewReviewController.class.php",
        "class_name" => "ViewReviewController",
    ),
    //// KONEC: Recenze clanku ////

    //// Recenze clanku ////
    "vlozit_recenzi" => array(
        "title" => "Vložení nové recenze",

        //// kontroler
        "file_name" => "InsertReviewController.class.php",
        "class_name" => "InsertReviewController",
    ),
    //// KONEC: Recenze clanku ////

    //// Sprava clanku ////
    "sprava_clanku" => array(
        "title" => "Správa článků",

        //// kontroler
        "file_name" => "ArticleManagementController.class.php",
        "class_name" => "ArticleManagementController",
    ),
    //// KONEC: Sprava clanku ////


    //// Zobrazeni clanku ////
    "zobrazeni_clanku" => array(
        "title" => "Zobrazení článku",

        //// kontroler
        "file_name" => "ViewArticleController.class.php",
        "class_name" => "ViewArticleController",
    ),
    //// KONEC: Zobrazeni clanku ////



    /// //// Zobrazeni clanku ////
    "o_nas" => array(
       "title" => "O nás",

       "file_name" => "AboutController.class.php",
       "class_name" => "AboutController",
    ),
    //// KONEC: Zobrazeni clanku ////



    /// //// Zobrazeni clanku ////
    "download" => array(
        "title" => "Stažení článku",

        "file_name" => "DownloadController.class.php",
        "class_name" => "DownloadController",
    ),
    //// KONEC: Zobrazeni clanku ////

);

?>
