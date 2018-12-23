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
                        // Параметры для меню с подуровнями
                        $param_1 = 'class="dropdown-toggle" data-toggle="dropdown"';
                        $param_2 = '<b class="caret"></b>';
                        // если нет подуровней, то на следующий уровень
                        if ($level[$i][2] == 'false') {
                            $param_1 = '';
                            $param_2 = '';
                        }

                        ?>
                        <li>
                            <!-- выводим данные -->
                            <a href="<?php echo $level[$i][0] ?>" <?php echo $param_1 ?>><?php echo $level[$i][1] . $param_2 ?></a>

                            <!-- 2 УРОВЕНЬ МЕНЮ -->
                            <ul class="dropdown-menu">
                                <?php
                                if (isset($menu[$i])) {
                                    for ($x = 0; $x < count($menu[$i]); $x++) {
                                        // если нет подуровней, то на следующий уровень
                                        if ($menu[$i][$x][4] == 'false') {
                                            $param_1 = '';
                                            $param_2 = '';
                                        }

                                        ?>
                                        <li>
                                            <!-- выводим данные -->
                                            <a <?php echo $menu[$i][$x][3]; ?> href="<?php echo $menu[$i][$x][0] ?>" <?php echo $param_1 ?>><img src="/view/<?php echo $SET->template() ?>/admin/images/icons/16x16/<?php echo $menu[$i][$x][1]; ?>" /> <?php echo $menu[$i][$x][2] . ' ' . $param_2 ?></a>

                                            <!-- 3 УРОВЕНЬ МЕНЮ -->
                                            <ul class="dropdown-menu link">
                                                <?php
                                                if (isset($submenu[$i][$x])) {
                                                    for ($y = 0; $y < count($submenu[$i][$x]); $y++) {

                                                        ?>
                                                        <li>
                                                            <!-- выводим данные -->
                                                            <a href="<?php echo $submenu[$i][$x][$y][0]; ?>"><img src="/view/<?php echo $SET->template() ?><?php echo $submenu[$i][$x][$y][1]; ?>" /> <?php echo $submenu[$i][$x][$y][2]; ?> </a>
                                                        </li>
                                                        <?php
                                                    }
                                                }

                                                ?>
                                            </ul>
                                        </li>
                                        <?php
                                    }
                                }

                                ?>
                            </ul>
                        </li>

                    <?php } ?>

                </ul>
            </div>
        </div>
    </nav>

<?php } ?>