<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$eMarket = new eMarket\Admin\Modules();
?>

<div id="settings_modules">
    <div class="panel panel-default">

        <div class="panel-heading">
            <!--Выводим уведомление об успешном действии-->
            <div id="alert_block"><?php \eMarket\Messages::alert(); ?></div>
            <h3 class="panel-title">
                <span class="settings_back"><button type="button" onClick='location.href = "<?php echo \eMarket\Settings::parentPartitionGenerator() ?>"' class="btn btn-primary btn-xs"><span class="back glyphicon glyphicon-share-alt"></span></button></span><span class="settings_name"><?php echo \eMarket\Settings::titlePageGenerator() ?></span>
            </h3>
        </div>
        <div class="panel-body">
            <!-- Панели -->
            <ul class="nav nav-tabs">
                <?php
                foreach ($_SESSION['MODULES_INFO'] as $type => $name) {
                    ?>
                    <?php echo $eMarket->class($type) ?><a data-toggle="tab" href="#<?php echo $type ?>_modules"><?php echo lang($type . '_modules') ?></a></li>
                <?php } ?>
            </ul>

            <!-- Содержимое панелей -->
            <div class="tab-content">
                <?php foreach ($_SESSION['MODULES_INFO'] as $type => $name) {
                    $eMarket->filter($type);
                    ?>
                    <div id="<?php echo $type ?>_modules" class="<?php echo \eMarket\Admin\Modules::$class_tab ?>">

                        <?php if (isset($_SESSION['MODULES_INFO'][$type])) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-radius">
                                    <thead>

                                        <tr class="bg-primary">
                                            <td><?php echo lang('installed_modules') ?></td>
                                            <td></td>
                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($_SESSION['MODULES_INFO'][$type] as $key) {
                                            if (in_array($key, \eMarket\Admin\Modules::$installed_filter)) {
                                                echo $eMarket->active($key);
                                                ?>

                                            <td><?php echo lang('modules_' . $type . '_' . $key . '_name') ?></td>

                                            <?php ?>
                                            <td>
                                                <div class="flexbox">
                                                    <div class="b-left">
                                                        <button type="button" onClick='location.href = "?route=settings/modules/edit&type=<?php echo $type ?>&name=<?php echo $key ?>"' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"> </span></button>
                                                    </div>
                                                    <form id="form_delete<?php echo $type . '_' . $key ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo $type . '_' . $key ?>', '?route=settings/modules&active=<?php echo $type ?>')" enctype="multipart/form-data">
                                                        <input hidden name="delete" value="<?php echo $type . '_' . $key ?>">
                                                        <div>
                                                            <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-remove"> </span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?> 
                                    </tbody>
                                </table>
                            </div>
                            </br>
                            <div class="table-responsive">
                                <table class="table table-hover table-radius">
                                    <thead>

                                        <tr class="bg-primary">
                                            <td><?php echo lang('uninstalled_modules') ?></td>
                                            <td></td>
                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($_SESSION['MODULES_INFO'][$type] as $key) {
                                            if (!in_array($key, \eMarket\Admin\Modules::$installed_filter)) {
                                                ?>

                                                <tr class="danger">
                                                    <td><?php echo lang('modules_' . $type . '_' . $key . '_name') ?></td>

                                                    <?php ?>
                                                    <td>
                                                        <div class="flexbox">
                                                            <form id="form_add_<?php echo $type . '_' . $key ?>" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_add_<?php echo $type . '_' . $key ?>', '?route=settings/modules&active=<?php echo $type ?>')" enctype="multipart/form-data">
                                                                <input hidden name="add" value="<?php echo $type . '_' . $key ?>">
                                                                <div>
                                                                    <button type="submit" name="add_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-install') ?>"><span class="glyphicon glyphicon-plus"> </span></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?> 

            </div>  
        </div> 
    </div>
</div> 