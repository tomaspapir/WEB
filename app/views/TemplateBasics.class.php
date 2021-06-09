<?php

/**
 * Class TemplateBasics trida vypisujici hlavicku, paticku a navigacni listu webu.
 */

class TemplateBasics {

    /** Vrati hlavicku
     * @param string $pagetitle Nazev stranky
     */
    public function getHTMLHeader(string $pagetitle) {
        ?>

        <!doctype html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">

                <title><?php echo $pagetitle; ?></title>

                <link rel="stylesheet" href="../V2/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
                <link rel="stylesheet" href="../V2/vendor/components/font-awesome/css/font-awesome.min.css">
                <link rel="stylesheet" href="../V2/css/root.css">
                <script src="../V2/vendor/components/jquery/jquery.min.js"></script>
                <script src="../V2/vendor/alexandermatveev/popper-bundle/AlexanderMatveev/PopperBundle/Resources/public/popper.min.js"></script>
                <script src="../V2/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
                <script type="text/javascript" src="../V2/scripts/scripts.js"></script>
            </head>
        <?php
    }

    /** Vrati navigacni listu
     * @param string $pagetitle
     */
    public function getHTMLNavbar(string $pagetitle) {
        ?>

        <nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
            <div class="container">
                <!-- Brand -->
                <a class="navbar-brand" href="index.php">
                    <i class="fa fa-motorcycle"></i>
                    <?php echo $pagetitle; ?>
                </a>

                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class='nav-item'>
                            <a class='nav-link' href='index.php'>Všechny články</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='index.php?page=o_nas'>O nás</a>
                        </li>
                    <?php
                    if (isset($_SESSION['role_id'])) {
                        switch ($_SESSION['role_id']) {
                            case 1:
                                echo"
                                       <li class='nav-item'>
                                         <a class='nav-link' href='index.php?page=sprava_clanku'>Správa článků</a>
                                       </li>";
                                break;
                            case 2:
                                echo"
                                       <li class='nav-item'>
                                         <a class='nav-link' href='index.php?page=recenze'>Moje recenze</a>
                                       </li>";
                                break;
                        }
                    } ?>


                        <li class="login-btn">
                                <?php
                                  $res = '<a href="index.php?page=';
                                    if (!empty($_SESSION['valid']) && $_SESSION['valid'] == true) $res .= 'sprava"';
                                    else $res .= 'login"';
                                    $res .= ' class="btn btn-primary">';
                                    echo $res
                                ?>
                                    <span class="fa fa-user"></span>
                                </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="spacer">
            &nbsp;
        </div>
        <?php
    }

    /** Vrati paticku */
    public function getHTMLFooter() {
        ?>
        <!-- Paticka -->
        <footer class="bg-dark text-white font-weight-bold">
                    <div class="col-md-12 py-3 bg-dark">
                        <div class="text-center bg-dark">
                            <i class="white-text font-weight-lighter">Contact us: </i>
                        </div>
                    </div>

                <ul class="list-inline text-center list-unstyled bg-dark">
                    <li class="list-inline-item">
                        <a class="fb-ic" href="https://www.facebook.com/" target="_blank">
                            <i class="fa fa-facebook white-text mr-md-5 mr-3 fa-2x"> </i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="tw-ic" href="https://www.youtube.com/" target="_blank">
                            <i class="fa fa-youtube white-text mr-md-5 mr-3 fa-2x"> </i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="ig-ic" href="https://www.instagram.com/" target="_blank">
                            <i class="fa fa-instagram white-text mr-md-5 mr-3 fa-2x"> </i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="contact-ic" href="mailto:babettaforum@gmail.com" target="_blank">
                            <i class="fa fa-envelope-square white-text mr-md-5 mr-3 fa-2x"></i>
                        </a>
                    </li>
                </ul>

            <div class="text-center py-3 font-weight-normal bg-dark">
                © 2020 Copyright: Tomáš Papírník
            </div>

        </footer>
        </html>
        <?php
    }

    /** Vrati paticku */
    public function getHTMLFooterEmpty() {
        ?>
        <!-- Paticka -->
        <footer class="footer bg-dark text-white font-weight-bold">
            <div class="col-md-12 py-3 bg-dark">
                <div class="text-center bg-dark">
                    <i class="white-text font-weight-lighter">Contact us: </i>
                </div>
            </div>

            <ul class="list-inline text-center list-unstyled bg-dark">
                <li class="list-inline-item">
                    <a class="fb-ic" href="https://www.facebook.com/" target="_blank">
                        <i class="fa fa-facebook white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="tw-ic" href="https://www.youtube.com/" target="_blank">
                        <i class="fa fa-youtube white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="ig-ic" href="https://www.instagram.com/" target="_blank">
                        <i class="fa fa-instagram white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="contact-ic" href="mailto:babettaforum@gmail.com" target="_blank">
                        <i class="fa fa-envelope-square white-text mr-md-5 mr-3 fa-2x"></i>
                    </a>
                </li>
            </ul>

            <div class="text-center py-3 font-weight-normal bg-dark">
                © 2020 Copyright: Tomáš Papírník
            </div>

        </footer>
        </html>
        <?php
    }

    /** Funkce slouzici k vypisu prvni casti tabulky ve sprave clanku
     * @param $article array clanku
     * @return string vrati vypis tabulky
     */
    public function getArticleTableFirstPart(array $article):string {
        if (empty($article['reviews'][0]['reviewer'])) {
            $res = "
                    <td>Nezvolen</td>
                    <td>Nehodnoceno</td>
                    ";
        }
        elseif (empty($article['reviews'][0]['star_review'])) {
            $res = "
                    <td>".$article['reviews'][0]['reviewer']."</td>
                    <td>Nehodnoceno</td>
                    ";
        }
        else {
            $res = "
                    <td>".$article['reviews'][0]['reviewer']."</td>
                    <td>"; for($i = 0; $i < $article['reviews'][0]['star_review']; $i++) {
                                 $res .= "<i class='fa fa-star' style='color: gold'></i>";
                           }
            $res .="</td>";
        }

        return $res;
    }

    /** Funkce slouzici k vypisu druhe casti tabulky ve sprave clanku
     * @param $article array clanku
     * @return string vrati vypis tabulky
     */
    public function getArticleTableSecondPart(array $article):string {
        $res = '';
        for ($i = 1; $i < 3; $i++) {
            if (empty($article['reviews'][$i]['reviewer'])) {
                $res .= "<tr>
                         <td>Nezvolen</td>
                         <td>Nehodnoceno</td>
                         </tr>";
            } elseif (empty($article['reviews'][$i]['star_review'])) {
                $res .= "<tr>
                         <td>".$article['reviews'][$i]['reviewer']."</td>
                         <td>Nehodnoceno</td>
                         </tr>";
            } else {
                $res .= "<tr>
                         <td>".$article['reviews'][$i]['reviewer']."</td>
                         <td>"; for($j = 0; $j < $article['reviews'][$i]['star_review']; $j++) {
                                    $res .= "<i class='fa fa-star' style='color: gold'></i>";
                                }
                $res .="</td></tr>";
            }
        }

        return $res;
    }
}

?>