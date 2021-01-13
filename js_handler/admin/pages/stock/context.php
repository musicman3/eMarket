<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMark
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

foreach (\eMarket\Modules::discountRouter('data') as $js_path) {
    echo '<script type="text/javascript" src="/modules/discount/' . $js_path . '/js_handler/admin/contextmenu/contextmenu.js"></script>';
}
?>

<script type="text/javascript">

    $(function () {
        var session = '<?php echo \eMarket\Admin\Stock::$ses_verify ?>';
        var lang = <?php echo json_encode(lang()) ?>;
        let parent_id = '<?php echo \eMarket\Admin\Stock::$parent_id ?>';
        var idsx_real_parent_id = '<?php echo \eMarket\Admin\Stock::$idsx_real_parent_id ?>';
        var discounts = {<?php echo \eMarket\Modules::$discounts ?>};
        var discount_dafault = {<?php echo \eMarket\Modules::$discount_default ?>};
        var stiker = '<?php echo \eMarket\Admin\Stikers::$stikers_flag ?>';
        var stikers = {<?php echo \eMarket\Admin\Stikers::$stikers ?>};
        var stikers_default = '<?php echo \eMarket\Admin\Stikers::$stikers_default ?>';
        var attributes_category = <?php echo json_encode(\eMarket\Admin\Stock::$attributes_category) ?>;

        var discounts_interface = [
            lang,
            parent_id,
            idsx_real_parent_id,
            discounts,
            discount_dafault
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
                        if (params.get('search') !== null || Number(parent_id) === 0) {
                            return true;
                        }
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $('#selected_attributes').val(JSON.stringify([]));
                        AttributesProcessing.add('admin', attributes_category, '<?php echo lang('#lang_all')[0] ?>');

                        $('#edit_product').val('');
                        $('#add_product').val('ok');
                        $(this).find('form').trigger('reset');
                        $('.summernote_add').val('');
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
                        if (params.get('search') !== null) {
                            return true;
                        }
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $('#edit').val('');
                        $('#add').val('ok');
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
                            var modal_id = modal_edit.split('product_')[1];
                            var json_data = $('div#ajax_data').data('jsondataproduct');

                            $('.summernote_add').summernote(summernote_pref);

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

                            AttributesProcessing.add('admin', json_data['attributes_data'][modal_id], '<?php echo lang('#lang_all')[0] ?>');

                            $('#edit_product').val(modal_id);
                            $('#add_product').val('');
                            FileuploadProduct.getImageToEditProduct(json_data['logo_general'], json_data['logo'], modal_id, 'products');

                            $('#index_product').modal('show');
                        } else {
                            var modal_id = opt.$trigger.attr("id");

                            var json_data = $('div#ajax_data').data('jsondatacategory');

                            for (var x = 0; x < json_data['name'].length; x++) {
                                $('#name_categories_stock_' + x).val(json_data['name'][x][modal_id]);
                            }
                            $('#attributes').val(json_data['attributes']);

                            $('#edit').val(modal_id);
                            $('#add').val('');
                            Fileupload.getImageToEdit(json_data['logo_general'], json_data['logo'], modal_id, 'categories');
                            sessionStorage.setItem('attributes', JSON.stringify(json_data['attributes'][modal_id]));
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
                                if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                jQuery.ajaxSetup({async: false});
                                var idArray = [];
                                $(".option").each(function (i) {
                                    if (!$(this).children().hasClass('inactive'))
                                        idArray[i] = this.id;
                                });
                                jQuery.post(window.location.href,
                                        {idsx_status_on_id: idArray,
                                            idsx_real_parent_id: idsx_real_parent_id,
                                            idsx_status_on_key: 'On'});
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
                                if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                jQuery.ajaxSetup({async: false});
                                var idArray = [];
                                $(".option").each(function (i) {
                                    if (!$(this).children().hasClass('inactive'))
                                        idArray[i] = this.id;
                                });
                                jQuery.post(window.location.href,
                                        {idsx_status_off_id: idArray,
                                            idsx_real_parent_id: idsx_real_parent_id,
                                            idsx_status_off_key: 'Off'});
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
                                if ($('div#ajax_data').data('jsondataproduct')['name'] === undefined && $('div#ajax_data').data('jsondatacategory')['name'] === undefined) {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                jQuery.ajaxSetup({async: false});
                                jQuery.post(window.location.href,
                                        {idsx_cut_marker: 'cut'});
                                var idArray = [];
                                $(".option").each(function (i) {
                                    if (!$(this).children().hasClass('inactive'))
                                        idArray[i] = this.id;
                                });
                                jQuery.post(window.location.href,
                                        {idsx_real_parent_id: idsx_real_parent_id,
                                            idsx_cut_id: idArray,
                                            parent_down: parent_id,
                                            idsx_cut_key: itemKey});
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
                                let params = (new URL(document.location)).searchParams;
                                if (session === '0' || params.get('search') !== null) {
                                    return true;
                                }
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                jQuery.ajaxSetup({async: false});
                                jQuery.post(window.location.href,
                                        {idsx_real_parent_id: idsx_real_parent_id,
                                            parent_down: parent_id,
                                            idsx_paste_key: itemKey});
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
                                    jQuery.ajaxSetup({async: false});
                                    var idArray = [];
                                    $(".option").each(function (i) {
                                        if (!$(this).children().hasClass('inactive'))
                                            idArray[i] = this.id;
                                    });
                                    jQuery.post(window.location.href,
                                            {delete: idArray,
                                                parent_down: parent_id});
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

                                var selected_id = $('select[name="context-menu-input-stiker"] option:selected').val();
                                jQuery.ajaxSetup({async: false});
                                var idArray = [];
                                $(".option").each(function (i) {
                                    if (!$(this).children().hasClass('inactive'))
                                        idArray[i] = this.id;
                                });
                                jQuery.post(window.location.href,
                                        {idsx_stiker_on_id: idArray,
                                            idsx_real_parent_id: idsx_real_parent_id,
                                            stiker: selected_id,
                                            idsx_stikerOn_key: 'On'});
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
                                    var selected_id = $('select[name="context-menu-input-stiker"] option:selected').val();
                                    jQuery.ajaxSetup({async: false});
                                    var idArray = [];
                                    $(".option").each(function (i) {
                                        if (!$(this).children().hasClass('inactive'))
                                            idArray[i] = this.id;
                                    });
                                    jQuery.post(window.location.href,
                                            {idsx_stiker_off_id: idArray,
                                                idsx_real_parent_id: idsx_real_parent_id,
                                                stiker: selected_id,
                                                idsx_stikerOff_key: 'Off'});
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

    function AjaxSuccess(data) {
        setTimeout(function () {
            $('#ajax').replaceWith($(data).find('#ajax'));
            Mouse.sortInitAll();
            $('[data-toggle="tooltip"]').tooltip();
        }, 100);
    }
</script>