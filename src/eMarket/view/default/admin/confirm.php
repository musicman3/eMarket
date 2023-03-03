<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="confirm" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3">
                <h5 id="confirm_title" class="modal-title"><?php echo lang('attention') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div id="confirm_body" class="modal-body"><?php echo lang('confirm-del') ?></div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm bi-x-circle" type="button" data-bs-dismiss="modal"> <?php echo lang('confirm-no') ?></button>
                <button id="confirmation" class="btn btn-danger btn-sm bi-check-circle" type="button"> <?php echo lang('confirm-yes') ?></button>
            </div>
        </div>
    </div>
</div>