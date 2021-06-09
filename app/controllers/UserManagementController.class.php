<?php
session_start();
require_once ("IController.interface.php");
require ("ControllerBasics.class.php");

/**
 * Class UserManagementController ovladac na zobrazeni panelu spravy uzivatele
 */

class UserManagementController implements IController {
    /** @var DatabaseModel databaze */
    private DatabaseModel $db;
    /** @var ControllerBasics trida k nacteni dat */
    private ControllerBasics $tpl;

    /**
     * UserManagementController constructor pripojeni k databazi a nacteni dat
     */
    public function __construct()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
        $this->tpl = new ControllerBasics();
    }

    /**
     * Vrati obsah stranky slouzici ke sprave uzivatele. Vrati take spravu uzivatelu, pokud je role prihlaseneho
     * uzivatele 'admin'
     * @param string $pageTitle Nazev stranky
     * @return string           Vypis v sablone
     */
    public function show(string $pageTitle):string {
        $tplData = $this->tpl->loadData();
        $tplData['title'] = $pageTitle;

        if (!isset($_SESSION['role_id'])) {
            header('Location: index.php');
            die;
        }
        else {
            if (isset($_POST['action']) and $_POST['action'] == "delete"
                and isset($_POST['user_id'])
            ) {
                // provedu smazani uzivatele
                $ok = $this->db->deleteUser(intval($_POST['user_id']));
                if ($ok) {
                    $tplData['delete'] = "OK: Uživatel s ID:$_POST[user_id] byl smazán z databáze.";
                    $tplData['users'] = $this->db->getAllUsers();
                    for ($i = 0; $i < sizeof($tplData['users']); $i++) {
                        $tplData['users'][$i]['role'] = $this->db->getUserRole($tplData['users'][$i]['id_users']);
                    }
                    header("Refresh:0");
                } else {
                    $tplData['delete'] = "CHYBA: Uživatele s ID:$_POST[user_id] se nepodařilo smazat z databáze.";
                }
            }

            if (isset($_POST['action']) and $_POST['action'] == "delete"
                and isset($_POST['article_id'])
            ) {
                // provedu smazani prispevku
                $ok = $this->db->deleteArticle(intval($_POST['article_id']));
                if ($ok) {
                    $tplData['delete'] = "OK: Článek s ID:$_POST[article_id] byl smazán z databáze.";
                    $tplData['articles'] = $this->db->getAllArticles();
                    header("Refresh:0");
                } else {
                    $tplData['delete'] = "CHYBA: Článek s ID:$_POST[article_id] se nepodařilo smazat z databáze.";
                }
            }

            if (isset($_POST['change_role']) and $_POST['change_role'] == "change" and isset($_POST['user_id'])
                and isset($_POST['role'])) {
                if ($this->db->changeUserRole($_POST['user_id'], $_POST['role'])) {
                    header("Refresh:0");
                }
            }

            ob_start();
            require_once($_SERVER['DOCUMENT_ROOT'] . VIEWS_DIR . "/UserManagementTemplate.tpl.php");
        }
        return ob_get_clean();
    }
}