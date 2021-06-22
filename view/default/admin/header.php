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

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse navbar-nav-scroll" id="navbarNavDropdown">
                <!-- Level 1 -->
                <ul class="navbar-nav">
                    <?php
                    for ($i = 0; $i < count(HeaderMenu::$level); $i++) {
                        HeaderMenu::setParameters(' dropdown-toggle','data-bs-toggle="dropdown"');
                        HeaderMenu::clearParameters(HeaderMenu::$level[$i][2]);
                        ?>

                        <li class="nav-item dropdown">
                            <a href="<?php echo HeaderMenu::$level[$i][0] ?>" class="nav-link<?php echo HeaderMenu::getParameters()[0] ?>" <?php echo HeaderMenu::getParameters()[1] ?>><span class="<?php echo HeaderMenu::$level[$i][3]; ?>"></span> <?php echo HeaderMenu::$level[$i][1] ?></a>
                            <?php if (isset(HeaderMenu::$menu[$i])) { ?>
                                <!-- Level 2 -->
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <?php
                                    for ($x = 0; $x < count(HeaderMenu::$menu[$i]); $x++) {
                                        ?>
                                        <li>
                                            <a class="dropdown-item" <?php echo HeaderMenu::$menu[$i][$x][3]; ?> href="<?php echo HeaderMenu::$menu[$i][$x][0] ?>"><span class="<?php echo HeaderMenu::$menu[$i][$x][1]; ?>"></span> <?php echo HeaderMenu::$menu[$i][$x][2] ?></a>
                                        </li><?php } ?>
                                </ul><?php } ?>
                        </li><?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php
}