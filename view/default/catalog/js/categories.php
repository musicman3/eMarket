<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<script type="text/javascript" language="javascript">
    document.addEventListener("DOMContentLoaded", function () {
        let params = (new URL(document.location)).searchParams;
        if (params.get('route') === 'listing') {
            document.querySelector('#cat_' + params.get('category_id')).closest('ul').setAttribute('aria-expand', 'true');
            document.querySelector('#namecat_' + params.get('category_id')).classList.add('toggle-bold');
            var json_data = JSON.parse(document.querySelector('#data_breadcrumb').dataset.breadcrumbid);
            json_data.forEach(e => document.querySelector('#cat_' + e).closest('ul').setAttribute('aria-expand', 'true'));
        }

        var toggle = new Toggle({
            buttonClassExpanded: 'toggle-btn-active',
            buttonSelector: 'span',
            parentClass: 'toggle-parent',
            singleSibling: true,
            targetSelector: '.menu ul ul'
        });
    });
</script>
