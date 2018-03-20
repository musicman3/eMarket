<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>
<div id="category_add" class="container">
	<div class="row">
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<h3 class="panel-title">
				      <div class="pull-left"><?php echo $lang['menu_categories'] ?></div>
				      <div class="clearfix"></div>
				</h3>
			</div>

		<div class="panel-body">
		
<form name="category_add" action="/controller/admin/pages/categories/categories.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <div class="form-group">
        <label for="parent_id">Родительская категория:</label></br>
        <select class="input-sm form-control" name="parent_id" id="parent_id"><option value="0" selected="selected">-- Топ --</option><option value="2">Настольные</option><option value="1">Ноутбуки</option></select>
        </div>
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
        <label for="sort_category">Сортировать список:</label></br>
        <input class="input-sm form-control" type="text" name="sort_category" id="sort_category" />
        </div>
    </fieldset>

    <p align="center">
        <input type="hidden" name="subaction" value="confirm" /><button type="submit" class="btn btn-primary btn-xs" /><span class="glyphicon glyphicon-save"></span> Сохранить</button>
        <button type="button" onclick="document.location.href='/controller/admin/pages/categories/categories.php'" class="btn btn-primary btn-xs" /><span class="glyphicon glyphicon-remove"></span> Отмена</button>
    </p>

</form>

			</div>
		</div>
	</div>
</div>