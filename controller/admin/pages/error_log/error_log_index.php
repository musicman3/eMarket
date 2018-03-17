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

<table class="table">
	<thead>
		<tr>
			<th>
			<?php if (file_exists($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log') == true) { ?><b>c <?php echo $lines_p-19 ?> по <?php echo $lines_p ?> ( из <?php echo $counter; ?> )</b><?php } ?>
			</th>
			<th>
<?php if (file_exists($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log') == true) { ?>	
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
<?php } ?>
			</th>
		</tr>
	</thead>
<tfoot>
    <tr>
      <th colspan="2">
<?php if (file_exists($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log') == true) { ?>
      <div class="log-del"><button type="submit" class="btn btn-primary btn-sm" action="#" formmethod="post">Удалить</button></div>
<?php } ?>
      </th>
    </tr>
</tfoot>
	<tbody>
			
<?php	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log') == true) {
	  for ($i; $i < $lines_p; $i++) { 

		if (strrpos ($lines[$i], 'PHP Notice:') == true ){ ?><tr class="success"><td colspan="2"><?php echo $lines[$i].'</td></tr>'; ?><?php }elseif

		(strrpos ($lines[$i], 'PHP Warning:') == true ){ ?><tr class="danger"><td colspan="2"><?php echo $lines[$i].'</td></tr>'; ?><?php }elseif

		(strrpos ($lines[$i], 'PHP Warning2:') == true ){ ?><tr class="warning"><td colspan="2"><?php echo $lines[$i].'</td></tr>'; ?><?php }elseif
			
			(strrpos ($lines[$i], 'PHP Parse error:') == true ){ ?><tr class="info"><td colspan="2"><?php echo $lines[$i].'</td></tr>'; ?><?php }else
			
				echo $lines[$i].'</td></tr>';
			}
		}
	?>

	</tbody>
	
</table>

			</div>
		</div>
	</div>
</div>