<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize
};
use eMarket\JsonRpc\{
    AiChat
};
?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel"><?php echo lang('aichat_name') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-3">
            <input type="radio" class="btn-check" name="options-outlined" id="chatgpt-outlined" autocomplete="off" <?php echo AiChat::checked('ChatGPT') ?> >
            <label class="btn btn-outline-success" for="chatgpt-outlined"><?php echo lang('aichat_chatgpt_name') ?></label>
            <input type="radio" class="btn-check" name="options-outlined" id="deepseek-outlined" autocomplete="off" <?php echo AiChat::checked('DeepSeek') ?> >
            <label class="btn btn-outline-success" for="deepseek-outlined"><?php echo lang('aichat_deepseek_name') ?></label>
        </div>

        <?php if (Authorize::$permission == 'admin') { ?>
            <div class="input-group mb-3">
                <input type="password" id="aichat_key" class="form-control" placeholder="<?php echo lang('aichat_api_key') ?>" aria-describedby="api_key">
                <button class="btn btn-outline-dark" type="button" id="api_key"><?php echo lang('save') ?></button>
            </div>
        <?php } ?>
        <div class="mb-3">
            <div class="card">
                <div class="card-header">
                    <?php echo lang('aichat_response') ?>
                </div>
                <div class="card-body">
                    <div id="chat_empty" class="overflow-auto"><?php echo lang('aichat_not_started') ?></div>
                    <div id="chat_bot" class="overflow-auto"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-body mb-3">
        <div class="mb-3">
            <textarea class="form-control" id="chat_user" rows="2" placeholder="<?php echo lang('aichat_user_placeholder') ?>"></textarea>
        </div>
        <div class="mb-3">
            <button id="aichatsend" class="btn btn-sm btn-success" type="button"><span id="aichatsendspan" class="text-light"></span> <?php echo lang('aichat_send_button') ?></button>
        </div>
    </div>
</div>
