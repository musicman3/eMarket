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


<div class="panel-body">
    <!--Скрытый div для передачи данных-->
    <div id="ajax_data" class='hidden'
         data-name='<?php echo $name_edit ?>'
         data-value='<?php echo $sale_value_edit ?>'
         data-start='<?php echo $date_start_edit ?>'
         data-end='<?php echo $date_end_edit ?>'
         data-default='<?php echo $default_set_edit ?>'
         ></div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th colspan="5">
                    <?php if ($lines == TRUE) { ?>
                        <div class="page"><?php echo lang('s') ?> <?php echo $start + 1 ?> <?php echo lang('po') ?> <?php echo $finish ?> ( <?php echo lang('iz') ?> <?php echo count($lines); ?> )</div>
                        <?php
                    } else {
                        ?>
                        <div><?php echo lang('no_listing') ?></div>
                    <?php } ?>
                </th>

                <th>

                    <div class="right"><a href="#add" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>

                    <form>
                        <?php if (count($lines) > $lines_on_page) { ?>
                            <input hidden name="route" value="settings/modules/edit">
                            <input hidden name="start" value="<?php echo $start ?>">
                            <input hidden name="finish" value="<?php echo $finish ?>">
                            <input hidden name="type" value="discount">
                            <input hidden name="name" value="sale">
                            <div class="left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                        <?php } ?>
                    </form>

                    <form>
                        <?php if (count($lines) > $lines_on_page) { ?>
                            <input hidden name="route" value="settings/modules/edit">
                            <input hidden name="start2" value="<?php echo $start ?>">
                            <input hidden name="finish2" value="<?php echo $finish ?>">
                            <input hidden name="type" value="discount">
                            <input hidden name="name" value="sale">
                            <div class="left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                        <?php } ?>
                    </form>

                </th>
            </tr>
            <?php if ($lines == TRUE) { ?>
                <tr class="border">
                    <th><?php echo lang('modules_discount_sale_admin_name') ?></th>
                    <th class="al-text"><?php echo lang('modules_discount_sale_admin_value') ?></th>
                    <th class="al-text"><?php echo lang('modules_discount_sale_admin_sale_start_date') ?></th>
                    <th class="al-text"><?php echo lang('modules_discount_sale_admin_sale_end_date') ?></th>
                    <th class="al-text"><?php echo lang('default') ?></th>
                    <th class="al-text-w"></th>
                </tr>
            <?php } ?>
        </thead>
        <tbody>
            <?php
            for ($start; $start < $finish; $start++) {
                if ($this_time > $lines[$start][6]) {
                    $active = ' class="danger"';
                } else {
                    $active = '';
                }
                ?>
                <tr<?php echo $active ?>>

                    <td><?php echo $lines[$start][1] ?></td>
                    <td class="al-text"><?php echo $lines[$start][2] ?></td>
                    <td class="al-text"><?php echo \eMarket\Set::dateLocale($lines[$start][3]); ?></td>
                    <td class="al-text"><?php echo \eMarket\Set::dateLocale($lines[$start][4]); ?></td>
                    <?php if ($lines[$start][5] == 1) { ?>
                        <td class="al-text"><?php echo lang('confirm-yes') ?></td>
                    <?php } else { ?>
                        <td class="al-text"><?php echo lang('confirm-no') ?></td>
    <?php } ?>
                    <td class="al-text-w">
                        <form id="form_delete<?php echo $lines[$start][0] ?>" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('<?php echo $lines[$start][0] ?>')" enctype="multipart/form-data">
                            <input hidden name="delete" value="<?php echo $lines[$start][0] ?>">
                            <div class="right">
                                <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                            </div>
                        </form>
                        <!--Вызов модального окна для редактирования-->
                        <div class="left">
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit" data-edit="<?php echo $lines[$start][0] ?>"><span class="glyphicon glyphicon-edit"></span></button>
                        </div>
                    </td>
                </tr>
<?php } ?>
        </tbody>
    </table>
</div>
