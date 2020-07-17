<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Контекстное меню -->
<script type="text/javascript">

    session = '<?php echo $ses_verify ?>';
    $(function () {
        $.contextMenu({
            selector: '.context-one',
            callback: function (itemKey, opt) {
                function send() {
                    $.ajax({
                        method: 'POST',
                        dataType: 'text',
                        url: '?route=stock',
                        data: ({
                            itemName: itemKey, //название ключа из меню (edit, delete, copy и т.п.)
                            ids2: opt.$trigger.attr("id")}), //id строки
                        success: function (data) {
                            setTimeout(function () {
                                $('#view_categories_stock').bootstrapSwitch('destroy');
                                $('#fileupload').fileupload('destroy');
                                $('#fileupload-product').fileupload('destroy');
                                $('#ajax').html(data);
                            }, 1000);
                        }
                    });
                }
                ;
                return send();
            },
            items: {

                "add_product": {
                    name: "<?php echo lang('add_product') ?>",
                    icon: function () {
                        return 'context-menu-icon glyphicon-shopping-cart';
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $('#edit_product').val('');
                        $('#add_product').val('ok');
                        //Очищаем поля
                        $(this).find('form').trigger('reset');
                        $('.summernote_add').val('');
                        $('#index_product').modal('show');
                    }
                },

                "sep1": "---------",

                "add": {
                    name: "<?php echo lang('add_category') ?>",
                    icon: function () {
                        return 'context-menu-icon glyphicon-folder-open';
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $('#edit').val('');
                        $('#add').val('ok');
                        //Очищаем поля
                        $(this).find('form').trigger('reset');
                        $('#index').modal('show');
                    }
                },

                "sep2": "---------",

                "edit": {
                    name: "<?php echo lang('button_edit') ?>",
                    icon: function () {
                        return 'context-menu-icon glyphicon-edit';
                    },
                    disabled: function () {
                        // Делаем не активным пункт меню, если нет строк
                        if ($('div#ajax_data').data('name') === undefined || $('div#ajax_data').data('nameproduct') === undefined) {
                            return true;
                        }
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {

                        var modal_edit = opt.$trigger.attr("id");
                        if (modal_edit.search('product_') > -1) {

                            $('.progress-bar').css('width', 0 + '%');
                            $('.file-upload').detach();
                            $('#delete_image_product').val('');
                            $('#general_image_edit_product').val('');
                            $('#alert_messages_edit_product').empty();
                            // Получаем ID при клике на кнопку редактирования
                            var modal_id = modal_edit.split('product_')[1];
                            // Получаем массивы данных
                            var name_edit = $('div#ajax_data').data('nameproduct');
                            var description_edit = $('div#ajax_data').data('descriptionproduct');
                            var keyword_edit = $('div#ajax_data').data('keywordproduct');
                            var tags_edit = $('div#ajax_data').data('tagsproduct');
                            var price_edit = $('div#ajax_data').data('priceproduct');
                            var currency_edit = $('div#ajax_data').data('currencyproduct');
                            var quantity_edit = $('div#ajax_data').data('quantityproduct');
                            var unit_edit = $('div#ajax_data').data('unitsproduct');
                            var model_edit = $('div#ajax_data').data('modelproduct');
                            var manufacturers_edit = $('div#ajax_data').data('manufacturersproduct');
                            var date_available_edit = $('div#ajax_data').data('dateavailableproduct');
                            var tax_edit = $('div#ajax_data').data('taxproduct');
                            var vendor_code_value_edit = $('div#ajax_data').data('vendorcodevalueproduct');
                            var vendor_code_edit = $('div#ajax_data').data('vendorcodeproduct');
                            var weight_value_edit = $('div#ajax_data').data('weightvalueproduct');
                            var weight_edit = $('div#ajax_data').data('weightproduct');
                            var min_quantity_edit = $('div#ajax_data').data('minquantityproduct');
                            var dimension_edit = $('div#ajax_data').data('dimensionproduct');
                            var length_edit = $('div#ajax_data').data('lengthproduct');
                            var width_edit = $('div#ajax_data').data('widthproduct');
                            var height_edit = $('div#ajax_data').data('heightproduct');
                            var logo_edit_product = $('div#ajax_data').data('logoproduct');
                            var logo_general_edit_product = $('div#ajax_data').data('generalproduct');
                            // Ищем id и добавляем данные
                            for (x = 0; x < name_edit.length; x++) {
                                $('#name_product_stock_' + x).val(name_edit[x][modal_id]);
                                $('#description_product_stock_' + x).summernote('code', description_edit[x][modal_id]);
                                $('#keyword_product_stock_' + x).val(keyword_edit[x][modal_id]);
                                $('#tags_product_stock_' + x).val(tags_edit[x][modal_id]);
                            }
                            $('#price_product_stock').val(price_edit[modal_id]);
                            $('#currency_product_stock').val(currency_edit[modal_id]);
                            $('#quantity_product_stock').val(quantity_edit[modal_id]);
                            $('#unit_product_stock').val(unit_edit[modal_id]);
                            $('#model_product_stock').val(model_edit[modal_id]);
                            $('#manufacturers_product_stock').val(manufacturers_edit[modal_id]);
                            if (date_available_edit[modal_id] === null) {
                                $('#date_available_product_stock').datepicker('setDate', '');
                            } else {
                                $('#date_available_product_stock').datepicker('setDate', new Date(date_available_edit[modal_id]));
                            }

                            $('#tax_product_stock').val(tax_edit[modal_id]);
                            $('#vendor_code_value_product_stock').val(vendor_code_value_edit[modal_id]);
                            $('#vendor_codes_product_stock').val(vendor_code_edit[modal_id]);
                            $('#weight_value_product_stock').val(weight_value_edit[modal_id]);
                            $('#weight_product_stock').val(weight_edit[modal_id]);
                            $('#min_quantity_product_stock').val(min_quantity_edit[modal_id]);
                            $('#length_product_stock').val(dimension_edit[modal_id]);
                            $('#value_length_product_stock').val(length_edit[modal_id]);
                            $('#value_width_product_stock').val(width_edit[modal_id]);
                            $('#value_height_product_stock').val(height_edit[modal_id]);
                            $('#edit_product').val(modal_id);
                            $('#add_product').val('');
                            // Подгружаем изображения
                            getImageToEditProduct(logo_general_edit_product, logo_edit_product, modal_id);

                            $('#index_product').modal('show');
                        } else {
                            // Получаем ID при клике на кнопку редактирования
                            var modal_id = opt.$trigger.attr("id");

                            // Получаем массивы данных
                            var name_edit = $('div#ajax_data').data('name');
                            var logo_edit = $('div#ajax_data').data('logo');
                            var logo_general_edit = $('div#ajax_data').data('general');
                            var attributes_edit = $('div#ajax_data').data('attributes');

                            // Ищем id и добавляем данные
                            for (x = 0; x < name_edit.length; x++) {
                                $('#name_categories_stock_' + x).val(name_edit[x][modal_id]);
                            }
                            $('#attributes').val(attributes_edit);

                            $('#edit').val(modal_id);
                            $('#add').val('');
                            // Подгружаем изображения
                            getImageToEdit(logo_general_edit, logo_edit, modal_id);
                            // Подгружаем атрибуты
                            sessionStorage.setItem('attributes', JSON.stringify(attributes_edit[modal_id]));
                            sessionStorage.setItem('attribute_action', 'add');
                            sessionStorage.setItem('value_attribute_flag', '0');
                            // Открываем модальное окно
                            $('#index').modal('show');

                        }

                    }
                },

                "sep3": "---------",

                "fold": {
                    "name": "<?php echo lang('button_action') ?>",
                    icon: function () {
                        return 'context-menu-icon glyphicon-hand-right';
                    },
                    disabled: function () {
                        // Делаем не активным пункт меню, если нет строк
                        if ($('div#ajax_data').data('name') === undefined && $('div#ajax_data').data('nameproduct') === undefined && session === '0') {
                            return true;
                        }
                    },
                    "items": {

                        "statusOn": {
                            name: "<?php echo lang('button_show') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-eye-open';
                            },
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                                if ($('div#ajax_data').data('name') === undefined || $('div#ajax_data').data('nameproduct') === undefined) {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                // Отправка данных по каждой выделенной строке
                                var idArray = [];
                                $(".option").each(function (i) {
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        idArray[i] = this.id;
                                });
                                jQuery.post('?route=stock',
                                        {idsx_statusOn_id: idArray,
                                            idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                            idsx_statusOn_key: 'On'});
                                // Отправка запроса для обновления страницы
                                jQuery.get('?route=stock',
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#view_categories_stock').bootstrapSwitch('destroy');
                                        $('#fileupload').fileupload('destroy');
                                        $('#fileupload-product').fileupload('destroy');
                                        $('#ajax').html(data);
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        },
                        "statusOff": {
                            name: "<?php echo lang('button_hide') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-eye-close';
                            },
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                                if ($('div#ajax_data').data('name') === undefined || $('div#ajax_data').data('nameproduct') === undefined) {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                // Отправка данных по каждой выделенной строке
                                var idArray = [];
                                $(".option").each(function (i) {
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        idArray[i] = this.id;
                                });
                                jQuery.post('?route=stock',
                                        {idsx_statusOff_id: idArray,
                                            idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                            idsx_statusOff_key: 'Off'});
                                // Отправка запроса для обновления страницы
                                jQuery.get('?route=stock',
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#view_categories_stock').bootstrapSwitch('destroy');
                                        $('#fileupload').fileupload('destroy');
                                        $('#fileupload-product').fileupload('destroy');
                                        $('#ajax').html(data);
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        },

                        "sep4": "---------",

                        "cut": {
                            name: "<?php echo lang('cut') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-scissors';
                            },
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                                if ($('div#ajax_data').data('name') === undefined || $('div#ajax_data').data('nameproduct') === undefined) {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                // Отправка маркера на очитку буффера
                                jQuery.post('?route=stock',
                                        {idsx_cut_marker: 'cut'});
                                // Отправка данных по каждой выделенной строке
                                var idArray = [];
                                $(".option").each(function (i) {
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        idArray[i] = this.id;
                                });
                                jQuery.post('?route=stock',
                                        {idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                            idsx_cut_id: idArray,
                                            parent_down: <?php echo $parent_id ?>,
                                            idsx_cut_key: itemKey});
                                // Отправка запроса для обновления страницы
                                jQuery.get('?route=stock',
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#view_categories_stock').bootstrapSwitch('destroy');
                                        $('#fileupload').fileupload('destroy');
                                        $('#fileupload-product').fileupload('destroy');
                                        $('#ajax').html(data);
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        },
                        "paste": {
                            name: "<?php echo lang('paste') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-paste';
                            },
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                                if (session === '0') {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                jQuery.post('?route=stock',
                                        {idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                            parent_down: <?php echo $parent_id ?>,
                                            idsx_paste_key: itemKey});
                                // Отправка запроса для обновления страницы
                                jQuery.get('?route=stock',
                                        {parent_down: <?php echo $parent_id ?>,
                                            modify: 'update_ok'},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        document.location.href = '<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>';
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        },

                        "sep5": "---------",

                        "delete": {
                            name: "<?php echo lang('button_delete') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-trash';
                            },
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                                if ($('div#ajax_data').data('name') === undefined || $('div#ajax_data').data('nameproduct') === undefined) {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                $('#confirm').modal('show');
                                $('#confirm_title').html('<?php echo lang('attention') ?>');
                                $('#confirm_body').html('<?php echo lang('confirm_delete_product_or_category') ?>');

                                confirmation.onclick = function () {
                                    // Установка синхронного запроса для jQuery.ajax
                                    jQuery.ajaxSetup({async: false});
                                    // Отправка данных по каждой выделенной строке
                                    var idArray = [];
                                    $(".option").each(function (i) { // выделенное мышкой
                                        if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                            idArray[i] = this.id;
                                    });
                                    jQuery.post('?route=stock',
                                            {delete: idArray,
                                                parent_down: <?php echo $parent_id ?>});
                                    // Отправка запроса для обновления страницы
                                    jQuery.get('?route=stock',
                                            {parent_down: <?php echo $parent_id ?>,
                                                modify: 'ok'},
                                            AjaxSuccess);
                                    // Обновление страницы
                                    function AjaxSuccess(data) {
                                        setTimeout(function () {
                                            $('#confirm').modal('hide');
                                            $('#view_categories_stock').bootstrapSwitch('destroy');
                                            $('#fileupload').fileupload('destroy');
                                            $('#fileupload-product').fileupload('destroy');
                                            $('#ajax').html(data);
                                        }, 100);
                                        $("#sort-list").sortable();
                                    }
                                }
                            }
                        }
                    }
                },

                "sep10": "---------",

                "fold2": {
                    "name": "<?php echo lang('button_sale') ?>",
                    icon: function () {
                        return 'context-menu-icon glyphicon-tag';
                    },
                    disabled: function () {
                        // Делаем не активным пункт меню, если нет строк
                        var sale = '<?php echo $sales_flag ?>';
                        if (sale === '0') {
                            return true;
                        }
                    },

                    "items": {
                        "sale": {
                            type: 'select',
                            options: {<?php echo $sales ?>},
                            selected: <?php echo $sale_default ?>,
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                                if ($('div#ajax_data').data('name') === undefined || $('div#ajax_data').data('nameproduct') === undefined) {
                                    return true;
                                }
                            }
                        },

                        "sep11": "---------",

                        'saleOn': {
                            name: "<?php echo lang('button_sale_on') ?>",
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Значение выбранного селекта
                                var selected_id = $('select[name="context-menu-input-sale"] option:selected').val();
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                // Отправка данных по каждой выделенной строке
                                var idArray = [];
                                $(".option").each(function (i) {
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        idArray[i] = this.id;
                                });
                                jQuery.post('?route=stock',
                                        {idsx_saleOn_id: idArray,
                                            idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                            sale: selected_id,
                                            idsx_saleOn_key: 'On'});
                                // Отправка запроса для обновления страницы
                                jQuery.get('?route=stock',
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#view_categories_stock').bootstrapSwitch('destroy');
                                        $('#fileupload').fileupload('destroy');
                                        $('#fileupload-product').fileupload('destroy');
                                        $('#ajax').html(data);
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            },
                            icon: function () {
                                return 'context-menu-icon glyphicon-star';
                            }
                        },

                        "saleOff": {
                            name: "<?php echo lang('button_sale_off') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-star-empty';
                            },
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                                if ($('div#ajax_data').data('name') === undefined || $('div#ajax_data').data('nameproduct') === undefined) {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                $('#confirm').modal('show');
                                $('#confirm_title').html('<?php echo lang('attention') ?>');
                                $('#confirm_body').html('<?php echo lang('confirm_delete_sale') ?>');

                                confirmation.onclick = function () {
                                    $('#confirm').modal('hide');
                                    // Значение выбранного селекта
                                    var selected_id = $('select[name="context-menu-input-sale"] option:selected').val();
                                    // Установка синхронного запроса для jQuery.ajax
                                    jQuery.ajaxSetup({async: false});
                                    // Отправка данных по каждой выделенной строке
                                    var idArray = [];
                                    $(".option").each(function (i) {
                                        if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                            idArray[i] = this.id;
                                    });
                                    jQuery.post('?route=stock',
                                            {idsx_saleOff_id: idArray,
                                                idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                sale: selected_id,
                                                idsx_saleOff_key: 'Off'});
                                    // Отправка запроса для обновления страницы
                                    jQuery.get('?route=stock',
                                            {parent_down: <?php echo $parent_id ?>},
                                            AjaxSuccess);
                                    // Обновление страницы
                                    function AjaxSuccess(data) {
                                        setTimeout(function () {
                                            $('#view_categories_stock').bootstrapSwitch('destroy');
                                            $('#fileupload').fileupload('destroy');
                                            $('#fileupload-product').fileupload('destroy');
                                            $('#ajax').html(data);
                                        }, 100);
                                        $("#sort-list").sortable();
                                    }
                                }
                            }
                        },

                        "sep12": "---------",

                        "saleOffAll": {
                            name: "<?php echo lang('button_sale_off_all') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-flash';
                            },
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                                if ($('div#ajax_data').data('name') === undefined || $('div#ajax_data').data('nameproduct') === undefined) {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                $('#confirm').modal('show');
                                $('#confirm_title').html('<?php echo lang('attention') ?>');
                                $('#confirm_body').html('<?php echo lang('confirm_delete_sales') ?>');

                                confirmation.onclick = function () {
                                    $('#confirm').modal('hide');
                                    // Значение выбранного селекта
                                    var selected_id = $('select[name="context-menu-input-sale"] option:selected').val();
                                    // Установка синхронного запроса для jQuery.ajax
                                    jQuery.ajaxSetup({async: false});
                                    // Отправка данных по каждой выделенной строке
                                    var idArray = [];
                                    $(".option").each(function (i) {
                                        if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                            idArray[i] = this.id;
                                    });
                                    jQuery.post('?route=stock',
                                            {idsx_saleOffAll_id: idArray,
                                                idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                idsx_saleOffAll_key: 'OffAll'});
                                    // Отправка запроса для обновления страницы
                                    jQuery.get('?route=stock',
                                            {parent_down: <?php echo $parent_id ?>},
                                            AjaxSuccess);
                                    // Обновление страницы
                                    function AjaxSuccess(data) {
                                        setTimeout(function () {
                                            $('#view_categories_stock').bootstrapSwitch('destroy');
                                            $('#fileupload').fileupload('destroy');
                                            $('#fileupload-product').fileupload('destroy');
                                            $('#ajax').html(data);
                                        }, 100);
                                        $("#sort-list").sortable();
                                    }
                                }
                            }
                        }
                    }
                },

                "sep13": "---------",

                "quit": {name: "<?php echo lang('menu_exit') ?>", icon: function () {
                        return 'context-menu-icon glyphicon-remove';
                    }}
            }
        });
    });
</script>