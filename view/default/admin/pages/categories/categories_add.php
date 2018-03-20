<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>
<form name="category_add" action="/controller/admin/pages/categories/categories.php" method="post" enctype="multipart/form-data">
    <fieldset>
      
        <div><label for="parent_id">Родительская категория:</label><br><select name="parent_id" id="parent_id"><option value="0" selected="selected">-- Топ --</option><option value="2">Настольные</option><option value="1">Ноутбуки</option></select></div>
        <div><br><label>Имя:</label>

            <p><img src="/view/default/admin/images/worldflags/ru.png" alt="Russian" title="Russian" width="16" height="10" />Russian<br />
            
            <?php // вывод из массива: name="categories_name[1]" id="categories_name[1] ?>
            <input type="text" name="name" id="name" /></p>
        </div>
        <div><br><label for="image">Изображение:</label>
        <input type="file" name="image" id="image" /> Макс.: 100M</div>

        <div><br><label for="sort_category">Сортировать список:</label><br>
        <input type="text" name="sort_category" id="sort_category" /></div>
    </fieldset>

    <p align="center">
        <input type="hidden" name="subaction" value="confirm" /><input type="submit" value="Сохранить" class="btn btn-primary btn-xs" /> 
    <input type="button" value="Отмена" onclick="document.location.href='/controller/admin/pages/categories/categories.php'" class="btn btn-primary btn-xs" /></p>

</form>
</div>
</div>