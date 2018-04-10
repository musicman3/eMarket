<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
?>

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
