<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
<!-- Модальное окно "Добавить категорию" -->
<div id="addProduct" class="product modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><?php echo $lang['title_products'] ?></h4>
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
                                <li class="active"><a data-toggle="tab" href="#Russian"><img src="/view/default/admin/images/worldflags/ru.png" alt="Russian" title="Russian" width="16" height="10" /> Russian</a></li>
                                <li><a data-toggle="tab" href="#English"><img src="/view/default/admin/images/worldflags/us.png" alt="English" title="English" width="16" height="10" /> English</a></li>
                            </ul>

                            <!-- Содержимое языковых панелей -->
                            <div class="tab-content">
                                <div id="Russian" class="tab-pane fade in active">
                                    <div class="form-group">
                                        <label><?php echo $lang['name'] ?>:</label><br>
                                        <input class="input-sm form-control" type="text" name="name" id="name" />
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['product_description'] ?>:</label><br>
                                        <textarea rows="3" class="input-sm form-control" name="description" id="description" /></textarea>
                                    </div>
                                    <div class="col-left">
                                        <label>Keyword:</label>
                                        <input class="input-sm form-control" type="text" name="keyword" id="keyword" />
                                    </div>
                                    <div class="col-right">
                                        <label>Tags:</label>
                                        <input class="input-sm form-control" type="text" name="tags" id="tags" />
                                    </div>
                                </div>
                                <div id="English" class="tab-pane fade">
                                    <div class="form-group">
                                        <label><?php echo $lang['name'] ?>:</label><br>
                                        <input class="input-sm form-control" type="text" name="name" id="name" />
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $lang['product_description'] ?>:</label><br>
                                        <textarea rows="3" class="input-sm form-control" name="description" id="description" /></textarea>
                                    </div>
                                    <div class="col-left">
                                        <label>Keyword:</label>
                                        <input class="input-sm form-control" type="text" name="keyword" id="keyword" />
                                    </div>
                                    <div class="col-right">
                                        <label>Tags:</label>
                                        <input class="input-sm form-control" type="text" name="tags" id="tags" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Содержимое панели Данные -->
                        <div id="panel2" class="tab-pane fade">
                            <div class="row">
                                <div class="col-left">
                                    <label><?php echo $lang['product_price'] ?>:</label>
                                    <input class="input-sm form-control" type="text" name="price" id="price" />
                                </div>
                                <div class="col-right">
                                    <label>Налог:</label>
                                    <select name="tax" id="tax" class="input-sm form-control">
                                        <option>НДС</option>
                                        <option>18%</option>
                                        <option>12%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left">
                                    <label><?php echo $lang['product_quantity'] ?>:</label>
                                    <input class="input-sm form-control" type="text" name="quantity" id="quantity" />
                                </div>
                                <div class="col-right">
                                    <label><?php echo $lang['product_unit'] ?>:</label>
                                    <select name="unit" id="unit" class="input-sm form-control">
                                        <option>шт.</option>
                                        <option>м.</option>
                                        <option>л.</option>
                                    </select>
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
                                    <input class="input-sm form-control" type="text" name="model" id="model" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-left">
                                    <label>Вес:</label>
                                    <input class="input-sm form-control" type="text" name="weight" id="weight" />
                                </div>
                                <div class="col-right">
                                    <label>Единица веса:</label>
                                    <select name="unit_weight" id="unit_weight" class="input-sm form-control">
                                        <option>кг.</option>
                                        <option>гр.</option>
                                        <option>унц.</option>
                                    </select>
                                </div>
			    </div>
                            <div class="row">
                                    <div class="col-left">
                                        <label>Дата поступления:</label>
                                        <input class="input-sm form-control" type="text" name="date_available" id="date_available" />
                                    </div>
                                    <div class="col-right">
                                        <label>Минимальное количество:</label>
                                        <input class="input-sm form-control" type="text" name="quantity" id="quantity" />
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
                                <input type="file" name="image" id="image" /> <?php echo $lang['max'] ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>
                            </div>
                        </div>

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