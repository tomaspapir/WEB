<?php

global $tplData;

$tplData['title'] = "BabettaForum";

require ("TemplateBasics.class.php");

$tpl = new TemplateBasics();

$tpl->getHTMLHeader($tplData['title']);
$tpl->getHTMLNavbar($tplData['title']);
$res = "<div id='article-management'>
            <div class='container'>
                <div id='article-management-row' class='row justify-content-center align-items-center'>
                    <div id='article-management-column' class='col-md-10'>
                       <div id='article-management-box' class='col-md-12'>
                         <h3>Seznam příspěvků</h3>
                         <h4 class='text-info'>Příspěvky čekající na schválění</h4>
                         <table class='table table-bordered'> <thead class='thead-dark'>                          
                            <tr>
                              <th>Titulek</th>
                              <th>Autor</th>
                              <th>Recenzent</th>
                              <th>Ohodnocnení</th>
                              <th>Rozhodnutí</th></thead>                              
                            </tr>";

foreach($tplData['articles'] as $article){
    if (isset($article['approved']) && $article['approved'] == 0) {
        $res .= "<td rowspan='3'><a class='blacked'
                              href='index.php?page=zobrazeni_clanku&article_title=$article[title]'>$article[title]</a></td>
                              <td rowspan='3'>$article[author]</td>";

        $res .= $tpl->getArticleTableFirstPart($article);
        $res .="<td rowspan='3' class='alert-warning'>Čeká na schválení</td>";
        $res .= $tpl->getArticleTableSecondPart($article);

    }
}
                $res .= "</table>                         
                         <h4 class='text-info'>Schválené příspěvky</h4>
                         <table class='table table-bordered'> <thead class='thead-dark'>                          
                            <tr>
                              <th>Titulek</th>
                              <th>Autor</th>
                              <th>Recenzent</th>
                              <th>Ohodnocnení</th>
                              <th>Rozhodnutí</th></thead>                              
                            </tr>";

foreach($tplData['articles'] as $article) {
    if (isset($article['approved']) && $article['approved'] == 1) {
        $res .= "<td rowspan='3'><a class='blacked' 
                               href='index.php?page=zobrazeni_clanku&article_title=$article[title]'>$article[title]</a></td>
                               <td rowspan='3'>$article[author]</td>";

        $res .= $tpl->getArticleTableFirstPart($article);
        $res .= "<td rowspan='3' class='alert-success'>Schváleno</td>";
        $res .= $tpl->getArticleTableSecondPart($article);

    }
}
                $res .= "</table>                       
                         <h4 class='text-info'>Zamítnuté příspěvky</h4>
                         <table class='table table-bordered'> <thead class='thead-dark'>                          
                             <tr>
                               <th>Titulek</th>
                               <th>Autor</th>
                               <th>Recenzent</th>
                               <th>Ohodnocnení</th>
                               <th>Rozhodnutí</th></thead>                              
                             </tr>";

foreach($tplData['articles'] as $article){
    if (isset($article['approved']) && $article['approved'] == -1) {
        $res .= "<td rowspan='3'><a class='blacked' 
                               href='index.php?page=zobrazeni_clanku&article_title=$article[title]'>$article[title]</a></td>
                               <td rowspan='3'>>$article[author]</td>";

        $res .= $tpl->getArticleTableFirstPart($article);
        $res .= "<td rowspan='3' class='alert-danger'>Zamítnuto</td>";
        $res .= $tpl->getArticleTableSecondPart($article);
    }
}

                $res .= "</table>
                       </div>
                    </div>
                </div>
            </div>
        </div>";

echo $res;

$tpl->getHTMLFooter();

