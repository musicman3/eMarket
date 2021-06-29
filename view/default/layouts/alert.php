<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
    <div id="liveToast" class="toast hide" data-bs-delay="<?php echo $_SESSION['message'][2] ?>">
        <div class="toast-header">
            <span class="bi-square-fill me-2 text-<?php echo $_SESSION['message'][0] ?>"></span>
            <strong class="me-auto"><?php echo lang('messages_alert_name') ?></strong>
            <small><?php echo $_SESSION['message'][4] ?></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            <?php echo $_SESSION['message'][1] ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Toast(document.querySelector('#liveToast')).show();
    });
</script>