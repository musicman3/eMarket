<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Admin\HeaderMenu;
use eMarket\Core\Update;

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
            <div class="text-center">
                <?php if (Update::checkVersion()['status'] != 'ok' OR Update::checkVersion()['this_version'] == Update::checkVersion()['new_version']) { ?>
                    <span class="text-success bi-broadcast" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo Update::checkVersion()['this_version'] ?>"></span>
                <?php } else { ?>
                    <span class="text-danger bi-broadcast" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo Update::checkVersion()['new_version'] . ' (' . Update::checkVersion()['this_version'] . ')' ?>"></span>
                <?php } ?>
            </div>
        </div>

    </nav>

    <?php
}