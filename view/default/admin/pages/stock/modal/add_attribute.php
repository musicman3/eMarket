<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить атрибут" -->
<div id="add_attribute" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Заполните карточку категорий" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title">Добавить новый атрибут</h4>
            </div>
            <div class="panel-body">

                <div class="form-group">
                    <div class="input-group has-success">
                        <span class="input-group-addon"><img src="/view/<?php echo \eMarket\Set::template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[0] ?>.png" alt="<?php echo lang('#lang_all')[0] ?>" title="<?php echo lang('#lang_all')[0] ?>" width="16" height="10" /></span>
                        <input id="attribute_<?php echo lang('#lang_all')[0] ?>" class="input-add-attribute input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="atribute_val_[]" required />
                    </div>
                </div>

                <?php
                if ($LANG_COUNT > 1) {
                    for ($x = 1; $x < $LANG_COUNT; $x++) {
                        ?>
                        <div class="form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><img src="/view/<?php echo \eMarket\Set::template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[$x] ?>.png" alt="<?php echo lang('#lang_all')[$x] ?>" title="<?php echo lang('#lang_all')[$x] ?>" width="16" height="10" /></span>
                                <input id="attribute_<?php echo lang('#lang_all')[$x] ?>" class="input-add-attribute input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="atribute_val_[]" required />
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                <button id="add_attribute_button" type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Добавить атрибут" -->
