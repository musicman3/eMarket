<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<?php if (isset($_SESSION['login']) && isset($_SESSION['pass'])) { // Выводим если авторизованы    ?>

    <div id="footerwrap">
        <footer class="clearfix"></footer>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p><img src="/view/<?php echo $SET->template() ?>/admin/images/emarket.png" width="57" alt="" class="img-responsive center-block"></p>

                    <p>Copyright (c) 2018-<?php echo date('Y') ?>, <a target=_blank href="https://github.com/musicman3/eMarket">eMarket Team</a>. All rights reserved.</p>
                </div>
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /footerwrap -->
    
<?php } 
if (isset($j) == false) {
    $j = 0;
}
if (isset($TOKEN) == false) {
    $TOKEN = 0;
}

?>