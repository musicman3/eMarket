<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div id="error_log">
    <div class="panel panel-default">

	<div class="panel-heading">
	    <div id="alert_block"><?php \eMarket\Core\Messages::alert(); ?></div>
	    <h3 class="panel-title">
		<?php echo \eMarket\Core\Settings::titlePageGenerator() ?>
	    </h3>
	</div>
	<?php if (file_exists(ROOT . '/model/work/errors.log') == true) { ?>
            <div class="panel-body">

    	    <div class="table-responsive">
    		<table class="table">
    		    <thead>
    			<tr>
    			    <th><?php echo \eMarket\Core\Pages::counterPage() ?></th>

    			    <th>
    				<div class="flexbox">
    				    <form id="form_delete_log" name="form_delete_log" action="javascript:void(null);" onsubmit="Ajax.callDelete('_log')" enctype="multipart/form-data">
    					<input hidden name="delete" value="delete">
    					<div class="b-left"><button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button></div>
    				    </form>
    				    <form>
                                        <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
    					<input hidden name="backstart" value="<?php echo \eMarket\Core\Pages::$start ?>">
    					<input hidden name="backfinish" value="<?php echo \eMarket\Core\Pages::$finish ?>">
    					<div class="b-left">
						<?php if (\eMarket\Core\Pages::$start > 0) { ?>
						    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button>
						<?php } else { ?>
						    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
						<?php } ?>
    					</div>
    				    </form>
    				    <form>
                                        <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
    					<input hidden name="start" value="<?php echo \eMarket\Core\Pages::$start ?>">
    					<input hidden name="finish" value="<?php echo \eMarket\Core\Pages::$finish ?>">
    					<div>
						<?php if (\eMarket\Core\Pages::$finish != \eMarket\Core\Pages::$count) { ?>
						    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button>
						<?php } else { ?>
						    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-right"></span></a>
						<?php } ?>
    					</div>
    				    </form>
    				</div>
    			    </th>
    			</tr>
    		    </thead>

    		    <tbody>

			    <?php
			    for (\eMarket\Core\Pages::$start; \eMarket\Core\Pages::$start < \eMarket\Core\Pages::$finish; \eMarket\Core\Pages::$start++, \eMarket\Core\Pages::lineUpdate()) {

				if (isset(eMarket\Core\Pages::$table['line']) == TRUE) {

				    if (strrpos(eMarket\Core\Pages::$table['line'], 'PHP Notice:') == TRUE) {
					?><tr class="success"><td colspan="2"><?php echo eMarket\Core\Pages::$table['line'] . '</td></tr>'; ?><?php
				    } elseif
				    (strrpos(eMarket\Core\Pages::$table['line'], 'PHP Warning:') == TRUE) {
					?><tr class="warning"><td colspan="2"><?php echo eMarket\Core\Pages::$table['line'] . '</td></tr>'; ?><?php
					    } elseif
					    (strrpos(eMarket\Core\Pages::$table['line'], 'PHP Catchable fatal error:') == TRUE) {
						?><tr class="danger"><td colspan="2"><?php echo eMarket\Core\Pages::$table['line'] . '</td></tr>'; ?><?php
					    } elseif
					    (strrpos(eMarket\Core\Pages::$table['line'], 'PHP Fatal error:') == TRUE) {
						?><tr class="danger"><td colspan="2"><?php echo eMarket\Core\Pages::$table['line'] . '</td></tr>'; ?><?php
					    } elseif
					    (strrpos(eMarket\Core\Pages::$table['line'], 'PHP Parse error:') == TRUE) {
						?><tr class="info"><td colspan="2"><?php echo eMarket\Core\Pages::$table['line'] . '</td></tr>'; ?><?php } else {
						?><tr><td colspan="2"><?php
						echo eMarket\Core\Pages::$table['line'] . '</td></tr>';
					    }
					}
				    }
				    ?>

    		    </tbody>

    		</table>
    	    </div>
            </div>
	<?php } else { ?>
            <div class="panel-body"><?php echo lang('no_listing') ?></div>
	<?php } ?>
    </div>
</div>