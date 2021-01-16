<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$HeaderMenu = new eMarket\Admin\HeaderMenu();

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
                    for ($i = 0; $i < count(\eMarket\Admin\HeaderMenu::$level); $i++) {
                        \eMarket\Admin\HeaderMenu::setParameters('class="dropdown-toggle" data-toggle="dropdown"', '<b class="caret"></b>');
                        \eMarket\Admin\HeaderMenu::clearParameters(\eMarket\Admin\HeaderMenu::$level[$i][2]);
                        ?>

                        <li>
                            <a href="<?php echo \eMarket\Admin\HeaderMenu::$level[$i][0] ?>" <?php echo \eMarket\Admin\HeaderMenu::getParameters()[0] ?>><?php echo \eMarket\Admin\HeaderMenu::$level[$i][1] . \eMarket\Admin\HeaderMenu::getParameters()[1] ?></a>
                            <?php if (isset(\eMarket\Admin\HeaderMenu::$menu[$i])) { ?>
                                <!-- Level 2 -->
                                <ul class="dropdown-menu">
                                    <?php
                                    for ($x = 0; $x < count(\eMarket\Admin\HeaderMenu::$menu[$i]); $x++) {
                                        \eMarket\Admin\HeaderMenu::clearParameters(\eMarket\Admin\HeaderMenu::$menu[$i][$x][4]);
                                        ?>
                                        <li>
                                            <a <?php echo \eMarket\Admin\HeaderMenu::$menu[$i][$x][3]; ?> href="<?php echo \eMarket\Admin\HeaderMenu::$menu[$i][$x][0] ?>" <?php echo \eMarket\Admin\HeaderMenu::getParameters()[0] ?>><span class="<?php echo \eMarket\Admin\HeaderMenu::$menu[$i][$x][1]; ?>"></span> <?php echo \eMarket\Admin\HeaderMenu::$menu[$i][$x][2] . ' ' . \eMarket\Admin\HeaderMenu::getParameters()[1] ?></a>
                                            <?php if (isset(\eMarket\Admin\HeaderMenu::$submenu[$i][$x])) { ?>
                                                <!-- Level 3 -->
                                                <ul class="dropdown-menu link">
                                                    <?php
                                                    for ($y = 0; $y < count(\eMarket\Admin\HeaderMenu::$submenu[$i][$x]); $y++) {
                                                        ?>
                                                        <li>
                                                            <a <?php echo \eMarket\Admin\HeaderMenu::$submenu[$i][$x][$y][3]; ?> href="<?php echo \eMarket\Admin\HeaderMenu::$submenu[$i][$x][$y][0]; ?>"><span class="<?php echo \eMarket\Admin\HeaderMenu::$submenu[$i][$x][$y][1]; ?>"></span> <?php echo \eMarket\Admin\HeaderMenu::$submenu[$i][$x][$y][2]; ?> </a>
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