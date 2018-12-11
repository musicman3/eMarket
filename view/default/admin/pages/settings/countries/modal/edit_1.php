<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* ЗАМЕТКИ
 * 
$name_edit_json = json_encode($name_edit);

<div id="name_edit_json"></div>

<script type="text/javascript" language="javascript">
     var name_edit = <?php echo $name_edit_json ?>;
     
     document.getElementById("name_edit_json").innerHTML = name_edit[0];
</script>

<?php echo $lines[$k][0] ?>
 * 
 * 
 * 
 * 
 */





//ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
$js_id = $lines[$k][0]; // ID, передать по ссылке типа data-whatever="@mdo"

$js_lang_all = lang('#lang_all')[0]; // Язык по умолчанию
$js_xl = $xl; // номер по циклу от count(lang('#lang_all'))
$js_name_edit = $name_edit[0]; // Имя на языке по умолчанию
$js_name_edit_xl = $name_edit[$xl]; // Имя на других языках
$js_value_edit = $value_edit; //alpha_2_edit
$js_value_edit2 = $value_edit2; //alpha_3_edit
$js_value_edit3 = $value_edit3; //address_format
?>

<!-- Модальное окно "Изменить" -->
<div id="edit" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Ставка указывается в формате: 10.00" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_'. $SET->titleDir() .'_index') ?></h4>
            </div>
            <form id="form" name="form" action="index.php" onsubmit="$('.modal').modal('hide')" method="get" enctype="multipart/form-data">
                <div class="panel-body">
                    <input type="hidden" name="edit" value="<?php echo $js_id ?>" />
                    
                    <!-- Языковые панели -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#<?php echo lang('#lang_all')[0] . $js_id ?>"><img src="/view/<?php echo $SET->template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[0] ?>.png" alt="<?php echo lang('#lang_all')[0] ?>" title="<?php echo lang('#lang_all')[0] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[0]) ?></a></li>

                        <?php
                        if (count(lang('#lang_all')) > 1) {
                            for ($xl = 1; $xl < count(lang('#lang_all')); $xl++) {

                                ?>

                                <li><a data-toggle="tab" href="#<?php echo lang('#lang_all')[$xl] . $js_id ?>"><img src="/view/<?php echo $SET->template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[$xl] ?>.png" alt="<?php echo lang('#lang_all')[$xl] ?>" title="<?php echo lang('#lang_all')[$xl] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[$xl]) ?></a></li>

                                <?php
                            }
                        }

                        ?>

                    </ul>

                    <!-- Содержимое языковых панелей -->
                    <div class="tab-content">
                        <div id="<?php echo lang('#lang_all')[0] . $js_id ?>" class="tab-pane fade in active">
                            <div class="form-group">
                                <div class="input-group has-error">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" type="text" name="name_edit_<?php echo $SET->titleDir() . '_' . lang('#lang_all')[0] ?>" id="name_edit<?php echo lang('#lang_all')[0] ?>" value="<?php echo $name_edit[0] ?>" />
                                </div>
                            </div>
                        </div>

                        <?php
                        if (count(lang('#lang_all')) > 1) {
                            for ($xl = 1; $xl < count(lang('#lang_all')); $xl++) {

                                ?>

                                <div id="<?php echo lang('#lang_all')[$xl] . $js_id ?>" class="tab-pane fade">
                                    <div class="form-group">
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" type="text" name="name_edit_<?php echo $SET->titleDir() . '_' . lang('#lang_all')[$xl] ?>" id="name_edit<?php echo lang('#lang_all')[$xl] ?>" value="<?php echo $name_edit[$xl] ?>" />
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        }

                        ?>

                        <div class="form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                <input class="input-sm form-control" type="text" name="alpha_2_edit" id="alpha_2_edit" value="<?php echo $value_edit ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                <input class="input-sm form-control" type="text" name="alpha_3_edit" id="alpha_3_edit" value="<?php echo $value_edit_2 ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address_format"><?php echo lang('address_format') ?></label>
                            <textarea class="form-control" rows="5" name="address_format" id="address_format"><?php echo $value_edit_3 ?></textarea>
                        </div> 
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Изменить" -->