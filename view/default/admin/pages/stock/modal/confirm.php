<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="confirm" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><div class="float-end">&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 id="confirm_title" class="modal-title"></h4>
            </div>
            <div id="confirm_body" class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo lang('confirm-no') ?></button>
                <button type="button" id="confirmation" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-ok"></span> <?php echo lang('confirm-yes') ?></button>
            </div>
        </div>
    </div>
</div>