<?php

/**
 * Trida pracujici s databazi
 */

class DatabaseModel {

    /** @var pdo Datovy objekt ktery umoznuje praci s databazi */
    private $pdo;

    /**
     * DatabaseModel constructor (pripojeni k databazi)
     */
    public function __construct() {
        // inicializace DB
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        // kodovani UTF-8
        $this->pdo->exec("set names utf8");
    }

    /**
     * @return array Vrati vsechny uzivatele serazene podle jejich primarniho klice
     */
    public function getAllUsersByID() {

        $q = "SELECT * FROM ".TABLE_USERS." ORDER BY id_users";
        $res = $this->pdo->query($q);

        if (!$res) return [];
        else return $res->fetchAll();

    }

    /**
     * @return array Vrati vsechny uzivatele serazene podle prijmeni
     */
    public function getAllUsers() {

        $q = "SELECT * FROM ".TABLE_USERS." ORDER BY last_name";
        $res = $this->pdo->query($q);

        if (!$res) return [];
        else return $res->fetchAll();

    }

    /**
     * @param int $id_user id uzivatele
     * @return mixed|string Vrati uzivatele podle zadaneho id
     */
    public function getUser(int $id_user) {
        $q = "SELECT * FROM ".TABLE_USERS." WHERE id_users=:id_user";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":id_user", $id_user);

        if ($res->execute()) return $res->fetch();
        else return '';
    }

    /**
     * @param string $username uzivatelske jmeno
     * @return mixed|string Vrati ID uzivatele podle uzivatelskeho jmena
     */
    public function getUserID(string $username) {
        $q = "SELECT id_users FROM ".TABLE_USERS." WHERE user_name=:username";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":username", $username);

        if ($res->execute()) return $res->fetchColumn();
        else return '';
    }

    /**
     * @param int $id_user id uzivatele
     * @return mixed|string Vrati roli uzivatele podle id
     */
    public function getUserRole(int $id_user) {
        $q = "SELECT name FROM ".TABLE_ROLES." JOIN ".TABLE_USERS." ON users.id_roles = roles.id_roles WHERE id_users=:id_user";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":id_user", $id_user);

        if ($res->execute()) return $res->fetchColumn();
        else return '';
    }

    /**
     * @param int $id_user id uzivatele
     * @param int $id_role id role
     * @return bool pokud se zmena role povedla tak vrati true
     */
    public function changeUserRole(int $id_user, int $id_role):bool {
        $q = "UPDATE ".TABLE_USERS." SET id_roles=:id_role WHERE id_users=:id_user";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":id_role", $id_role);
        $res->bindValue(":id_user", $id_user);

        if ($res->execute()) return true;
        else return false;
    }

    /**
     * @return array Vrati vsechny clanky serazene podle data vytvoreni
     */
    public function getAllArticles() {

        $q = "SELECT * FROM ".TABLE_ARTICLES." ORDER BY created_on DESC";
        $res = $this->pdo->query($q);

        if(!$res) return[];
        else return $res->fetchAll();

    }

    /**
     * @param int $article_id id clanku
     * @return string vrati nazev clanku
     */
    public function getArticleName(int $article_id):string {
        $q = "SELECT title FROM ".TABLE_ARTICLES." WHERE id_articles=:article_id";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":article_id", $article_id);

        if($res->execute()) return $res->fetchColumn();
        else return '';
    }

    /**
     * @param string $title titulek
     * @return mixed|string vrati id clanku podle titulku
     */
    public function getArticleID(string $title) {
        $q = "SELECT id_articles FROM ".TABLE_ARTICLES." WHERE title=:title";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":title", $title);

        if ($res->execute()) return $res->fetchColumn();
        else return '';
    }

    /**
     * @param int $article_id id clanku
     * @return mixed|string vrati autora clanku
     */
    public function getArticleAuthor(int $article_id) {
        $q = "SELECT CONCAT(first_name , ' ' , last_name) AS name
              FROM ".TABLE_USERS." JOIN ".TABLE_ARTICLES." ON users.id_users = articles.id_users WHERE id_articles=:article_id";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":article_id", $article_id);

        if($res->execute()) return $res->fetchColumn();
        else return '';
    }

    /**
     * @param int $article_id id clanku
     * @return mixed|string vrati id autora clanku
     */
    public function getArticleAuthorID(int $article_id) {
        $q = "SELECT id_users FROM ".TABLE_ARTICLES." WHERE id_articles=:article_id";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":article_id", $article_id);

        if($res->execute()) return $res->fetchColumn();
        else return '';
    }

    /**
     * @param int $id_user id uzivatele
     * @return mixed|string vrati jmeno a prijmeni uzivatele
     */
    public function getUsersName(int $id_user) {
        $q = "SELECT CONCAT(first_name , ' ' , last_name) AS name
              FROM ".TABLE_USERS." WHERE id_users =:id_user";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":id_user", $id_user);

        if($res->execute()) return $res->fetchColumn();
        else return '';
    }

    /**
     * @param int $article_id id clanku
     * @return array vrati recenze clanku
     */
    public function getArticleReviews(int $article_id) {
        $q = "SELECT * FROM ".TABLE_REVIEWS." WHERE id_articles=:article_id";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":article_id", $article_id);

        if($res->execute()) return $res->fetchAll();
        else return[];
    }

    /**
     * Metoda slouzici k vlozeni noveho uzivatele do databaze
     * @param string $username  uzivatelske jmeno
     * @param string $email     email
     * @param string $password  heslo
     * @param string $firstname jmeno
     * @param string $lastname  prijmeni
     * @return bool pokud vlozeni probehlo uspesne vrati 1, jinak 0
     */
    public function insertUser(string $username, string $email, string $password,
                                 string $firstname, string $lastname):int {
        $username = htmlspecialchars($username);
        $email = htmlspecialchars($email);
        $firstname = htmlspecialchars($firstname);
        $lastname = htmlspecialchars($lastname);

        $q = "INSERT INTO ".TABLE_USERS." (id_roles, user_name, email, first_name, last_name, password)".
             " VALUES ('3', :username, :email, :firstname, :lastname, :password)";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":username", $username);
        $res->bindValue(":email", $email);
        $res->bindValue(":firstname", $firstname);
        $res->bindValue(":lastname", $lastname);
        $res->bindValue(":password", $password);

        if($res->execute()) return 1;
        else return $this->pdo->errorCode();
    }

    /**
     * @param string $title titulek
     * @param string $content obsah
     * @param int $user_id autor
     * @return bool pokud se vlozeni clanku povede tak vrati true
     */
    public function insertArticle(string $title, string $content, int $user_id):bool {
        $title = htmlspecialchars($title);
        $content = htmlspecialchars($content);

        $q = "INSERT INTO ".TABLE_ARTICLES." (id_users, created_on, title, text, approved)".
            " VALUES (:user_id, '".date("Y-m-d H:i:s")."', :title, :content, '0')";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":user_id", $user_id);
        $res->bindValue(":title", $title);
        $res->bindValue(":content", $content);

        if($res->execute()) return true;
        else return false;
    }

    /**
     * @param int $article_id id clanku
     * @param int $user_id id uzivatele
     * @return bool vrati true, pokud se vlozeni recenze povede
     */
    public function insertReview(int $article_id, int $user_id):bool {
        $q = "INSERT INTO ".TABLE_REVIEWS." (id_articles, id_users)".
            " VALUES (:article_id, :user_id)";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":article_id", $article_id);
        $res->bindValue(":user_id", $user_id);

        if($res->execute()) return true;
        else return false;
    }

    /**
     * @param int $article_id id clanku
     * @param int $status status
     * @return bool vrati true, pokud se povede zmena statusu clanku
     */
    public function changeArticleStatus(int $article_id, int $status):bool {
        $q = "UPDATE ".TABLE_ARTICLES." SET approved=:status WHERE id_articles=:article_id";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":status", $status);
        $res->bindValue(":article_id", $article_id);

        if($res->execute()) return true;
        else return false;
    }

    /**
     * @param int $article_id id clanku
     * @param string $title titulek
     * @param string $content obsah
     * @return bool vrati true, pokud se povede editace clanku
     */
    public function editArticle(int $article_id, string $title, string $content):bool {
        $title = htmlspecialchars($title);
        $content = htmlspecialchars($content);

        $q = "UPDATE ".TABLE_ARTICLES." SET title=:title, text=:content, approved = '0' WHERE id_articles=:article_id";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":title", $title);
        $res->bindValue(":content", $content);
        $res->bindValue(":article_id", $article_id);

        if($res->execute()) return true;
        else return false;
    }

    /**
     * @param int $review_id id hodnoceni
     * @param int $star_review hodnoceni ve hvezdickach
     * @param string $caption_review hodnoceni titulku
     * @param string $content_review hodnoceni obsahu
     * @param string $stylistics_review hodnoceni stylistiky
     * @return bool vrati true, pokud se uprava hodnoceni povede
     */
    public function editReview(int $review_id, int $star_review, string $caption_review,
                               string $content_review, string $stylistics_review):bool {
        $caption_review = htmlspecialchars($caption_review);
        $content_review = htmlspecialchars($content_review);
        $stylistics_review = htmlspecialchars($stylistics_review);

        $q = "UPDATE ".TABLE_REVIEWS." SET caption_review=:caption_review, content_review=:content_review,
              stylistics_review=:stylistics_review, star_review=:star_review WHERE id_reviews=:review_id";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":caption_review", $caption_review);
        $res->bindValue(":content_review", $content_review);
        $res->bindValue(":stylistics_review", $stylistics_review);
        $res->bindValue(":star_review", $star_review);
        $res->bindValue(":review_id", $review_id);

        if($res->execute()) return true;
        else return false;
    }

    /**
     * @param int $id_user id uzivatele
     * @return bool vrati true, pokud se povede smazani uzivatele
     */
    public function deleteUser(int $id_user):bool {
        $q = "DELETE FROM ".TABLE_USERS." WHERE id_users = '$id_user'";
        $res = $this->pdo->prepare($q);

        if($res->execute()) return true;
        else return false;
    }

    /**
     * @param int $id_article id clanku
     * @return bool vrati true, pokud se povede smazani clanku
     */
    public function deleteArticle(int $id_article):bool {
        $q = "DELETE FROM ".TABLE_ARTICLES." WHERE id_articles = '$id_article'";
        $res = $this->pdo->prepare($q);

        if($res->execute()) return true;
        else return false;
    }

    /**
     * @param int $id_review id hodnoceni
     * @return bool vrati true, pokud se povede smazani hodnoceni
     */
    public function deleteReview(int $id_review):bool {
        $q = "DELETE FROM ".TABLE_REVIEWS." WHERE id_reviews = '$id_review'";
        $res = $this->pdo->prepare($q);

        if($res->execute()) return true;
        else return false;
    }

    /**
     * @param int $id_article id clanku
     * @return bool vrati true, pokud se povede smazat hodnoceni clanku
     */
    public function deleteArticleReviews(int $id_article):bool {
        $q = "DELETE FROM ".TABLE_REVIEWS." WHERE id_articles = '$id_article'";
        $res = $this->pdo->prepare($q);

        if($res->execute()) return true;
        else return false;
    }

    /**
     * Metoda slouzici k overeni, jestli je uzivatelske jmeno validni
     * @param string $username uzivatelske jmeno
     * @return bool Vrati 1, pokud je uziv. jmeno validni, jinak 0
     */
    public function verifyUsername(string $username):bool {
        $q = "SELECT * FROM ".TABLE_USERS." WHERE user_name=:username";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":username", $username);

        if($res->execute()) return true;
        else return false;
    }

    /** Vrati zahashovane heslo k zadanemu uziv. jmenu
     * @param int $id_user id uzivatele
     * @return array|string zahashovane heslo
     */
    public function getUsersHashedPassword(int $id_user) {
        $q = "SELECT password FROM ".TABLE_USERS." WHERE id_users=:id_user";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":id_user", $id_user);

        if($res->execute()) return $res->fetchColumn();
        else return "";
    }

    /**
     * @param int $id_user id uzivatele
     * @return array vrati hodnoceni vytvorene uzivatelem
     */
    public function getUsersReviews(int $id_user) {
        $q = "SELECT * FROM ".TABLE_REVIEWS." WHERE id_users=:id_user";
        $res = $this->pdo->prepare($q);
        $res->bindValue(":id_user", $id_user);

        if($res->execute()) return $res->fetchAll();
        else return [];
    }
}

