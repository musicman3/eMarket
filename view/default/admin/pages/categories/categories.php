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
				      <div class="pull-left"><?php echo $lang['menu_categories'] ?></div>
				      <div class="clearfix"></div>
				</h3>
			</div>

		<div class="panel-body">
<div class="table-responsive">
<table class="table">
	<thead>
		<tr>
			<th>
			<div class="log-page"><?php echo $lang['s'] ?> <?php echo $i+1 ?> <?php echo $lang['po'] ?> <?php echo $lines_p ?> ( <?php echo $lang['iz'] ?> <?php echo $counter; ?> )<div>
			</th>
			
			<th>


		<div class="category-add"><button type="button" name="category_add" class="btn btn-primary btn-xs" onclick="document.location.href='/controller/admin/pages/categories/categories_add.php'"><?php echo $lang['button_add'] ?></button></div>
	<br>
  <form>
   <input hidden name="i" value="<?php echo $i ?>">
   <input hidden name="lines_p" value="<?php echo $lines_p ?>">
   <div class="log-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
  </form>
		
			
  <form>
   <input hidden name="i2" value="<?php echo $i ?>">
   <input hidden name="lines_p2" value="<?php echo $lines_p ?>">
   <div class="log-left"><button type="submit" class="btn btn-primary btn-xs"  action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
  </form>
  
  	<form>
	  	<input hidden name="log_delete" value="delete">
		<div class="log-del"><button type="submit" name="log_delete" class="btn btn-primary btn-xs" action="/controller/admin/pages/categories/categories.php" formmethod="post"><?php echo $lang['button_delete'] ?></button></div>
	</form>
			</th>
		</tr>
	</thead>

	<tbody>
			
<?php	for ($i; $i < $lines_p; $i++) { 
		
				 ?><tr><td colspan="2"><?php echo $lines[$i][1] ?></td><td colspan="2">Редактировать</td><td colspan="2">Переместить</td><td colspan="2">Удалить</td><td colspan="2">Чекбокс</td></tr> 
			<?php }
	?>

	</tbody>
	
</table>
</div>
			</div>



		</div>
	</div>
</div>