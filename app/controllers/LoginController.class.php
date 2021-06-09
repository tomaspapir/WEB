<?php
session_start();
require_once ("IController.interface.php");

/**
 * Class LoginController ovladac na zobrazeni prihlasovaci stranky
 */
class LoginController implements IController {

    /** @var DatabaseModel $db databazovy model */
    private DatabaseModel $db;

    /**
     * LoginController constructor pripojeni k databazi
     */
    public function __construct() {
        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * Vrati obsah prihlasovaci stranky
     * @param string $pageTitle Nazev stranky
     * @return string Sablona
     */
    public function show(string $pageTitle): string {
        if (isset($_SESSION['role_id'])) {
            header('Location: index.php');
            die;
        }
        else {
            if (isset($_POST['user_name']) and isset($_POST['password'])) {
                $username = trim($_POST['user_name']);

                if ($this->db->verifyUsername($username)) {
                    $_SESSION['user_id'] = $this->db->getUserID($username);
                    $hashed_password = $this->db->getUsersHashedPassword($_SESSION['user_id']);

                    if (!empty($hashed_password)) {
                        if (password_verify(trim($_POST['password']), $hashed_password)) {
                            $_SESSION['valid'] = true;
                            $user = $this->db->getUser($_SESSION['user_id']);

                            $_SESSION['username'] = $username;
                            $_SESSION['role'] = $this->db->getUserRole($_SESSION['user_id']);
                            $_SESSION['role_id'] = $user['id_roles'];
                            $_SESSION['email'] = $user['email'];
                            $_SESSION['firstname'] = $user['first_name'];
                            $_SESSION['lastname'] = $user['last_name'];
                            ob_start();
                            header("Location: index.php?page=sprava");
                            ob_end_flush();
                        } else echo "<br><br><div class='alert alert-danger text-center' role='alert'>Špatné jméno nebo heslo.</div>";

                    }
                }
            }
        }

        ob_start();
        require_once($_SERVER['DOCUMENT_ROOT'] . VIEWS_DIR . "/LoginTemplate.tpl.php");

        return ob_get_clean();
    }
}