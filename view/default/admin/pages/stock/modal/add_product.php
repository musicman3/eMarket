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
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Заполните карточку товара" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_' . $SET->titleDir() . '_index') ?></h4>
            </div>
            <form id="form_add_product" name="form_add_product" action="javascript:void(null);" onsubmit="callAddProduct()">
                <div class="panel-body">
                    <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>" />
                    <input type="hidden" name="add_product" value="ok" />
                    <input id="general_image_add_product" type="hidden" name="general_image_add_product" value="">

                    <!-- Панели формы -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#panel_add_1">Описание</a></li>
                        <li><a data-toggle="tab" href="#panel_add_2">Основное</a></li>
                        <li><a data-toggle="tab" href="#panel_add_3">Дополнительное</a></li>
                        <li><a data-toggle="tab" href="#panel_add_4">Изображения</a></li>
                    </ul>

                    <!-- Содержимое панелей формы-->
                    <div class="tab-content">

                        <!-- Содержимое панели Описание -->
                        <div id="panel_add_1" class="tab-pane fade in active">

                            <!-- Языковые панели -->
                            <?php require_once(ROOT . '/view/' . $SET->template() . '/layouts/lang_tabs_add_product.php') ?>

                            <!-- Содержимое языковых панелей -->
                            <div class="tab-content">
                                <div id="product_<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
                                    <div class="form-group">
                                        <div><small class="form-text text-muted">Название товара</small></div>
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_product_stock_0" id="name_product_stock_0" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div><small class="form-text text-muted">Описание товара</small></div>
                                        <textarea rows="3" class="input-sm form-control summernote_add" name="description_product_stock_0" id="description_product_stock_0" /></textarea>
                                    </div>
                                    <div class="col-left">
                                        <div><small class="form-text text-muted">Keywords для поисковой оптимизации</small></div>
                                        <div class="input-group has-success">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="Keywords" type="text" name="keyword_product_stock_0" id="keyword_product_stock_0" />
                                        </div>
                                    </div>
                                    <div class="col-right">
                                        <div><small class="form-text text-muted">Tags для поисковой оптимизации</small></div>
                                        <div class="input-group has-success">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="Tags" type="text" name="tags_product_stock_0" id="tags_product_stock_0" />
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if ($LANG_COUNT > 1) {
                                    for ($x = 1; $x < $LANG_COUNT; $x++) {

                                        ?>

                                        <div id="product_<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                            <div class="form-group">
                                                <div><small class="form-text text-muted">Название товара</small></div>
                                                <div class="input-group has-error">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_product_stock_<?php echo $x ?>" id="name_product_stock_<?php echo $x ?>" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div><small class="form-text text-muted">Описание товара</small></div>
                                                <textarea rows="3" class="input-sm form-control summernote_add" name="description_product_stock_<?php echo $x ?>" id="description_product_stock_<?php echo $x ?>" /></textarea>
                                            </div>
                                            <div class="col-left">
                                                <div><small class="form-text text-muted">Keywords для поисковой оптимизации</small></div>
                                                <div class="input-group has-success">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="Keywords" type="text" name="keyword_product_stock_<?php echo $x ?>" id="keyword_product_stock_<?php echo $x ?>" />
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <div><small class="form-text text-muted">Tags для поисковой оптимизации</small></div>
                                                <div class="input-group has-success">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="Tags" type="text" name="tags_product_stock_<?php echo $x ?>" id="tags_product_stock_<?php echo $x ?>" />
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
                        <div id="panel_add_2" class="tab-pane fade">
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Цена товара</small></div>
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="0.00" type="text" name="price_product_stock" id="price_product_stock" required />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Тип валюты</small></div>
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-euro"></span></span>
                                        <select name="currency_product_stock" id="currency_product_stock" class="input-sm form-control">
                                            <?php $SET->viewSelect($currencies_all) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Количество на складе</small></div>
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="1" type="text" name="quantity_product_stock" id="quantity_product_stock" required />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Единица измерения количества</small></div>
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
                                        <select name="unit_product_stock" id="unit_product_stock" class="input-sm form-control">
                                            <?php $SET->viewSelect($units_all) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Модель товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input class="input-sm form-control" placeholder="ABC123" type="text" name="model_product_stock" id="model_product_stock" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Производитель товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-object-align-bottom"></span></span>
                                        <select name="manufacturers_product_stock" id="manufacturers_product_stock" class="input-sm form-control">
                                            <?php $SET->viewSelect($manufacturers_all) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Дата поступления товара на склад</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        <input class="input-sm form-control" placeholder="Дата поступления" type="text" name="date_available_product_stock" id="date_available_product_stock" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Тип налога</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span></span>
                                        <select name="tax_product_stock" id="tax_product_stock" class="input-sm form-control">
                                            <?php $SET->viewSelect($taxes_all) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <!-- Содержимое панели Дополнительное -->
                        <div id="panel_add_3" class="tab-pane fade">
                            <div class="row">
                                <div class="col-left form-group">
                                    <div><small class="form-text text-muted">Значение идентификатора товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input class="input-sm form-control" placeholder="ABC123" type="text" name="vendor_code_value_product_stock" id="vendor_code_value_product_stock" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Тип идентификатора</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
                                        <select name="vendor_codes_product_stock" id="vendor_codes_product_stock" class="input-sm form-control">
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
                                        <input class="input-sm form-control" placeholder="0.00" type="text" name="weight_value_product_stock" id="weight_value_product_stock" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Единица измерения веса</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-scale"></span></span>
                                        <select name="weight_product_stock" id="weight_product_stock" class="input-sm form-control">
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
                                        <input class="input-sm form-control" placeholder="1" type="text" name="min_quantity_product_stock" id="min_quantity_product_stock" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div><small class="form-text text-muted">Единица измерения длины</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-road"></span></span>
                                        <select name="length_product_stock" id="length_product_stock" class="input-sm form-control">
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
                                        <input class="input-sm form-control" placeholder="0.00" type="text" name="value_length_product_stock" id="value_length_product_stock" />
                                    </div>
                                </div>
                                <div class="col-left-w form-group">
                                    <div><small class="form-text text-muted">Ширина товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="0.00" type="text" name="value_width_product_stock" id="value_width_product_stock" />
                                    </div>
                                </div>
                                <div class="col-right-w form-group">
                                    <div><small class="form-text text-muted">Высота товара</small></div>
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="0.00" type="text" name="value_height_product_stock" id="value_height_product_stock" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Содержимое панели Изображения -->
                        <div id="panel_add_4" class="tab-pane fade">

                            <!-- Выводим сообщения -->
                            <div id="alert_messages_add_product"></div>

                            <!-- ЗАГРУЗКА jQuery-File-Upload -->
                            <div class="form-group">
                                <span class="btn btn-primary btn-sm fileinput-button">
                                    <i class="glyphicon glyphicon-picture"></i><span> <?php echo lang('button_add_image') ?></span>
                                    <input class="input-sm form-control" id="fileupload-add-product" type="file" name="files[]" accept="image/jpeg,image/png,image/gif" multiple>
                                </span>
                                <?php echo lang('max') ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>
                                <br>
                                <br>
                                <div><small class="form-text text-muted">Эффекты для обработки изображения</small></div>
                                <div class="input-group has-success">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-adjust"></span></span>
                                    <select name="effect-add-product" id="effect-add-product" class="input-sm form-control">
                                        <option value="effect-off" selected>Нет эффектов</option>
                                        <option value="effect-sepia">Сепия</option>
                                        <option value="effect-black-white">Чёрно-белое</option>
                                        <option value="effect-blur-1">Размытие 1</option>
                                        <option value="effect-blur-2">Размытие 2</option>
                                    </select>
                                </div>
                                <br>
                                <div id="progress_add_product" class="progress">
                                    <div class="progress-bar progress-bar-warning progress-bar-striped active"></div>
                                </div>
                                <div id="logo-add-product" class="text-center"></div>
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