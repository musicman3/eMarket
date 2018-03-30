<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
// 
// собираем данные для отображения в Редактировании категорий
$name_category_edit = $PDO->selectPrepare("SELECT name FROM " . TABLE_CATEGORIES . " WHERE id=?", array($lines[$i][0]));
$status_category_edit = $PDO->selectPrepare("SELECT status FROM " . TABLE_CATEGORIES . " WHERE id=?", array($lines[$i][0]));
if ($status_category_edit == 1) {
    $status_category_edit = 'checked';
} else {
    $status_category_edit = '';
}
?>

<!-- Модальное окно "Редактировать категорию" -->
<div id="<?php echo 'addCategory' . $lines[$i][0] ?>" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><?php echo $lang['menu_categories'] ?></h4>
            </div>
            <form name="category_edit" action="/controller/admin/pages/categories/categories.php" method="post" enctype="multipart/form-data">
                <div class="panel-body">
                    <fieldset>
                        <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>" />
                        <input type="hidden" name="cat_edit" value="<?php echo $lines[$i][0] ?>" />
                        <div class="form-group">
                            <label><?php echo $lang['name'] ?>:</label><br>
                            <img src="/view/default/admin/images/worldflags/ru.png" alt="Russian" title="Russian" width="16" height="10" />Russian<br>
                            <?php // вывод из массива: name="categories_name[1]" id="categories_name[1]  ?>
                            <input class="input-sm form-control" type="text" name="name_edit" id="name" value="<?php echo $name_category_edit ?>" />
                        </div>
                        <div class="form-group">
                            <label for="image"><?php echo $lang['images'] ?>:</label><br>
                            <input type="file" name="image" id="image" /> <?php echo $lang['max'] ?>: 100M
                        </div>
                        <div class="form-group">
                            <label for="view_category"><?php echo $lang['display'] ?> </label>
                            <input class="check-box" type="checkbox" name="view_cat" <?php echo $status_category_edit ?>>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="subaction" value="confirm" />
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-save"></span> <?php echo $lang['save'] ?></button>
                    <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $lang['cancel'] ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Редактировать категорию" -->