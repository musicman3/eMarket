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
        // Установка на синхронный запрос через jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                {token_ajax: token,
                    ids: ids.join()});

        // Повторный вызов функции для нормального обновления страницы
        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                {parent_down: <?php echo $parent_id ?>}, // id родительской категории
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
                    callback: function (itemKey, opt, rootMenu, originalEvent) {

                        //Собираем данные для модального окна
                        <?php if (isset($name_edit)) { ?>

                            $('#edit').on('show.bs.modal', function (event) {
                                var modal = $(this);
                                var button = $(event.relatedTarget);
                                var modal_id = opt.$trigger.attr("id"); // Получаем ID при клике на кнопку редактирования
                                // Получаем массивы данных
                                var name_edit = <?php echo $name_edit ?>;

                                // Ищем классы и меняем данные
                                for (x = 0; x < name_edit.length; x++) {
                                    modal.find('.name_edit' + x).val(name_edit[x][modal_id]);
                                }

                                modal.find('.js_edit').val(modal_id);
                            });

                        <?php } ?>

                        $('#edit').modal('show'); // Открываем модальное окно
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
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка на синхронный запрос через jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                $(".option").each(function () { // выделенное мышкой
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                                {idsx_statusOn_id: this.id,
                                                    modify: 'ok',
                                                    idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                    idsx_statusOn_key: itemKey});

                                });
                                // Отправка пустого запроса для обновления страницы
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
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка на синхронный запрос через jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                $(".option").each(function () { // выделенное мышкой
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                                {idsx_statusOff_id: this.id,
                                                    modify: 'ok',
                                                    idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                                    idsx_statusOff_key: itemKey});
                                });
                                // Отправка пустого запроса для обновления страницы
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
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка на синхронный запрос через jQuery.ajax
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
                                // Отправка пустого запроса для обновления страницы
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
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка на синхронный запрос через jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                        {idsx_real_parent_id: '<?php echo $idsx_real_parent_id ?>',
                                            modify: 'ok',
                                            parent_down: <?php echo $parent_id ?>,
                                            idsx_paste_key: itemKey});

                                // Отправка пустого запроса для обновления страницы
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

                        "sep3": "---------",

                        "delete": {
                            name: "Удалить",
                            icon: function () {
                                return 'context-menu-icon glyphicon-trash';
                            },
                            callback: function (itemKey, opt, rootMenu, originalEvent) {
                                // Установка на синхронный запрос через jQuery.ajax
                                jQuery.ajaxSetup({async: false});
                                $(".option").each(function () { // выделенное мышкой
                                    if (!$(this).children().hasClass('inactive'))  // выделенное мышкой
                                        jQuery.get('/controller/admin/pages/stock/index.php', // отправка данных GET
                                                {idsx_delete_id: this.id,
                                                    modify: 'ok',
                                                    parent_down: <?php echo $parent_id ?>,
                                                    idsx_delete_key: itemKey});
                                });
                                // Отправка пустого запроса для обновления страницы
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
