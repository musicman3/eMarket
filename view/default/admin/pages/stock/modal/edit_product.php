<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

require(ROOT . '/controller/admin/pages/stock/modal/edit_product.php');
?>
<!-- Модальное окно "Добавить товар" -->
<div id="edit_product" class="products modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Заполните карточку товара" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_' . $SET->titleDir() . '_index') ?></h4>
            </div>
            <form id="form_edit_product" name="form_edit_product" action="javascript:void(null);" onsubmit="callEditProduct()">
                <div class="panel-body">
                    <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>" />
                    <input id="js_edit_product" type="hidden" name="edit_product" value="" />
                    <input id="delete_image_product" type="hidden" name="delete_image_product" value="" />
                    <input id="general_image_edit_product" type="hidden" name="general_image_edit_product" value="" />
                    <input id="general_image_edit_new_product" type="hidden" name="general_image_edit_new_product" value="" />

                    <!-- Панели формы -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#panel_edit_1">Описание</a></li>
                        <li><a data-toggle="tab" href="#panel_edit_2">Основное</a></li>
                        <li><a data-toggle="tab" href="#panel_edit_3">Дополнительное</a></li>
                        <li><a data-toggle="tab" href="#panel_edit_4">Изображения</a></li>
                    </ul>

                    <!-- Содержимое панелей формы-->
                    <div class="tab-content">

                        <!-- Содержимое панели Описание -->
                        <div id="panel_edit_1" class="tab-pane fade in active">

                            <!-- Языковые панели -->
                            <?php require_once(ROOT . '/view/' . $SET->template() . '/layouts/lang_tabs_edit_product.php') ?>

                            <!-- Содержимое языковых панелей -->
                            <div class="tab-content">
                                <div id="productEdit_<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
                                    <div class="form-group">
                                        <div><small class="form-text text-muted">Название товара</small></div>
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_product_stock_edit_0" id="name_product_stock_edit_0" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div><small class="form-text text-muted">Описание товара</small></div>
                                        <textarea rows="3" class="input-sm form-control summernote_edit" name="description_product_stock_edit_0" id="description_product_stock_edit_0" /></textarea>
                                    </div>
                                    <div class="col-left">
                                        <div><small class="form-text text-muted">Keywords для поисковой оптимизации</small></div>
                                        <div class="input-group has-success">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="Keywords" type="text" name="keyword_product_stock_edit_0" id="keyword_product_stock_edit_0" />
                                        </div>
                                    </div>
                                    <div class="col-right">
                                        <div><small class="form-text text-muted">Tags для поисковой оптимизации</small></div>
                                        <div class="input-group has-success">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="Tags" type="text" name="tags_product_stock_edit_0" id="tags_product_stock_edit_0" />
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if ($LANG_COUNT > 1) {
                                    for ($x = 1; $x < $LANG_COUNT; $x++) {

                                        ?>

                                        <div id="productEdit_<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                            <div class="form-group">
                                                <div><small class="form-text text-muted">Название товара</small></div>
                                                <div class="input-group has-error">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_product_stock_edit_<?php echo $x ?>" id="name_product_stock_edit_<?php echo $x ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div><small class="form-text text-muted">Описание товара</small></div>
                                                <textarea rows="3" class="input-sm form-control summernote_edit" name="description_product_stock_edit_<?php echo $x ?>" id="description_product_stock_edit_<?php echo $x ?>" /></textarea>
                                            </div>
                                            <div class="col-left">
                                                <div><small class="form-text text-muted">Keywords для поисковой оптимизации</small></div>
                                                <div class="input-group has-success">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="Keyword" type="text" name="keyword_product_stock_edit_<?php echo $x ?>" id="keyword_product_stock_edit_<?php echo $x ?>" />
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <div><small class="form-text text-muted">Tags для поисковой оптимизации</small></div>
                                                <div class="input-group has-success">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="Tags" type="text" name="tags_product_stock_edit_<?php echo $x ?>" id="tags_product_stock_edit_<?php echo $x ?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                }

                                ?>

                            </div>
                        </div>

                        <!-- Содержимое панели Основное -->
                        <div id="panel_edit_2" class="tab-pane fade">
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Цена товара</small></div>
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="0.00" type="text" name="price_product_stock_edit" id="price_product_stock_edit" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Тип валюты</small></div>
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-euro"></span></span>
                                        <select name="currency_product_stock_edit" id="currency_product_stock_edit" class="input-sm form-control">
                                            <?php $SET->viewSelect($currencies_all, $currencies_all[2], false) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Количество на складе</small></div>
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="1" type="text" name="quantity_product_stock_edit" id="quantity_product_stock_edit" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Единица измерения количества</small></div>
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
                                        <select name="unit_product_stock_edit" id="unit_product_stock_edit" class="input-sm form-control">
                                            <?php $SET->viewSelect($units_all, $units_all[2], false) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Модель товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input class="input-sm form-control" placeholder="ABC123" type="text" name="model_product_stock_edit" id="model_product_stock_edit" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Производитель товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-object-align-bottom"></span></span>
                                        <select name="manufacturers_product_stock_edit" id="manufacturers_product_stock_edit" class="input-sm form-control">
                                            <?php $SET->viewSelect($manufacturers_all, $manufacturers_all[1], false) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Дата поступления товара на склад</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        <input class="input-sm form-control data" placeholder="Дата поступления" type="text" name="date_available_product_stock_edit" id="date_available_product_stock_edit" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Тип налога</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span></span>
                                        <select name="tax_product_stock_edit" id="tax_product_stock_edit" class="input-sm form-control">
                                            <?php $SET->viewSelect($taxes_all, $taxes_all[1], false) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <!-- Содержимое панели Дополнительное -->
                        <div id="panel_edit_3" class="tab-pane fade">
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Значение идентификатора товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input class="input-sm form-control" placeholder="ABC123" type="text" name="vendor_code_value_product_stock_edit" id="vendor_code_value_product_stock_edit" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Тип идентификатора</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
                                        <select name="vendor_codes_product_stock_edit" id="vendor_codes_product_stock_edit" class="input-sm form-control">
                                            <?php $SET->viewSelect($vendor_codes_all) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Вес товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="0.00" type="text" name="value_weight_product_stock_edit" id="value_weight_product_stock_edit" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Единица измерения веса</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-scale"></span></span>
                                        <select name="weight_product_stock_edit" id="weight_product_stock_edit" class="input-sm form-control">
                                            <?php $SET->viewSelect($weight_all) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Минимальное количество для заказа</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="1" type="text" name="min_quantity_product_stock_edit" id="min_quantity_product_stock_edit" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Единица измерения длины</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-road"></span></span>
                                        <select name="length_product_stock_edit" id="length_product_stock_edit" class="input-sm form-control">
                                            <?php $SET->viewSelect($length_all) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left-w form-group">
                                    <div><small class="form-text text-muted">Длина товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="0.00" type="text" name="value_length_product_stock_edit" id="value_length_product_stock_edit" />
                                    </div>
                                </div>
                                <div class="col-left-w form-group">
                                    <div><small class="form-text text-muted">Ширина товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="0.00" type="text" name="value_width_product_stock_edit" id="value_width_product_stock_edit" />
                                    </div>
                                </div>
                                <div class="col-right-w form-group">
                                    <div><small class="form-text text-muted">Высота товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="0.00" type="text" name="value_height_product_stock_edit" id="value_height_product_stock_edit" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Содержимое панели Изображения -->
                        <div id="panel_edit_4" class="tab-pane fade">
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