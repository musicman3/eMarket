<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

<p>Пожалуйста, заполните необходимую информацию в поле для новой категории.</p>

  <fieldset>
    <div><label for="parent_id">Родительская категория:</label><select name="parent_id" id="parent_id"><option value="0" selected="selected">-- Топ --</option><option value="2">Настольные</option><option value="1">Ноутбуки</option></select></div>
    <div><label>Имя:</label>

<p><img src="../images/worldflags/ru.png" alt="Russian" title="Russian" width="16" height="10" />&nbsp;Russian<br /><input type="text" name="categories_name[1]" id="categories_name[1]" /></p>
    </div>
    <div><label for="categories_image">Изображение:</label><input type="file" name="categories_image" id="categories_image" />&nbsp;Макс.: 100M</div>
    <div><label for="sort_order">Сортировать список:</label><input type="text" name="sort_order" id="sort_order" /></div>
  </fieldset>

  <p align="center"><input type="hidden" name="subaction" value="confirm" /><input type="submit" value="Сохранить" class="btn btn-primary btn-xs" /> <input type="button" value="Отмена" onclick="document.location.href='http://emarket.com/admin/index.php?categories=';" class="btn btn-primary btn-xs" /></p>

  </form>
</div>
</div>