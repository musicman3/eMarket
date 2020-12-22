/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Модуль Распродажа
 *
 * @package DiscountSales
 * @author eMarket
 * 
 */
class DiscountSale {

    /**
     * Вывод в контекстное меню
     * @param sales_interface {Array} (входящий массив)
     * @return output {Object} (исходящие данные)
     *
     */
    static context(sales_interface) {

        var lang = sales_interface[0];
        var parent_id = sales_interface[1];
        var idsx_real_parent_id = sales_interface[2];
        var sales = sales_interface[3];
        var sale = sales_interface[4];
        var sale_dafault = sales_interface[5];

        var output = {
            name: lang['modules_discount_sale_admin_button_sale'],
            icon: function () {
                return 'context-menu-icon glyphicon-tag';
            },
            disabled: function () {
                // Делаем не активным пункт меню, если нет строк
                if (sale === '0' || $('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
                    return true;
                }
            },

            items: {
                sale: {
                    type: 'select',
                    options: sales,
                    selected: sale_dafault,
                    disabled: function () {
                        // Делаем не активным пункт меню, если нет строк
                        if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
                            return true;
                        }
                    }
                },

                sale_sep_1: "---------",

                saleOn: {
                    name: lang['modules_discount_sale_admin_button_sale_on'],
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
                        jQuery.post(window.location.href,
                                {idsx_sale_on_id: idArray,
                                    idsx_real_parent_id: idsx_real_parent_id,
                                    sale: selected_id,
                                    idsx_sale_on_key: 'On'});
                        // Отправка запроса для обновления страницы
                        jQuery.get(window.location.href,
                                {parent_down: parent_id},
                                AjaxSuccess);
                    },
                    icon: function () {
                        return 'context-menu-icon glyphicon-star';
                    }
                },

                saleOff: {
                    name: lang['modules_discount_sale_admin_button_sale_off'],
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
                        $('#confirm_title').html(lang['modules_discount_sale_admin_attention']);
                        $('#confirm_body').html(lang['modules_discount_sale_admin_confirm_delete_sale']);

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
                            jQuery.post(window.location.href,
                                    {idsx_sale_off_id: idArray,
                                        idsx_real_parent_id: idsx_real_parent_id,
                                        sale: selected_id,
                                        idsx_sale_off_key: 'Off'});
                            // Отправка запроса для обновления страницы
                            jQuery.get(window.location.href,
                                    {parent_down: parent_id},
                                    AjaxSuccess);
                        };
                    }
                },

                sale_sep_2: "---------",

                saleOffAll: {
                    name: lang['modules_discount_sale_admin_button_sale_off_all'],
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
                        $('#confirm_title').html(lang['modules_discount_sale_admin_attention']);
                        $('#confirm_body').html(lang['modules_discount_sale_admin_confirm_delete_sales']);

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
                            jQuery.post(window.location.href,
                                    {idsx_sale_off_all_id: idArray,
                                        idsx_real_parent_id: idsx_real_parent_id,
                                        idsx_sale_off_all_key: 'OffAll'});
                            // Отправка запроса для обновления страницы
                            jQuery.get(window.location.href,
                                    {parent_down: parent_id},
                                    AjaxSuccess);
                        };
                    }
                }
            }
        };

        return output;
    }
}