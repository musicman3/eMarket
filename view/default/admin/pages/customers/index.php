<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="ajax">
    <div class="container-fluid">
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

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 offset-0">
                    <form>
                        <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                        <div class="input-group">
                            <input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">
                                <?php if ($lines == TRUE) { ?>
                                    <div class="page"><?php echo lang('with') ?> <?php echo $start + 1 ?> <?php echo lang('to') ?> <?php echo $finish ?> ( <?php echo lang('of') ?> <?php echo $count_lines; ?> )</div>
                                    <?php
                                } else {
                                    ?>
                                    <div><?php echo lang('no_listing') ?></div>
                                <?php } ?>
                            </th>

                            <th>

                                <?php if ($count_lines > $lines_on_page) { ?>
                                    <form>
                                        <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                                        <input hidden name="start" value="<?php echo $start ?>">
                                        <input hidden name="finish" value="<?php echo $finish ?>">
                                        <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                    </form>

                                    <form>
                                        <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                                        <input hidden name="backstart" value="<?php echo $start ?>">
                                        <input hidden name="backfinish" value="<?php echo $finish ?>">
                                        <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>

                                    </form>
                                <?php } ?>

                            </th>
                        </tr>
                        <?php if ($lines == TRUE) { ?>
                            <tr class="border">
                                <th><?php echo lang('customers_firstname') ?></th>
                                <th class="al-text"><?php echo lang('customers_lastname') ?></th>
                                <th class="al-text"><?php echo lang('customers_date_created') ?></th>
                                <th class="al-text"><?php echo lang('customers_email') ?></th>
                                <th class="al-text-w"></th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php for ($start; $start < $finish; $start++) { ?>
                            <tr class="<?php echo \eMarket\Set::statusSwithClass($lines[$start][18]) ?>">
                                <td><?php echo $lines[$start][3] ?></td>
                                <td class="al-text"><?php echo $lines[$start][4] ?></td>
                                <td class="al-text"><?php echo \eMarket\Set::dateLocale($lines[$start][6]) ?></td>
                                <td class="al-text"><?php echo $lines[$start][11] ?></td>
                                <td class="al-text-w">
                                    <form id="form_delete<?php echo $lines[$start][0] ?>" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('<?php echo $lines[$start][0] ?>')" enctype="multipart/form-data">
                                        <input hidden name="delete" value="<?php echo $lines[$start][0] ?>">
                                        <div class="b-right">
                                            <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                        </div>
                                    </form>
                                    <!--Кнопка переключения статуса-->
                                    <div class="b-left">
                                        <form id="form_status<?php echo $lines[$start][0] ?>" name="form_status" action="javascript:void(null);" onsubmit="callAdd('form_status<?php echo $lines[$start][0] ?>')" enctype="multipart/form-data">
                                            <input hidden name="status" value="<?php echo $lines[$start][0] ?>">
                                            <div class="b-right">
                                                <button type="submit" name="status_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-status') ?>"><span class="glyphicon glyphicon-off"> </span></button>
                                            </div>
                                        </form>
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
