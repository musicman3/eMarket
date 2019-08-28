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
                <?php
                foreach ($_SESSION['MODULES_INFO'] as $type => $name) {
                    if ($VALID->inGET('active') == $type OR ( !$VALID->inGET('active') && $type == 'payment')) {
                        $class = ' class="active"';
                    } else {
                        $class = '';
                    }

                    ?>
                    <li<?php echo $class ?>><a data-toggle="tab" href="#<?php echo $type ?>_modules"><?php echo lang($type . '_modules') ?></a></li>
                <?php } ?>
            </ul>

            <!-- Содержимое панелей -->
            <div class="tab-content">
                <?php
                foreach ($_SESSION['MODULES_INFO'] as $type => $name) {
                    if ($VALID->inGET('active') == $type OR ( !$VALID->inGET('active') && $type == 'payment')) {
                        $class_tab = 'tab-pane fade in active';
                    } else {
                        $class_tab = 'tab-pane fade';
                    }
                    $installed_filter = $FUNC->filterArrayToKey($installed, 'type', $type, 'name');

                    ?>
                    <div id="<?php echo $type ?>_modules" class="<?php echo $class_tab ?>">

                        <?php if (isset($_SESSION['MODULES_INFO'][$type])) { ?>
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
                                    foreach ($_SESSION['MODULES_INFO'][$type] as $key) {
                                        if (in_array($key, $installed_filter)) {

                                            ?>
                                            <tr>
                                                <td><?php echo lang($type . '_' . $key . '_name') ?></td>

                                                <?php ?>
                                                <td class="al-text-w">
                                                    <form id="form_delete<?php echo $type . '_' . $key ?>" name="form_delete" action="javascript:void(null);" onsubmit="callDelete('<?php echo $type . '_' . $key ?>', '?route=settings/modules&active=<?php echo $type ?>')" enctype="multipart/form-data">
                                                        <input hidden name="delete" value="<?php echo $type . '_' . $key ?>">
                                                        <div class="right">
                                                            <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-remove"> </span></button>
                                                        </div>
                                                    </form>
                                                    <div class="left">
                                                        <button type="button" onClick='location.href = "?route=settings/modules/edit&type=<?php echo $type ?>&name=<?php echo $key ?>"' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"> </span></button>
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
                                    foreach ($_SESSION['MODULES_INFO'][$type] as $key) {
                                        if (!in_array($key, $installed_filter)) {

                                            ?>

                                            <tr>
                                                <td><?php echo lang($type . '_' . $key . '_name') ?></td>

                                                <?php ?>
                                                <td class="al-text-w">
                                                    <form id="form_add_<?php echo $type . '_' . $key ?>" name="form_add" action="javascript:void(null);" onsubmit="callAdd('form_add_<?php echo $type . '_' . $key ?>', '?route=settings/modules&active=<?php echo $type ?>')" enctype="multipart/form-data">
                                                        <input hidden name="add" value="<?php echo $type . '_' . $key ?>">
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
                        </div>
                    <?php }
                } ?> 

            </div>  
        </div> 
    </div> 
</div> 