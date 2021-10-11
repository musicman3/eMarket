<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
    Settings
};
use eMarket\Admin\Modules;
?>

<div id="settings_modules">
    <div class="card">

        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h5 class="card-title row justify-content-between">
                <div class="col-4 text-start">
                    <button type="button" onClick='location.href = "<?php echo Settings::parentPartitionGenerator() ?>"' class="btn btn-primary btn-sm bi-reply"> <?php echo lang('button_back') ?></button>
                </div>
                <div class="col-4 text-center">
                    <?php echo Settings::titlePageGenerator() ?>
                </div>
                <div class="col-4 text-end"></div>
            </h5>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs">
                <?php
                foreach ($_SESSION['MODULES_INFO'] as $type => $name) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $eMarket->class($type) ?>" data-bs-toggle="tab" href="#<?php echo $type ?>_modules"><?php echo lang($type . '_modules') ?></a>
                    </li>
                <?php } ?>
            </ul>

            <div class="tab-content pt-2">
                <?php
                foreach ($_SESSION['MODULES_INFO'] as $type => $name) {
                    $eMarket->filter($type);
                    ?>
                    <div id="<?php echo $type ?>_modules" class="<?php echo Modules::$class_tab ?>">

                        <?php if (isset($_SESSION['MODULES_INFO'][$type])) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-radius mb-0">
                                    <thead>

                                        <tr class="bg-primary align-middle text-white">
                                            <td><?php echo lang('installed_modules') ?></td>
                                            <td></td>
                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($_SESSION['MODULES_INFO'][$type] as $key) {
                                            if (in_array($key, Modules::$installed_filter)) {
                                                ?>
                                                <tr class="<?php echo $eMarket->active($key) ?>">

                                                    <td><?php echo lang('modules_' . $type . '_' . $key . '_name') ?></td>

                                                    <?php ?>
                                                    <td>
                                                        <div class="gap-2 d-flex justify-content-end">
                                                            <button type="button" onClick='location.href = "?route=settings/modules/edit&type=<?php echo $type ?>&name=<?php echo $key ?>"' class="btn btn-primary btn-sm bi-pencil-square"></button>
                                                            <form id="form_delete<?php echo $type . '_' . $key ?>" name="form_delete" action="javascript:void(null);" enctype="multipart/form-data">
                                                                <input hidden name="delete" value="<?php echo $type . '_' . $key ?>">
                                                                <button type="button" name="delete_but" class="btn btn-primary btn-sm bi-trash" onclick="Confirmation.del('<?php echo $type . '_' . $key ?>', '?route=settings/modules&active=<?php echo $type ?>')"></button>
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
                                <table class="table table-hover table-radius mb-0">
                                    <thead>

                                        <tr class="bg-primary text-white">
                                            <td><?php echo lang('uninstalled_modules') ?></td>
                                            <td></td>
                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($_SESSION['MODULES_INFO'][$type] as $key) {
                                            if (!in_array($key, Modules::$installed_filter)) {
                                                ?>

                                                <tr class="<?php echo $eMarket->active($key) ?> align-middle">
                                                    <td><?php echo lang('modules_' . $type . '_' . $key . '_name') ?></td>

                                                    <?php ?>
                                                    <td>
                                                        <div class="gap-2 d-flex justify-content-end">
                                                            <form id="form_add_<?php echo $type . '_' . $key ?>" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_add_<?php echo $type . '_' . $key ?>', '?route=settings/modules&active=<?php echo $type ?>')" enctype="multipart/form-data">
                                                                <input hidden name="add" value="<?php echo $type . '_' . $key ?>">
                                                                <button type="submit" name="add_but" class="btn btn-primary btn-sm bi-plus" data-bs-placement="left" data-bs-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-install') ?>"></button>
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