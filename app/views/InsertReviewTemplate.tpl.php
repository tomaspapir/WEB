<?php

global $tplData;

$tplData['title'] = "BabettaForum";

require ("TemplateBasics.class.php");

$tpl = new TemplateBasics();

$tpl->getHTMLHeader($tplData['title']);
$tpl->getHTMLNavbar($tplData['title']);

$res = "";

?>
<div id="management">
    <div class="container">
        <div id="management-row" class="row justify-content-center align-items-center">
            <div id="management-column" class="col-md-10">
                <div id="management-box" class="col-md-12">
                    <br>
                    <form id="article-form" class="form" method="post">
                        <div class="form-group">
                            <?php

                            if (isset($_POST['action']) and $_POST['action'] == "edit"
                                and isset($_POST['article_name']) and isset($_POST['id_review'])) {
                                $id_review = $_POST['id_review'];
                                $title = $_POST['article_name'];
                                $star_review = 0;
                                if (isset($_POST['star_review'])) {
                                    $star_review = $_POST['star_review'];
                                }
                                echo "<label for='article-name' class='text-info'>Titulek článku</label> <br>
                                         <input type='text' name='title'
                                          id='title' class='form-control' value='$title' readonly>
                                     </div>
                                     <div class='form-group'>
                                         <label for='star' class='text-info'>Celkové hodnocení v <i class='fa fa-star' style='color: gold'></i></label> <br>
                                         <select name='star'>
                                            <option value=1".($star_review == 1 ? ' selected': '').">1</option>
                                            <option value=2".($star_review == 2 ? ' selected': '').">2</option>
                                            <option value=3".($star_review == 3 ? ' selected': '').">3</option>
                                            <option value=4".($star_review == 4 ? ' selected': '').">4</option>
                                            <option value=5".($star_review == 5 ? ' selected': '').">5</option>
                                         </select>
                                     </div>
                                     
                                     <div class='form-group'>
                                         <label for='caption' class='text-info'>Hodnocení titulku</label> <br>
                                         <textarea id='caption' name='caption' class='form-control' rows='4' cols='50'
                                                   style='resize: none;' required>";
                                if (isset($_POST['caption_review'])) echo $_POST['caption_review']."</textarea>";
                                else echo "</textarea>";
                                echo "</div>";

                                echo "<div class='form-group'>
                                         <label for='content' class='text-info'>Hodnocení obsahu</label> <br>
                                         <textarea id='content' name='content' class='form-control' rows='4' cols='50'
                                                   style='resize: none;' required>";
                                if (isset($_POST['content_review'])) echo $_POST['content_review']."</textarea>";
                                else echo "</textarea>";
                                echo "</div>";

                                echo "<div class='form-group'>
                                         <label for='stylistics' class='text-info'>Hodnocení stylistiky</label> <br>
                                         <textarea id='stylistics' name='stylistics' class='form-control' rows='4' cols='50'
                                                   style='resize: none;' required>";
                                if (isset($_POST['stylistics_review'])) echo $_POST['stylistics_review']."</textarea>";
                                else echo "</textarea>";
                                echo "</div>";
                                echo "<input type='hidden' name='id_review' value='$id_review'>";
                                echo "<button class='btn btn-info' type='submit' name='action' value='edit_review'>Upravit</button>";
                                echo "</form>";
                            }
                            ?>

                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$tpl->getHTMLFooter();