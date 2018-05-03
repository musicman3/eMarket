<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
    <!-- Модальное окно "Налог" -->
    <?php require_once('modal/taxes_add.php') ?>
    <!-- КОНЕЦ Модальное окно "Добавить категорию" -->

<div id="ajax">
    <div id="settings" class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left"><?php echo $lang['title_settings'] ?></div>
                        <div class="clearfix"></div>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-globe"> </span></a></div>
                                    <div class="settings-page">Страны</div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-pencil"></span></button></div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-plus"></span></button></div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-adjust"> </span></a></div>
                                    <div class="settings-page">Зоны</div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-pencil"></span></button></div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-plus"></span></button></div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-briefcase"> </span></a></div>
                                    <div class="settings-page">Налоги</div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-pencil"></span></button></div>
                                    <div class="settings-right"><a href="#taxes_add" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-road"> </span></a></div>
                                    <div class="settings-page">Размер</div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-pencil"></span></button></div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-plus"></span></button></div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-oil"> </span></a></div>
                                    <div class="settings-page">Вес</div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-pencil"></span></button></div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-plus"></span></button></div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-comment"> </span></a></div>
                                    <div class="settings-page">Языки</div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-pencil"></span></button></div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-plus"></span></button></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-tag"> </span></a></div>
                                    <div class="settings-page">Идентификатор товара</div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-pencil"></span></button></div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-plus"></span></button></div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-flag"> </span></a></div>
                                    <div class="settings-page">Единица измерения</div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-pencil"></span></button></div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-plus"></span></button></div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-barcode"> </span></a></div>
                                    <div class="settings-page">Штриховые коды</div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-pencil"></span></button></div>
                                    <div class="settings-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/stock/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-plus"></span></button></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>