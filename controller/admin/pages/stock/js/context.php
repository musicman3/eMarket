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
                                $('#fileupload').fileupload('destroy');
                                $('#fileupload-product').fileupload('destroy');
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
                    disabled: function () {
                        let params = (new URL(document.location)).searchParams;
                        let parent_id = '<?php echo $parent_id ?>';
                        // Делаем не активным пункт меню, если нет строк
                        if (params.get('search') !== null || Number(parent_id) === 0) {
                            return true;
                        }
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $('#selected_attributes').val(JSON.stringify([]));
                        // Выводим атрибуты
                        AttributesProcessing.add('admin', <?php echo json_encode($attributes_category) ?>);

                        $('#edit_product').val('');
                        $('#add_product').val('ok');
                        //Очищаем поля
                        $(this).find('form').trigger('reset');
                        $('.summernote_add').val('');
                        // Загружаем настройки Summernote
                        $('.summernote_add').summernote(summernote_pref);
                        $('#index_product').modal('show');
                    }
                },

                "sep1": "---------",

                "add": {
                    name: "<?php echo lang('add_category') ?>",
                    icon: function () {
                        return 'context-menu-icon glyphicon-folder-open';
                    },
                    disabled: function () {
                        let params = (new URL(document.location)).searchParams;
                        // Делаем не активным пункт меню, если нет строк
                        if (params.get('search') !== null) {
                            return true;
                        }
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
                        if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
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
                            var json_data = $('div#ajax_data').data('jsondataproduct');

                            // Загружаем настройки Summernote
                            $('.summernote_add').summernote(summernote_pref);
                            // Ищем id и добавляем данные
                            for (var x = 0; x < json_data['name'].length; x++) {
                                $('#name_product_stock_' + x).val(json_data['name'][x][modal_id]);
                                $('#description_product_stock_' + x).summernote('code', json_data['description'][x][modal_id]);
                                $('#keyword_product_stock_' + x).val(json_data['keyword'][x][modal_id]);
                                $('#tags_product_stock_' + x).val(json_data['tags'][x][modal_id]);
                            }
                            $('#price_product_stock').val(json_data['price'][modal_id]);
                            $('#currency_product_stock').val(json_data['currency'][modal_id]);
                            $('#quantity_product_stock').val(json_data['quantity'][modal_id]);
                            $('#unit_product_stock').val(json_data['units'][modal_id]);
                            $('#model_product_stock').val(json_data['model'][modal_id]);
                            $('#manufacturers_product_stock').val(json_data['manufacturers'][modal_id]);
                            if (json_data['date_available'][modal_id] === null) {
                                $('#date_available_product_stock').datepicker('setDate', '');
                            } else {
                                $('#date_available_product_stock').datepicker('setDate', new Date(json_data['date_available'][modal_id]));
                            }

                            $('#tax_product_stock').val(json_data['tax'][modal_id]);
                            $('#vendor_code_value_product_stock').val(json_data['vendor_code_value'][modal_id]);
                            $('#vendor_codes_product_stock').val(json_data['vendor_code'][modal_id]);
                            $('#weight_value_product_stock').val(json_data['weight_value'][modal_id]);
                            $('#weight_product_stock').val(json_data['weight'][modal_id]);
                            $('#min_quantity_product_stock').val(json_data['min_quantity'][modal_id]);
                            $('#length_product_stock').val(json_data['dimension'][modal_id]);
                            $('#value_length_product_stock').val(json_data['length'][modal_id]);
                            $('#value_width_product_stock').val(json_data['width'][modal_id]);
                            $('#value_height_product_stock').val(json_data['height'][modal_id]);
                            $('#selected_attributes').val(JSON.stringify(json_data['attributes'][modal_id]));

                            // Выводим атрибуты
                            AttributesProcessing.add('admin', json_data['attributes_data'][modal_id]);

                            $('#edit_product').val(modal_id);
                            $('#add_product').val('');
                            // Подгружаем изображения
                            FileuploadProduct.getImageToEditProduct(json_data['logo_general'], json_data['logo'], modal_id, 'products');

                            $('#index_product').modal('show');
                        } else {
                            // Получаем ID при клике на кнопку редактирования
                            var modal_id = opt.$trigger.attr("id");

                            // Получаем массивы данных
                            var json_data = $('div#ajax_data').data('jsondatacategory');

                            // Ищем id и добавляем данные
                            for (var x = 0; x < json_data['name'].length; x++) {
                                $('#name_categories_stock_' + x).val(json_data['name'][x][modal_id]);
                            }
                            $('#attributes').val(json_data['attributes']);

                            $('#edit').val(modal_id);
                            $('#add').val('');
                            // Подгружаем изображения
                            Fileupload.getImageToEdit(json_data['logo_general'], json_data['logo'], modal_id, 'categories');
                            // Подгружаем атрибуты
                            sessionStorage.setItem('attributes', JSON.stringify(json_data['attributes'][modal_id]));
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
                        if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined && session === '0') {
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
                                if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
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
                                $('.group-attributes').sortable('option', 'disabled', true);
                                $('.attribute').sortable('option', 'disabled', true);
                                $('.values_attribute').sortable('option', 'disabled', true);
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
                                    $('#fileupload').fileupload('destroy');
                                    $('#fileupload-product').fileupload('destroy');
                                    $('#ajax').html(data);
                                    $('.group-attributes').sortable('option', 'disabled', false);
                                    $('.attribute').sortable('option', 'disabled', false);
                                    $('.values_attributes').sortable('option', 'disabled', false);
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
                                if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
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
                                $('.group-attributes').sortable('option', 'disabled', true);
                                $('.attribute').sortable('option', 'disabled', true);
                                $('.values_attribute').sortable('option', 'disabled', true);
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
                                    $('#fileupload').fileupload('destroy');
                                    $('#fileupload-product').fileupload('destroy');
                                    $('#ajax').html(data);
                                    $('.group-attributes').sortable('option', 'disabled', false);
                                    $('.attribute').sortable('option', 'disabled', false);
                                    $('.values_attributes').sortable('option', 'disabled', false);
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
                                if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
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
                                $('.group-attributes').sortable('option', 'disabled', true);
                                $('.attribute').sortable('option', 'disabled', true);
                                $('.values_attribute').sortable('option', 'disabled', true);
                                jQuery.post('?route=stock',
                                        {idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                            idsx_cut_id: idArray,
                                            parent_down: <?php echo $parent_id ?>,
                                            idsx_cut_key: itemKey});
                                // Отправка запроса для обновления страницы
                                jQuery.get('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    $('#fileupload').fileupload('destroy');
                                    $('#fileupload-product').fileupload('destroy');
                                    $('#ajax').html(data);
                                    $('.group-attributes').sortable('option', 'disabled', false);
                                    $('.attribute').sortable('option', 'disabled', false);
                                    $('.values_attributes').sortable('option', 'disabled', false);
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
                                let params = (new URL(document.location)).searchParams;
                                // Делаем не активным пункт меню, если нет строк
                                if (session === '0' || params.get('search') !== null) {
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
                                jQuery.get('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                                        {parent_down: <?php echo $parent_id ?>,
                                            modify: 'update_ok'},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    $('#fileupload').fileupload('destroy');
                                    $('#fileupload-product').fileupload('destroy');
                                    $('#ajax').html(data);
                                    $('.group-attributes').sortable('option', 'disabled', false);
                                    $('.attribute').sortable('option', 'disabled', false);
                                    $('.values_attributes').sortable('option', 'disabled', false);
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
                                if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
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
                                    $('.group-attributes').sortable('option', 'disabled', true);
                                    $('.attribute').sortable('option', 'disabled', true);
                                    $('.values_attribute').sortable('option', 'disabled', true);
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
                                        $('#confirm').modal('hide');
                                        $('#fileupload').fileupload('destroy');
                                        $('#fileupload-product').fileupload('destroy');
                                        $('#ajax').html(data);
                                        $('.group-attributes').sortable('option', 'disabled', false);
                                        $('.attribute').sortable('option', 'disabled', false);
                                        $('.values_attributes').sortable('option', 'disabled', false);
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
                        if (sale === '0' || $('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
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
                                if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
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
                                $('.group-attributes').sortable('option', 'disabled', true);
                                $('.attribute').sortable('option', 'disabled', true);
                                $('.values_attribute').sortable('option', 'disabled', true);
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
                                    $('#fileupload').fileupload('destroy');
                                    $('#fileupload-product').fileupload('destroy');
                                    $('#ajax').html(data);
                                    $('.group-attributes').sortable('option', 'disabled', false);
                                    $('.attribute').sortable('option', 'disabled', false);
                                    $('.values_attributes').sortable('option', 'disabled', false);
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
                                if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
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
                                    $('.group-attributes').sortable('option', 'disabled', true);
                                    $('.attribute').sortable('option', 'disabled', true);
                                    $('.values_attribute').sortable('option', 'disabled', true);
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
                                        $('#fileupload').fileupload('destroy');
                                        $('#fileupload-product').fileupload('destroy');
                                        $('#ajax').html(data);
                                        $('.group-attributes').sortable('option', 'disabled', false);
                                        $('.attribute').sortable('option', 'disabled', false);
                                        $('.values_attributes').sortable('option', 'disabled', false);
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
                                if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
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
                                    $('.group-attributes').sortable('option', 'disabled', true);
                                    $('.attribute').sortable('option', 'disabled', true);
                                    $('.values_attribute').sortable('option', 'disabled', true);
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
                                        $('#fileupload').fileupload('destroy');
                                        $('#fileupload-product').fileupload('destroy');
                                        $('#ajax').html(data);
                                        $('.group-attributes').sortable('option', 'disabled', false);
                                        $('.attribute').sortable('option', 'disabled', false);
                                        $('.values_attributes').sortable('option', 'disabled', false);
                                    }
                                }
                            }
                        }
                    }
                },

                "sep13": "---------",

                "fold3": {
                    "name": "<?php echo lang('button_stiker') ?>",
                    icon: function () {
                        return 'context-menu-icon glyphicon-bookmark';
                    },
                    disabled: function () {
                        // Делаем не активным пункт меню, если нет строк
                        var sale = '<?php echo $stikers_flag ?>';
                        if (sale === '0') {
                            return true;
                        }
                    },

                    "items": {
                        "stiker": {
                            type: 'select',
                            options: {<?php echo $stikers ?>},
                            selected: <?php echo $stikers_default ?>,
                            disabled: function () {

                            }
                        },

                        "sep14": "---------",

                        'stikerOn': {
                            name: "<?php echo lang('button_stiker_add') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-plus';
                            },
                            disabled: function () {

                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Значение выбранного селекта
                                var selected_id = $('select[name="context-menu-input-stiker"] option:selected').val();
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                // Отправка данных по каждой выделенной строке
                                var idArray = [];
                                $(".option").each(function (i) {
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        idArray[i] = this.id;
                                });
                                $('.group-attributes').sortable('option', 'disabled', true);
                                $('.attribute').sortable('option', 'disabled', true);
                                $('.values_attribute').sortable('option', 'disabled', true);
                                jQuery.post('?route=stock',
                                        {idsx_stikerOn_id: idArray,
                                            idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                            stiker: selected_id,
                                            idsx_stikerOn_key: 'On'});
                                // Отправка запроса для обновления страницы
                                jQuery.get('?route=stock',
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    $('#fileupload').fileupload('destroy');
                                    $('#fileupload-product').fileupload('destroy');
                                    $('#ajax').html(data);
                                    $('.group-attributes').sortable('option', 'disabled', false);
                                    $('.attribute').sortable('option', 'disabled', false);
                                    $('.values_attributes').sortable('option', 'disabled', false);
                                }
                            }
                        },

                        "stikerOff": {
                            name: "<?php echo lang('button_stiker_delete') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-trash';
                            },
                            disabled: function () {

                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                $('#confirm').modal('show');
                                $('#confirm_title').html('<?php echo lang('attention') ?>');
                                $('#confirm_body').html('<?php echo lang('confirm_delete_stiker') ?>');

                                confirmation.onclick = function () {
                                    $('#confirm').modal('hide');
                                    // Значение выбранного селекта
                                    var selected_id = $('select[name="context-menu-input-stiker"] option:selected').val();
                                    // Установка синхронного запроса для jQuery.ajax
                                    jQuery.ajaxSetup({async: false});
                                    // Отправка данных по каждой выделенной строке
                                    var idArray = [];
                                    $(".option").each(function (i) {
                                        if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                            idArray[i] = this.id;
                                    });
                                    $('.group-attributes').sortable('option', 'disabled', true);
                                    $('.attribute').sortable('option', 'disabled', true);
                                    $('.values_attribute').sortable('option', 'disabled', true);
                                    jQuery.post('?route=stock',
                                            {idsx_stikerOff_id: idArray,
                                                idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                stiker: selected_id,
                                                idsx_stikerOff_key: 'Off'});
                                    // Отправка запроса для обновления страницы
                                    jQuery.get('?route=stock',
                                            {parent_down: <?php echo $parent_id ?>},
                                            AjaxSuccess);
                                    // Обновление страницы
                                    function AjaxSuccess(data) {
                                        $('#fileupload').fileupload('destroy');
                                        $('#fileupload-product').fileupload('destroy');
                                        $('#ajax').html(data);
                                        $('.group-attributes').sortable('option', 'disabled', false);
                                        $('.attribute').sortable('option', 'disabled', false);
                                        $('.values_attributes').sortable('option', 'disabled', false);
                                    }
                                }
                            }
                        },
                    }
                },

                "sep15": "---------",

                "quit": {name: "<?php echo lang('menu_exit') ?>", icon: function () {
                        return 'context-menu-icon glyphicon-remove';
                    }}
            }
        });
    });
</script>