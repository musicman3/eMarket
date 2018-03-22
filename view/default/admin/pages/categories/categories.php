<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

<div id="category" class="container">
 <div class="row">
  <div class="panel panel-default">
		
   <div class="panel-heading">
	<h3 class="panel-title">
	 <div class="pull-left"><?php echo $lang['menu_categories'] ?></div>
	 <form name="category_add" action="/controller/admin/pages/categories/categories_add.php" method="post"><div class="add"><button type="submit" name="category_add" value="<?php echo $parent_id ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> <?php echo $lang['button_add'] ?></button></div></form>
	 <div class="clearfix"></div>
	</h3>
   </div>
   <?php if ($lines == true) { ?>
   <div class="panel-body">
	<div class="table-responsive">
	 <table class="table">
	  <thead>
	   <tr>
		<th>
		 <div class="log-page"><?php echo $lang['s'] ?> <?php echo $i+1 ?> <?php echo $lang['po'] ?> <?php echo $lines_p ?> ( <?php echo $lang['iz'] ?> <?php echo $counter; ?> )</div>
		</th>
		<th>
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
	
		</th>
	   </tr>
	  </thead>
	  <tfoot>
	   <tr>
		<th align="left">Групповые действия</th>
		<th align="right">
		 <div class="log-right"><input class="check-box" type="checkbox" value=""></div>
		 <form><input hidden name="log_delete" value="delete"><div class="log-left"><button type="submit" name="cat_delete_batch" class="btn btn-primary btn-xs" title="<?php echo $lang['button_delete'] ?>" action="" formmethod="post"><span class="glyphicon glyphicon-trash"> </span></button></div></form>
		 <div class="log-left"><button class="btn btn-primary btn-xs" title="<?php echo $lang['button_move'] ?>" action="" formmethod="post"><span class="glyphicon glyphicon-transfer"> </span></button></div>
			
		</th>
	   </tr>
	  </tfoot>
	  <tbody>
			
	   <?php $parent_up = $lines[0][4];
	   if ($parent_up > 0) { ?>

	   <tr>
	   <td colspan="2" align="left"><form><div><button name="parent_up" value="<?php echo $parent_up ?>" class="btn btn-default btn-xs" title="" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-level-up"></span></button></div></form></td>
	   </tr>
		 
	   <?php } for ($i; $i < $lines_p; $i++) { ?>
		
	   <tr>
		<?php if($lines[$i][8] == 0){ ?>
		<td align="left"><form><div><button name="parent_down" value="<?php echo $lines[$i][0] ?>" class="btn btn-default btn-xs" title="<?php echo $lines[$i][1] ?>" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-folder-open"> </span></button> <?php echo $lines[$i][1] ?></div></form></td>	  
		<?php }else{ ?>
		<td align="left"><form><div><button name="parent_down" value="<?php echo $lines[$i][0] ?>" class="btn btn-primary btn-xs" title="<?php echo $lines[$i][1] ?>" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-folder-open"> </span></button> <?php echo $lines[$i][1] ?></div></form></td>
		<?php } ?>
		<td align="right">
		 <div class="log-right"><input class="check-box" type="checkbox" value=""></div>
		 <form><div class="log-left"><button class="btn btn-primary btn-xs" title="<?php echo $lang['button_delete'] ?>" name="cat_delete" value="<?php echo $lines[$i][0] ?>" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-trash"> </span></button></div></form>
		 <div class="log-left"><button class="btn btn-primary btn-xs" title="<?php echo $lang['button_move'] ?>" action="" formmethod="post"><span class="glyphicon glyphicon-transfer"> </span></button></div>
		 <div class="log-left"><button class="btn btn-primary btn-xs" title="<?php echo $lang['button_edit'] ?>" action="" formmethod="post"><span class="glyphicon glyphicon-list-alt"> </span></button></div>
		</td>
	   </tr>

	   <?php } ?>

	  </tbody>
	
	 </table>
	</div>
   </div>

   <?php } elseif ($lines == false && isset($_POST['parent_down']) > 0) { ?>

<div class="panel-body"><?php echo $lang['no_cat'] ?>
   	 <div class="table-responsive">
	 <table class="table">
		<tbody>
	   <tr>
	   <td colspan="2" align="left"><form><div><button name="parent_up" value="<?php echo $_POST['parent_down'] ?>" class="btn btn-default btn-xs" title="" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-level-up"></span></button></div></form></td>
	   </tr>
		</tbody>
	</table>
	</div>
</div>
   <?php } else { ?>
<div class="panel-body"><?php echo $lang['no_cat'] ?></div>
   <?php } ?>
  </div>
 </div>
</div>