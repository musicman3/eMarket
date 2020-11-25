<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Настройки" -->
<?php require(ROOT . '/view/' . \eMarket\Set::template() . '/admin/pages/slideshow/modal/settings.php') ?>
<!-- КОНЕЦ Модальное окно "Настройки" -->

<!-- Модальное окно "Добавить" -->
<?php require_once('modal/index.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<div id="ajax">
    <div id="slideshow" class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <!--Выводим уведомление об успешном действии-->
                <?php \eMarket\Messages::alert(); ?>
                <h3 class="panel-title">
                    <div class="pull-left"><?php echo \eMarket\Set::titlePageGenerator() ?></div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <div class="panel-body">
                <!-- Языковые панели -->
                    <?php require_once(ROOT . '/view/' . \eMarket\Set::template() . '/layouts/lang_tabs_add.php') ?>
                <div class="tab-content">
                    <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="4">
                                        <div class="page">с 1 по 1 ( из 1 )</div>
                                    </th>

                                    <th>
                                        <form>
                                            <div class="b-right"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                        </form>

                                        <form>
                                            <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                        </form>

                                        <div class="b-left"><a href="#settings" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-cog"></span></a></div>

                                        <div class="b-left"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>

                                    </th>
                                </tr>

                                <tr class="border">
                                    <th>Рисунок</th>
                                    <th class="al-text">Название</th>
                                    <th class="al-text">Начало показа</th>
                                    <th class="al-text">Конец показа</th>
                                    <th class="al-text-w"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Рисунок</td>
                                    <td class="al-text">Название</td>
                                    <th class="al-text">10.10.20</th>
                                    <th class="al-text">20.10.20</th>
                                    <td class="al-text-w">
                                        <div class="b-right">
                                            <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                        </div>
                                        <div class="b-left">
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-edit"></span></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    if ($LANG_COUNT > 1) {
                        for ($x = 1; $x < $LANG_COUNT; $x++) {
                            ?>

                            <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                <table class="table table-hover">

                                    <thead>
                                        <tr>
                                            <th colspan="4">
                                                <div class="page">с 1 по 1 ( из 1 )</div>
                                            </th>

                                            <th>

                                                <form>
                                                    <div class="b-right"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                                </form>

                                                <form>
                                                    <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                                </form>

                                                <div class="b-left"><a href="#settings" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-cog"></span></a></div>

                                                <div class="b-left"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>

                                            </th>
                                        </tr>

                                        <tr class="border">
                                            <th>Рисунок</th>
                                            <th class="al-text">Название</th>
                                            <th class="al-text">Начало показа</th>
                                            <th class="al-text">Конец показа</th>
                                            <th class="al-text-w"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>Рисунок</td>
                                            <td class="al-text">Название</td>
                                            <th class="al-text">10.10.20</th>
                                            <th class="al-text">20.10.20</th>
                                            <td class="al-text-w">
                                                <div class="b-right">
                                                    <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                                </div>
                                                <div class="b-left">
                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-edit"></span></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
