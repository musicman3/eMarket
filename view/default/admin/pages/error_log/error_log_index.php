<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

<div id="log" class="container">
	<div class="row">
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<h3 class="panel-title">
				      <div class="pull-left"><?php echo $lang['menu_error_log'] ?></div>
				      <div class="clearfix"></div>
				</h3>
			</div>

		<div class="panel-body">
<?php if (file_exists($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log') == true) { ?>
<table class="table">
	<thead>
		<tr>
			<th>
			<b><?php echo $lang['s'] ?> <?php echo $i+1 ?> <?php echo $lang['po'] ?> <?php echo $lines_p ?> ( <?php echo $lang['iz'] ?> <?php echo $counter; ?> )</b>
			</th>
			<th>

  <form>
   <input hidden name="i" value="<?php echo $i ?>">
   <input hidden name="lines_p" value="<?php echo $lines_p ?>">
   <div class="log-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/error_log/error_log_index.php" formmethod="post"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
  </form>
		
			
  <form>
   <input hidden name="i2" value="<?php echo $i ?>">
   <input hidden name="lines_p2" value="<?php echo $lines_p ?>">
   <div class="log-left"><button type="submit" class="btn btn-primary btn-xs"  action="/controller/admin/pages/error_log/error_log_index.php" formmethod="post"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
  </form>

			</th>
		</tr>
	</thead>
<tfoot>
    <tr>
      <th colspan="2">

	  <form>
	  	<input hidden name="log_delete" value="delete">
      <div class="log-del"><button type="submit" name="log_delete" class="btn btn-primary btn-sm" action="/controller/admin/pages/error_log/error_log_index.php" formmethod="post"><?php echo $lang['button_delete'] ?></button></div>
	  </form>

      </th>
    </tr>
</tfoot>
	<tbody>
			
<?php	for ($i; $i < $lines_p; $i++) { 

		if (strrpos ($lines[$i], 'PHP Notice:') == true ){ ?><tr class="success"><td colspan="2"><?php echo $lines[$i].'</td></tr>'; ?><?php }elseif

		(strrpos ($lines[$i], 'PHP Warning:') == true ){ ?><tr class="danger"><td colspan="2"><?php echo $lines[$i].'</td></tr>'; ?><?php }elseif

		(strrpos ($lines[$i], 'PHP Fatal error:') == true ){ ?><tr class="warning"><td colspan="2"><?php echo $lines[$i].'</td></tr>'; ?><?php }elseif
			
			(strrpos ($lines[$i], 'PHP Parse error:') == true ){ ?><tr class="info"><td colspan="2"><?php echo $lines[$i].'</td></tr>'; ?><?php }else
			
				{ ?><tr><td colspan="2"><?php echo $lines[$i].'</td></tr>'; }
			}
	?>

	</tbody>
	
</table>
<?php } ?>
			</div>
		</div>
	</div>
</div>