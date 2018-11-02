<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
<!-- Вставляем модальное окно "Добавить категорию" -->
<?php require_once('modal/categories_add.php') ?>

<!-- Дублируем модальные окна Редактирования категорий -->
<?php $k = $start; // дублируем переменную ?>

<?php for ($k; $k < $finish; $k++) { // запускаем цикл формирования модальных окон Редактирования категорий ?>

    <!-- Вставляем модальное окно "Редактировать категорию" -->
    <?php require('modal/categories_edit.php') ?>

<?php } ?>

<div id="ajax">

    <div id="category" class="container">
        <div class="row">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left"><?php echo lang('title_categories') ?></div>

                        <!-- Количество строк на странице -->
                        <form action="/controller/admin/pages/stock/categories/categories.php" method="get" class="form-inline">
                            <div class="add-xs"><?php echo lang('rows_page') ?>: <select name="select_row" class="input-xs form-control" onchange="this.form.submit()">
                                    <option>(<?php echo $lines_of_page ?>)</option>
                                    <option>20</option>
                                    <option>35</option>
                                    <option>50</option>
                                    <option>75</option>
                                    <option>100</option>
                                </select>
                            </div>
                        </form>

                        <div class="clearfix"></div>
                    </h3>
                </div>
                <?php if ($lines == TRUE) { ?>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="3">
                                        <div class="page"><?php echo lang('s') ?> <?php echo $start + 1 ?> <?php echo lang('po') ?> <?php echo $finish ?> ( <?php echo lang('iz') ?> <?php echo $count_lines; ?> )</div>

                                        <!-- Переключаем страницу "ВПЕРЕД" -->
                                        <form>
                                            <input hidden name="start" value="<?php echo $start ?>">
                                            <input hidden name="finish" value="<?php echo $finish ?>">
                                            <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
                                            <div class="right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                        </form>

                                        <!-- Переключаем страницу "НАЗАД" -->
                                        <form>
                                            <input hidden name="start2" value="<?php echo $start ?>">
                                            <input hidden name="finish2" value="<?php echo $finish ?>">
                                            <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
                                            <div class="left"><button type="submit" class="btn btn-primary btn-xs"  action="/controller/admin/pages/stock/categories/categories.php" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                        </form>

                                    </th>
                                </tr>
                            </thead>
                            <tbody id="sort-list">

                                <?php $parent_up = $lines[0][3]; ?>
                                <?php if ($parent_up > 0) { ?>

                                    <tr class="sortno">
                                        <td  class="sortleft-m" align="left"><div></div></td>
                                        <td colspan="2" align="left">

                                            <!-- Категории "ВВЕРХ" -->
                                            <form>
                                                <div>
                                                    <button name="parent_up" value="<?php echo $parent_up ?>" class="btn btn-default btn-xs" title="" action="/controller/admin/pages/stock/categories/categories.php" formmethod="get"><span class="glyphicon glyphicon-option-horizontal"></span></button>
                                                </div>
                                            </form>

                                        </td>
                                    </tr>

                                <?php } for ($start; $start < $finish; $start++) { ?>

                                    <tr class="sort-list" unitid="<?php echo $lines[$start][0] ?>">

                                        <!-- Вырезанные категории "АКТИВНЫЕ" -->
                                        <?php if (isset($_SESSION['buffer']) == true && in_array($lines[$start][0], $_SESSION['buffer']) == true && $lines[$start][8] == 1) { ?>
                                            <td class="sortyes sortleft-m" align="left"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft" align="left"><div><a href="#" class="btn btn-primary btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-folder-open"> </span></a></div></td>

                                            <!-- Вырезанные категории "НЕ АКТИВНЫЕ" -->
                                        <?php } elseif (isset($_SESSION['buffer']) == true && in_array($lines[$start][0], $_SESSION['buffer']) == true && $lines[$start][8] == 0) { ?>
                                            <td class="sortyes sortleft-m" align="left"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft" align="left"><div><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-folder-open"> </span></a></div></td>

                                            <!-- Если категория НЕ АКТИВНА -->
                                        <?php } elseif ($lines[$start][8] == 0) { ?>
                                            <td class="sortyes sortleft-m" align="left"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft" align="left">

                                                <!-- Неактивная категория "ВНИЗ" -->
                                                <form>
                                                    <div>
                                                        <button name="parent_down" value="<?php echo $lines[$start][0] ?>" class="btn btn-default btn-xs" title="<?php echo $lines[$start][1] ?>" action="/controller/admin/pages/stock/categories/categories.php" formmethod="get"><span class="glyphicon glyphicon-folder-open"> </span></button>
                                                    </div>
                                                </form>

                                            </td>

                                            <?php
                                        } else {

                                            ?>
                                            <!-- Если категория АКТИВНА -->
                                            <td class="sortyes sortleft-m" align="left"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft" align="left">

                                                <!-- Активная категория "ВНИЗ" -->
                                                <form>
                                                    <div>
                                                        <button name="parent_down" value="<?php echo $lines[$start][0] ?>" class="btn btn-primary btn-xs" title="<?php echo $lines[$start][1] ?>" action="/controller/admin/pages/stock/categories/categories.php" formmethod="get"><span class="glyphicon glyphicon-folder-open"> </span></button>
                                                    </div>
                                                </form>

                                            </td>
                                            <?php
                                        }

                                        ?>

                                        <!-- ВЫБРАННЫЕ СТРОКИ -->
                                        <td align="left" class="option" id="<?php echo $lines[$start][0] ?>"><span class="inactive" style="display: none;"></span>
                                            <div class="context-one" id="<?php echo $lines[$start][0] ?>"><?php echo $lines[$start][1] ?>
                                            </div>

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
                                        <div><?php echo lang('no_cat') ?></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="sortno">
                                    <td  class="sortleft-m" align="left"></td>
                                    <td class="sortleft" align="left">

                                        <!-- Категорий нет "ВВЕРХ" -->
                                        <form>
                                            <div>
                                                <button name="parent_up" value="<?php echo $parent_id ?>" class="btn btn-default btn-xs" title="" action="/controller/admin/pages/stock/categories/categories.php" formmethod="get"><span class="glyphicon glyphicon-option-horizontal"></span></button>
                                            </div>
                                        </form>

                                    </td>
                                    <td class="options" align="left"><div class="context-one"><?php echo lang('no_cat') ?></div></td>
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
                                        <div><?php echo lang('no_cat') ?></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td  class="sortleft-m" align="left"></td>
                                    <td class="sortleft" align="left"></td>
                                    <td class="options" align="left"><div class="context-one"><?php echo lang('no_cat') ?></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>