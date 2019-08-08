<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="settings_basic_settings" class="container-fluid">
    <div class="panel panel-default">

        <div class="panel-heading">
            <!--Выводим уведомление об успешном действии-->
            <?php $MESSAGES->alert(); ?>
            <h3 class="panel-title">
                <div class="pull-left"><a class="btn btn-primary btn-xs" href="?route=settings"><span class="back glyphicon glyphicon-share-alt"></span></a> <?php echo lang('title_' . $SET->titleDir() . '_index') ?></div>
                <div class="clearfix"></div>
            </h3>
        </div>
        <div class="panel-body">
            <!-- Панели -->
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#payment_modules"><?php echo lang('payment_modules') ?></a></li>
                <li><a data-toggle="tab" href="#shipping_modules"><?php echo lang('shipping_modules') ?></a></li>
                <li><a data-toggle="tab" href="#cart_modules"><?php echo lang('cart_modules') ?></a></li>
                <li><a data-toggle="tab" href="#other_modules"><?php echo lang('other_modules') ?></a></li>
            </ul>

            <!-- Содержимое панелей -->
            <div class="tab-content">
                <!-- Оплата -->
                <div id="payment_modules" class="tab-pane fade in active">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="6">
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
                                <td class="al-text">325</td>
                                <td class="al-text">ывачс</td>

                                <td class="al-text">вапва</td>

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

                        </tbody>
                    </table>


                </div>
                <!-- Доставка -->
                <div id="shipping_modules" class="tab-pane fade">




                </div>

                <!-- Корзина -->
                <div id="cart_modules" class="tab-pane fade">




                </div>

                <!-- Другое -->
                <div id="other_modules" class="tab-pane fade">




                </div>
            </div>        
        </div>
    </div>
</div>