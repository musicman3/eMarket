<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div id="settings_modules" class="container-fluid">
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

                    <?php if (isset($_SESSION['MODULES_INFO']['payment'])) { ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                    </th>
                                </tr>

                                <tr class="info border">
                                    <th><?php echo lang('installed_modules') ?></th>
                                    <th class="al-text-w"></th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php
                                foreach ($_SESSION['MODULES_INFO']['payment'] as $key) {
                                    if (isset($payment_installed[0]['name']) && $payment_installed[0]['name'] == $key) {

                                        ?>
                                        <tr>
                                            <td><?php echo lang('payment_' . $key . '_name') ?></td>

                                            <?php ?>
                                            <td class="al-text-w">
                                                <form id="form_delete<?php echo '_payment_' . $key ?>" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('<?php echo '_payment_' . $key ?>')" enctype="multipart/form-data">
                                                    <input hidden name="delete" value="<?php echo 'payment_' . $key ?>">
                                                    <div class="right">
                                                        <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-remove"> </span></button>
                                                    </div>
                                                </form>
                                                <div class="left">
                                                    <button type="button" onClick='location.href = "?route=settings/modules/edit&type=payment&name=<?php echo $key ?>"' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"> </span></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }

                                ?> 
                            </tbody>
                        </table>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                    </th>
                                </tr>

                                <tr class="danger border">
                                    <th><?php echo lang('uninstalled_modules') ?></th>
                                    <th class="al-text-w"></th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php
                                foreach ($_SESSION['MODULES_INFO']['payment'] as $key) {
                                    if (!isset($payment_installed[0]['name']) OR $payment_installed[0]['name'] != $key) {

                                        ?>

                                        <tr>
                                            <td><?php echo lang('payment_' . $key . '_name') ?></td>

                                            <?php ?>
                                            <td class="al-text-w">
                                                <form id="form_add<?php echo '_payment_' . $key ?>" name="form_add" action="javascript:void(null);" onsubmit="callAdd('form_add<?php echo '_payment_' . $key ?>')" enctype="multipart/form-data">
                                                    <input hidden name="add" value="<?php echo 'payment_' . $key ?>">
                                                    <div class="right">
                                                        <button type="submit" name="add_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-install') ?>"><span class="glyphicon glyphicon-plus"> </span></button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }

                                ?> 
                            </tbody>
                        </table>
                    <?php } ?> 
                </div>


                <!-- Доставка -->
                <div id="shipping_modules" class="tab-pane fade">

                    <?php if (isset($_SESSION['MODULES_INFO']['shipping'])) { ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                    </th>
                                </tr>

                                <tr class="border">
                                    <th><?php echo lang('modules_name') ?></th>
                                    <th class="al-text-w"></th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php foreach ($_SESSION['MODULES_INFO']['shipping'] as $key) { ?>
                                    <tr>
                                        <td><?php echo lang('shipping_' . $key . '_name') ?></td>

                                        <td class="al-text-w">
                                            <form id="form_delete<?php echo '_shipping_' . $key ?>" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('<?php echo '_shipping_' . $key ?>')" enctype="multipart/form-data">
                                                <input hidden name="delete" value="<?php echo '_shipping_' . $key ?>">
                                                <div class="right">
                                                    <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                                </div>
                                            </form>
                                            <!--Вызов модального окна для редактирования-->
                                            <div class="left">
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit" data-edit="<?php echo '_shipping_' . $key ?>"><span class="glyphicon glyphicon-edit"></span></button>
                                            </div>
                                        </td>

                                    </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    <?php } ?> 
                </div>

                <!-- Корзина -->
                <div id="cart_modules" class="tab-pane fade">

                    <?php if (isset($_SESSION['MODULES_INFO']['cart'])) { ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                    </th>
                                </tr>

                                <tr class="border">
                                    <th><?php echo lang('modules_name') ?></th>
                                    <th class="al-text-w"></th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php foreach ($_SESSION['MODULES_INFO']['cart'] as $key) { ?>
                                    <tr>
                                        <td><?php echo lang('cart_' . $key . '_name') ?></td>

                                        <td class="al-text-w">
                                            <form id="form_delete<?php echo '_cart_' . $key ?>" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('<?php echo '_cart_' . $key ?>')" enctype="multipart/form-data">
                                                <input hidden name="delete" value="<?php echo '_cart_' . $key ?>">
                                                <div class="right">
                                                    <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                                </div>
                                            </form>
                                            <!--Вызов модального окна для редактирования-->
                                            <div class="left">
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit" data-edit="<?php echo '_cart_' . $key ?>"><span class="glyphicon glyphicon-edit"></span></button>
                                            </div>
                                        </td>

                                    </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    <?php } ?>
                </div>

                <!-- Другое -->
                <div id="other_modules" class="tab-pane fade">

                    <?php if (isset($_SESSION['MODULES_INFO']['other'])) { ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                    </th>
                                </tr>

                                <tr class="border">
                                    <th><?php echo lang('modules_name') ?></th>
                                    <th class="al-text-w"></th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php foreach ($_SESSION['MODULES_INFO']['other'] as $key) { ?>
                                    <tr>
                                        <td><?php echo lang('other_' . $key . '_name') ?></td>

                                        <td class="al-text-w">
                                            <form id="form_delete<?php echo '_other_' . $key ?>" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('<?php echo '_other_' . $key ?>')" enctype="multipart/form-data">
                                                <input hidden name="delete" value="<?php echo '_other_' . $key ?>">
                                                <div class="right">
                                                    <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                                </div>
                                            </form>
                                            <!--Вызов модального окна для редактирования-->
                                            <div class="left">
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit" data-edit="<?php echo '_other_' . $key ?>"><span class="glyphicon glyphicon-edit"></span></button>
                                            </div>
                                        </td>

                                    </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    <?php } ?>
                </div>

            </div>  
        </div>
    </div>
</div>