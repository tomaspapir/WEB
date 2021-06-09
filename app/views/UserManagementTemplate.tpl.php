<?php

global $tplData;

$tplData['title'] = "BabettaForum";

require ("TemplateBasics.class.php");

$tpl = new TemplateBasics();

$tpl->getHTMLHeader($tplData['title']);
$tpl->getHTMLNavbar($tplData['title']);

$res_admin = "<table class='table table-hover table-users'><tr><thead class='thead-dark'>
              <th>ID</th>
              <th>Jméno</th>
              <th>Příjmení</th>
              <th>Login</th>
              <th>E-mail</th>
              <th>Role</th>
                <th>Akce</th></tr>";
foreach($tplData['users'] as $u){
    $roleChanger = "
              <form method='post'>
                 <select class='text-center' name='role'>
                     <option value=1".($u['id_roles'] == 1 ? ' selected': '').">Administrátor</option>
                     <option value=2".($u['id_roles'] == 2 ? ' selected': '').">Recenzent</option>
                     <option value=3".($u['id_roles'] == 3 ? ' selected': '').">Autor</option>
                 </select><br>
                 <input type='hidden' value='$u[id_users]' name='user_id' />
                 <button type='submit' name='change_role' class='btn btn-info btn-sm' value='change'>Změnit roli</button>
              </form>
                   ";
    $res_admin .= "
              <tr>
              <td>$u[id_users]</td>
              <td>$u[first_name]</td>
              <td>$u[last_name]</td>
              <td>$u[user_name]</td>
              <td>$u[email]</td>
              <td>$roleChanger</td>"
              ."<td><form method='post'>"
              ."<input type='hidden' name='user_id' value='$u[id_users]'>"
              ."<button class='btn btn-danger' type='submit' name='action' value='delete'>Smazat</button>"
              ."</form></td></tr>";
}

$res_admin .= "</table>";

$res_reviewer = "<table class='table table-hover table-users'><tr><thead class='thead-dark'>
                 <th>Název článku</th>
                 <th>Ohodnocení</th>
                 <th>Akce</th></tr>";

foreach($tplData['users'] as $u){
    if (isset($u['reviews'])) {
        for ($i = 0; $i < sizeof($u['reviews']); $i++) {
            if ($u['id_users'] == $_SESSION['user_id']) {
                $review_id = $u['reviews'][$i]['id_reviews'];
                $article_name = $u['reviews'][$i]['article_name'];
                $star_review = '';
                $caption_review = '';
                $content_review = '';
                $stylistics_review = '';

                if (isset($u['reviews'][$i]['star_review'])) {
                    $star_review = $u['reviews'][$i]['star_review'];
                }
                if (isset($u['reviews'][$i]['caption_review'])) {
                    $caption_review = $u['reviews'][$i]['caption_review'];
                }
                if (isset($u['reviews'][$i]['content_review'])) {
                    $content_review = $u['reviews'][$i]['content_review'];
                }
                if (isset($u['reviews'][$i]['stylistics_review'])) {
                    $stylistics_review = $u['reviews'][$i]['stylistics_review'];
                }

                $res_reviewer .= "<tr>
                            <td>$article_name</td>
                            <td>";
                if (empty($star_review)) $res_reviewer .= "Dosud neohodnoceno";
                else {
                    for ($k = 0; $k < $star_review; $k++) {
                        $res_reviewer .= "<i class='fa fa-star' style='color: gold'></i>";
                    }
                }
                $res_reviewer .= "</td>"
                    . "<td class='text-center'><form action='index.php?page=vlozit_recenzi' method='post'>"
                    . "<input type='hidden' name='id_review' value='$review_id'>"
                    . "<input type='hidden' name='article_name' value='$article_name'>"
                    . "<input type='hidden' name='star_review' value='$star_review'>"
                    . "<input type='hidden' name='caption_review' value='$caption_review'>"
                    . "<input type='hidden' name='content_review' value='$content_review'>"
                    . "<input type='hidden' name='stylistics_review' value='$stylistics_review'>"
                    . "<button class='btn btn-info' type='submit' name='action' value='edit'>Upravit</button>"
                    . "</form></td></tr>";
            }
        }
    }
}
$res_reviewer .= "</table>";
?>

<div id="management">
        <div class="container">
            <div id="management-row" class="row justify-content-center align-items-center">
                <div id="management-column" class="col-md-12">
                   <div id="management-box" class="col-md-12">
                       <br>
                       <h3 class="text-center text-info">Správa účtu</h3><br>
                       <h4 class="text-lg-left">Uživatelské jméno</h4>
                       <i class="user-management text-monospace"><?= $_SESSION['username']?></i><br><br>
                       <h4 class="text-lg-left">Email</h4>
                       <i class="user-management text-monospace"><?= $_SESSION['email']?></i><br><br>
                       <h4 class="text-lg-left">Jméno</h4>
                       <i class="user-management text-monospace"><?= $_SESSION['firstname']?></i><br><br>
                       <h4 class="text-lg-left">Příjmení</h4>
                       <i class="user-management text-monospace"><?= $_SESSION['lastname']?></i><br><br>
                       <h4 class="text-lg-left">Role na webu</h4>
                       <i class="user-management text-monospace"><?= $_SESSION['role']?></i><br><br>

                       <form class="text-center" action="deleteSession.php" method="post">
                           <button class="btn btn-info btn-md" type="submit">
                               Odhlásit se
                           </button>
                       </form>
                </div>
                <div id="management">
                    <div class="container">
                        <div id="management-row" class="row justify-content-center align-items-center">
                                <div id="management-box" class="col-md-12">
                                    <br>
                                    <h3 class="text-center text-info">Moje příspěvky</h3><br>
                                    <table class='table table-bordered'> <thead class='thead-dark'>
                                        <tr>
                                            <th>Titulek</th>
                                            <th>Status</th>
                                            <th>Hodnocení</th>
                                            <th>Akce</th>
                                        </tr>
                                        <?php
                          for ($i = 0; $i < sizeof($tplData['articles']); $i++) {
                                if ($tplData['articles'][$i]['id_users'] == $_SESSION['user_id']) {
                                      $article_id = $tplData['articles'][$i]['id_articles'];
                                      $article_title = $tplData['articles'][$i]['title'];
                                      $article_content = $tplData['articles'][$i]['text'];
                                      $article_id_status = $tplData['articles'][$i]['approved'];
                                      $article_status = 0;
                                      switch ($article_id_status) {
                                         case -1:
                                            $article_status = "Zamítnuto";
                                            break;
                                         case 0:
                                            $article_status = "Čekající na schválení";
                                            break;
                                         case 1:
                                            $article_status = "Schváleno";
                                            break;
                                      }


                                   echo "<tr>
                                          <td><a href='index.php?page=download&file=".$article_id."'>".$article_title."</a></td>
                                          <td>$article_status</td>
                                          <td>";
                                  if (!empty($tplData['articles'][$i]['reviews'])) {
                                      for ($j = 0; $j < sizeof($tplData['articles'][$i]['reviews']); $j++) {

                                         if (!empty($tplData['articles'][$i]['reviews'][$j]['reviewer'])) {
                                            $review = $tplData['articles'][$i]['reviews'][$j]['reviewer']."<br> ";
                                            if (empty($tplData['articles'][$i]['reviews'][$j]['star_review'])) $review .= "Bez hodnocení";

                                            for ($k = 0; $k < $tplData['articles'][$i]['reviews'][$j]['star_review']; $k++) {
                                                  $review .= "<i class='fa fa-star' style='color: gold'></i>";
                                            }
                                            echo $review."<br><hr>";

                                         } else echo "Bez hodnocení <br>";
                                      }
                                  } else echo "Bez hodnocení <br>";
                                  echo "</td>

                                                    <td class='text-center'><form action='index.php?page=prispevek' method='post'>
                                                    <input type='hidden' name='article_id' value='$article_id'>       
                                                    <input type='hidden' name='article_title' value='$article_title'>                                       
                                                    <input type='hidden' name='article_content' value='$article_content'>                                       
                                
                                                    <button class='btn btn-info'
                                                            type='submit' name='action' value='edit'>Upravit</button>                                                            
                                                    </form> <br>
                                                    
                                                    <form method='post'>
                                                    <input type='hidden' name='article_id' value='$article_id'>                                       
                                                    <button class='btn btn-danger
                                                            type='submit' name='action' value='delete'>Smazat</button>
                                                            
                                                    </form></td>
                                                  </tr>";
                                        }

                                    }
                                    ?>


                                    </table>

                                </div>
                            </div>


                <?php if($_SESSION['role'] == 'administrator') {
                    echo
                    '<div id="management-row" class="row justify-content-center align-items-center">
                        <div id="management-box" class="col-md-12">
                           <br>
                           <h3 class="text-center text-info">Správa uživatelů</h3><br>'.
                           $res_admin.'
                        </div>
                    </div>';
                } ?>

                <?php if($_SESSION['role'] == 'reviewer') {
                    echo
                    '<div id="management-row" class="row justify-content-center align-items-center">
                       <div id="management-box" class="col-md-12">
                         <br>
                         <h3 class="text-center text-info">Moje recenze</h3><br>'.
                         $res_reviewer.'
                        </div>
                    </div>';
                } ?>
                    </div>
                    </div>
                 </div>
            </div>
        </div>
</div>

<?php
$tpl->getHTMLFooter();
