<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
<!-- Модальное окно "Добавить категорию" -->
<div id="addCategory" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><?php echo $lang['menu_categories'] ?></h4>
            </div>
            <form id="form_post" name="form_post" action="javascript:void(null);" onsubmit="call()" method="post" enctype="multipart/form-data">
                <div class="panel-body">
                        <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>" />
                        <div class="form-group">
                            <label><?php echo $lang['name'] ?>:</label><br>
                            <img src="/view/default/admin/images/worldflags/ru.png" alt="Russian" title="Russian" width="16" height="10" />Russian<br>
                            <input class="input-sm form-control" type="text" name="name" id="name" />
                        </div>
                        <div class="form-group">
                            <label for="image"><?php echo $lang['images'] ?>:</label><br>
                            <input type="file" name="image" id="image" /> <?php echo $lang['max'] ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>
                        </div>
                        <div class="form-group">
                            <label for="view_category"><?php echo $lang['display'] ?> </label>
                            <input class="check-box" type="checkbox" name="view_cat" checked>
                        </div>
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

<script type="text/javascript" language="javascript">
    function call() {
        var msg = $('#form_post').serialize();
        $.ajax({
            type: 'POST',
            url: '/controller/admin/pages/stock/categories/categories.php',
            data: msg,
            success: function (data) {
                $('#addCategory').remove();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
                $('#ajax').html(data);
            }
        });
    }
</script>
<!-- КОНЕЦ Модальное окно "Добавить категорию" -->