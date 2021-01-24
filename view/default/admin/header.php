<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Admin\HeaderMenu;

if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
    ?>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="collapse" id="navbarToggleExternalContent">
                <div class="bg-dark p-4">
                    <h5 class="text-white h4">Collapsed content</h5>
                    <span class="text-muted">Toggleable via the navbar brand.</span>
                </div>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <!-- Level 1 -->
                <ul class="navbar-nav">
                    <?php
                    for ($i = 0; $i < count(HeaderMenu::$level); $i++) {
                        HeaderMenu::setParameters(' dropdown-toggle"', ' role="button" data-bs-toggle="dropdown"');
                        HeaderMenu::clearParameters(HeaderMenu::$level[$i][2]);
                        ?>

                        <li class="nav-item dropdown">
                            <a href="<?php echo HeaderMenu::$level[$i][0] ?>" class="nav-link<?php echo HeaderMenu::getParameters()[0] ?>" <?php echo HeaderMenu::getParameters()[1] ?>><?php echo HeaderMenu::$level[$i][1] ?></a>
                            <?php if (isset(HeaderMenu::$menu[$i])) { ?>
                                <!-- Level 2 -->
                                <ul class="dropdown-menu">
                                    <?php
                                    for ($x = 0; $x < count(HeaderMenu::$menu[$i]); $x++) {
                                        HeaderMenu::clearParameters(HeaderMenu::$menu[$i][$x][4]);
                                        ?>
                                        <li>
                                            <a class="dropdown-item" <?php echo HeaderMenu::$menu[$i][$x][3]; ?> href="<?php echo HeaderMenu::$menu[$i][$x][0] ?>"><span class="<?php echo \eMarket\Admin\HeaderMenu::$menu[$i][$x][1]; ?>"></span> <?php echo \eMarket\Admin\HeaderMenu::$menu[$i][$x][2] ?></a>

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