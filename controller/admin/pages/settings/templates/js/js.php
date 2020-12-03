<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript" language="javascript">
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
                var arrList3 = $('#sortable3 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList4 = $('#sortable4 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList5 = $('#sortable5 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList6 = $('#sortable6 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList7 = $('#sortable7 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList8 = $('#sortable8 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList9 = $('#sortable9 li').map(function () {
                    return $(this).attr('id');
                }).get();
                jQuery.get('',
                        {layout_header: arrList1,
                            layout_header_basket: arrList2,
                            layout_content: arrList3,
                            layout_content_basket: arrList4,
                            layout_boxes_left: arrList5,
                            layout_boxes_right: arrList6,
                            layout_boxes_basket: arrList7,
                            layout_footer: arrList8,
                            layout_footer_basket: arrList9,
                            template: $('#name_templates').val(),
                            page: $('#layout_pages_templates').val()}
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
                var arrList1 = $('#sortable1 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList2 = $('#sortable2 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList3 = $('#sortable3 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList4 = $('#sortable4 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList5 = $('#sortable5 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList6 = $('#sortable6 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList7 = $('#sortable7 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList8 = $('#sortable8 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList9 = $('#sortable9 li').map(function () {
                    return $(this).attr('id');
                }).get();
                jQuery.get('',
                        {layout_header: arrList1,
                            layout_header_basket: arrList2,
                            layout_content: arrList3,
                            layout_content_basket: arrList4,
                            layout_boxes_left: arrList5,
                            layout_boxes_right: arrList6,
                            layout_boxes_basket: arrList7,
                            layout_footer: arrList8,
                            layout_footer_basket: arrList9,
                            template: $('#name_templates').val(),
                            page: $('#layout_pages_templates').val()}
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
                var arrList1 = $('#sortable1 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList2 = $('#sortable2 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList3 = $('#sortable3 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList4 = $('#sortable4 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList5 = $('#sortable5 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList6 = $('#sortable6 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList7 = $('#sortable7 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList8 = $('#sortable8 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList9 = $('#sortable9 li').map(function () {
                    return $(this).attr('id');
                }).get();
                //alert(arrList2);
                jQuery.get('',
                        {layout_header: arrList1,
                            layout_header_basket: arrList2,
                            layout_content: arrList3,
                            layout_content_basket: arrList4,
                            layout_boxes_left: arrList5,
                            layout_boxes_right: arrList6,
                            layout_boxes_basket: arrList7,
                            layout_footer: arrList8,
                            layout_footer_basket: arrList9,
                            template: $('#name_templates').val(),
                            page: $('#layout_pages_templates').val()}
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
                var arrList1 = $('#sortable1 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList2 = $('#sortable2 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList3 = $('#sortable3 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList4 = $('#sortable4 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList5 = $('#sortable5 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList6 = $('#sortable6 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList7 = $('#sortable7 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList8 = $('#sortable8 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList9 = $('#sortable9 li').map(function () {
                    return $(this).attr('id');
                }).get();
                jQuery.get('',
                        {layout_header: arrList1,
                            layout_header_basket: arrList2,
                            layout_content: arrList3,
                            layout_content_basket: arrList4,
                            layout_boxes_left: arrList5,
                            layout_boxes_right: arrList6,
                            layout_boxes_basket: arrList7,
                            layout_footer: arrList8,
                            layout_footer_basket: arrList9,
                            template: $('#name_templates').val(),
                            page: $('#layout_pages_templates').val()}
                );
            }
        });
    });
</script>

<script type="text/javascript" language="javascript">
    selectTemplate = function (event) {
        document.forms["select_template"].submit();
    };
    selectPage = function (event) {
        document.forms["select_page"].submit();
    };
</script>