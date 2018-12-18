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
        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                {token_ajax: token,
                    ids: ids.join()});

        // Повторный вызов функции для нормального обновления страницы
        jQuery.get('<?php echo $VALID->inSERVER('REQUEST_URI') ?>', // отправка данных GET
                {}, // id родительской категории
                AjaxSuccess);
        function AjaxSuccess(data) {
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
                        method: 'GET',
                        dataType: 'text',
                        url: '/controller/admin/pages/stock/index.php',
                        data: ({
                            itemName: itemKey, //название ключа из меню (edit, delete, copy и т.п.)
                            ids2: opt.$trigger.attr("id")}), //id строки
                        success: function (data) {
                            setTimeout(function () {
                                $('#ajax').html(data);
                            }, 1000);
                        }
                    });
                }
                ;
                return send();
            },
            items: {

                "add": {
                    name: "Добавить категорию",
                    icon: function () {
                        return 'context-menu-icon glyphicon-plus';
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $('#add').modal('show');
                    }
                },

                "edit": {
                    name: "Редактировать",
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

                        //Собираем данные для модального окна
                        <?php if (isset($name_edit)) { ?>

                            $('#edit').on('show.bs.modal', function (event) {
                                var modal = $(this);
                                var button = $(event.relatedTarget);
                                // Получаем ID при клике на кнопку редактирования
                                var modal_id = opt.$trigger.attr("id");
                                // Получаем массивы данных
                                var name_edit = <?php echo $name_edit ?>;

                                // Ищем классы и меняем данные
                                for (x = 0; x < name_edit.length; x++) {
                                    modal.find('.name_edit' + x).val(name_edit[x][modal_id]);
                                }
                                modal.find('.js_edit').val(modal_id);
                                
                            });

                        <?php } ?>
                        // Открываем модальное окно
                        $('#edit').modal('show');
                    }
                },

                "sep": "---------",

                "fold": {
                    "name": "Выбранное",
                    icon: function () {
                        return 'context-menu-icon glyphicon-ok';
                    },
                    "items": {

                        "statusOn": {
                            name: "Отобразить",
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
                                        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                                {idsx_statusOn_id: this.id,
                                                    idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                    idsx_statusOn_key: itemKey});

                                });
                                // Отправка запроса для обновления страницы
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#ajax').html(data);
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        },

                        "statusOff": {
                            name: "Скрыть",
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
                                        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                                {idsx_statusOff_id: this.id,
                                                    idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                    idsx_statusOff_key: itemKey});
                                });
                                // Отправка запроса для обновления страницы
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#ajax').html(data);
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        },

                        "sep2": "---------",

                        "cut": {
                            name: "Вырезать",
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
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                        {idsx_cut_marker: 'cut'});

                                // Отправка данных по каждой выделенной строке
                                $(".option").each(function () { // выделенное мышкой
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                                {idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                    idsx_cut_id: this.id,
                                                    parent_down: <?php echo $parent_id ?>,
                                                    idsx_cut_key: itemKey});
                                });
                                // Отправка запроса для обновления страницы
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                        {parent_down: <?php echo $parent_id ?>},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#ajax').html(data);
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        },

                        "paste": {
                            name: "Вставить",
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
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                        {idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                            parent_down: <?php echo $parent_id ?>,
                                            idsx_paste_key: itemKey});

                                // Отправка запроса для обновления страницы
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
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
                            name: "Удалить",
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
                                        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                                {idsx_delete_id: this.id,
                                                    parent_down: <?php echo $parent_id ?>,
                                                    idsx_delete_key: itemKey});
                                });
                                // Отправка запроса для обновления страницы
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                        {parent_down: <?php echo $parent_id ?>,
                                            modify: 'ok'},
                                        AjaxSuccess);
                                // Обновление страницы
                                function AjaxSuccess(data) {
                                    setTimeout(function () {
                                        $('#ajax').html(data);
                                    }, 100);
                                    $("#sort-list").sortable();
                                }
                            }
                        }
                    }
                },
                "sep4": "---------",
                "quit": {name: "Выход", icon: function () {
                        return 'context-menu-icon glyphicon-remove';
                    }}
            }
        });
    });
</script>

<!-- Модальное окно "Добавить категорию" -->
<script type="text/javascript" language="javascript">
    function call_add() {
        var msg = $('#form_add').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'GET',
            url: '/controller/admin/pages/stock/index.php',
            data: msg,
            success: function (data) {
                $('#add').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
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

<!-- Модальное окно "Редактировать категорию" -->
<script type="text/javascript" language="javascript">
    function call_edit() {
        var msg = $('#form_edit').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'GET',
            url: '/controller/admin/pages/stock/index.php',
            data: msg,
            success: function (data) {
                $('#edit').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                {parent_down: <?php echo $parent_id ?>,
                    modify: 'ok'},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            setTimeout(function () {
                $('#ajax').html(data);
            }, 100);
            $("#sort-list").sortable();
        }
    }
</script>