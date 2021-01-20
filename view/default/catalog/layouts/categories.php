<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Catalog\Categories;
use \eMarket\Core\Settings;
?>

<div id="layouts-categories" class="panel panel-default">
    <div class="panel-heading"><?php echo lang('categories_name') ?></div>
    <div class="panel-body category_block"><?php Categories::data(); ?></div>
</div>
<?php if (Categories::$categories_and_breadcrumb != 0) { ?>
    <div id="data_breadcrumb" class="hidden"
         data-breadcrumbid='<?php echo json_encode(array_reverse(Categories::$categories_and_breadcrumb)) ?>'
         data-breadcrumbname='<?php echo json_encode(Settings::breadcrumbName(array_reverse(Categories::$categories_and_breadcrumb))) ?>'>
    </div>
<?php }