<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="layouts-categories" class="panel panel-default">
    <div class="panel-heading"><?php echo lang('categories_name') ?></div>
    <div class="panel-body category_block"><?php \eMarket\Catalog\Categories::data(); ?></div>
</div>
<?php if (\eMarket\Catalog\Categories::$categories_and_breadcrumb != 0) { ?>
    <div id="data_breadcrumb" class="hidden"
         data-breadcrumbid='<?php echo json_encode(array_reverse(\eMarket\Catalog\Categories::$categories_and_breadcrumb)) ?>'
         data-breadcrumbname='<?php echo json_encode(\eMarket\Core\Settings::breadcrumbName(array_reverse(\eMarket\Catalog\Categories::$categories_and_breadcrumb))) ?>'>
    </div>
<?php } ?>