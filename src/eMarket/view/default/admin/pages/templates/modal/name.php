<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="config_name" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3 mb-3">
                <h5 class="modal-title"><?php echo lang('templates_set_config_name') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default"><?php echo lang('templates_name') ?></span>
                    <input type="text" id="config_input" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm bi-x-circle" type="button" data-bs-dismiss="modal"> <?php echo lang('confirm-no') ?></button>
                <button id="config_confirm" class="btn btn-danger btn-sm bi-check-circle" type="button"> <?php echo lang('confirm-yes') ?></button>
            </div>
        </div>
    </div>
</div>