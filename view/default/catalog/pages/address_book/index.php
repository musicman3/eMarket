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

<!--Выводим уведомление об успешном действии-->
<?php \eMarket\Messages::alert(); ?>
<h1><?php echo lang('my_address_book') ?></h1>

<div id="ajax_data" class='hidden'
     data-json='<?php echo $address_data_json ?>'
     data-countries='<?php echo $countries_data_json ?>'
     ></div>

<table class="table table-hover">
    <thead>
        <tr>
            <th colspan="2">
            </th>
            <th>
                <div class="b-right"><a href="#add" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>
            </th>
        </tr>
        <tr>
            <th><?php echo lang('address_book_shipping_address') ?></th>
            <th class="al-text"><?php echo lang('default') ?></th>
            <th class="al-text-w"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($address_data_json != FALSE) {
            $x = 1;
            foreach ($address_data as $val) {
                ?>
                <tr>
                    <td><img src="/view/<?php echo \eMarket\Set::template() ?>/admin/images/worldflags/<?php echo strtolower($val['alpha_2']) ?>.png" alt="<?php echo $val['countries_name'] . ', ' . $val['regions_name'] ?>" title="<?php echo $val['countries_name'] . ', ' . $val['regions_name'] ?>" width="16" height="10" /> <?php echo $val['zip'] . ', ' . $val['city'] . ', ' . $val['address'] ?></td>
                    <?php if ($val['default'] == 1) { ?>
                        <td class="al-text"><?php echo lang('confirm-yes') ?></td>
                    <?php } else { ?>
                        <td class="al-text"><?php echo lang('confirm-no') ?></td>
                    <?php } ?>
                    <td class="al-text-w">
                        <form id="form_delete<?php echo $x ?>" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('<?php echo $x ?>')" enctype="multipart/form-data">
                            <input hidden name="delete" value="<?php echo $x ?>">
                            <div class="b-right">
                                <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                            </div>
                        </form>
                        <!--Вызов модального окна для редактирования-->
                        <div class="b-left">
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit" data-edit="<?php echo $x ?>"><span class="glyphicon glyphicon-edit"></span></button>
                        </div>
                    </td>
                </tr>
                <?php
                $x++;
            }
        }
        ?>

    </tbody>
</table>
