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
                var arrList2 = $('#sortable1 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList3 = $('#sortable2 li').map(function () {
                    return $(this).attr('id');
                }).get();
                //alert(arrList3);
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
                var arrList2 = $('#sortable1 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList3 = $('#sortable2 li').map(function () {
                    return $(this).attr('id');
                }).get();
                //alert(arrList3);
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
                var arrList2 = $('#sortable1 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList3 = $('#sortable2 li').map(function () {
                    return $(this).attr('id');
                }).get();
                //alert(arrList3);
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
                var arrList2 = $('#sortable1 li').map(function () {
                    return $(this).attr('id');
                }).get();
                var arrList3 = $('#sortable2 li').map(function () {
                    return $(this).attr('id');
                }).get();
                //alert(arrList3);
            }
        });        
    });
</script>