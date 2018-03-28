<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>

<?php if (isset($_SESSION['login']) && isset($_SESSION['pass'])) { // Выводим если авторизованы    ?>

    <div id="footerwrap">
        <footer class="clearfix"></footer>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p><img src="/view/default/admin/images/emarket.png" width="80" alt="" class="img-responsive center-block"></p>

                    <p>Copyright (c) 2018-<?php echo date('Y') ?>, <a href="#">eMarket Team</a>. All rights reserved.</p>
                </div>
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /footerwrap -->

    <?php
}
if (isset($j) == false) {
    $j = 0;
}
if (isset($TOKEN) == false) {
    $TOKEN = 0;
}

?>
<!-- /Выбрать все селекты -->
<script type="text/javascript">
    $(function () {
        $("input.select-all").click(function () {
            var checked = this.checked;
            $("input.select-item").each(function (index, item) {
                item.checked = checked;
            });
        });
    });
</script>

<!-- /Сортировка мышкой -->
<script type="text/javascript">
    $(document).ready(function () {
        $("#sort-list").sortable({
            items: 'tr.sort-list',
            handle: 'td.sortyes',
            axis: "y",
            over: function (event, ui) {
                ui.helper.css("opacity", "0.7"),
                        ui.helper.css("background-color", "#F5F5F5")
            },
            beforeStop: function (event, ui) {
                ui.helper.css("opacity", "1.0"),
                        ui.helper.css("background-color", "#ffffff")
            },
            stop: function (event, ui) {
                sortList();
            }
        });
    });

    function sortList() {
        var ids = [];
        var j = '<?php echo $j ?>';
        var token = '<?php echo $TOKEN ?>';
        $("#sort-list tr").each(function () {
            ids[ids.length] = $(this).attr('unitid');
        });
        $.ajax({
            method: 'POST',
            dataType: 'text',
            url: '/controller/admin/pages/categories/categories.php',
            data: ({
                token_ajax: token,
                j: j,
                ids: ids.join()})
        });
    }
</script>

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
                        url: '/controller/admin/pages/categories/categories.php',
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

                "addItem": {
                    name: "Добавить товар",
                    icon: "edit",
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        var m = "Отдельная функция для " + itemKey + " " + opt.$trigger.attr("id");
                        window.console && console.log(m) || alert(m);
                    }
                },

                "addCat": {
                    name: "Добавить категорию",
                    icon: "edit",
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $('#addCategory').modal('show');
                    }
                },

                "sep": "---------",

                "edit": {
                    name: "Редактировать",
                    icon: "edit",
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $('#addCategory' + opt.$trigger.attr("id")).modal('show');
                    }
                },

                "delete": {name: "Удалить", icon: "delete"},
                "sep1": "---------",

                "cut": {name: "Вырезать", icon: "cut"},
                "copy": {name: "Копировать", icon: "copy"},
                "paste": {name: "Вставить", icon: "paste"},

                "sep2": "---------",
                "quit": {name: "Выход", icon: function () {
                        return 'context-menu-icon context-menu-icon-quit';
                    }}
            }
        });
    });
</script>