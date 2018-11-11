<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
<!-- Модальное окно "Добавить" -->
<?php require_once('modal/add.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<!-- Дублируем модальные окна Редактирования -->
<?php $k = $start; // дублируем переменную   ?>

<?php for ($k; $k < $finish; $k++) { // запускаем цикл формирования модальных окон  ?>

    <!-- Вставляем модальное окно "Редактировать" -->
    <?php require(ROOT . '/view/' . $TEMPLATE . '/admin/pages/settings/zones/modal/edit.php') ?>

<?php }

?>

<div id="ajax">
    <div id="settings" class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left"><a class="btn btn-primary btn-xs" href="<?php echo $_SESSION['zone_page'] ?>"><span class="back glyphicon glyphicon-share-alt"></span></a> <?php echo lang('title_regions') ?></div>
                        <div class="clearfix"></div>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <?php if ($lines == TRUE) { ?>
                                        <div class="page"><?php echo lang('s') ?> <?php echo $start + 1 ?> <?php echo lang('po') ?> <?php echo $finish ?> ( <?php echo lang('iz') ?> <?php echo count($lines); ?> )</div>
                                        <?php
                                    } else {

                                        ?>
                                        <div><?php echo lang('no_zones') ?></div>
                                    <?php } ?>
                                </th>

                                <th>
                                    <form>
                                        <?php if (count($lines) > 0) { ?>
                                            <input hidden name="start" value="<?php echo $start ?>">
                                            <input hidden name="finish" value="<?php echo $finish ?>">
                                            <input hidden name="zone_id" value="<?php echo $zones_id ?>">
                                            <div class="right"><button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                        <?php } ?>
                                    </form>

                                    <form>
                                        <?php if (count($lines) > 0) { ?>
                                            <input hidden name="start2" value="<?php echo $start ?>">
                                            <input hidden name="finish2" value="<?php echo $finish ?>">
                                            <input hidden name="zone_id" value="<?php echo $zones_id ?>">
                                            <div class="left"><button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                        <?php } ?>
                                    </form>

                                    <div class="left">
                                        <a href="#add" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a>
                                    </div>
                                </th>
                            </tr>
                            <?php if ($lines == TRUE) { ?>
                                <tr class="border">
                                    <th> </th>
                                    <th><?php echo lang('zone') ?></th>
                                    <th> </th>
                                </tr>
                            <?php } ?>
                        </thead>
                        <tbody>
                            <?php for ($start; $start < $finish; $start++) { ?>

                                <!--Формирование списка для всплывающих подсказок-->
                                <?php
                                $text = '';
                                $y = 0;
                                for ($x = 0; $x < count($FUNC->filter_array_to_key($name_regions, 0, $lines[$start][0], 1)); $x++) {
                                    if (isset($regions[$x][0]) == TRUE && isset($lines[$start][0]) == TRUE && $regions[$x][0] == $lines[$start][0]) { // если регион есть
                                        $text .= $FUNC->filter_array_to_key($name_regions, 0, $regions[$x][0], 1)[$y] . ', '; // то, добавляем название региона
                                        $y++;
                                    }
                                }

                                ?>
                                <!--КОНЕЦ Формирование списка для всплывающих подсказок-->

                                <tr>
                                    <td class="sortleft"><a class="btn btn-primary btn-xs" href="#" ><span data-toggle="tooltip" data-html="true" data-placement="right" data-original-title="<?php echo $text ?>" class="glyphicon glyphicon-eye-open"></span></a></td>
                                    <td><?php echo $FUNC->filter_array_to_key($name_country, 0, $lines[$start][0], 1)[0] ?></td>
                                    <td> </td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
