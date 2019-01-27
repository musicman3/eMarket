<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Модальное окно "Добавить" -->
<div id="add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Ставка указывается в формате: 10.00" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_'. $SET->titleDir() .'_index') ?></h4>
            </div>
            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="callAdd()">
                <div class="panel-body">
                    <input type="hidden" name="add" value="ok" />

                    <!-- Языковые панели -->
                    <?php require_once(ROOT . '/view/' . $SET->template() . '/layouts/lang_tabs_add.php') ?>

                    <!-- Содержимое языковых панелей -->
                    <div class="tab-content">
                        <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
                            <div class="form-group">
                                <div class="input-group has-error">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo lang('name_country') ?>" type="text" name="name_countries_0" id="name_countries_0" required />
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($LANG_COUNT > 1) {
                            for ($x = 1; $x < $LANG_COUNT; $x++) {

                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                    <div class="form-group">
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name_country') ?>" type="text" name="name_countries_<?php echo $x ?>" id="name_countries_<?php echo $x ?>" required />
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
                                <input class="input-sm form-control" placeholder="<?php echo lang('alpha_2') ?>" type="text" name="alpha_2_countries" id="alpha_2_countries" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('alpha_3') ?>" type="text" name="alpha_3_countries" id="alpha_3_countries" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address_format"><?php echo lang('address_format') ?></label>
                            <textarea class="form-control" placeholder="<?php echo lang('add_address_format') ?>" rows="5" name="address_format_countries" id="address_format_countries"></textarea>
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
<!-- КОНЕЦ Модальное окно "Добавить" -->