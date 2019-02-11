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
                    <ul id="sortable1" class="connectedSortable block-ul" style="width:668px;">
                        <li class="sortno list-group-item-success">Название</li>
                    </ul>
                    <ul id="sortable2" class="connectedSortable block-ul" style="width:220px;">
                        <li class="sortno list-group-item-success">Название стакан</li>
                        <li class="sortyes">Five</li>
                        <li class="sortyes">Six</li>
                    </ul>
                </div>
                <div class="center-block">
                    <ul id="sortable3" class="connectedSortable2 block-ul" style="width:220px;">
                        <li class="sortno list-group-item-info">Название</li>
                    </ul>
                    <ul id="sortable4" class="connectedSortable2 block-ul" style="width:220px;">
                        <li class="sortno list-group-item-info">Название</li>
                    </ul>
                    <ul id="sortable5" class="connectedSortable2 block-ul" style="width:220px;">
                        <li class="sortno list-group-item-info">Название</li>
                    </ul>
                    <ul id="sortable6" class="connectedSortable2 block-ul" style="width:220px;">
                        <li class="sortno list-group-item-info">Название стакан</li>
                        <li class="sortyes">Five</li>
                        <li class="sortyes">Six</li>
                    </ul>
                </div>
                <div class="center-block">
                    <ul id="sortable7" class="connectedSortable3 block-ul" style="width:668px;">
                        <li class="sortno list-group-item-success">Название</li>
                    </ul>
                    <ul id="sortable8" class="connectedSortable3 block-ul" style="width:220px;">
                        <li class="sortno list-group-item-success">Название стакан</li>
                        <li class="sortyes">Five</li>
                        <li class="sortyes">Six</li>
                    </ul>
                </div>
		<button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
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

        $("#sortable3, #sortable4, #sortable5, #sortable6").sortable({
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

        $("#sortable7, #sortable8").sortable({
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
    });
</script>