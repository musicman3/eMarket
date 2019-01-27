<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Модальное окно "Добавить товар" -->
<div id="add_product" class="products modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Заполните карточку товара" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_' . $SET->titleDir() . '_index') ?></h4>
            </div>
            <form id="form_add_product" name="form_add_product" action="javascript:void(null);" onsubmit="callAddProduct()">
                <div class="panel-body">
                    <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>" />
                    <input type="hidden" name="add_product" value="ok" />
                    <input id="general_image_add_product" type="hidden" name="general_image_add_product" value="">

                    <!-- Панели формы -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#panel_add_1">Основное</a></li>
                        <li><a data-toggle="tab" href="#panel_add_2">Данные</a></li>
                        <li><a data-toggle="tab" href="#panel_add_3">Изображения</a></li>
                    </ul>

                    <!-- Содержимое панелей формы-->
                    <div class="tab-content">

                        <!-- Содержимое панели основное -->
                        <div id="panel_add_1" class="tab-pane fade in active">

                            <!-- Языковые панели -->
                            <?php require_once(ROOT . '/view/' . $SET->template() . '/layouts/lang_tabs_add_product.php') ?>

                            <!-- Содержимое языковых панелей -->
                            <div class="tab-content">
                                <div id="product_<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
                                    <div class="form-group">
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="product_name_0" id="product_name_0" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo lang('product_description') ?>:</label><br>
                                        <textarea rows="3" class="input-sm form-control summernote_add" name="product_description_0" id="product_description_0" /></textarea>
                                    </div>
                                    <div class="col-left">
                                        <div class="input-group has-success">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="Keyword" type="text" name="product_keyword_0" id="product_keyword_0" />
                                        </div>
                                    </div>
                                    <div class="col-right">
                                        <div class="input-group has-success">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="Tags" type="text" name="product_tags_0" id="product_tags_0" />
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if ($LANG_COUNT > 1) {
                                    for ($x = 1; $x < $LANG_COUNT; $x++) {

                                        ?>

                                        <div id="product_<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                            <div class="form-group">
                                                <div class="input-group has-error">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="product_name_<?php echo $x ?>" id="product_name_<?php echo $x ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo lang('product_description') ?>:</label><br>
                                                <textarea rows="3" class="input-sm form-control summernote_add" name="product_description_<?php echo $x ?>" id="product_description_<?php echo $x ?>" /></textarea>
                                            </div>
                                            <div class="col-left">
                                                <div class="input-group has-success">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="Keyword" type="text" name="product_keyword_<?php echo $x ?>" id="product_keyword_<?php echo $x ?>" />
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <div class="input-group has-success">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="Tags" type="text" name="product_tags_<?php echo $x ?>" id="product_tags_<?php echo $x ?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                }

                                ?>

                            </div>
                        </div>

                        <!-- Содержимое панели Данные -->
                        <div id="panel_add_2" class="tab-pane fade">
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="<?php echo lang('product_price') ?>" type="text" name="product_price" id="product_price" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="product_tax" id="product_tax" class="input-sm form-control">
                                            <option selected hidden>-- Налог --</option>
                                            <?php for ($x = 0; $x < count($taxes_all); $x++) { ?>

                                                <option><?php echo $taxes_all[$x] ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="<?php echo lang('product_quantity') ?>" type="text" name="product_quantity" id="product_quantity" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="product_unit" id="product_unit" class="input-sm form-control">
                                            <option disabled selected hidden>-- <?php echo lang('product_unit') ?> --</option>
                                            <?php for ($x = 0; $x < count($units_all); $x++) { ?>

                                                <option><?php echo $units_all[$x] ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input class="input-sm form-control" placeholder="Модель" type="text" name="product_model" id="product_model" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        <input class="input-sm form-control data" placeholder="Дата поступления" type="text" name="product_date_available" id="product_date_available" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="product_manufacturers" id="product_manufacturers" class="input-sm form-control">
                                            <option selected hidden>-- Производитель --</option>
                                            <?php for ($x = 0; $x < count($manufacturers_all); $x++) { ?>

                                                <option><?php echo $manufacturers_all[$x] ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="product_code" id="product_code" class="input-sm form-control">
                                            <option disabled selected hidden>-- Штриховые коды --</option>
                                            <option>Нет</option>                                        
                                            <option>Barcode</option>
                                            <option>QR-code</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="product_vendor_codes" id="product_vendor_codes" class="input-sm form-control">
                                            <option selected hidden>-- Идентификатор --</option>
                                            <?php for ($x = 0; $x < count($vendor_codes_all); $x++) { ?>

                                                <option><?php echo $vendor_codes_all[$x] ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input class="input-sm form-control" placeholder="Значение идентификатора" type="text" name="product_vendor_code_value" id="product_vendor_code_value" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="product_weight" id="product_weight" class="input-sm form-control">
                                            <option selected hidden>-- Вес --</option>
                                            <?php for ($x = 0; $x < count($weight_all); $x++) { ?>

                                                <option><?php echo $weight_all[$x] ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="Значение веса" type="text" name="product_value_weight" id="product_value_weight" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="Минимальное количество" type="text" name="product_min_quantity" id="product_min_quantity" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="product_length" id="product_length" class="input-sm form-control">
                                            <option selected hidden>-- Размер --</option>
                                            <?php for ($x = 0; $x < count($length_all); $x++) { ?>

                                                <option><?php echo $length_all[$x] ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left-w form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="Длина" type="text" name="product_value_length" id="product_value_length" />
                                    </div>
                                </div>
                                <div class="col-left-w form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="Ширина" type="text" name="product_value_width" id="product_value_width" />
                                    </div>
                                </div>
                                <div class="col-right-w form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="Высота" type="text" name="product_value_height" id="product_value_height" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Содержимое панели Изображения -->
                        <div id="panel_add_3" class="tab-pane fade">
                            <div class="form-group">
                                <label for="image"><?php echo lang('images') ?>:</label><br>
                            </div>
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
<!-- КОНЕЦ Модальное окно "Добавить категорию" -->