<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно -->
<div id="forgot" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
	    <div class="modal-header">
		<div class="pull-right"><button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title">Восстановление пароля</h4>
            </div>
            <form enctype="multipart/form-data" method="post" action="">
		<div class="modal-body">
		    <div class="has-error email">
			<input class="form-control" type="email" placeholder="<?php echo lang('e_mail') ?>" id="email" name="email" required>
		    </div>
		</div>
		<div class="modal-footer">
		    <button type="submit" class="btn btn-primary"><?php echo lang('continue') ?></button>
		</div>
	    </form>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно -->