<?php
session_start();
require_once("IController.interface.php");

/**
 * Class RegistrationController ovladac pro registraci noveho uzivatele do databaze webu
 */
class RegistrationController implements IController {

    /** @var DatabaseModel $db databazovy model */
    private DatabaseModel $db;

    /**
     * RegistrationController constructor pripojeni k databazi
     */
    public function __construct() {

        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->db = new DatabaseModel();

    }

    /**
     * Vrati obsah stranky s registraci
     * @param string $pageTitle nazev stranky
     * @return string sablona
     */
    public function show(string $pageTitle): string {

        if (isset($_SESSION['role_id'])) {
            header('Location: index.php');
            die;
        }
        else {
            if (!empty($_POST['user_name']) and !empty($_POST['email']) and !empty($_POST['password'])
                and !empty($_POST['password_repeat']) and !empty($_POST['first_name']) and !empty($_POST['last_name'])) {

                $username = $_POST['user_name'];
                $email = $_POST['email'];
                $firstname = $_POST['first_name'];
                $lastname = $_POST['last_name'];

                if (trim($_POST['password']) == '' || trim($_POST['password_repeat']) == ''
                    || trim($_POST['user_name']) == '' || trim($_POST['email']) == ''
                    || trim($firstname) == '' || trim($_POST['last_name']) == '')
                    echo "<br><br><div class='alert alert-danger text-center' role='alert'>Prosím vyplňte všechny hodnoty</div>";

                else if ($_POST['password'] != $_POST['password_repeat'])
                    echo "<br><br><div class='alert alert-danger text-center' role='alert'>Zadané hesla se nerovnají</div>";

                else {
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    if ($this->db->insertUser($username, $email, $password, $firstname, $lastname) == 1) {
                        $_SESSION['reg'] = 1;
                        ob_start();
                        header("Location: index.php?page=login");
                        ob_end_flush();
                    } else if ($this->db->insertUser($username, $email, $password, $firstname, $lastname) == 23000) {
                        $_SESSION['reg'] = 23000;
                    }
                }
            }
            ob_start();
            require_once($_SERVER['DOCUMENT_ROOT'] . VIEWS_DIR . "/RegistrationTemplate.tpl.php");
        }
        return ob_get_clean();
    }
}
