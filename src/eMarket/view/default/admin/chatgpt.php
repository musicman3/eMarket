<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize
};
?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel"><?php echo lang('chatgpt_name') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php if (Authorize::$permission == 'admin') { ?>
            <div class="input-group mb-3">
                <input type="password" id="chatgpt_key" class="form-control" placeholder="<?php echo lang('chatgpt_api_key') ?>" aria-describedby="api_key">
                <button class="btn btn-outline-dark" type="button" id="api_key"><?php echo lang('save') ?></button>
            </div>
        <?php } ?>
        <div class="mb-3">
            <div class="card">
                <div class="card-header">
                    <?php echo lang('chatgpt_response') ?>
                </div>
                <div class="card-body">
                    <div id="chat_bot" class="overflow-auto"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <textarea class="form-control" id="chat_user" rows="2" placeholder="<?php echo lang('chatgpt_user_placeholder') ?>"></textarea>
    </div>
    <div class="mb-3">
        <button id="chatgptsend" class="btn btn-sm btn-success" type="button"><span id="chatgptsendspan" class="text-light"></span> <?php echo lang('chatgpt_send_button') ?></button>
    </div>
</div>
