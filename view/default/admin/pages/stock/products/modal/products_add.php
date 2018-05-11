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
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Заполните карточку товара" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title">Налоги</h4>
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
                                <li class="active"><a data-toggle="tab" href="#<?php echo $lang_all[0] ?>"><img src="/view/default/admin/images/langflags/<?php echo $lang_all[0] ?>.png" alt="<?php echo $lang_all[0] ?>" title="<?php echo $lang_all[0] ?>" width="16" height="10" /> <?php echo $lang['menu_language'] ?></a></li>

                                <?php
                                if (count($lang_all) > 1) {
                                    for ($xl = 1; $xl < count($lang_all); $xl++) {

                                        ?>

                                        <li><a data-toggle="tab" href="#<?php echo $lang_all[$xl] ?>"><img src="/view/default/admin/images/langflags/<?php echo $lang_all[$xl] ?>.png" alt="<?php echo $lang_all[$xl] ?>" title="<?php echo $lang_all[$xl] ?>" width="16" height="10" /> <?php echo $lang_all[$xl] ?></a></li>

                                        <?php
                                    }
                                }

                                ?>

                            </ul>

                            <!-- Содержимое языковых панелей -->
                            <div class="tab-content">
                                <div id="<?php echo $lang_all[0] ?>" class="tab-pane fade in active">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo $lang['name'] ?>" type="text" name="name" id="name" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['product_description'] ?>:</label><br>
                                        <textarea rows="3" class="input-sm form-control" name="description" id="description" /></textarea>
                                    </div>
                                    <div class="col-left">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="Keyword" type="text" name="keyword" id="keyword" />
                                        </div>
                                    </div>
                                    <div class="col-right">
                                        <div class="input-group">
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
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="<?php echo $lang['name'] ?>" type="text" name="name1" id="name1" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $lang['product_description'] ?>:</label><br>
                                                <textarea rows="3" class="input-sm form-control" name="description1" id="description1" /></textarea>
                                            </div>
                                            <div class="col-left">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="Keyword" type="text" name="keyword1" id="keyword1" />
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <div class="input-group">
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
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input class="input-sm form-control" placeholder="<?php echo $lang['product_price'] ?>" type="text" name="price" id="price" />
                                    </div>
                                </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                        <select name="tax" id="tax" class="input-sm form-control">
                                            <option selected hidden>-- Налог --</option>
                                            <option>Без налога</option>
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
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo $lang['product_quantity'] ?>" type="text" name="quantity" id="quantity" />
                                </div>
                                    </div>
                                <div class="col-right form-group">
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                    <select name="unit" id="unit" class="input-sm form-control">
                                        <option disabled selected hidden>-- <?php echo $lang['product_unit'] ?> --</option>
                                        <option>шт.</option>
                                        <option>м.</option>
                                        <option>л.</option>
                                    </select>
                                </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-left">
                                    <div class="input-group has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" placeholder="Модель" type="text" name="model" id="model" />
                                </div>
                                    </div>
                                <div class="col-right">
                                    <div class="input-group  has-error">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    <input class="input-sm form-control data" placeholder="Дата поступления" type="text" name="date_available" id="date_available" />
                                </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-left">
                                    <label>Производитель:</label>
                                    <select name="manufacturer" id="manufacturer" class="input-sm form-control">
                                        <option>Acer</option>
                                        <option>Asus</option>
                                        <option>Intel</option>
                                    </select>
                                </div>
                                <div class="col-right">
                                    <label>Штриховые коды:</label>
                                    <select name="code" id="code" class="input-sm form-control">
                                        <option>Нет</option>                                        
                                        <option>Barcode</option>
                                        <option>QR-code</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left">
                                    <label>Идентификатор товара:</label>
                                    <select name="product_code" id="product_code" class="input-sm form-control">
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
                                <div class="col-right">
                                    <label>Значение идентификатора:</label>
                                    <input class="input-sm form-control" type="text" name="product_code_value" id="product_code_value" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left">
                                    <label>Значение веса:</label>
                                    <input class="input-sm form-control" type="text" name="weight" id="weight" />
                                </div>
                                <div class="col-right">
                                    <label>Вес:</label>
                                    <select name="unit_weight" id="unit_weight" class="input-sm form-control">
                                        <option>кг.</option>
                                        <option>гр.</option>
                                        <option>унц.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left">
                                    <label>Минимальное количество:</label>
                                    <input class="input-sm form-control" type="text" name="min_quantity" id="min_quantity" />
                                </div>
                                <div class="col-right">
                                    <label>Размер:</label>
                                    <select name="unit_lenght" id="unit_lenght" class="input-sm form-control">
                                        <option>мм</option>
                                        <option>см</option>
                                        <option>м</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left-w">
                                    <label>Длина:</label>
                                    <input class="input-sm form-control" type="text" name="length" id="length" />
                                </div>
                                <div class="col-left-w">
                                    <label>Ширина:</label>
                                    <input class="input-sm form-control" type="text" name="width" id="width" />
                                </div>
                                <div class="col-right-w">
                                    <label>Высота:</label>
                                    <input class="input-sm form-control" type="text" name="height" id="height" />
                                </div>
                            </div>

                        </div>

                        <!-- Содержимое панели Изображения -->
                        <div id="panel3" class="tab-pane fade">
                            <div class="form-group">
                                <label for="image"><?php echo $lang['images'] ?>:</label>
                                <input type="file" multiple="multiple" name="files[]" accept="image" /> <?php echo $lang['max'] ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-save"></span> <?php echo $lang['save'] ?></button>
                    <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $lang['cancel'] ?></button>
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
