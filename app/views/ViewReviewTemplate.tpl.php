<?php

global $tplData;

$tplData['title'] = "BabettaForum";

require ("TemplateBasics.class.php");

$tpl = new TemplateBasics();

$tpl->getHTMLHeader($tplData['title']);
$tpl->getHTMLNavbar($tplData['title']);

$res = "";
$hasReviews = false;

if (isset($_GET['status']) and $_GET['status'] == "success") {
    echo "<div class='alert alert-success text-center' role='alert'>Recenze přidána</div>";
}

$res .= "<div class='mcontainer'>";
foreach ($tplData['users'] as $u) {
    if (isset($u['reviews'])) {
        for ($i = 0; $i < sizeof($u['reviews']); $i++) {
            if ($u['id_users'] == $_SESSION['user_id']) {
                $hasReviews = true;
                $review_id = $u['reviews'][$i]['id_reviews'];
                $article_name = $u['reviews'][$i]['article_name'];
                $caption_review = $u['reviews'][$i]['caption_review'];
                $content_review = $u['reviews'][$i]['content_review'];
                $stylistics_review = $u['reviews'][$i]['stylistics_review'];
                $star_review = $u['reviews'][$i]['star_review'];
                $res .= "<div class='container'>
                         <div class='row justify-content-center align-items-center'>
                         <div class='col-md-10 jumbotron'>
                         <div class='col-md-12'>";
                $res .= "<h2>$article_name</h2>";
                $res .= "<b>Celkové hodnocení: </b>";
                for ($j = 0; $j <$u['reviews'][$i]['star_review']; $j++) {
                    $res .= "<i class='fa fa-star' style='color: gold'></i>";
                }
                $res .= "<br><b>Hodocení titulku: </b>" . $caption_review . "<br>";
                $res .= "<b>Hodnocení obsahu: </b>" . $content_review . "<br>";
                $res .= "<b>Hodnocení stylistiky: </b>" . $stylistics_review . "<br><br>";
                $res .= "</td>"
                    . "<td class='text-center'><form action='index.php?page=vlozit_recenzi' method='post'>"
                    . "<input type='hidden' name='id_review' value='$review_id'>"
                    . "<input type='hidden' name='article_name' value='$article_name'>"
                    . "<input type='hidden' name='star_review' value='$star_review'>"
                    . "<input type='hidden' name='caption_review' value='$caption_review'>"
                    . "<input type='hidden' name='content_review' value='$content_review'>"
                    . "<input type='hidden' name='stylistics_review' value='$stylistics_review'>"
                    . "<button class='btn btn-info' type='submit' name='action' value='edit'>Upravit</button>"
                    . "</form></td></tr>";
                $res .= "</div></div></div></div>";
            }
        }
        $res .= "</div>";
    }
}
if (!$hasReviews) {
    $path = "..".IMG_DIR."/sad2.png";
    $res .= "<div class='container'>
                     <div class='row justify-content-center align-items-center'>
                     <div class='col-md-6 jumbotron'>
                     <div class='col-md-12'>
                     <div class='alert alert-warning text-center' role='alert'>Dosud vám nebyly přiděleny žádné
                     články k ohodnocení.</div>
                     <img src=$path class='card-img img-fluid'></div></div></div></div>";
}
echo $res;

//$tpl->getHTMLFooter();
