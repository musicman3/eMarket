<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="layouts-categories" class="panel panel-default">
    <div class="panel-heading"><?php echo lang('categories_name') ?></div>
    <div class="panel-body category_block">
        <?php $categories_and_breadcrumb = \eMarket\Func::escape_sign(\eMarket\Tree::categories($sql, \eMarket\Valid::inGET('category_id'))); ?>
    </div>
</div>
<?php if ($categories_and_breadcrumb != 0) { ?>
    <div id="data_breadcrumb" class="hidden"
         data-breadcrumbid='<?php echo json_encode(array_reverse($categories_and_breadcrumb)) ?>'
         data-breadcrumbname='<?php echo json_encode(\eMarket\Set::breadcrumbName(array_reverse($categories_and_breadcrumb))) ?>'>
    </div>
<?php } ?>
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