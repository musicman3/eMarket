<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Вставляем модальное окно "Добавить категорию" -->
<?php require_once('modal/add.php') ?>

<!-- Вставляем модальное окно "Добавить товар" -->
<?php require_once('modal/add_product.php') ?>

<!-- Модальное окно "Редактировать" -->
<?php require_once(ROOT . '/view/' . $SET->template() . '/admin/pages/stock/categories/modal/edit.php') ?>
<!-- КОНЕЦ Модальное окно "Редактировать" -->

<div id="ajax">

    <div id="category" class="container-fluid">
        <div class="row-fluid">
            <div class="panel panel-default">

                <div class="panel-heading">

                    <!--Выводим уведомление об успешном действии-->
                    <?php $MESSAGES->alert(); ?>

                    <h3 class="panel-title">
                        <div class="pull-left"><?php echo lang('title_categories_index') ?></div>
                        <div class="clearfix"></div>
                    </h3>
                </div>
                <?php if ($lines == TRUE) { ?>
                    <div class="panel-body">
                        <!--Скрытый div для передачи данных-->
                    <?php if (isset($name_edit)) { ?>
                        <div id="ajax_data" class='hidden'
                             data-name='<?php echo $name_edit ?>'
                             data-logo='<?php echo $logo_edit ?>'
                             data-general='<?php echo $logo_general ?>'
                             ></div>
                        
                    <?php } ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="3">
                                        <?php
                                        // Счетчик в навигации
                                        if ($finish == $count_lines && ($finish - $start) < $lines_on_page OR $finish == $lines_on_page) {
                                            $finish_out = $finish;
                                        } else {
                                            $finish_out = $finish - 1;
                                        }
                                        ?>


                                        <div class="page"><?php echo lang('s') ?> <?php echo $start + 1 ?> <?php echo lang('po') ?> <?php echo $finish_out ?> ( <?php echo lang('iz') ?> <?php echo $count_lines; ?> )</div>

                                        <!-- Переключаем страницу "ВПЕРЕД" -->
                                        <form>
                                            <?php if (count($lines) > $lines_on_page) { ?>
                                                <input hidden name="start" value="<?php echo $start ?>">
                                                <input hidden name="finish" value="<?php echo $finish ?>">
                                                <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
                                                <div class="right"><button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                            <?php } ?>
                                        </form>

                                        <!-- Переключаем страницу "НАЗАД" -->
                                        <form>
                                            <?php if (count($lines) > $lines_on_page) { ?>
                                                <input hidden name="start2" value="<?php echo $start ?>">
                                                <input hidden name="finish2" value="<?php echo $finish ?>">
                                                <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
                                                <div class="left"><button type="submit" class="btn btn-primary btn-xs"  action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                            <?php } ?>
                                        </form>

                                    </th>
                                </tr>
                            </thead>
                            <tbody id="sort-list">

                                <?php $parent_up = $lines[0][3]; ?>
                                <?php if ($parent_up > 0) { ?>

                                    <tr class="sortno">
                                        <td  class="sortleft-m"><div></div></td>
                                        <td colspan="2" align="left">

                                            <!-- Категории "ВВЕРХ" -->
                                            <form>
                                                <div>
                                                    <button name="parent_up" value="<?php echo $parent_up ?>" class="btn btn-default btn-xs" title="" action="index.php" formmethod="get"><span class="glyphicon glyphicon-option-horizontal"></span></button>
                                                </div>
                                            </form>

                                        </td>
                                    </tr>

                                    <?php
                                }
                                $transfer = 0;
                                for ($start; $start < $finish; $start++) {
                                    $transfer++;
                                    ?>

                                    <tr class="sort-list" unitid="<?php echo $lines[$start][0] ?>">

                                        <!-- Вырезанные категории "АКТИВНЫЕ" -->
                                        <?php if (isset($_SESSION['buffer']) == true && in_array($lines[$start][0], $_SESSION['buffer']) == true && $lines[$start][8] == 1) { ?>
                                            <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-primary btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-folder-open"> </span></a></div></td>

                                            <!-- Вырезанные категории "НЕ АКТИВНЫЕ" -->
                                        <?php } elseif (isset($_SESSION['buffer']) == true && in_array($lines[$start][0], $_SESSION['buffer']) == true && $lines[$start][8] == 0) { ?>
                                            <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-folder-open"> </span></a></div></td>

                                            <!-- Категория для трансфера -->
                                        <?php } elseif ($transfer == $lines_on_page + 1) { ?>
                                            <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-primary btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-transfer"> </span></a></div></td>

                                            <!-- Если категория НЕ АКТИВНА -->
                                        <?php } elseif ($lines[$start][8] == 0) { ?>
                                            <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft">

                                                <!-- Неактивная категория "ВНИЗ" -->
                                                <form>
                                                    <div>
                                                        <button name="parent_down" value="<?php echo $lines[$start][0] ?>" class="btn btn-default btn-xs" title="<?php echo $lines[$start][1] ?>" action="index.php" formmethod="get"><span class="glyphicon glyphicon-folder-open"> </span></button>
                                                    </div>
                                                </form>

                                            </td>

                                            <?php
                                        } else {
                                            ?>
                                            <!-- Если категория АКТИВНА -->
                                            <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft">

                                                <!-- Активная категория "ВНИЗ" -->
                                                <form>
                                                    <div>
                                                        <button name="parent_down" value="<?php echo $lines[$start][0] ?>" class="btn btn-primary btn-xs" title="<?php echo $lines[$start][1] ?>" action="index.php" formmethod="get"><span class="glyphicon glyphicon-folder-open"> </span></button>
                                                    </div>
                                                </form>

                                            </td>
                                            <?php
                                        }
                                        ?>

                                        <!-- ВЫБРАННЫЕ СТРОКИ -->
                                        <td class="option" id="<?php echo $lines[$start][0] ?>"><span class="inactive" style="display: none;"></span>
                                            <?php if ($transfer == $lines_on_page + 1) { ?>
                                                <div class="transfer" id="<?php echo $lines[$start][0] ?>"><?php echo lang('categories_transfer') ?></div>
                                            <?php } else { ?>
                                                <div class="context-one" id="<?php echo $lines[$start][0] ?>"><?php echo $lines[$start][1] ?></div>
                                            <?php } ?>


                                        </td>	 
                                    </tr>

                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>

                    <?php
                } elseif ($lines == FALSE && $parent_id > 0) {
                    ?>

                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="3">
                                        <div><?php echo lang('no_listing') ?></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="sortno">
                                    <td  class="sortleft-m"></td>
                                    <td class="sortleft">

                                        <!-- Категорий нет "ВВЕРХ" -->
                                        <form>
                                            <div>
                                                <button name="parent_up" value="<?php echo $parent_id ?>" class="btn btn-default btn-xs" title="" action="index.php" formmethod="get"><span class="glyphicon glyphicon-option-horizontal"></span></button>
                                            </div>
                                        </form>

                                    </td>
                                    <td class="options"><div class="context-one"><?php echo lang('no_listing') ?></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="3">
                                        <div><?php echo lang('no_listing') ?></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td  class="sortleft-m"></td>
                                    <td class="sortleft"></td>
                                    <td class="options"><div class="context-one"><?php echo lang('no_listing') ?></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>