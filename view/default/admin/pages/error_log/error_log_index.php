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
			<?php if ($counter > 0) { ?><b>c <?php echo $lines_p-19 ?> по <?php echo $lines_p ?> ( из <?php echo $counter; ?> )</b><?php } ?>
			</th>
			<th>
<?php if ($counter > 0) { ?>	
  <form>
   <input hidden name="i" value="<?php echo $i ?>">
   <input hidden name="lines_p" value="<?php echo $lines_p ?>">
   <div style="display: inline-block;float: right; padding-left:5px;"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/error_log/error_log_index.php" formmethod="post"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
  </form>
		
			
  <form>
   <input hidden name="i2" value="<?php echo $i ?>">
   <input hidden name="lines_p2" value="<?php echo $lines_p ?>">
   <div style="display: inline-block;float: right; padding-right:5px;"><button type="submit" class="btn btn-primary btn-xs"  action="/controller/admin/pages/error_log/error_log_index.php" formmethod="post"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
  </form>
<?php } ?>
			</th>
		</tr>
	</thead>
<tfoot>
    <tr>
      <th colspan="2">
<?php if ($counter > 0) { ?>
      <div style="display: inline-block;float: right;"><button type="submit" class="btn btn-primary btn-sm" action="#" formmethod="post">Удалить</button></div>
<?php } ?>
      </th>
    </tr>
</tfoot>
	<tbody>
			
<?php	for ($i; $i < $lines_p; $i++) { 

		if (strrpos ($lines[$i], 'PHP Notice:') == true ){ ?><tr class="success"><td colspan="2"><?php echo $lines[$i].'<br>'; ?><?php }elseif

		(strrpos ($lines[$i], 'PHP Warning:') == true ){ ?><tr class="danger"><td colspan="2"><?php echo $lines[$i].'<br>'; ?><?php }elseif

		(strrpos ($lines[$i], 'PHP Warning2:') == true ){ ?><tr class="warning"><td colspan="2"><?php echo $lines[$i].'<br>'; ?><?php }elseif
			
			(strrpos ($lines[$i], 'PHP Parse error:') == true ){ ?><tr class="info"><td colspan="2"><?php echo $lines[$i].'<br>'; ?><?php }elseif
			
			($counter > 0){

				echo $lines[$i].'<br>';
			?>

		</td></tr><?php }} ?>

	</tbody>
	
</table>

			</div>
		</div>
	</div>
</div>