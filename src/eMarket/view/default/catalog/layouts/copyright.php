<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Clock\SystemClock
};
?>

<div class="container-fluid footerwrap">
    <hr>
    <p class="footer text-center">Copyright © 2018-<?php echo SystemClock::nowFormatDate('Y') ?>, <a target=_blank href="https://github.com/musicman3/eMarket">eMarket Team</a>. All rights reserved.</p>
</div>
