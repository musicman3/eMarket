<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Admin\HeaderMenu;
use eMarket\Core\{
    Settings,
};

if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
    ?>

    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <span class="navbar-brand"><?php echo Settings::titlePageGenerator() ?></span>
            <div class="text-center">
                <span id="update_box" class="text-secondary bi-broadcast" data-bs-toggle="tooltip" data-bs-placement="left"></span>
            </div>
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel"><?php echo lang('menu_name') ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- Level 1 -->
                    <ul class="navbar-nav">
                        <?php
                        foreach (HeaderMenu::$level as $level_key => $level) {
                            HeaderMenu::setParameters(' dropdown-toggle', 'data-bs-toggle="dropdown"');
                            HeaderMenu::clearParameters($level[2]);
                            ?>

                            <li class="nav-item dropdown">
                                <a href="<?php echo $level[0] ?>" class="nav-link<?php echo HeaderMenu::getParameters()[0] ?>" <?php echo HeaderMenu::getParameters()[1] ?>><span class="<?php echo $level[3]; ?>"></span> <?php echo $level[1] ?></a>
                                <?php if (isset(HeaderMenu::$menu[$level_key])) { ?>
                                    <!-- Level 2 -->
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <?php
                                        foreach (HeaderMenu::$menu[$level_key] as $level_value) {
                                            ?>
                                            <li>
                                                <a class="dropdown-item" <?php echo $level_value[3]; ?> href="<?php echo $level_value[0] ?>"><span class="<?php echo $level_value[1]; ?>"></span> <?php echo $level_value[2] ?></a>
                                            </li><?php } ?>
                                    </ul><?php } ?>
                            </li><?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <?php
}