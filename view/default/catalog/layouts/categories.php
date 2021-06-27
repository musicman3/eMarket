<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Catalog\Categories;
use eMarket\Core\Settings;
?>

<div id="layouts-categories" class="card mb-2">
    <div class="card-header p-2"><h3 class="mb-0"><?php echo lang('categories_name') ?></h3></div>
    <div class="card-body category_block p-2"><nav class="menu"><?php Categories::data(); ?></nav></div>
</div>
<?php if (Categories::$categories_and_breadcrumb != 0) { ?>
    <div id="data_breadcrumb" class="hidden"
         data-breadcrumbid='<?php echo json_encode(array_reverse(Categories::$categories_and_breadcrumb)) ?>'
         data-breadcrumbname='<?php echo json_encode(Settings::breadcrumbName(array_reverse(Categories::$categories_and_breadcrumb))) ?>'>
    </div>
<?php }