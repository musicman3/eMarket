<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (!isset($idsx_real_parent_id)) {
    $idsx_real_parent_id = '';
}

?>
<!-- /Сортировка мышкой -->
<script type="text/javascript">
    $(document).ready(function () {
        $("#sort-list").sortable({
            items: 'tr.sort-list',
            handle: 'td.sortyes',
            axis: "y",
            over: function (event, ui) {
                ui.helper.css("opacity", "0.7"),
                        ui.helper.css("background-color", "#F5F5F5");
            },
            beforeStop: function (event, ui) {
                ui.helper.css("opacity", "1.0"),
                        ui.helper.css("background-color", "");
            },
            stop: function (event, ui) {
                sortList();
            }
        });
    });

    function sortList() {
        var ids = [];
        var token = '<?php echo $TOKEN ?>';
        $("#sort-list tr").each(function () {
            ids[ids.length] = $(this).attr('unitid');
        });
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.post('/controller/admin/pages/stock/index.php', // отправка данных POST
                {token_ajax: token,
                    ids: ids.join()});
        // Повторный вызов функции для нормального обновления страницы
        jQuery.get('<?php echo $VALID->inSERVER('REQUEST_URI') ?>', // отправка данных POST
                {}, // id родительской категории
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#fileupload-edit').fileupload('destroy');
            $('#fileupload-add').fileupload('destroy');
            $('#ajax').html(data);
        }
    }
</script>

<!-- /Выбор мышкой -->
<script type="text/javascript">
    $(".option").click(function () {
        $(this).find('span').toggleClass('inactive');
        $(this).toggleClass('active');
    });
</script>
<!-- /Выбор мышкой -->

<!-- /Контекстное меню -->
<script type="text/javascript">
    $(function () {
        $.contextMenu({
            selector: '.context-one',
            callback: function (itemKey, opt) {
                function send() {
                    $.ajax({
                        method: 'POST',
                        dataType: 'text',
                        url: '/controller/admin/pages/stock/index.php',
                        data: ({
                            itemName: itemKey, //название ключа из меню (edit, delete, copy и т.п.)
                            ids2: opt.$trigger.attr("id")}), //id строки
                        success: function (data) {
                            setTimeout(function () {
                                $('#fileupload-edit').fileupload('destroy');
                                $('#fileupload-add').fileupload('destroy');
                                editor.destroy();
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
                        $('#add_product').on('shown.bs.modal', function() {
                        $(document).off('focusin.modal');
                        });
                        $('#add_product').modal('show');
                    }
                }, 
                
                "sep": "---------",

                "add": {
                    name: "<?php echo lang('add_category') ?>",
                    icon: function () {
                        return 'context-menu-icon glyphicon-folder-open';
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $('#add').modal('show');
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
                    <?php if (!isset($name_edit)) { ?>
                            return true;
                    <?php } ?>
                    },
                    
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        
                        var modal_edit = opt.$trigger.attr("id");
                        
                        if (modal_edit.search('product_') > -1){
                            
                            $('#edit_product').on('show.bs.modal', function (event) {
                            // Получаем ID при клике на кнопку редактирования
                            var modal_id = modal_edit.split('product_')[1];
                            // Получаем массивы данных
                            var name_edit = $('div#ajax_data').data('nameproduct');

                            // Ищем id и добавляем данные
                            for (x = 0; x < name_edit.length; x++) {
                                $('#product_name_edit_' + x).val(name_edit[x][modal_id]);
                            }

                        });
                              
                        $('#edit_product').modal('show');   
                        //alert(modal_edit .split('product_')[1]);
                            
                        }else{
                                                
                        $('#edit').on('show.bs.modal', function (event) {
                            $('.progress-bar').css('width', 0 + '%');
                            $('.file-upload').detach();
                            $('#delete_image').val('');
                            $('#general_image_edit').val('');
                            $('#alert_messages_edit').empty();

                            // Получаем ID при клике на кнопку редактирования
                            var modal_id = opt.$trigger.attr("id");
                            // Получаем массивы данных
                            var name_edit = $('div#ajax_data').data('name');
                            var logo_edit = $('div#ajax_data').data('logo');
                            var logo_general_edit = $('div#ajax_data').data('general');

                            // Ищем id и добавляем данные
                            for (x = 0; x < name_edit.length; x++) {
                                $('#name_edit' + x).val(name_edit[x][modal_id]);
                            }
                            $('#js_edit').val(modal_id);

                            // Подгружаем изображения
                            getImageToEdit(logo_general_edit, logo_edit, modal_id);

                        });

                        // Открываем модальное окно
                        $('#edit').modal('show');    
                            
                        }

                    }
                },

                "sep": "---------",

                "fold": {
                    "name": "<?php echo lang('selected') ?>",
                    icon: function () {
                        return 'context-menu-icon glyphicon-ok';
                    },
                    "items": {

                        "statusOn": {
                            name: "<?php echo lang('button_show') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-eye-open';
                            },
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                            <?php if (!isset($name_edit)) { ?>
                                    return true;
                            <?php } ?>
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                // Отправка данных по каждой выделенной строке
                                $(".option").each(function () { // выделенное мышкой
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        jQuery.post('/controller/admin/pages/stock/index.php', // отправка данных POST
                                                {idsx_statusOn_id: this.id,
                                                    idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                    idsx_statusOn_key: itemKey});

                                });
                                // Отправка запроса для обновления страницы
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных POST
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#fileupload-edit').fileupload('destroy');
                                        $('#fileupload-add').fileupload('destroy');
                                        editor.destroy();
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
                            <?php if (!isset($name_edit)) { ?>
                                    return true;
                            <?php } ?>
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                // Отправка данных по каждой выделенной строке
                                $(".option").each(function () { // выделенное мышкой
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        jQuery.post('/controller/admin/pages/stock/index.php', // отправка данных POST
                                                {idsx_statusOff_id: this.id,
                                                    idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                    idsx_statusOff_key: itemKey});
                                });
                                // Отправка запроса для обновления страницы
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных POST
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#fileupload-edit').fileupload('destroy');
                                        $('#fileupload-add').fileupload('destroy');
                                        editor.destroy();
                                        $('#ajax').html(data);
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        },

                        "sep2": "---------",

                        "cut": {
                            name: "<?php echo lang('cut') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-scissors';
                            },
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                            <?php if (!isset($name_edit)) { ?>
                                    return true;
                            <?php } ?>
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                // Отправка маркера на очитку буффера
                                jQuery.post('/controller/admin/pages/stock/index.php', // отправка данных POST
                                        {idsx_cut_marker: 'cut'});

                                // Отправка данных по каждой выделенной строке
                                $(".option").each(function () { // выделенное мышкой
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        jQuery.post('/controller/admin/pages/stock/index.php', // отправка данных POST
                                                {idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                    idsx_cut_id: this.id,
                                                    parent_down: <?php echo $parent_id ?>,
                                                    idsx_cut_key: itemKey});
                                });
                                // Отправка запроса для обновления страницы
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных POST
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#fileupload-edit').fileupload('destroy');
                                        $('#fileupload-add').fileupload('destroy');
                                        editor.destroy();
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
                                // Делаем не активным пункт меню, если буффер пуст
                            <?php if (!isset($_SESSION['buffer'])) { ?>
                                    return true;
                            <?php } ?>
                            },

                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                jQuery.post('/controller/admin/pages/stock/index.php', // отправка данных POST
                                        {idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                            parent_down: <?php echo $parent_id ?>,
                                            idsx_paste_key: itemKey});

                                // Отправка запроса для обновления страницы
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных POST
                                        {parent_down: <?php echo $parent_id ?>,
                                            modify: 'update_ok'},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        document.location.href = '<?php echo $VALID->inSERVER('REQUEST_URI') ?>';
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        },

                        "sep3": "---------",

                        "delete": {
                            name: "<?php echo lang('button_delete') ?>",
                            icon: function () {
                                return 'context-menu-icon glyphicon-trash';
                            },
                            disabled: function () {
                                // Делаем не активным пункт меню, если нет строк
                            <?php if (!isset($name_edit)) { ?>
                                    return true;
                            <?php } ?>
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка синхронного запроса для jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                // Отправка данных по каждой выделенной строке
                                $(".option").each(function () { // выделенное мышкой
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        jQuery.post('/controller/admin/pages/stock/index.php', // отправка данных POST
                                                {delete: this.id,
                                                    parent_down: <?php echo $parent_id ?>});
                                });
                                // Отправка запроса для обновления страницы
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных POST
                                        {parent_down: <?php echo $parent_id ?>,
                                            modify: 'ok'},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#fileupload-edit').fileupload('destroy');
                                        $('#fileupload-add').fileupload('destroy');
                                        editor.destroy();
                                        $('#ajax').html(data);
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        }
                    }
                },
                "sep4": "---------",
                "quit": {name: "<?php echo lang('menu_exit') ?>", icon: function () {
                        return 'context-menu-icon glyphicon-remove';
                    }}
            }
        });
    });
</script>

<!-- Модальное окно "Добавить" -->
<script type="text/javascript">
    function callAdd() {
        var msg = $('#form_add').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '/controller/admin/pages/stock/index.php',
            data: msg,
            beforeSend: function (data) {
                $('#add').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных POST
                {parent_down: <?php echo $parent_id ?>,
                    modify: 'update_ok'},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            setTimeout(function () {
                document.location.href = '<?php echo $VALID->inSERVER('REQUEST_URI') ?>';
            }, 100);
            $("#sort-list").sortable();
        }
    }
</script>

<!-- Модальное окно "Редактировать" -->
<script type="text/javascript">
    function callEdit() {
        var msg = $('#form_edit').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '/controller/admin/pages/stock/index.php',
            data: msg,
            beforeSend: function (data) {
                $('#edit').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных POST
                {parent_down: <?php echo $parent_id ?>,
                    modify: 'ok'},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            setTimeout(function () {
                $('#fileupload-edit').fileupload('destroy');
                $('#fileupload-add').fileupload('destroy');
                editor.destroy();
                $('#ajax').html(data);
            }, 100);
            $("#sort-list").sortable();
        }
    }
</script>

<script type="text/javascript" src="/ext/ckeditor/ckeditor.js"></script>
<script>

</script>

<!-- Автовыбор языка Datepicker" -->
<script type="text/javascript" src="/ext/jquery/ui/i18n/datepicker-<?php echo lang('meta-language') ?>.js"></script>
<!-- Настройка Datepicker" -->
<script type="text/javascript">
    $(function () {
        $("#date_available, #date_available_edit").datepicker({
            showOtherMonths: true,
            showAnim: 'fadeIn',
            duration: 'normal',
            showWeek: true,
            selectOtherMonths: true
        });
    });
</script>

<!-- Модальное окно "Добавить" -->
<script type="text/javascript">
    function callAddProduct() {
        var msg = $('#form_add_product').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '/controller/admin/pages/stock/index.php',
            data: msg,
            beforeSend: function (data) {
                $('#add_product').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных POST
                {parent_down: <?php echo $parent_id ?>,
                    modify: 'update_ok'},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            setTimeout(function () {
                document.location.href = '<?php echo $VALID->inSERVER('REQUEST_URI') ?>';
            }, 100);
            $("#sort-list").sortable();
        }
    }
</script>

<?php
// Подгружаем jQuery File Upload
$AJAX->fileUpload('index.php', 'categories', $resize_param);

?>