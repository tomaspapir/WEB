<?php

global $tplData;

$tplData['title'] = "BabettaForum";

require ("TemplateBasics.class.php");

$tpl = new TemplateBasics();

$tpl->getHTMLHeader($tplData['title']);
$tpl->getHTMLNavbar($tplData['title']);

$res = "";
?>

<div id="registration">
        <div class="container">
            <div id="registration-row" class="row justify-content-center align-items-center">
                <div id="registration-column" class="col-md-10">
                   <div id="registration-box" class="col-md-12">
                       <br>
                       <form id="article-form" class="form" method="post" enctype="multipart/form-data">
                       <div class="form-group">
                           <?php
                           if(isset($_POST['action']) and $_POST['action'] == "edit"
                               and isset($_POST['article_id']) and isset($_POST['article_title']) and isset($_POST['article_content'])){
                               $id = $_POST['article_id'];
                               $title = $_POST['article_title'];
                               $content = $_POST['article_content'];
                               echo "
                                         <label for='title' class='text-info'>Titulek</label> <br>
                                         <input type='text' name='title' id='title' class='form-control' value='$title' required>
                                     </div>
                                     <div class='form-group'>
                                         <label for='content' class='text-info'>Obsah</label> <br>
                                         <textarea id='content' name='content' class='form-control' rows='4' cols='50'
                                                   style='resize: none;' class='form-control' required>$content</textarea>                                       
                                     </div>
                                     <div class='form-group'>
                                         <label for='content' class='text-info'>Obsah v PDF</label> <br>
                                         <input type='file' name='fileToUpload' id='fileToUpload' class='form-control' required>
                                     </div>
                                     <div class='form-group'>
                                         <button class='btn btn-info' type='submit'
                                                 name='action' value='edit'>Upravit a odeslat ke schválení</button>                                                            
                                         <input type='hidden' name='article_id' value='$id'
                                     </div>
                                    ";
                           }
                           else {
                               echo "<label for='title' class='text-info'>Titulek</label> <br>
                                         <input type='text' name='title' id='title' class='form-control' required>
                                     </div>
                                     <div class='form-group'>
                                         <label for='content' class='text-info'>Obsah</label> <br>
                                         <textarea id='content' name='content' class='form-control' rows='4' cols='50'
                                                   style='resize: none;' required></textarea>
                                     </div>
                                     <div class='form-group'>
                                         <label for='content' class='text-info'>Obsah v PDF</label> <br>
                                         <input type='file' name='fileToUpload' id='fileToUpload' required>
                                     </div>
                                     <div class='form-group'>
                                          <button class='btn btn-info' type='submit'
                                                 name='action' value='insert'>Odeslat ke schválení</button>  
                                     </div>
                                    </div>";
                           }
                           ?>

</div>
</div>


</div>
</div>
</div>

<script>
    document.getElementById('content').style.height="400px";
</script>

<?php
$tpl->getHTMLFooter();