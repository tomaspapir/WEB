<?php

global $tplData;

$tplData['title'] = "BabettaForum";
CONST ACCEPTED = 1;
CONST WAITING = 0;
CONST REJECTED = -1;

require ("TemplateBasics.class.php");

$tpl = new TemplateBasics();
$found = false;

$tpl->getHTMLHeader($tplData['title']);
$tpl->getHTMLNavbar($tplData['title']);

if (isset($_GET['article_title'])) {
    foreach ($tplData['articles'] as $article) {
        if($article['title'] == $_GET['article_title']) {
            $found = true;
            if ($article['approved'] == 0 and (!isset($_SESSION['role_id']) or $_SESSION['role_id'] > 1)) {
                header('Location: index.php');
                die;
            }
            else {
                $article_id = $article['id_articles'];
                $status = 0;
                $res = "<div class='container'>
                    <div class='row justify-content-center align-items-center'>
                    <div class='col-md-10'>
                    <div class='col-md-12 jumbotron'>";
                $res .= "<h2>$article[title]</h2>";
                $res .= "<b>Autor: </b>" . $article['author'] . " (" . date("d. m. Y, H:i:s", strtotime($article['created_on'])) . ")<br><br>";
                $res .= "<div style='text-align:justify;'>$article[text]</div><hr>";
                $res .= "<a class='btn btn-outline-dark' href='index.php?page=download&file=".$article_id."'><i class='fa fa-download'></i> PDF</a>";
                if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) {
                    $res .= "<h3>Stav</h3>";
                    switch ($article['approved']) {
                        case -1:
                            $res .= "<label class='alert-danger'>Zamítnuto</label>";
                            $status = -1;
                            break;
                        case 0:
                            $res .= "<label class='alert-warning'>Čeká na schválení</label>";
                            $status = 0;
                            break;
                        case 1:
                            $res .= "<label class='alert-success'>Schváleno</label>";
                            $status = 1;
                            break;
                    }

                    $res .= "<hr><h3>Recenze</h3>
                         <form method='post'>";

                    for ($i = 0; $i < 3; $i++) {
                        if (empty($article['reviews'][$i]['reviewer'])) {
                            $res .= "<b>Administrátor dosud nepřiřadil recenzenta </b><br>                                 
                                    <select class='text-center' name='reviewer_id$i'>
                                       <option value='' selected disabled hidden>Vyberte recenzenta</option>";
                            for ($j = 0; $j < sizeof($tplData['users']); $j++) {
                                if ($tplData['users'][$j]['id_roles'] == 2) {
                                    $user_id = $tplData['users'][$j]['id_users'];
                                    $name = $tplData['users'][$j]['first_name'] . " " . $tplData['users'][$j]['last_name'];
                                    $res .= "<option value=$user_id>$name</option>";
                                }
                            }
                            $res .= "</select> <hr>";
                        } else {
                            $reviewer_id = $article['reviews'][$i]['id_users'];
                            $review_id = $article['reviews'][$i]['id_reviews'];
                            $res .= "<b>Recenzent: </b>" . $article['reviews'][$i]['reviewer'] . "<br>";
                            $res .= "<b>Celkové hodnocení: </b>";
                            for ($j = 0; $j < $article['reviews'][$i]['star_review']; $j++) {
                                $res .= "<i class='fa fa-star' style='color: gold'></i>";
                            }
                            $res .= "<br><br>";
                            $res .= "<b>Ohodnocení titulku: </b>" . $article['reviews'][$i]['caption_review'] . "<br>";
                            $res .= "<b>Ohodnocení obsahu: </b>" . $article['reviews'][$i]['content_review'] . "<br>";
                            $res .= "<b>Ohodnocení stylistiky: </b>" . $article['reviews'][$i]['stylistics_review'] . "<br>";
                            $res .= "<input type='submit' name='delete' class='btn btn-danger btn-sm' value='Odstranit recenzi s ID: $review_id'>";
                            $res .= "<br> <hr>";
                        }
                    }
                    $res .= "<h3>Změna stavu</h3>";
                    $res .= "<select class='text-center' name='status'>
                             <option class='alert-success' value=1" . ($status == 1 ? ' selected' : '') . ">Schváleno</option>
                             <option class='alert-warning' value=0" . ($status == 0 ? ' selected' : '') . ">Čeká na schválení</option>
                             <option class='alert-danger' value=-1" . ($status == -1 ? ' selected' : '') . ">Zamítnuto</option>
                         </select> <br> <br>
                         <input type='hidden' value=$article_id name='article_id' />
                         <input type='submit' name='submit' class='btn btn-info btn-md' value='Změnit stav'><hr>
                         <input type='submit' name='remove' class='btn btn-danger btn-md' value='Odstranit článek'>

                         </form>";
                }
                $res .= "</div></div></div></div>";

                echo $res;
            }
        }
    }
    if (!$found) {
        header('Location: index.php');
        die;
    }
}
$tpl->getHTMLFooter();

