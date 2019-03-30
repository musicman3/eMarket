<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<nav class="navbar navbar-inverse navbar-no-corners navbar-no-margin" role="navigation">
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
                <li><a href="/"><i class="glyphicon glyphicon-home"></i><span class="hidden-sm"> <?php echo lang('breadcrumb_home') ?></span></a></li>
                <li><a href="#"><i class="glyphicon glyphicon-certificate"></i><span class="hidden-sm">  <?php echo lang('sale') ?></span></a></li>
                <li><a href="#"><i class="glyphicon glyphicon-fire"></i><span class="hidden-sm"> <?php echo lang('recommended') ?></span></a></li>
                <li><a href="#"><i class="glyphicon glyphicon-comment"></i><span class="hidden-sm"> <?php echo lang('articles') ?></span></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-globe"></i><span class="hidden-sm"> <?php echo lang('navbar_languages') ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach (lang('#lang_all') as $value) { ?>
                            <li><a href="<?php echo '/?route=catalog&language=' . $value ?>"><?php echo lang('language_name', $value) ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-credit-card"></i><span class="hidden-sm"> <?php echo lang('navbar_currencies') ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($SET->currenciesData() as $value) { ?>
                            <li><a href="<?php echo '/?route=catalog&currency_default=' . $value[1] ?>"><?php echo $value[0] ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <?php if ($CUSTOMER == FALSE) { ?>
                        <a href="/?route=login"><i class="glyphicon glyphicon-user"></i><span class="hidden-sm"> <?php echo lang('login_to_account') ?></span></a>
                    <?php } else { ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user"></i><span class="hidden-sm"> <?php echo lang('my_account') ?></span> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/?route=login&logout=ok"><?php echo lang('navbar_logout') ?></a></li>
                            <li class="divider"></li>
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">My Orders</a></li>
                            <li><a href="#">My Address Book</a></li>
                            <li><a href="#">My Password</a></li>
                        </ul>
                    <?php } ?>
                </li>
                <?php if ($CART->totalQuantity() == 0) { ?>
                    <li class="nav"><a href="#" class="disabled"><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo $CART->totalQuantity() . ' ' . lang('navbar_pcs') ?></a></li>
                <?php } else { ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo $CART->totalQuantity() . ' ' . lang('navbar_pcs') ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="disabled"><?php echo $CART->totalQuantity() . ' ' . lang('navbar_pcs') . ' (' . $PRODUCTS->productPrice($CART->totalPrice(), $CURRENCIES, 1) . ')' ?></a></li>
                            <li class="divider"></li>
                            <li><a href="/?route=cart">View Cart</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>