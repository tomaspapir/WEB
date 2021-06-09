<?php

//nacteni nastaveni webu
require_once ("settings.inc.php");
//nacteni tridy spoustejici aplikaci
require_once ("app/LaunchApplication.class.php");

/** spousteni aplikace */
$app = new LaunchApplication();
$app -> launchApp();

?>

