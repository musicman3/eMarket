<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div id="settings_templates" class="container-fluid hidden-sm hidden-xs">
    <div class="row-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left"><a class="btn btn-primary btn-xs" href="../"><span class="back glyphicon glyphicon-share-alt"></span></a> Шаблон</div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <div class="panel-body">
                <div class="center-block">
                    <ul id="sortable1" class="connectedSortable bg-success" style="width:668px;">
                        <li class="sortno">Название</li>
                    </ul>
                    <ul id="sortable2" class="connectedSortable bg-success" style="width:220px;">
                        <li class="sortno">Название стакан</li>
                        <li class="sortyes">Five</li>
                        <li class="sortyes">Six</li>
                    </ul>
                </div>
                <div class="center-block">
                    <ul id="sortable3" class="connectedSortable2 bg-info" style="width:220px;">
                        <li class="sortno">Название</li>
                    </ul>
                    <ul id="sortable4" class="connectedSortable2 bg-info" style="width:220px;">
                        <li class="sortno">Название</li>
                    </ul>
                    <ul id="sortable5" class="connectedSortable2 bg-info" style="width:220px;">
                        <li class="sortno">Название</li>
                    </ul>
                    <ul id="sortable6" class="connectedSortable2 bg-info" style="width:220px;">
                        <li class="sortno">Название стакан</li>
                        <li class="sortyes">Five</li>
                        <li class="sortyes">Six</li>
                    </ul>
                </div>
                <div class="center-block">
                    <ul id="sortable7" class="connectedSortable3 bg-success" style="width:668px;">
                        <li class="sortno">Название</li>
                    </ul>
                    <ul id="sortable8" class="connectedSortable3 bg-success" style="width:220px;">
                        <li class="sortno">Название стакан</li>
                        <li class="sortyes">Five</li>
                        <li class="sortyes">Six</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="settings_templates" class="container-fluid visible-sm visible-xs">
    <div class="row-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">Шаблон</div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <div class="panel-body">
                На планшетах и смартфонах не доступно
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#sortable1, #sortable2").sortable({
            connectWith: ".connectedSortable",
            items: "li:not(.sortno)",
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

        $("#sortable3, #sortable4, #sortable5, #sortable6").sortable({
            connectWith: ".connectedSortable2",
            items: "li:not(.sortno)",
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

        $("#sortable7, #sortable8").sortable({
            connectWith: ".connectedSortable3",
            items: "li:not(.sortno)",
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