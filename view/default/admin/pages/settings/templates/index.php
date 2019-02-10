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
<ul style="width:668px; display:inline-block; border:1px solid #ccc;vertical-align:top;padding: 5px;">
    <li style="list-style-type: none;text-align:center;">Название</li>
</ul>
<ul style="width:220px; display:inline-block; border:1px solid #ccc;vertical-align:top;padding: 5px;">
    <li style="list-style-type: none;text-align:center;">Название</li>
    <li style="list-style-type: none;text-align:center;">Five</li>
    <li style="list-style-type: none;text-align:center;">Six</li>
</ul>
</div>
<div class="center-block">
<ul style="width:220px; display:inline-block; border:1px solid #ccc;vertical-align:top;padding: 5px;">
    <li style="list-style-type: none;text-align:center;">Название</li>
</ul>
<ul style="width:220px; display:inline-block; border:1px solid #ccc;vertical-align:top;padding: 5px;">
    <li style="list-style-type: none;text-align:center;">Название</li>
</ul>
<ul style="width:220px; display:inline-block; border:1px solid #ccc;vertical-align:top;padding: 5px;">
    <li style="list-style-type: none;text-align:center;">Название</li>
</ul>
<ul style="width:220px; display:inline-block; border:1px solid #ccc;vertical-align:top;padding: 5px;">
    <li style="list-style-type: none;text-align:center;">Название</li>
    <li style="list-style-type: none;text-align:center;">Five</li>
    <li style="list-style-type: none;text-align:center;">Six</li>
</ul>
</div>
<div class="center-block">
<ul style="width:668px; display:inline-block; border:1px solid #ccc;vertical-align:top;padding: 5px;">
    <li style="list-style-type: none;text-align:center;">Название</li>
</ul>
<ul style="width:220px; display:inline-block; border:1px solid #ccc;vertical-align:top;padding: 5px;">
    <li style="list-style-type: none;text-align:center;">Название</li>
    <li style="list-style-type: none;text-align:center;">Five</li>
    <li style="list-style-type: none;text-align:center;">Six</li>
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
$("ul").on('click', 'li', function (e) {
    if (e.ctrlKey || e.metaKey) {
        $(this).toggleClass("selected");
    } else {
        $(this).addClass("selected").siblings().removeClass('selected');
    }
}).sortable({
    connectWith: "ul",
    delay: 150,
    revert: 0,
    helper: function (e, item) {
        if (!item.hasClass('selected')) {
            item.addClass('selected').siblings().removeClass('selected');
        }
        var elements = item.parent().children('.selected').clone();
        item.data('multidrag', elements).siblings('.selected').remove();
        var helper = $('<li/>');
        return helper.append(elements);
    },
    stop: function (e, ui) {
        var elements = ui.item.data('multidrag');
        ui.item.after(elements).remove();
    }
});
</script>