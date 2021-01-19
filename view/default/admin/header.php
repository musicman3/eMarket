<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Admin\HeaderMenu;

if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
    ?>

    <nav class="navbar navbar-fixed-top navbar-inverse">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-navbar">
                <!-- Level 1 -->
                <ul class="nav navbar-nav">
                    <?php
                    for ($i = 0; $i < count(HeaderMenu::$level); $i++) {
                        HeaderMenu::setParameters('class="dropdown-toggle" data-toggle="dropdown"', '<b class="caret"></b>');
                        HeaderMenu::clearParameters(HeaderMenu::$level[$i][2]);
                        ?>

                        <li>
                            <a href="<?php echo HeaderMenu::$level[$i][0] ?>" <?php echo HeaderMenu::getParameters()[0] ?>><?php echo HeaderMenu::$level[$i][1] . HeaderMenu::getParameters()[1] ?></a>
                            <?php if (isset(HeaderMenu::$menu[$i])) { ?>
                                <!-- Level 2 -->
                                <ul class="dropdown-menu">
                                    <?php
                                    for ($x = 0; $x < count(HeaderMenu::$menu[$i]); $x++) {
                                        HeaderMenu::clearParameters(HeaderMenu::$menu[$i][$x][4]);
                                        ?>
                                        <li>
                                            <a <?php echo HeaderMenu::$menu[$i][$x][3]; ?> href="<?php echo HeaderMenu::$menu[$i][$x][0] ?>" <?php echo HeaderMenu::getParameters()[0] ?>><span class="<?php echo HeaderMenu::$menu[$i][$x][1]; ?>"></span> <?php echo HeaderMenu::$menu[$i][$x][2] . ' ' . HeaderMenu::getParameters()[1] ?></a>
                                            <?php if (isset(HeaderMenu::$submenu[$i][$x])) { ?>
                                                <!-- Level 3 -->
                                                <ul class="dropdown-menu link">
                                                    <?php
                                                    for ($y = 0; $y < count(HeaderMenu::$submenu[$i][$x]); $y++) {
                                                        ?>
                                                        <li>
                                                            <a <?php echo HeaderMenu::$submenu[$i][$x][$y][3]; ?> href="<?php echo HeaderMenu::$submenu[$i][$x][$y][0]; ?>"><span class="<?php echo HeaderMenu::$submenu[$i][$x][$y][1]; ?>"></span> <?php echo HeaderMenu::$submenu[$i][$x][$y][2]; ?> </a>
                                                        </li><?php } ?>
                                                </ul><?php } ?>
                                        </li><?php } ?>
                                </ul><?php } ?>
                        </li><?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php
}