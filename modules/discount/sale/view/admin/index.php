<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно -->
<?php require_once('modal/index.php') ?>
<!-- КОНЕЦ Модальное окно -->

<!--Скрытый div для передачи данных-->
<div id="ajax_data" class='hidden' data-jsondata='<?php echo $json_data ?>'></div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th colspan="5">
                    <?php if ($lines == TRUE) { ?>
                        <?php echo lang('with') ?> <?php echo $start + 1 ?> <?php echo lang('to') ?> <?php echo $finish ?> ( <?php echo lang('of') ?> <?php echo count($lines); ?> )
                        <?php
                    } else {
                        ?>
                        <?php echo lang('no_listing') ?>
                    <?php } ?>
                </th>

                <th>
                    <div class="flexbox">
                        <div class="b-left"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>

                        <form>
                            <input hidden name="route" value="settings/modules/edit">
                            <input hidden name="backstart" value="<?php echo $start ?>">
                            <input hidden name="backfinish" value="<?php echo $finish ?>">
                            <input hidden name="type" value="<?php echo \eMarket\Valid::inGET('type') ?>">
                            <input hidden name="name" value="<?php echo \eMarket\Valid::inGET('name') ?>">
                            <div class="b-left">
                                <?php if ($start > 0) { ?>
                                    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button>
                                <?php } else { ?>
                                    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                <?php } ?>
                            </div>
                        </form>

                        <form>
                            <input hidden name="route" value="settings/modules/edit">
                            <input hidden name="start" value="<?php echo $start ?>">
                            <input hidden name="finish" value="<?php echo $finish ?>">
                            <input hidden name="type" value="<?php echo \eMarket\Valid::inGET('type') ?>">
                            <input hidden name="name" value="<?php echo \eMarket\Valid::inGET('name') ?>">
                            <div>
                                <?php if ($finish != count($lines)) { ?>
                                    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button>
                                <?php } else { ?>
                                    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                <?php } ?>
                            </div>
                        </form>

                    </div>
                </th>
            </tr>
            <?php if ($lines == TRUE) { ?>
                <tr class="border">
                    <th><?php echo lang('modules_discount_sale_admin_name') ?></th>
                    <th class="text-center"><?php echo lang('modules_discount_sale_admin_value') ?></th>
                    <th class="text-center"><?php echo lang('modules_discount_sale_admin_sale_start_date') ?></th>
                    <th class="text-center"><?php echo lang('modules_discount_sale_admin_sale_end_date') ?></th>
                    <th class="text-center"><?php echo lang('default') ?></th>
                    <th></th>
                </tr>
            <?php } ?>
        </thead>
        <tbody>
            <?php
            for ($start; $start < $finish; $start++) {
                if ($this_time > $lines[$start]['UNIX_TIMESTAMP (date_end)']) {
                    $active = ' class="danger"';
                } else {
                    $active = '';
                }
                ?>
                <tr<?php echo $active ?>>

                    <td><?php echo $lines[$start]['name'] ?></td>
                    <td class="text-center"><?php echo $lines[$start]['sale_value'] ?></td>
                    <td class="text-center"><?php echo \eMarket\Settings::dateLocale($lines[$start]['date_start']); ?></td>
                    <td class="text-center"><?php echo \eMarket\Settings::dateLocale($lines[$start]['date_end']); ?></td>
                    <?php if ($lines[$start]['default_set'] == 1) { ?>
                        <td class="text-center"><?php echo lang('confirm-yes') ?></td>
                    <?php } else { ?>
                        <td class="text-center"><?php echo lang('confirm-no') ?></td>
                    <?php } ?>
                    <td>
                        <div class="flexbox">
                            <!--Вызов модального окна для редактирования-->
                            <div class="b-left">
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#index" data-edit="<?php echo $lines[$start]['id'] ?>"><span class="glyphicon glyphicon-edit"></span></button>
                            </div>
                            <form id="form_delete<?php echo $lines[$start]['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo $lines[$start]['id'] ?>')" enctype="multipart/form-data">
                                <input hidden name="delete" value="<?php echo $lines[$start]['id'] ?>">
                                <div>
                                    <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                </div>
                            </form>

                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>