<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
<!-- Модальное окно "Добавить категорию" -->
<?php require_once('modal/categories_add.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить категорию" -->

<?php $abc = 1; if ($abc == 0) { ?>
<div id="ajax">
    <div id="category" class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left">Товары</div>
                        <form action="/controller/admin/pages/stock/categories/categories.php" method="post" class="form-inline">
                            <div class="add-xs">Строк на странице: <select name="select_row" class="input-xs form-control" onchange="this.form.submit()">
                                    <option>(<?php echo $lines_page ?>)</option>
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
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        <div class="log-page"><?php echo $lang['s'] ?> <?php echo $i + 1 ?> <?php echo $lang['po'] ?> <?php echo $lines_p ?> ( <?php echo $lang['iz'] ?> <?php echo $counter; ?> )</div>
                                            <div class="log-right"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                            <div class="log-left"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="sort-list">
                                    <tr class="sortno">
                                        <td class="sortleft-m" align="left"></td>
                                        <td colspan="5" align="left"><div><button class="btn btn-default btn-xs">....</button></div></td>
                                    </tr>
                                    <tr class="sort-list">
                                        <td class="sortyes sortleft-m" align="left"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                        <td class="sortleft" align="left"><div><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-folder-open"> </span></button></div></td>
                                        <td class="left" align="left">Название товара пишем вот таким длинным для проверки длинны названия и колонок таблиц</td>
					<td class="right" align="left">Модель</td>
					<td class="right" align="left">Штук</td>
					<td class="right" align="left">Цена</td>
                                    </tr>
                            </tbody>
                        </table>
            </div>
        </div>
    </div>
</div>
</div>

<?php } elseif ($abc == 1) { ?>
<div id="ajax">

    <div id="category" class="container">
        <div class="row">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left"><?php echo $lang['menu_categories'] ?></div>

                        <!-- Количество строк на странице -->
                        <form action="/controller/admin/pages/stock/categories/categories.php" method="post" class="form-inline">
                            <div class="add-xs">Строк на странице: <select name="select_row" class="input-xs form-control" onchange="this.form.submit()">
                                    <option>(<?php echo $lines_page ?>)</option>
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
                                        <div class="log-page"><?php echo $lang['s'] ?> <?php echo $i + 1 ?> <?php echo $lang['po'] ?> <?php echo $lines_p ?> ( <?php echo $lang['iz'] ?> <?php echo $counter; ?> )</div>

                                        <!-- Переключаем страницу "ВПЕРЕД" -->
                                        <form>
                                            <input hidden name="i" value="<?php echo $i ?>">
                                            <input hidden name="lines_p" value="<?php echo $lines_p ?>">
                                            <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
                                            <div class="log-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                        </form>

                                        <!-- Переключаем страницу "НАЗАД" -->
                                        <form>
                                            <input hidden name="i2" value="<?php echo $i ?>">
                                            <input hidden name="lines_p2" value="<?php echo $lines_p ?>">
                                            <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
                                            <div class="log-left"><button type="submit" class="btn btn-primary btn-xs"  action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
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
                                                    <button name="parent_up" value="<?php echo $parent_up ?>" class="btn btn-default btn-xs" title="" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post">....</button>
                                                </div>
                                            </form>

                                        </td>
                                    </tr>

                                <?php } for ($i; $i < $lines_p; $i++) { ?>

                                    <tr class="sort-list" unitid="<?php echo $lines[$i][0] ?>">

                                        <!-- Вырезанные категории "АКТИВНЫЕ" -->
                                        <?php if (isset($_SESSION['buffer']) == true && in_array($lines[$i][0], $_SESSION['buffer']) == true && $lines[$i][8] == 1) { ?>
                                            <td class="sortyes sortleft-m" align="left"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft" align="left"><div><a href="#" class="btn btn-primary btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-folder-open"> </span></a></div></td>

                                            <!-- Вырезанные категории "НЕ АКТИВНЫЕ" -->
                                        <?php } elseif (isset($_SESSION['buffer']) == true && in_array($lines[$i][0], $_SESSION['buffer']) == true && $lines[$i][8] == 0) { ?>
                                            <td class="sortyes sortleft-m" align="left"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft" align="left"><div><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-folder-open"> </span></a></div></td>

                                            <!-- Если категория НЕ АКТИВНА -->
                                        <?php } elseif ($lines[$i][8] == 0) { ?>
                                            <td class="sortyes sortleft-m" align="left"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft" align="left">

                                                <!-- Неактивная категория "ВНИЗ" -->
                                                <form>
                                                    <div>
                                                        <button name="parent_down" value="<?php echo $lines[$i][0] ?>" class="btn btn-default btn-xs" title="<?php echo $lines[$i][1] ?>" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-folder-open"> </span></button>
                                                    </div>
                                                </form>

                                            </td>

                                        <?php } else { ?>
                                            <!-- Если категория АКТИВНА -->
                                            <td class="sortyes sortleft-m" align="left"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft" align="left">

                                                <!-- Активная категория "ВНИЗ" -->
                                                <form>
                                                    <div>
                                                        <button name="parent_down" value="<?php echo $lines[$i][0] ?>" class="btn btn-primary btn-xs" title="<?php echo $lines[$i][1] ?>" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-folder-open"> </span></button>
                                                    </div>
                                                </form>

                                            </td>
                                        <?php } ?>

                                        <!-- ВЫБРАННЫЕ СТРОКИ -->
                                        <td align="left" class="option" id="<?php echo $lines[$i][0] ?>"><span class="inactive" style="display: none;"></span>
                                            <div class="context-one" id="<?php echo $lines[$i][0] ?>"><?php echo $lines[$i][1] ?>
                                                
                                                <!-- Модальное окно "Редактировать категорию" -->
                                                <?php require('modal/categories_edit.php') ?>
                                                <!-- КОНЕЦ Модальное окно "Редактировать категорию" -->
                                                
                                            </div>
                                        </td>	 
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                <?php } elseif ($lines == FALSE && $VALID->inPOST('parent_down') > 0) { ?>

                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="3">
                                        <div class="log-page"><?php echo $lang['no_cat'] ?></div>
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
                                                <button name="parent_up" value="<?php echo $VALID->inPOST('parent_down') ?>" class="btn btn-default btn-xs" title="" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post">....</button>
                                            </div>
                                        </form>

                                    </td>
                                    <td class="options" align="left"><div class="context-one"><?php echo $lang['no_cat'] ?></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="3">
                                        <div class="log-page"><?php echo $lang['no_cat'] ?></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td  class="sortleft-m" align="left"></td>
                                    <td class="sortleft" align="left"></td>
                                    <td class="options" align="left"><div class="context-one"><?php echo $lang['no_cat'] ?></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>