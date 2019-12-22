<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!--Выводим уведомление об успешном действии-->
<?php \eMarket\Messages::alert(); ?>
<h1><?php echo lang('my_address_book') ?></h1>

<div class="panel-body">
    <table class="table table-hover">
        <thead>
            <tr>
                <th colspan="4">
                </th>
                <th>
                    <div class="right"><a href="#add" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>
                </th>
            </tr>
            <tr class="border">
                <th><?php echo lang('name_full') ?></th>
                <th class="al-text"><?php echo lang('name_little') ?></th>
                <th class="al-text"><?php echo lang('value') ?></th>
                <th class="al-text"><?php echo lang('default') ?></th>
                <th class="al-text-w"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>123</td>
                <td class="al-text">1236</td>
                <td class="al-text">23654</td>
                <td class="al-text"><?php echo lang('confirm-yes') ?></td>

                <td class="al-text-w">
                    <form id="form_delete1" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('1')" enctype="multipart/form-data">
                        <input hidden name="delete" value="1">
                        <div class="right">
                            <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                        </div>
                    </form>
                    <!--Вызов модального окна для редактирования-->
                    <div class="left">
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit" data-edit="1"><span class="glyphicon glyphicon-edit"></span></button>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</div>