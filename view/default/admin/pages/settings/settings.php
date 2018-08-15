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
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-adjust"> </span></a></div>
                                    <div class="settings-page">Зоны</div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="/controller/admin/pages/settings/taxes.php" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-briefcase"> </span></a></div>
                                    <div class="settings-page">Налоги</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-road"> </span></a></div>
                                    <div class="settings-page">Размер</div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-oil"> </span></a></div>
                                    <div class="settings-page">Вес</div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-comment"> </span></a></div>
                                    <div class="settings-page">Языки</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-tag"> </span></a></div>
                                    <div class="settings-page">Идентификатор товара</div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-flag"> </span></a></div>
                                    <div class="settings-page">Единица измерения</div>
                                </td>
                                <td>
                                    <div class="settings-left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-barcode"> </span></a></div>
                                    <div class="settings-page">Штриховые коды</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>