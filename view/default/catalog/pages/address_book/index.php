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
<?php //require_once('modal/edit.php') ?>
<!-- КОНЕЦ Модальное окно "Редактировать" -->

<!--Выводим уведомление об успешном действии-->
<?php \eMarket\Messages::alert(); ?>
<h1><?php echo lang('my_address_book') ?></h1>

<div class="panel-body">
    <table class="table table-hover">
        <thead>
            <tr>
                <th colspan="2">
                </th>
                <th>
                    <div class="right"><a href="#add" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>
                </th>
            </tr>
            <tr class="border">
                <th><?php echo lang('shipping_address') ?></th>
                <th class="al-text"><?php echo lang('default') ?></th>
                <th class="al-text-w"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($adress_array_data_temp != FALSE) {
                foreach (json_decode($adress_array_data_temp, 1) as $val) {
                    ?>
                    <tr>
                        <td><img src="/view/<?php echo \eMarket\Set::template() ?>/admin/images/worldflags/<?php echo strtolower($country_name[$val['countries_id']][0]) ?>.png" alt="<?php echo $country_name[$val['countries_id']][1] ?>" title="<?php echo $country_name[$val['countries_id']][1] ?>" width="16" height="10" /> <?php echo $val['zip'] . ', ' . $val['city'] . ', ' . $val['address'] ?></td>
                        <td class="al-text">Да</td>
                        <td class="al-text-w">
                            <form id="form_delete1" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('1')" enctype="multipart/form-data">
                                <input hidden name="delete" value="1">
                                <div class="right">
                                    <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                </div>
                            </form>
                            <!--Вызов модального окна для редактирования-->
                            <div class="left">
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit" data-edit="1"><span class="glyphicon glyphicon-edit"></span></button>
                            </div>
                        </td>
                    </tr>
                <?php }
            }
            ?>

        </tbody>
    </table>
</div>