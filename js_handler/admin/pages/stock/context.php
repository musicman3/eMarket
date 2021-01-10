<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMark
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

foreach (\eMarket\Modules::discountRouter('data') as $js_path) {
    echo '<script type="text/javascript" src="/modules/discount/' . $js_path . '/js_handler/admin/contextmenu/contextmenu.js"></script>';
}
?>
<!-- Контекстное меню -->
<script type="text/javascript">

    $(function () {
        var session = '<?php echo $ses_verify ?>';
        var lang = <?php echo json_encode(lang()) ?>;
        let parent_id = '<?php echo $parent_id ?>';
        var idsx_real_parent_id = '<?php echo $idsx_real_parent_id ?>';
        var sale = '<?php echo $sales_flag ?>';
        var sales = {<?php echo $sales ?>};
        var sale_dafault = '<?php echo $sale_default ?>';
        var stiker = '<?php echo $stikers_flag ?>';
        var stikers = {<?php echo $stikers ?>};
        var stikers_default = '<?php echo $stikers_default ?>';
        var attributes_category = <?php echo json_encode($attributes_category) ?>;

        var sales_interface = [
            lang,
            parent_id,
            idsx_real_parent_id,
            sales,
            sale,
            sale_dafault
        ];

        $.contextMenu({
            selector: '.context-one',

            items: {

                "add_product": {
                    name: lang['add_product'],
                    icon: function () {
                        return 'context-menu-icon glyphicon-shopping-cart';
                    },
                    disabled: function () {
                        let params = (new URL(document.location)).searchParams;
                        // Делаем не активным пункт меню, если нет строк
                        if (params.get('search') !== null || Number(parent_id) === 0) {
                            return true;
                        }
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $('#selected_attributes').val(JSON.stringify([]));
                        // Выводим атрибуты
                        AttributesProcessing.add('admin', attributes_category, '<?php echo lang('#lang_all')[0] ?>');

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
                    name: lang['add_category'],
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
                    name: lang['button_edit'],
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
                            AttributesProcessing.add('admin', json_data['attributes_data'][modal_id], '<?php echo lang('#lang_all')[0] ?>');

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
                    "name": lang['button_action'],
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
                            name: lang['button_show'],
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
                                jQuery.post(window.location.href,
                                        {idsx_status_on_id: idArray,
                                            idsx_real_parent_id: idsx_real_parent_id,
                                            idsx_status_on_key: 'On'});
                                // Отправка запроса для обновления страницы
                                jQuery.get(window.location.href,
                                        {parent_down: parent_id},
                                        AjaxSuccess);
                            }
                        },
                        "statusOff": {
                            name: lang['button_hide'],
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
                                jQuery.post(window.location.href,
                                        {idsx_status_off_id: idArray,
                                            idsx_real_parent_id: idsx_real_parent_id,
                                            idsx_status_off_key: 'Off'});
                                // Отправка запроса для обновления страницы
                                jQuery.get(window.location.href,
                                        {parent_down: parent_id},
                                        AjaxSuccess);
                            }
                        },

                        "sep4": "---------",

                        "cut": {
                            name: lang['cut'],
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
                                jQuery.post(window.location.href,
                                        {idsx_cut_marker: 'cut'});
                                // Отправка данных по каждой выделенной строке
                                var idArray = [];
                                $(".option").each(function (i) {
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        idArray[i] = this.id;
                                });
                                jQuery.post(window.location.href,
                                        {idsx_real_parent_id: idsx_real_parent_id,
                                            idsx_cut_id: idArray,
                                            parent_down: parent_id,
                                            idsx_cut_key: itemKey});
                                // Отправка запроса для обновления страницы
                                jQuery.get(window.location.href,
                                        {parent_down: parent_id},
                                        AjaxSuccess);
                            }
                        },
                        "paste": {
                            name: lang['paste'],
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
                                jQuery.post(window.location.href,
                                        {idsx_real_parent_id: idsx_real_parent_id,
                                            parent_down: parent_id,
                                            idsx_paste_key: itemKey});
                                // Отправка запроса для обновления страницы
                                jQuery.get(window.location.href,
                                        {parent_down: parent_id,
                                            message: 'ok'},
                                        AjaxSuccess);
                            }
                        },

                        "sep5": "---------",

                        "delete": {
                            name: lang['button_delete'],
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
                                $('#confirm_title').html(lang['attention']);
                                $('#confirm_body').html(lang['confirm_delete_product_or_category']);

                                confirmation.onclick = function () {
                                    $('#confirm').modal('hide');
                                    // Установка синхронного запроса для jQuery.ajax
                                    jQuery.ajaxSetup({async: false});
                                    // Отправка данных по каждой выделенной строке
                                    var idArray = [];
                                    $(".option").each(function (i) { // выделенное мышкой
                                        if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                            idArray[i] = this.id;
                                    });
                                    jQuery.post(window.location.href,
                                            {delete: idArray,
                                                parent_down: parent_id});
                                    // Отправка запроса для обновления страницы
                                    jQuery.get(window.location.href,
                                            {parent_down: parent_id,
                                                message: 'ok'},
                                            AjaxSuccess);
                                };
                            }
                        }
                    }
                },
                
                "discount_separator": <?php echo \eMarket\Modules::discountRouter('functions') ?>,


                "fold3": {
                    "name": lang['button_stiker'],
                    icon: function () {
                        return 'context-menu-icon glyphicon-bookmark';
                    },
                    disabled: function () {
                        // Делаем не активным пункт меню, если нет строк
                        if (stiker === '0') {
                            return true;
                        }
                    },

                    "items": {
                        "stiker": {
                            type: 'select',
                            options: stikers,
                            selected: stikers_default,
                            disabled: function () {

                            }
                        },

                        "sep14": "---------",

                        'stikerOn': {
                            name: lang['button_stiker_add'],
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
                                jQuery.post(window.location.href,
                                        {idsx_stiker_on_id: idArray,
                                            idsx_real_parent_id: idsx_real_parent_id,
                                            stiker: selected_id,
                                            idsx_stikerOn_key: 'On'});
                                // Отправка запроса для обновления страницы
                                jQuery.get(window.location.href,
                                        {parent_down: parent_id},
                                        AjaxSuccess);
                            }
                        },

                        "stikerOff": {
                            name: lang['button_stiker_delete'],
                            icon: function () {
                                return 'context-menu-icon glyphicon-trash';
                            },
                            disabled: function () {

                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                $('#confirm').modal('show');
                                $('#confirm_title').html(lang['attention']);
                                $('#confirm_body').html(lang['confirm_delete_stiker']);

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
                                    jQuery.post(window.location.href,
                                            {idsx_stiker_off_id: idArray,
                                                idsx_real_parent_id: idsx_real_parent_id,
                                                stiker: selected_id,
                                                idsx_stikerOff_key: 'Off'});
                                    // Отправка запроса для обновления страницы
                                    jQuery.get(window.location.href,
                                            {parent_down: parent_id},
                                            AjaxSuccess);
                                };
                            }
                        }
                    }
                },

                "sep15": "---------",

                "quit": {
                    name: lang['menu_exit'],
                    icon: function () {
                        return 'context-menu-icon glyphicon-remove';
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        opt.$menu.trigger("contextmenu:hide");
                    }
                }
            }
        });
    });


    // Обновление страницы
    function AjaxSuccess(data) {
        setTimeout(function () {
            $('#ajax').replaceWith($(data).find('#ajax'));
            Mouse.sortInitAll();
            $('[data-toggle="tooltip"]').tooltip();
        }, 100);
    }
</script>