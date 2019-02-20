<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script>
    $(function () {
        $("#sortable1, #sortable2").sortable({
            connectWith: ".connectedSortable",
            items: "li:not(.sortno)",
            over: function (event, ui) {
                ui.helper.css("color", "#204d74");
            },
            beforeStop: function (event, ui) {
                ui.helper.css("color", "");
            },
            stop: function (event, li) {
                var arrList1 = $('#sortable1 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList2 = $('#sortable2 li').map(function () {
                    return $(this).attr('id');
                }).get();
                jQuery.post('index.php',
                        {layout_header: arrList1,
                            layout_header_basket: arrList2,
                            template: $('#name_templates').val()}
                );
            }
        });

        $("#sortable3, #sortable4").sortable({
            connectWith: ".connectedSortable2",
            items: "li:not(.sortno)",
            over: function (event, ui) {
                ui.helper.css("color", "#204d74");
            },
            beforeStop: function (event, ui) {
                ui.helper.css("color", "");
            },
            stop: function (event, li) {
                var arrList1 = $('#sortable3 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList2 = $('#sortable4 li').map(function () {
                    return $(this).attr('id');
                }).get();
                jQuery.post('index.php',
                        {layout_content: arrList1,
                            layout_content_basket: arrList2,
                            template: $('#name_templates').val()}
                );
            }
        });

        $("#sortable5, #sortable6, #sortable7").sortable({
            connectWith: ".connectedSortable3",
            items: "li:not(.sortno)",
            over: function (event, ui) {
                ui.helper.css("color", "#204d74");
            },
            beforeStop: function (event, ui) {
                ui.helper.css("color", "");
            },
            stop: function (event, li) {
                var arrList1 = $('#sortable5 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList2 = $('#sortable6 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList3 = $('#sortable7 li').map(function () {
                    return $(this).attr('id');
                }).get();
                //alert(arrList2);
                jQuery.post('index.php',
                        {layout_boxes_left: arrList1,
                            layout_boxes_right: arrList2,
                            layout_boxes_basket: arrList3,
                            template: $('#name_templates').val()}
                );
            }
        });

        $("#sortable8, #sortable9").sortable({
            connectWith: ".connectedSortable4",
            items: "li:not(.sortno)",
            over: function (event, ui) {
                ui.helper.css("color", "#204d74");
            },
            beforeStop: function (event, ui) {
                ui.helper.css("color", "");
            },
            stop: function (event, li) {
                var arrList1 = $('#sortable8 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList2 = $('#sortable9 li').map(function () {
                    return $(this).attr('id');
                }).get();
                jQuery.post('index.php',
                        {layout_footer: arrList1,
                            layout_footer_basket: arrList2,
                            template: $('#name_templates').val()}
                );
            }
        });
    });
</script>