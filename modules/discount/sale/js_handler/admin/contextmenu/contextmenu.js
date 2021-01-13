/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * DiscountSale
 *
 * @package DiscountSales
 * @author eMarket
 * 
 */
class DiscountSale {

    /**
     * Outputting data to context menu
     * @param discounts_interface {Array} (input data)
     * @return output {Object} (output data)
     *
     */
    static context(discounts_interface) {

        var lang = discounts_interface[0];
        var parent_id = discounts_interface[1];
        var idsx_real_parent_id = discounts_interface[2];
        var discounts = discounts_interface[3];
        var discount = discounts_interface[4];
        var discount_dafault = discounts_interface[5];

        var output = {
            name: lang['modules_discount_sale_admin_button_sale'],
            icon: function () {
                return 'context-menu-icon glyphicon-tag';
            },
            disabled: function () {
                if (discount === '0' || $('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
                    return true;
                }
            },

            items: {
                sale: {
                    type: 'select',
                    options: discounts,
                    selected: discount_dafault,
                    disabled: function () {
                        if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
                            return true;
                        }
                    }
                },

                sale_sep_1: "---------",

                saleOn: {
                    name: lang['modules_discount_sale_admin_button_sale_on'],
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        var selected_id = $('select[name="context-menu-input-sale"] option:selected').val();
                        jQuery.ajaxSetup({async: false});
                        var idArray = [];
                        $(".option").each(function (i) {
                            if (!$(this).children().hasClass('inactive'))
                                idArray[i] = this.id;
                        });
                        jQuery.post(window.location.href,
                                {idsx_sale_on_id: idArray,
                                    idsx_real_parent_id: idsx_real_parent_id,
                                    sale: selected_id,
                                    idsx_sale_on_key: 'On'});
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
                            var selected_id = $('select[name="context-menu-input-sale"] option:selected').val();
                            jQuery.ajaxSetup({async: false});
                            var idArray = [];
                            $(".option").each(function (i) {
                                if (!$(this).children().hasClass('inactive'))
                                    idArray[i] = this.id;
                            });
                            jQuery.post(window.location.href,
                                    {idsx_sale_off_id: idArray,
                                        idsx_real_parent_id: idsx_real_parent_id,
                                        sale: selected_id,
                                        idsx_sale_off_key: 'Off'});
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
                            var selected_id = $('select[name="context-menu-input-sale"] option:selected').val();
                            jQuery.ajaxSetup({async: false});
                            var idArray = [];
                            $(".option").each(function (i) {
                                if (!$(this).children().hasClass('inactive'))
                                    idArray[i] = this.id;
                            });
                            jQuery.post(window.location.href,
                                    {idsx_sale_off_all_id: idArray,
                                        idsx_real_parent_id: idsx_real_parent_id,
                                        idsx_sale_off_all_key: 'OffAll'});
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