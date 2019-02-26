<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div class="panel panel-default">
    <div class="panel-heading">Categories</div>
    <div class="panel-body category_block">
        <?php $categories_and_breadcrumb = $TREE->categories($sql, $VALID->inGET('category_id')); ?>
    </div>
</div>
<div id="data_breadcrumb" class="hidden"
     data-breadcrumb='<?php $categories_and_breadcrumb ?>'>
</div>

<script type="text/javascript" language="javascript">
    function categorytreeview() {
        if ($('.box-category').hasClass('treeview') === true) {
            $(".box-category").treeview({
                animated: 100,
                collapsed: true,
                unique: true
            });
        }
    }
    $(document).ready(function () {
        categorytreeview();
    });
</script>