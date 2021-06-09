<?php

global $tplData;

$tplData['title'] = "BabettaForum";

require ("TemplateBasics.class.php");

$tpl = new TemplateBasics();

$tpl->getHTMLHeader($tplData['title']);
$tpl->getHTMLNavbar($tplData['title']);
?>

<!DOCTYPE html>
<html>
<body>
<div class='container'>
        <div class='col-md-12'>
            <div id="about" style="text-align: center">
                <button type="button" class="btn-outline-dark btn" onclick="loadDoc()">Klikni mě</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
$tpl->getHTMLFooterEmpty();