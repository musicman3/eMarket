<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
use eMarket\Core\{
    Authorize
};
?>

<div id="forgot_password" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3">
                <h3 class="modal-title"><?php echo lang('register_password_recovery') ?></h3>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <form class="was-validated" enctype="multipart/form-data" method="post" action="">
                <input type="hidden" name="csrf_token" value="<?php echo Authorize::csrfToken() ?>" />
                <div class="modal-body">
                    <div class="email">
                        <input class="form-control" type="email" placeholder="<?php echo lang('e_mail') ?>" id="email_for_recovery" name="email_for_recovery" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><?php echo lang('continue') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>