<?php
//session_start();
global $tplData;
$tplData['title'] = "BabettaForum";

require ("TemplateBasics.class.php");

$tpl = new TemplateBasics();
$tpl->getHTMLHeader($tplData['title']);
$tpl->getHTMLNavbar($tplData['title']);

if(isset($_SESSION['reg']) && $_SESSION['reg'] == 1) {
    echo "<div class='alert alert-success text-center' role='alert'>Registrace proběhla úspěšně! Prosím přihlaste se</div>";
    $_SESSION['reg'] = 0;
}
?>

<div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                   <div id="login-box" class="col-md-12">
                      <form id="login-form" class="form" method="post">
                          <h3 class="text-center text-info">Přihlášení</h3>
                          <div class="form-group">
                              <label for="username" class="text-info">Uživatelské jméno</label> <br>
                              <input type="text" name="user_name" id="user_name" class="form-control" required>
                          </div>
                           <div class="form-group">
                               <label for="password" class="text-info">Heslo:</label> <br>
                               <input type="password" name="password" id="password" class="form-control" required>
                           </div>
                          <div id="register-link" class="text-right">
                              <a href="index.php?page=registrace" class="text-info">
                                Ještě nemáte účet? Zaregistrujte se kliknutím zde</a> <br> <br>
                          </div>
                           <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Přihlásit se">
                          </div>
                          <br>

                    </form>
                 </div>
                </div>
            </div>
        </div>
    </div> <br>

<?php
$tpl->getHTMLFooterEmpty();