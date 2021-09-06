<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMark
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

foreach (\eMarket\Core\Modules::discountRouter('data') as $js_path) {
    echo '<script type="text/javascript" src="/modules/discount/' . $js_path . '/js_handler/admin/contextmenu/contextmenu.js"></script>';
}
?>
<link rel="stylesheet" type="text/css" href="/ext/ctxmenu/ctxmenu.css" media="screen" />
<script src="/ext/ctxmenu/ctxmenu.min.js"></script>

<script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function () {
        contextMenuInit();
    });

    ctxmenu.attach('#sort-list', []);
    var picker = Stock.pikaday();

    function contextMenuInit() {
        var buttons = document.querySelectorAll('.context-one');
        buttons.forEach(function (button) {
            button.addEventListener('mousedown', function (e) {

                var elem = e.currentTarget;
                var session = '<?php echo \eMarket\Admin\Stock::$ses_verify ?>';
                let parent_id = '<?php echo \eMarket\Admin\Stock::$parent_id ?>';
                var idsx_real_parent_id = '<?php echo \eMarket\Admin\Stock::$idsx_real_parent_id ?>';
                var discounts = {<?php echo \eMarket\Core\Modules::$discounts ?>};
                var discount_dafault = {<?php echo \eMarket\Core\Modules::$discount_default ?>};
                var sticker = '<?php echo \eMarket\Admin\Stickers::$stickers_flag ?>';
                var stickers = {<?php echo \eMarket\Admin\Stickers::$stickers ?>};
                var stickers_default = '<?php echo \eMarket\Admin\Stickers::$stickers_default ?>';
                var attributes_category = <?php echo json_encode(\eMarket\Admin\Stock::$attributes_category) ?>;
                var lang_name = '<?php echo lang('#lang_all')[0] ?>';

                var discounts_interface = [
                    lang,
                    parent_id,
                    idsx_real_parent_id,
                    discounts,
                    discount_dafault
                ];

                var stickers_options = '';
                for (key in stickers) {
                    stickers_options = stickers_options + '<option value="' + key + '">' + stickers[key] + '</option>';
                }

                var json_data_product = JSON.parse(document.querySelector('#ajax_data').dataset.jsondataproduct);
                var json_data_category = JSON.parse(document.querySelector('#ajax_data').dataset.jsondatacategory);

                var menuDefinition = [
                    {
                        // ---------- Add product ----------
                        text: '<span class="bi-cart-plus"> ' + lang['add_product'] + '</span>',
                        action: function () {
                            document.querySelector('#selected_attributes').value = JSON.stringify([]);
                            AttributesProcessing.add('admin', attributes_category, lang_name);

                            document.querySelector('#edit_product').value = '';
                            document.querySelector('#add_product').value = 'ok';
                            document.querySelectorAll('form').forEach(e => e.reset());
                            document.querySelector('.wysiwyg').value = '';
                            new bootstrap.Modal(document.querySelector('#index_product')).show();
                        },
                        disabled: (new URL(document.location)).searchParams.get('search') !== null || Number(parent_id) === 0
                    },

                    {isDivider: true},

                    {
                        // ---------- Add Category ----------
                        text: '<span class="bi-folder-plus"> ' + lang['add_category'] + '</span>',
                        action: function () {
                            document.querySelector('#edit').value = '';
                            document.querySelector('#add').value = 'ok';
                            document.querySelectorAll('form').forEach(e => e.reset());
                            new bootstrap.Modal(document.querySelector('#index')).show();
                        },
                        disabled: (new URL(document.location)).searchParams.get('search') !== null
                    },

                    {isDivider: true},

                    {
                        // ---------- Edit ----------
                        text: '<span class="bi-pencil-square"> ' + lang['button_edit'] + '</span>',
                        action: function () {
                            var modal_edit = elem.id;
                            if (modal_edit.search('product_') > -1) {

                                document.querySelectorAll('.progress-bar').forEach(e => e.setAttribute("style", "width: 0%;"));
                                document.querySelectorAll('.file-upload').forEach(e => e.innerHTML = '');

                                document.querySelector('#delete_image_product').value = '';
                                document.querySelector('#general_image_edit_product').value = '';
                                var modal_id = modal_edit.split('product_')[1];

                                for (var x = 0; x < json_data_product.name.length; x++) {
                                    document.querySelector('#name_product_stock_' + x).value = json_data_product.name[x][modal_id];
                                    tinymce.get('description_product_stock_' + x).setContent(json_data_product.description[x][modal_id]);
                                    document.querySelector('#keyword_product_stock_' + x).value = json_data_product.keyword[x][modal_id];
                                    document.querySelector('#tags_product_stock_' + x).value = json_data_product.tags[x][modal_id];
                                }

                                document.querySelector('#price_product_stock').value = json_data_product.price[modal_id];
                                document.querySelector('#currency_product_stock').value = json_data_product.currency[modal_id];
                                document.querySelector('#quantity_product_stock').value = json_data_product.quantity[modal_id];
                                document.querySelector('#unit_product_stock').value = json_data_product.units[modal_id];
                                document.querySelector('#model_product_stock').value = json_data_product.model[modal_id];
                                document.querySelector('#manufacturers_product_stock').value = json_data_product.manufacturers[modal_id];

                                if (json_data_product.date_available[modal_id] === null) {
                                    picker.setDate('');
                                } else {
                                    picker.setDate(new Date(json_data_product.date_available[modal_id]));
                                }

                                document.querySelector('#tax_product_stock').value = json_data_product.tax[modal_id];
                                document.querySelector('#vendor_code_value_product_stock').value = json_data_product.vendor_code_value[modal_id];
                                document.querySelector('#vendor_codes_product_stock').value = json_data_product.vendor_code[modal_id];
                                document.querySelector('#weight_value_product_stock').value = json_data_product.weight_value[modal_id];
                                document.querySelector('#weight_product_stock').value = json_data_product.weight[modal_id];
                                document.querySelector('#min_quantity_product_stock').value = json_data_product.min_quantity[modal_id];
                                document.querySelector('#length_product_stock').value = json_data_product.dimension[modal_id];
                                document.querySelector('#value_length_product_stock').value = json_data_product.length[modal_id];
                                document.querySelector('#value_width_product_stock').value = json_data_product.width[modal_id];
                                document.querySelector('#value_height_product_stock').value = json_data_product.height[modal_id];
                                document.querySelector('#selected_attributes').value = JSON.stringify(json_data_product.attributes[modal_id]);

                                AttributesProcessing.add('admin', json_data_product.attributes_data[modal_id], lang_name);

                                document.querySelector('#edit_product').value = modal_id;
                                document.querySelector('#add_product').value = '';
                                FileuploadProduct.getImageToEditProduct(json_data_product.logo_general, json_data_product.logo, modal_id, 'products');
                                new bootstrap.Modal(document.querySelector('#index_product')).show();
                            } else {
                                var modal_id = modal_edit.split('category_')[1];

                                for (var x = 0; x < json_data_category['name'].length; x++) {
                                    document.querySelector('#name_categories_stock_' + x).value = json_data_category.name[x][modal_id];
                                }
                                document.querySelector('#attributes').value = json_data_category.attributes;

                                document.querySelector('#edit').value = modal_id;
                                document.querySelector('#add').value = '';

                                Fileupload.getImageToEdit(json_data_category.logo_general, json_data_category.logo, modal_id, 'categories');
                                sessionStorage.setItem('attributes', JSON.stringify(json_data_category.attributes[modal_id]));
                                new bootstrap.Modal(document.querySelector('#index')).show();
                            }
                        },
                        disabled: json_data_product.name === undefined && json_data_category.name === undefined
                    },

                    {isDivider: true},

                    {
                        // ---------- Action ----------
                        text: '<span class="bi-box-arrow-in-right"> ' + lang['button_action'] + '</span>',
                        disabled: json_data_product.name === undefined && json_data_category.name === undefined && session === '0',
                        subMenu: [
                            {
                                // ---------- Show ----------
                                text: '<span class="bi-eye"> ' + lang['button_show'] + '</span>',
                                action: function () {
                                    var idArray = [];
                                    document.querySelectorAll('.table-primary').forEach(function (string, index) {
                                        idArray[index] = string.id;
                                    });
                                    Ajax.postData(window.location.href, {
                                        idsx_status_on_id: idArray,
                                        idsx_real_parent_id: idsx_real_parent_id,
                                        idsx_status_on_key: 'On'
                                    }, false).then((data) => {
                                        Ajax.postData(window.location.href, {
                                            parent_down: parent_id
                                        });
                                    });

                                },
                                disabled: json_data_product.name === undefined && json_data_category.name === undefined
                            },
                            {
                                // ---------- Hide ----------
                                text: '<span class="bi-eye-slash"> ' + lang['button_hide'] + '</span>',
                                action: function () {
                                    var idArray = [];
                                    document.querySelectorAll('.table-primary').forEach(function (string, index) {
                                        idArray[index] = string.id;
                                    });
                                    Ajax.postData(window.location.href, {
                                        idsx_status_off_id: idArray,
                                        idsx_real_parent_id: idsx_real_parent_id,
                                        idsx_status_off_key: 'Off'
                                    }, false).then((data) => {
                                        Ajax.postData(window.location.href, {
                                            parent_down: parent_id
                                        });
                                    });
                                },
                                disabled: json_data_product.name === undefined && json_data_category.name === undefined
                            },
                            {
                                // ---------- Cut ----------
                                text: '<span class="bi-scissors"> ' + lang['cut'] + '</span>',
                                action: function () {
                                    Ajax.postData(window.location.href, {idsx_cut_marker: 'cut'}, false);
                                    var idArray = [];
                                    document.querySelectorAll('.table-primary').forEach(function (string, index) {
                                        idArray[index] = string.id;
                                    });
                                    Ajax.postData(window.location.href, {
                                        idsx_real_parent_id: idsx_real_parent_id,
                                        idsx_cut_id: idArray,
                                        idsx_cut_key: 'cut'
                                    }, false).then((data) => {
                                        Ajax.postData(window.location.href, {
                                            parent_down: parent_id
                                        });
                                    });
                                },
                                disabled: json_data_product.name === undefined && json_data_category.name === undefined
                            },
                            {
                                // ---------- Paste ----------
                                text: '<span class="bi-clipboard-check"> ' + lang['paste'] + '</span>',
                                action: function () {
                                    Ajax.postData(window.location.href, {
                                        idsx_real_parent_id: idsx_real_parent_id,
                                        idsx_paste_key: 'paste'
                                    }, false).then((data) => {
                                        Ajax.postData(window.location.href, {
                                            parent_down: parent_id,
                                            message: 'ok'
                                        });
                                    });
                                },
                                disabled: session === '0' || (new URL(document.location)).searchParams.get('search') !== null
                            },

                            {isDivider: true},

                            {
                                // ---------- Delete ----------
                                text: '<span class="bi-trash"> ' + lang['button_delete'] + '</span>',
                                action: function () {
                                    new bootstrap.Modal(document.querySelector('#confirm')).show();
                                    document.querySelector('#confirm_title').innerHTML = lang['attention'];
                                    document.querySelector('#confirm_body').innerHTML = lang['confirm_delete_product_or_category'];

                                    confirmation.onclick = function () {
                                        bootstrap.Modal.getInstance(document.querySelector('#confirm')).hide();
                                        var idArray = [];
                                        document.querySelectorAll('.table-primary').forEach(function (string, index) {
                                            idArray[index] = string.id;
                                        });
                                        Ajax.postData(window.location.href, {
                                            delete: idArray
                                        }, false).then((data) => {
                                            Ajax.postData(window.location.href, {
                                                parent_down: parent_id,
                                                message: 'ok'
                                            });
                                        });
                                    };
                                },
                                disabled: json_data_product.name === undefined && json_data_category.name === undefined
                            }
                        ]
                    },<?php echo \eMarket\Core\Modules::discountRouter('functions') ?>, // ---------- Discounts ----------
                    {
                        // ---------- Sticker ----------
                        text: '<span class="bi-bookmark"> ' + lang['button_sticker'] + '</span>',
                        disabled: sticker === '0' || json_data_product.name === undefined,
                        subMenu: [
                            {
                                // ---------- Sticker select ----------
                                html: '<span><select class="form-select" name="context-menu-input-sticker">' + stickers_options + '</select></span>'
                            },
                            {
                                // ---------- Add sticker ----------
                                text: '<span class="bi-bookmark-plus"> ' + lang['button_sticker_add'] + '</span>',
                                action: function () {
                                    var selected_id = document.querySelector('[name="context-menu-input-sticker"]').value;
                                    var idArray = [];
                                    document.querySelectorAll('.table-primary').forEach(function (string, index) {
                                        idArray[index] = string.id;
                                    });
                                    Ajax.postData(window.location.href, {
                                        idsx_sticker_on_id: idArray,
                                        idsx_real_parent_id: idsx_real_parent_id,
                                        sticker: selected_id,
                                        idsx_stickerOn_key: 'On'
                                    }, false).then((data) => {
                                        Ajax.postData(window.location.href, {
                                            parent_down: parent_id
                                        });
                                    });
                                },
                                disabled: false
                            },
                            {
                                // ---------- Delete sticker ----------
                                text: '<span class="bi-bookmark-dash"> ' + lang['button_sticker_delete'] + '</span>',
                                action: function () {
                                    new bootstrap.Modal(document.querySelector('#confirm')).show();
                                    document.querySelector('#confirm_title').innerHTML = lang['attention'];
                                    document.querySelector('#confirm_body').innerHTML = lang['confirm_delete_sticker'];
                                    var selected_id = document.querySelector('[name="context-menu-input-sticker"]').value;

                                    confirmation.onclick = function () {
                                        bootstrap.Modal.getInstance(document.querySelector('#confirm')).hide();
                                        var idArray = [];
                                        document.querySelectorAll('.table-primary').forEach(function (string, index) {
                                            idArray[index] = string.id;
                                        });
                                        Ajax.postData(window.location.href, {
                                            idsx_sticker_off_id: idArray,
                                            idsx_real_parent_id: idsx_real_parent_id,
                                            sticker: selected_id,
                                            idsx_stickerOff_key: 'Off'
                                        }, false).then((data) => {
                                            Ajax.postData(window.location.href, {
                                                parent_down: parent_id
                                            });
                                        });
                                    };
                                },
                                disabled: false
                            }
                        ]
                    },

                    {isDivider: true},

                    {
                        // ---------- Exit ----------
                        text: '<span class="bi-box-arrow-right"> ' + lang['menu_exit'] + '</span>',
                        action: function () {
                        },
                        disabled: false
                    }
                ];
                ctxmenu.update('#' + elem.id, menuDefinition);
            });
        });
    }

    /**
     * Ajax Success
     *
     *@param data {Object} (ajax data)
     */
    function AjaxSuccess(data) {
        setTimeout(function () {
            var ajax_data = document.createElement('div');
            ajax_data.innerHTML = data;
            document.querySelector('#ajax').replaceWith(ajax_data.querySelector('#ajax'));
            contextMenuInit();
            Mouse.sortInitAll();

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            new TableSelect(document.querySelector('#table-id'), {
                selectedClassName: 'table-primary',
                shouldSelectRow(row) {
                    return !row.classList.contains('unselectable');
                }
            });
            document.querySelector('#table-id').addEventListener('mousedown', function (event) {
                if (event.ctrlKey) {
                    event.preventDefault();
                }
            });
        }, 100);
    }
</script>