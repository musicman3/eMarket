<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Clock\SystemClock
};
use eMarket\Admin\{
    BasicSettings
};

new BasicSettings();
?>

<div class="container-fluid footerwrap">
    <hr>
    <p class="footer text-center">Copyright © <?php echo BasicSettings::$year_of_foundation ?>-<?php echo SystemClock::nowFormatDate('Y') ?>, <?php echo BasicSettings::$store_name ?></p>
</div>
