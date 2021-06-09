<?php
global $tplData;

$tplData['title'] = "BabettaForum";

require ("TemplateBasics.class.php");

$tpl = new TemplateBasics();
$tpl->getHTMLHeader($tplData['title']);
$tpl->getHTMLNavbar($tplData['title']);

if(isset($_SESSION['reg']) && $_SESSION['reg'] == 23000) {
    echo "<div class='alert alert-danger text-center' role='alert'>Uživatelské jméno nebo email již existuje.</div>";
    $_SESSION['reg'] = 0;
}
?>
<div class="mcontainer">
    <div id="registration">
        <div class="container">
            <div id="registration-row" class="row justify-content-center align-items-center">
                <div id="registration-column" class="col-md-6">
                    <div id="registration-box" class="col-md-12">
                        <form id="registration-form" class="form" method="post">
                            <h3 class="text-center text-info">Registrace</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Uživatelské jméno</label> <br>
                                <input type="text" minlength="6" maxlength="20" name="user_name"
                                       id="user_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="text-info">Emailová adresa</label> <br>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Heslo</label> <br>
                                <input type="password" minlength="6" maxlength="20" name="password"
                                       id="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password_repeat" class="text-info">Heslo znovu</label> <br>
                                <input type="password" minlength="6" maxlength="20" name="password_repeat"
                                       id="password_repeat" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="firstname" class="text-info">Jméno</label> <br>
                                <input type="text" name="first_name" id="first_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="text-info">Příjmení</label> <br>
                                <input type="text" name="last_name" id="last_name" class="form-control" required>
                            </div>
                            <div id="login-link" class="text-right">
                                <a href="index.php?page=login" class="text-info">
                                    Již máte účet? Přihlaste se kliknutím zde</a> <br> <br>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Zaregistrovat se">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$tpl->getHTMLFooter();
