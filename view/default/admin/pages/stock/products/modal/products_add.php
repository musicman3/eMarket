<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
?>
<!-- Модальное окно "Добавить товар" -->
<div id="addProduct" class="products modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Красные поля обязательны для заполнения" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title">Добавить товар</h4>
            </div>
            <form id="form_post" name="form_post" action="javascript:void(null);" onsubmit="call()" method="post" enctype="multipart/form-data">
                <div class="panel-body">

                    <!-- Панели формы -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#panel1">Основное</a></li>
                        <li><a data-toggle="tab" href="#panel2">Данные</a></li>
                        <li><a data-toggle="tab" href="#panel3">Изображения</a></li>
                    </ul>

                    <!-- Содержимое панелей формы-->
                    <div class="tab-content">
                        <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>" />

                        <!-- Содержимое панели основное -->
                        <div id="panel1" class="tab-pane fade in active">

                            <!-- Языковые панели -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#<?php echo $lang_all[0] ?>"><img src="/view/<?php echo $TEMPLATE ?>/admin/images/langflags/<?php echo $lang_all[0] ?>.png" alt="<?php echo $lang_all[0] ?>" title="<?php echo $lang_all[0] ?>" width="16" height="10" /> <?php echo lang('menu_language') ?></a></li>

                                <?php
                                if (count($lang_all) > 1) {
                                    for ($xl = 1; $xl < count($lang_all); $xl++) {
                                        ?>

                                        <li><a data-toggle="tab" href="#<?php echo $lang_all[$xl] ?>"><img src="/view/<?php echo $TEMPLATE ?>/admin/images/langflags/<?php echo $lang_all[$xl] ?>.png" alt="<?php echo $lang_all[$xl] ?>" title="<?php echo $lang_all[$xl] ?>" width="16" height="10" /> <?php echo $lang_all[$xl] ?></a></li>

                                        <?php
                                    }
                                }
                                ?>

                            </ul>

                            <!-- Содержимое языковых панелей -->
                            <div class="tab-content">
                                <div id="<?php echo $lang_all[0] ?>" class="tab-pane fade in active">
                                    <div class="form-group">
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name" id="name" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo lang('product_description') ?>:</label><br>
                                        <textarea rows="3" class="input-sm form-control" name="description" id="description" /></textarea>
                                    </div>
                                    <div class="col-left">
                                        <div class="input-group has-success">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="Keyword" type="text" name="keyword" id="keyword" />
                                        </div>
                                    </div>
                                    <div class="col-right">
                                        <div class="input-group has-success">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="Tags" type="text" name="tags" id="tags" />
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if (count($lang_all) > 1) {
                                    for ($xl = 1; $xl < count($lang_all); $xl++) {
                                        ?>

                                        <div id="<?php echo $lang_all[$xl] ?>" class="tab-pane fade">
                                            <div class="form-group">
                                                <div class="input-group has-error">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name1" id="name1" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo lang('product_description') ?>:</label><br>
                                                <textarea rows="3" class="input-sm form-control" name="description1" id="description1" /></textarea>
                                            </div>
                                            <div class="col-left">
                                                <div class="input-group has-success">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="Keyword" type="text" name="keyword1" id="keyword1" />
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <div class="input-group has-success">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="Tags" type="text" name="tags1" id="tags1" />
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
                        <div id="panel2" class="tab-pane fade">
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="<?php echo lang('product_price') ?>" type="text" name="price" id="price" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="tax" id="tax" class="input-sm form-control">
                                            <option selected hidden>-- Налог --</option>
                                            <?php
                                            for ($tx = 0; $tx < count($taxes_all); $tx++) {
                                                ?>

                                                <option><?php echo $taxes_all[$tx] ?></option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="<?php echo lang('product_quantity') ?>" type="text" name="quantity" id="quantity" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="unit" id="unit" class="input-sm form-control">
                                            <option disabled selected hidden>-- <?php echo lang('product_unit') ?> --</option>
                                            <?php
                                            for ($un = 0; $un < count($units_all); $un++) {
                                                ?>

                                                <option><?php echo $units_all[$un] ?></option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input class="input-sm form-control" placeholder="Модель" type="text" name="model" id="model" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        <input class="input-sm form-control data" placeholder="Дата поступления" type="text" name="date_available" id="date_available" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="manufacturer" id="manufacturer" class="input-sm form-control">
                                            <option disabled selected hidden>-- Производитель --</option>
                                            <option>Acer</option>
                                            <option>Asus</option>
                                            <option>Intel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="code" id="code" class="input-sm form-control">
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
                                        <select name="product_code" id="product_code" class="input-sm form-control">
                                            <option disabled selected hidden>-- Идентификатор --</option>
                                            <option>Нет</option>
                                            <option>Артикул</option>
                                            <option>SCU</option>
                                            <option>UPC</option>
                                            <option>EAN</option>
                                            <option>JAN</option>
                                            <option>ISBN</option>
                                            <option>MPN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input class="input-sm form-control" placeholder="Значение идентификатора" type="text" name="product_code_value" id="product_code_value" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="unit_weight" id="unit_weight" class="input-sm form-control">
                                            <option disabled selected hidden>-- Вес --</option>
                                            <option>кг.</option>
                                            <option>гр.</option>
                                            <option>унц.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="Значение веса" type="text" name="weight" id="weight" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="Минимальное количество" type="text" name="min_quantity" id="min_quantity" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="unit_lenght" id="unit_lenght" class="input-sm form-control">
                                            <option disabled selected hidden>-- Размер --</option>
                                            <option>мм</option>
                                            <option>см</option>
                                            <option>м</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left-w form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="Длина" type="text" name="length" id="length" />
                                    </div>
                                </div>
                                <div class="col-left-w form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="Ширина" type="text" name="width" id="width" />
                                    </div>
                                </div>
                                <div class="col-right-w form-group">
                                    <div class="input-group has-success">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                        <input class="input-sm form-control" placeholder="Высота" type="text" name="height" id="height" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Содержимое панели Изображения -->
                        <div id="panel3" class="tab-pane fade">
                            <div class="form-group">
                                <label for="image"><?php echo lang('images') ?>:</label><br>
                                <label class="btn btn-primary btn-xs" for="my-file-selector">
                                    <input id="my-file-selector" multiple="multiple" name="files[]" accept="image" type="file" style="display:none;"><span class="glyphicon glyphicon-download-alt"></span> Загрузить
                                </label><br>
                                    <?php echo lang('max') ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>
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

<script type="text/javascript" language="javascript">
    function call() {
        tinyMCE.triggerSave();
        var msg = $('#form_post').serialize();
        $.ajax({
            type: 'POST',
            url: '/controller/admin/pages/stock/products/products.php',
            data: msg,
            success: function (data) {
                $('#addProduct').remove();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
                $('#ajax').html(data);
            }
        });
    }
</script>
<!-- КОНЕЦ Модальное окно "Добавить категорию" -->
