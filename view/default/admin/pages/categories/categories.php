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

	 <div class="add"><button type="submit" name="category_add" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addCategory"><span class="glyphicon glyphicon-plus"></span> <?php echo $lang['button_add'] ?></button>
	  <div id="addCategory" class="modal fade">
	   <div class="modal-dialog">
		<div class="modal-content">
		 <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
		  <h4 class="modal-title"><?php echo $lang['menu_categories'] ?></h4>
		 </div>
		 <div class="panel-body">
		  <form name="category_add" action="/controller/admin/pages/categories/categories.php" method="post" enctype="multipart/form-data">
		   <fieldset>
			<input type="hidden" name="parent_id" value="<?php echo $parent_id ?>" />
			<div class="form-group">
			 <label>Имя:</label></br>
			 <img src="/view/default/admin/images/worldflags/ru.png" alt="Russian" title="Russian" width="16" height="10" />Russian</br>
			 <?php // вывод из массива: name="categories_name[1]" id="categories_name[1] ?>
			 <input class="input-sm form-control" type="text" name="name" id="name" />
			</div>
			<div class="form-group">
			 <label for="image">Изображение:</label></br>
			 <input type="file" name="image" id="image" /> Макс.: 100M
			</div>
			<div class="form-group">
			 <label for="sort_category">Сортировать:</label></br>
			 <input class="input-sm form-control" type="text" name="sort_category" id="sort_category" />
			</div>
			<div class="form-group">
			 <label for="view_category">Отображать </label>
			 <input class="check-box" type="checkbox" name="view_cat" checked>
			</div>
		   </fieldset>
						  
		   <p align="center">
			<input type="hidden" name="subaction" value="confirm" /><button type="submit" class="btn btn-primary btn-xs" /><span class="glyphicon glyphicon-save"></span> <?php echo $lang['save'] ?></button>
			<button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $lang['cancel'] ?></button>
		   </p>
	  
		  </form>
	  
		 </div>
		 <div class="modal-footer">
		 </div>
		</div>
	   </div>
	  </div>
	 </div>



	 <div class="clearfix"></div>
	</h3>
   </div>
	<?php if ($lines == TRUE) { ?>
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
		   <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
		   <div class="log-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
		  </form>
			
		  <form>
		   <input hidden name="i2" value="<?php echo $i ?>">
		   <input hidden name="lines_p2" value="<?php echo $lines_p ?>">
		   <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
		   <div class="log-left"><button type="submit" class="btn btn-primary btn-xs"  action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
		  </form>
	
		 </th>
		</tr>
	   </thead>
	   <tfoot>
		<tr>
		 <th align="left">Групповые действия</th>
		 <th align="right">
		  <div class="log-right"><input class="select-all check-box" type="checkbox" value=""></div>
		  <form><input hidden name="log_delete" value="delete"><div class="log-left"><button type="submit" name="cat_delete_batch" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo $lang['confirm-yes'] ?>" data-btn-cancel-label="<?php echo $lang['confirm-no'] ?>" title="<?php echo $lang['confirm-del'] ?>" action="" formmethod="post"><span class="glyphicon glyphicon-trash"> </span></button></div></form>
		  <div class="log-left"><button class="btn btn-primary btn-xs" title="<?php echo $lang['button_move'] ?>" action="" formmethod="post"><span class="glyphicon glyphicon-transfer"> </span></button></div>
			
		 </th>
		</tr>
	   </tfoot>
	   <tbody id="sort-list">
			
		<?php $parent_up = $lines[0][4]; ?>
		 <?php if ($parent_up > 0) { ?>

		 <tr style="cursor:default;background:none;">
		  <td colspan="2" align="left"><form><div><button name="parent_up" value="<?php echo $parent_up ?>" class="btn btn-default btn-xs" title="" action="/controller/admin/pages/categories/categories.php" formmethod="post">....</button></div></form></td>
		 </tr>
		 
		 <?php } for ($i; $i < $lines_p; $i++) { ?>
		
		 <tr class="sort-list" unitid="<?php echo $lines[$i][0] ?>">
		   <?php if($lines[$i][8] == 0){ ?>
			<td align="left"><form><div><button name="parent_down" value="<?php echo $lines[$i][0] ?>" class="btn btn-default btn-xs" title="<?php echo $lines[$i][1] ?>" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-folder-open"> </span></button> <?php echo $lines[$i][1] ?></div></form></td>	  
		   <?php }else{ ?>
			<td align="left"><form><div><button name="parent_down" value="<?php echo $lines[$i][0] ?>" class="btn btn-primary btn-xs" title="<?php echo $lines[$i][1] ?>" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-folder-open"> </span></button> <?php echo $lines[$i][1] ?></div></form></td>
		   <?php } ?>
		  <td align="right">
		   <div class="log-right"><input class="select-item check-box" type="checkbox" value=""></div>
		   <form><div class="log-left"><button class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo $lang['confirm-yes'] ?>" data-btn-cancel-label="<?php echo $lang['confirm-no'] ?>" title="<?php echo $lang['confirm-del'] ?>" name="cat_delete" value="<?php echo $lines[$i][0] ?>" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-trash"> </span></button></div></form>
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

	<div class="panel-body"><p><?php echo $lang['no_cat'] ?></p>
   	 <div class="table-responsive">
	  <table class="table">
	   <tbody>
		<tr>
		 <td colspan="2" align="left"><form><div><button name="parent_up" value="<?php echo $_POST['parent_down'] ?>" class="btn btn-default btn-xs" title="" action="/controller/admin/pages/categories/categories.php" formmethod="post">....</button></div></form></td>
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