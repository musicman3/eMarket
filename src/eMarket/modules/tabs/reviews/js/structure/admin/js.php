<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    document.querySelector('#index').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var modal_id = Number(button.dataset.edit);

        if (Number.isInteger(modal_id)) {
            var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);

            document.querySelector('#review').value = JSON.parse(json_data['reviews'][modal_id]);
            document.querySelector('#edit').value = modal_id;
            document.querySelector('#add').value = '';
        }
    });
</script>