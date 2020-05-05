<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить" -->
<?php require_once('modal/add.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<!-- Модальное окно "Редактировать" -->
<?php require_once('modal/edit.php') ?>
<!-- КОНЕЦ Модальное окно "Редактировать" -->

<!--Скрытый div для передачи данных-->
<div id="ajax_data" class='hidden'
     data-price='<?php echo $minimum_price_edit ?>'
     data-zone='<?php echo $shipping_zone_edit ?>'
     ></div>

<table class="table table-hover">
    <thead>
        <tr>
            <th colspan="2">
                <?php if ($lines == TRUE) { ?>
                    <div class="page"><?php echo lang('with') ?> <?php echo $start + 1 ?> <?php echo lang('to') ?> <?php echo $finish ?> ( <?php echo lang('of') ?> <?php echo count($lines); ?> )</div>
                    <?php
                } else {
                    ?>
                    <div><?php echo lang('no_listing') ?></div>
                <?php } ?>
            </th>

            <th>

                <div class="b-right"><a href="#add" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>

                <form>
                    <?php if (count($lines) > $lines_on_page) { ?>
                        <input hidden name="route" value="settings/modules/edit">
                        <input hidden name="start" value="<?php echo $start ?>">
                        <input hidden name="finish" value="<?php echo $finish ?>">
                        <input hidden name="type" value="<?php echo \eMarket\Valid::inGET('type') ?>">
                        <input hidden name="name" value="<?php echo \eMarket\Valid::inGET('name') ?>">
                        <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                    <?php } ?>
                </form>

                <form>
                    <?php if (count($lines) > $lines_on_page) { ?>
                        <input hidden name="route" value="settings/modules/edit">
                        <input hidden name="backstart" value="<?php echo $start ?>">
                        <input hidden name="backfinish" value="<?php echo $finish ?>">
                        <input hidden name="type" value="<?php echo \eMarket\Valid::inGET('type') ?>">
                        <input hidden name="name" value="<?php echo \eMarket\Valid::inGET('name') ?>">
                        <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                    <?php } ?>
                </form>

            </th>
        </tr>
        <?php if ($lines == TRUE) { ?>
            <tr class="border">
                <th><?php echo lang('modules_shipping_free_admin_shipping_zone') ?></th>
                <th class="al-text"><?php echo lang('modules_shipping_free_admin_minimum_order_price') ?></th>
                <th class="al-text-w"></th>
            </tr>
        <?php } ?>
    </thead>
    <tbody>
        <?php
        for ($start; $start < $finish; $start++) {
            ?>
            <tr>
                <td><?php echo $zones_name[$lines[$start][2]] ?></td>
                <td class="al-text"><?php echo $lines[$start][1] ?></td>
                <td class="al-text-w">
                    <form id="form_delete<?php echo $lines[$start][0] ?>" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('<?php echo $lines[$start][0] ?>')" enctype="multipart/form-data">
                        <input hidden name="delete" value="<?php echo $lines[$start][0] ?>">
                        <div class="b-right">
                            <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                        </div>
                    </form>
                    <!--Вызов модального окна для редактирования-->
                    <div class="b-left">
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit" data-edit="<?php echo $lines[$start][0] ?>"><span class="glyphicon glyphicon-edit"></span></button>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>