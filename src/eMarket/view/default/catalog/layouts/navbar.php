<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize,
    Cart,
    Ecb,
    Settings
};
?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown"><a href="/" class="nav-link bi-house-door"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('breadcrumb_home') ?></span></a></li>
                <!--<li class="nav-item dropdown"><a href="#" class="nav-link"><span class="d-inline d-md-none d-lg-inline">  <?php echo lang('sale') ?></span></a></li>
                <li class="nav-item dropdown"><a href="#" class="nav-link"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('recommended') ?></span></a></li>
                <li class="nav-item dropdown"><a href="#" class="nav-link"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('articles') ?></span></a></li>-->
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle bi-translate" data-bs-toggle="dropdown"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('navbar_languages') ?></span></a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <?php foreach (lang('#lang_all') as $value) { ?>
                            <li><a href="<?php echo Settings::langCurrencyPath() . '&language=' . $value ?>" class="dropdown-item"><img src="/view/<?php echo Settings::template() ?>/admin/images/langflags/<?php echo $value ?>.png"> <?php echo lang('language_name', $value) ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle bi-currency-exchange" data-bs-toggle="dropdown"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('navbar_currencies') ?></span></a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <?php foreach (Settings::currenciesData() as $value) { ?>
                            <li><a href="<?php echo Settings::langCurrencyPath() . '&currency_default=' . $value['id'] ?>" class="dropdown-item"><?php echo $value['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if (Authorize::$customer == FALSE) { ?>
                    <li class="nav-item dropdown"><a href="/?route=login" class="nav-link bi-person"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('login_to_account') ?></span></a></li>
                <?php } else { ?>
                    <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle bi-person" data-bs-toggle="dropdown"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('my_account') ?></span></a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li><a href="/?route=login&logout=ok" class="dropdown-item"><?php echo lang('navbar_logout') ?></a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="/?route=my_account" class="dropdown-item"><?php echo lang('title_my_account_index') ?></a></li>
                            <li><a href="/?route=orders" class="dropdown-item"><?php echo lang('title_orders_index') ?></a></li>
                            <li><a href="/?route=address_book" class="dropdown-item"><?php echo lang('my_address_book') ?></a></li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (Cart::totalQuantity() == 0) { ?>
                    <li id="cart_bar" class="nav-item dropdown"><a href="#" class="nav-link disabled bi-basket"> <?php echo Cart::totalQuantity() . ' ' . lang('navbar_pcs') ?></a></li>
                <?php } else { ?>
                    <li id="cart_bar" class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle bi-basket" data-bs-toggle="dropdown" > <?php echo Cart::totalQuantity() . ' ' . lang('navbar_pcs') ?></a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li><a href="#" class="dropdown-item disabled"><?php echo Ecb::totalPriceCartInterface(1) ?></a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="/?route=cart" class="dropdown-item"><?php echo lang('navbar_view_cart') ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>