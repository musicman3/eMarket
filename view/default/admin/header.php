<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (isset($_SESSION['login']) && isset($_SESSION['pass'])) { // Выводим если авторизованы 

    ?>

    <nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- 1 УРОВЕНЬ МЕНЮ -->
                <ul class="nav navbar-nav">
                    <?php
                    $level_count = count($level);
                    for ($i = 0; $i < $level_count; $i++) {

                        ?>
                        <li>
                            <?php if ($i != $level_count - 1) { ?>
                                <!-- если есть вкладки на следующий уровень -->
                                <a href="<?php echo $level[$i][0]; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $level[$i][1]; ?><b class="caret"></b></a>
                            <?php } else { ?>
                                <!-- без вкладок на уровень -->
                                <a href="<?php echo $level[$i][0]; ?>"><?php echo $level[$i][1]; ?></a>
                            <?php } ?>

                            <!-- 2 УРОВЕНЬ МЕНЮ -->
                            <ul class="dropdown-menu">
                                <?php
                                if (!isset($menu[$i])) {
                                    $menu[$i] = array();
                                }
                                $menu_count = count($menu[$i]);
                                for ($x = 0; $x < $menu_count; $x++) {

                                    ?>
                                    <li>
                                        <?php if ($i == $level_count - 2 && $x < 2) { ?>
                                            <!-- если есть вкладки на следующий уровень -->
                                            <a href="<?php echo $menu[$i][$x][0]; ?>" class="dropdown-toggle" data-toggle="dropdown"><img src="/view/<?php echo $SET->template() ?>/admin/images/icons/16x16/<?php echo $menu[$i][$x][1]; ?>" /> <?php echo $menu[$i][$x][2]; ?> <b class="caret"></b></a>

                                        <?php } else { ?>
                                            <!-- без вкладок на уровень -->
                                            <a <?php echo $menu[$i][$x][3]; ?> href="<?php echo $menu[$i][$x][0]; ?>"><img src="/view/<?php echo $SET->template() ?>/admin/images/icons/16x16/<?php echo $menu[$i][$x][1]; ?>" /> <?php echo $menu[$i][$x][2]; ?> </a>
                                        <?php } ?>

                                        <!-- 3 УРОВЕНЬ МЕНЮ -->
                                        <ul class="dropdown-menu link">
                                            <?php
                                            if (!isset($submenu[$i][$x])) {
                                                $submenu[$i][$x] = array();
                                            }
                                            $submenu_count = count($submenu[$i][$x]);
                                            for ($y = 0; $y < $submenu_count; $y++) {

                                                ?>
                                                <li>
                                                    <a href="<?php echo $submenu[$i][$x][$y][0]; ?>"><img src="/view/<?php echo $SET->template() ?><?php echo $submenu[$i][$x][$y][1]; ?>" /> <?php echo $submenu[$i][$x][$y][2]; ?> </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>

                    <?php } ?>

                </ul>
            </div>
        </div>
    </nav>

<?php } ?>