<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно -->
<?php require_once('modal/index.php') ?>
<!-- КОНЕЦ Модальное окно -->

<div id="ajax">
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <!--Выводим уведомление об успешном действии-->
                <?php \eMarket\Messages::alert(); ?>
                <h3 class="panel-title">
                    <div class="pull-left"><span class="settings_back"><button type="button" onClick='location.href = "<?php echo $_SESSION['country_page'] ?>"' class="btn btn-primary btn-xs"><span class="back glyphicon glyphicon-share-alt"></span></button></span><span class="settings_name"><?php echo \eMarket\Set::titlePageGenerator() ?></span></div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <div class="panel-body">

                <!--Скрытый div для передачи данных-->
                <div id="ajax_data" class='hidden' data-jsondata='<?php echo $json_data ?>'></div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="2">
                                <?php if ($lines == TRUE) { ?>
                                    <div class="page"><?php echo lang('with') ?> <?php echo $start + 1 ?> <?php echo lang('to') ?> <?php echo $finish ?> ( <?php echo lang('of') ?> <?php echo $count_lines; ?> )</div>
                                    <?php
                                } else {
                                    ?>
                                    <div><?php echo lang('no_listing') ?></div>
                                <?php } ?>
                            </th>

                            <th>

                                <div class="b-right"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>

                                <?php if ($count_lines > $lines_on_page) { ?>
                                    <form>
                                        <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                                        <input hidden name="start" value="<?php echo $start ?>">
                                        <input hidden name="finish" value="<?php echo $finish ?>">
                                        <input hidden name="country_id" value="<?php echo \eMarket\Valid::inGET('country_id') ?>">
                                        <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                    </form>

                                    <form>
                                        <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                                        <input hidden name="backstart" value="<?php echo $start ?>">
                                        <input hidden name="backfinish" value="<?php echo $finish ?>">
                                        <input hidden name="country_id" value="<?php echo \eMarket\Valid::inGET('country_id') ?>">
                                        <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                    </form>
                                <?php } ?>

                            </th>
                        </tr>
                        <?php if ($lines == TRUE) { ?>
                            <tr class="border">
                                <th><?php echo lang('name_region') ?></th>
                                <th class="al-text"><?php echo lang('region_code') ?></th>
                                <th class="al-text-w"></th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php for ($start; $start < $finish; $start++) { ?>
                            <tr>
                                <td><?php echo $lines[$start][2] ?></td>
                                <td class="al-text"><?php echo $lines[$start][1] ?></td>
                                <td class="al-text-w">
                                    <form id="form_delete<?php echo $lines[$start][0] ?>" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('<?php echo $lines[$start][0] ?>')" enctype="multipart/form-data">
                                        <input hidden name="delete" value="<?php echo $lines[$start][0] ?>">
                                        <input hidden name="country_id" value="<?php echo \eMarket\Valid::inGET('country_id') ?>">
                                        <div class="b-right">
                                            <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                        </div>
                                    </form>
                                    <!--Вызов модального окна для редактирования-->
                                    <div class="b-left">
                                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#index" data-edit="<?php echo $lines[$start][0] ?>"><span class="glyphicon glyphicon-edit"></span></button>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>