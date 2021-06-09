<?php

/**
 * Class ControllerBasics nacteni dat
 */
class ControllerBasics {

    /** @var DatabaseModel databaze */
    private DatabaseModel $db;

    public function __construct() {
        require_once($_SERVER['DOCUMENT_ROOT'] . MODELS_DIR . "/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * @return array Vsechny potrebne data z databaze
     */
    public function loadData():array {

        global $tplData;
        $tplData = [];

        $tplData['users'] = $this->db->getAllUsers();
        for ($i = 0; $i < sizeof($tplData['users']); $i++) {
            $tplData['users'][$i]['role'] = $this->db->getUserRole($tplData['users'][$i]['id_users']);
        }
        for ($i = 0; $i < sizeof($tplData['users']); $i++) {
            if ($tplData['users'][$i]['role'] == 'reviewer') {
                $tplData['users'][$i]['reviews'] = $this->db->getUsersReviews($tplData['users'][$i]['id_users']);
            }
            if (isset($tplData['users'][$i]['reviews'])) {
                for ($j = 0; $j < sizeof($tplData['users'][$i]['reviews']); $j++) {
                    if (!empty($tplData['users'][$i]['reviews'][$j]['id_articles'])) {
                        $tplData['users'][$i]['reviews'][$j]['article_name'] =
                            $this->db->getArticleName($tplData['users'][$i]['reviews'][$j]['id_articles']);
                    }
                }
            }
        }

        $tplData['articles'] = $this->db->getAllArticles();
        for ($i = 0; $i < sizeof($tplData['articles']); $i++) {
            $tplData['articles'][$i]['author'] = $this->db->getArticleAuthor($tplData['articles'][$i]['id_articles']);
            $tplData['articles'][$i]['reviews'] = $this->db->getArticleReviews($tplData['articles'][$i]['id_articles']);

            for ($j = 0; $j < sizeof($tplData['articles'][$i]['reviews']); $j++) {
                if (!empty($tplData['articles'][$i]['reviews'][$j]['id_users'])) {
                    $tplData['articles'][$i]['reviews'][$j]['reviewer'] =
                        $this->db->getUsersName($tplData['articles'][$i]['reviews'][$j]['id_users']);
                }
            }
        }

        return $tplData;

    }

}