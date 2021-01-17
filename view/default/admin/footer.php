<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<?php if (isset($_SESSION['login']) && isset($_SESSION['pass'])) { ?>

    <div id="footerwrap">
        <footer class="clearfix"></footer>

        <div class="container-fluid">
            <div class="row">
                <p><img src="/view/<?php echo \eMarket\Core\Settings::template() ?>/admin/images/emarket.png" width="57" alt="" class="img-responsive center-block"></p>
                <p>Copyright © 2018-<?php echo date('Y') ?>, <a target=_blank href="https://github.com/musicman3/eMarket">eMarket Team</a>. All rights reserved.</p>
            </div>
        </div>
    </div>

<?php } ?>