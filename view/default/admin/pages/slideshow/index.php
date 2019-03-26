<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Модальное окно "Настройки" -->
<?php require_once('modal/settings.php') ?>
<!-- КОНЕЦ Модальное окно "Настройки" -->

<!-- Модальное окно "Добавить" -->
<?php require_once('modal/add.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<!-- Модальное окно "Редактировать" -->
<?php require(ROOT . '/view/' . $SET->template() . '/admin/pages/slideshow/modal/edit.php') ?>
<!-- КОНЕЦ Модальное окно "Редактировать" -->

<div id="ajax">
    <div id="slideshow" class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <!--Выводим уведомление об успешном действии-->
                    <?php $MESSAGES->alert(); ?>
                    <h3 class="panel-title">
                        <div class="pull-left"><a href="#settings" class="btn btn-primary btn-xs" data-toggle="modal"><span class="back glyphicon glyphicon-wrench"></span></a> <?php echo lang('title_' . $SET->titleDir() . '_index') ?></div>
                        <div class="clearfix"></div>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="3">
                                        <div class="page">с 1 по 1 ( из 1 )</div>
                                </th>

                                <th>
                                
                                    <div class="right"><a href="#add" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>
                                
                                    <form>
                                            <div class="left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                    </form>

                                    <form>
                                            <div class="left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                    </form>

                                </th>
                            </tr>
                                <tr class="border">
                                    <th>Рисунок</th>
                                    <th class="al-text">Ссылка</th>
                                    <th class="al-text">Активна</th>
                                    <th class="al-text-w"></th>
                                </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>Рисунок</td>
                                    <td class="al-text">Ссылка</td>
                                    <td class="al-text">Активна</td>
                                    <td class="al-text-w">
                                            <div class="right">
                                                <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                            </div>
                                        <div class="left">
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-edit"></span></button>
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>
