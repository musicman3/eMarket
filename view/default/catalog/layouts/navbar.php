<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Autorize,
    Cart,
    Ecb,
    Settings
};
?>

<nav class="navbar navbar-inverse navbar-no-corners navbar-no-margin">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse-core-nav">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="bs-navbar-collapse-core-nav">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="/"><span class="glyphicon glyphicon-home"></span><span class="hidden-sm"> <?php echo lang('breadcrumb_home') ?></span></a></li>
                <!--<li><a href="#"><span class="glyphicon glyphicon-certificate"></span><span class="hidden-sm">  <?php echo lang('sale') ?></span></a></li>
                <li><a href="#"><span class="glyphicon glyphicon-fire"></span><span class="hidden-sm"> <?php echo lang('recommended') ?></span></a></li>
                <li><a href="#"><span class="glyphicon glyphicon-comment"></span><span class="hidden-sm"> <?php echo lang('articles') ?></span></a></li>-->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-globe"></span><span class="hidden-sm"> <?php echo lang('navbar_languages') ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach (lang('#lang_all') as $value) { ?>
                            <li><a href="<?php echo Settings::langCurrencyPath() . '&language=' . $value ?>"><img src="/view/<?php echo Settings::template() ?>/admin/images/langflags/<?php echo $value ?>.png"> <?php echo lang('language_name', $value) ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="dropdown"><a data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-credit-card"></span><span class="hidden-sm"> <?php echo lang('navbar_currencies') ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach (Settings::currenciesData() as $value) { ?>
                            <li><a href="<?php echo Settings::langCurrencyPath() . '&currency_default=' . $value['id'] ?>"><?php echo $value['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if (Autorize::$customer == FALSE) { ?>
                    <li><a href="/?route=login"><span class="glyphicon glyphicon-user"></span><span class="hidden-sm"> <?php echo lang('login_to_account') ?></span></a></li>
                <?php } else { ?>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span><span class="hidden-sm"> <?php echo lang('my_account') ?></span> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/?route=login&logout=ok"><?php echo lang('navbar_logout') ?></a></li>
                            <li class="divider"></li>
                            <li><a href="/?route=my_account"><?php echo lang('title_my_account_index') ?></a></li>
                            <li><a href="/?route=orders"><?php echo lang('title_orders_index') ?></a></li>
                            <li><a href="/?route=address_book"><?php echo lang('my_address_book') ?></a></li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (Cart::totalQuantity() == 0) { ?>
                    <li id="cart_bar" class="nav"><a href="#" class="disabled"><span class="glyphicon glyphicon-shopping-cart"></span> <?php echo Cart::totalQuantity() . ' ' . lang('navbar_pcs') ?></a></li>
                <?php } else { ?>
                    <li id="cart_bar" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-shopping-cart"></span> <?php echo Cart::totalQuantity() . ' ' . lang('navbar_pcs') ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="disabled"><?php echo Ecb::totalPriceCartInterface(1) ?></a></li>
                            <li class="divider"></li>
                            <li><a href="/?route=cart"><?php echo lang('navbar_view_cart') ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>