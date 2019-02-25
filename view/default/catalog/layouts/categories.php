<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript" language="javascript">
    function categorytreeview() {
        if ($('.box-category').hasClass('treeview') === true) {
            $(".box-category").treeview({
                animated: 100,
                collapsed: true,
                unique: true
            });
            $('.box-category li').parent().removeClass('expandable');
            $('.box-category li').parent().addClass('collapsable');
            $('box-category .box-category .collapsable li').css('display', 'block');
        }
    }
    $(document).ready(function () {
        categorytreeview();
    });
</script>

<div class="panel panel-default">
    <div class="panel-heading">Categories</div>
    <div class="panel-body category_block">
        <?php $TREE->categories() ?>
    </div>
</div>