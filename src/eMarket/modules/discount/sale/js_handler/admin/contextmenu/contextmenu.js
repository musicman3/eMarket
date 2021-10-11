/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global AjaxSuccess, confirmation, json_data_category, json_data_product, Ajax, bootstrap */

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

        var discounts = new Object();
        for (var key in discounts_interface[3]) {
            var discount_name = key.split('_');
            if (discount_name[0] === 'sale') {
                discounts[discount_name[1]] = discounts_interface[3][key];
            }
        }

        var discounts_options = '';
        var discounts_view = 0;
        for (key in discounts) {
            discounts_options = discounts_options + '<option value="' + key + '">' + discounts[key] + '</option>';
            if (key !== '' || key !== undefined) {
                discounts_view++;
            }
        }

        var discount_dafault = '';
        for (var key in discounts_interface[4]) {
            var default_id = key.split('_');
            if (default_id[0] === 'sale') {
                discount_dafault = default_id[1];
            }
        }

        var lang = discounts_interface[0];
        var parent_id = discounts_interface[1];
        var idsx_real_parent_id = discounts_interface[2];

        var json_data_product = JSON.parse(document.querySelector('#ajax_data').dataset.jsondataproduct);
        var json_data_category = JSON.parse(document.querySelector('#ajax_data').dataset.jsondatacategory);

        var output = {
            // ---------- Sale ----------
            text: '<span class="bi-star"> ' + lang['modules_discount_sale_admin_button_sale'] + '</span>',
            disabled: discounts_view === 0 || discounts.length === 0 || json_data_product.name === undefined && json_data_category.name === undefined,
            subMenu: [
                {
                    // ---------- Sale select ----------
                    html: '<span><select class="form-select" name="context-menu-input-sale">' + discounts_options + '</select></span>'
                },
                {
                    // ---------- Add to sale ----------
                    text: '<span class="bi-star-fill"> ' + lang['modules_discount_sale_admin_button_sale_on'] + '</span>',
                    action: function () {
                        var selected_id = document.querySelector('[name="context-menu-input-sale"]').value;
                        var idArray = [];
                        document.querySelectorAll('.table-primary').forEach(function (string, index) {
                            idArray[index] = string.id;
                        });
                        Ajax.postData(window.location.href, {
                            idsx_sale_on_id: idArray,
                            idsx_real_parent_id: idsx_real_parent_id,
                            sale: selected_id,
                            idsx_sale_on_key: 'On'
                        }, false).then((data) => {
                            Ajax.postData(window.location.href, {
                                parent_down: parent_id
                            });
                        });
                    },
                    disabled: json_data_product.name === undefined && json_data_category.name === undefined

                },
                {
                    // ---------- Remove from sale ----------
                    text: '<span class="bi-star"> ' + lang['modules_discount_sale_admin_button_sale_off'] + '</span>',
                    action: function () {
                        new bootstrap.Modal(document.querySelector('#confirm')).show();
                        document.querySelector('#confirm_title').innerHTML = lang['modules_discount_sale_admin_attention'];
                        document.querySelector('#confirm_body').innerHTML = lang['modules_discount_sale_admin_confirm_delete_sale'];
                        var selected_id = document.querySelector('[name="context-menu-input-sale"]').value;
                        confirmation.onclick = function () {
                            bootstrap.Modal.getInstance(document.querySelector('#confirm')).hide();
                            var idArray = [];
                            document.querySelectorAll('.table-primary').forEach(function (string, index) {
                                idArray[index] = string.id;
                            });
                            Ajax.postData(window.location.href, {
                                idsx_sale_off_id: idArray,
                                idsx_real_parent_id: idsx_real_parent_id,
                                sale: selected_id,
                                idsx_sale_off_key: 'Off'
                            }, false).then((data) => {
                                Ajax.postData(window.location.href, {
                                    parent_down: parent_id
                                });
                            });
                        };
                    },
                    disabled: json_data_product.name === undefined && json_data_category.name === undefined

                },
                {
                    // ---------- Remove all sales ----------
                    text: '<span class="bi-lightning-fill"> ' + lang['modules_discount_sale_admin_button_sale_off_all'] + '</span>',
                    action: function () {
                        new bootstrap.Modal(document.querySelector('#confirm')).show();
                        document.querySelector('#confirm_title').innerHTML = lang['modules_discount_sale_admin_attention'];
                        document.querySelector('#confirm_body').innerHTML = lang['modules_discount_sale_admin_confirm_delete_sales'];

                        confirmation.onclick = function () {
                            bootstrap.Modal.getInstance(document.querySelector('#confirm')).hide();
                            var idArray = [];
                            document.querySelectorAll('.table-primary').forEach(function (string, index) {
                                idArray[index] = string.id;
                            });

                            Ajax.postData(window.location.href, {
                                idsx_sale_off_all_id: idArray,
                                idsx_real_parent_id: idsx_real_parent_id,
                                idsx_sale_off_all_key: 'OffAll'
                            }, false).then((data) => {
                                Ajax.postData(window.location.href, {
                                    parent_down: parent_id
                                });
                            });
                        };
                    },
                    disabled: json_data_product.name === undefined && json_data_category.name === undefined
                }
            ]
        };

        return output;
    }
}