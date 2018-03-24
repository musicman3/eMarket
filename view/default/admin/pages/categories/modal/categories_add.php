<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>
	 <!-- Модальное окно "Добавить категорию" -->
	  <div id="addCategory" class="modal fade" tabindex="-1">
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
	 <!-- КОНЕЦ Модальное окно "Добавить категорию" -->