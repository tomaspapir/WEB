<?php

global $tplData;

$tplData['title'] = "BabettaForum";

require ("TemplateBasics.class.php");

$tpl = new TemplateBasics();

$tpl->getHTMLHeader($tplData['title']);
$tpl->getHTMLNavbar($tplData['title']);

$res = "";
$id_author = 0;

if (isset($_GET['download']) && $_GET['download'] == "failed")
    echo "<div class='alert alert-danger text-center' role='alert'>Neplatný soubor</div>";

if (!empty($_SESSION['role_id']) AND $_SESSION['role_id'] <= 3)
    $res .= "<h3 class='text-center'><a href='index.php?page=prispevek' class='btn btn-info'><i class='fa fa-inbox'></i> Vložit nový článek</a></h3>";
if(array_key_exists('articles', $tplData)) {
    $res .= "<div class='mcontainer'>";
    foreach ($tplData['articles'] as $article) {
        $stars = 0;
        $review_count = 0;

        if ($article['approved'] == 1) {
            $author = $article['author'];
            $res .= "<div class='container'>
                     <div class='row justify-content-center align-items-center'>
                     <div class='col-md-10 jumbotron'>
                     <div class='col-md-12'>";
            $res .= "<h2><a class='blacked' 
                               href='index.php?page=zobrazeni_clanku&article_title=$article[title]'>$article[title]</a></td></h2>";
            for ($i = 0; $i < 3; $i++) {
                if (!empty($article['reviews'][$i]['star_review'])) {
                    $review_count++;
                    $stars += $article['reviews'][$i]['star_review'];
                }
            }
            $res .= "<b>Autor: </b>". $author." (" . date("d. m. Y, H:i:s", strtotime($article['created_on'])) . ")<br>";
            $res .= "<b>Recenze: </b>";
            if ($stars > 0 and $review_count > 0) {
                for ($j = 0; $j < ($stars / $review_count); $j++) {
                    $res .= "<i class='fa fa-star' style='color: gold'></i>";
                }
            } else  $res .= "<i>Dosud neohodnoceno</i>";
            $res .= "<br>";
            $res .= "<br>";
            if (strlen($article['text']) < 650) {
                $res .= "<div class='max-lines hyper' style='text-align:justify;'>
                         <a href='index.php?page=zobrazeni_clanku&article_title=$article[title]'>$article[text]</a></div><hr>";
            }
            else {
                $preview = substr($article['text'], 0, 650);
                $res .= "<div class='max-lines hyper' style='text-align:justify;'> 
                         <a href='index.php?page=zobrazeni_clanku&article_title=$article[title]'>$preview...</a></div><hr>";
            }
            $res .= "</div></div></div></div>";
        }
    }
    $res .="</div>";
} else echo "Články nebyly nalezeny.";
echo $res;

$tpl->getHTMLFooter();

