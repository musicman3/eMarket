<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>

<script src="/ext/sortablejs/sortable.min.js"></script>

<script type="text/javascript" language="javascript">

    function idHandler(selector) {
        var idArray = [];
        var data = Array.from(document.querySelector(selector).children);
        data.splice(0, 1);
        data.forEach(function (string, index) {
            if (string.id !== '') {
                idArray[index] = string.id;
            }
        });
        return idArray;
    }

    function updateData() {
        Ajax.postData(window.location.href, {
            layout_header: idHandler('#sortable1'),
            layout_header_basket: idHandler('#sortable2'),
            layout_content: idHandler('#sortable3'),
            layout_content_basket: idHandler('#sortable4'),
            layout_boxes_left: idHandler('#sortable5'),
            layout_boxes_right: idHandler('#sortable6'),
            layout_boxes_basket: idHandler('#sortable7'),
            layout_footer: idHandler('#sortable8'),
            layout_footer_basket: idHandler('#sortable9'),
            template: document.querySelector('#name_templates').value,
            page: document.querySelector('#layout_pages_templates').value
        });
    }

    function sortablePref(selector, group) {
        new Sortable(document.querySelector(selector), {
            group: group,
            animation: 150,
            filter: '.sortno',
            ghostClass: 'bg-info',
            draggable: '.sortyes',
            onEnd: function () {
                updateData();
            }
        });
    }
    
    sortablePref('#sortable1', 'header');
    sortablePref('#sortable2', 'header');
    sortablePref('#sortable3', 'content');
    sortablePref('#sortable4', 'content');
    sortablePref('#sortable5', 'boxes');
    sortablePref('#sortable6', 'boxes');
    sortablePref('#sortable7', 'boxes');
    sortablePref('#sortable8', 'footer');
    sortablePref('#sortable9', 'footer');

</script>

<script type="text/javascript" language="javascript">
    selectTemplate = function () {
        document.forms["select_template"].submit();
    };
    selectPage = function () {
        document.forms["select_page"].submit();
    };
</script>