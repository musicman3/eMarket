<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Middleware\CatalogAuthorize,
    Ecb,
    Settings
};
use eMarket\Catalog\{
    Cart
};
use eMarket\Admin\{
    Currencies,
    Contacts,
    AboutUs,
    Shipping
};
?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
    <div class="container-fluid">

        <?php if (Settings::catalogButton() == 'on') { ?>
            <div class="p-1"><a href="/?route=listing" class="btn btn-dark" role="button"><span class="d-inline d-md-none d-lg-inline bi bi-bag"> <?php echo lang('navbar_catalog_button') ?></span></a></div>
        <?php } ?>

        <div class="p-1">
            <form>
                <input hidden name="route" value="listing">
                <div class="input-group">
                    <input type="search" id="search" name="search" placeholder="<?php echo lang('search_name') ?>" class="form-control" required>
                    <button type="submit" class="btn btn-outline-light bi-search"></button>
                </div>
            </form>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul id="left_bar" class="navbar-nav"></ul>
            <ul id="right_bar" class="navbar-nav">
                <?php if (count(lang('#lang_all')) > 1) { ?>
                    <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle bi-translate" data-bs-toggle="dropdown"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('navbar_languages') ?></span></a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <?php foreach (lang('#lang_all') as $value) { ?>
                                <li><a href="<?php echo Settings::langCurrencyPath() . '&language=' . $value ?>" class="dropdown-item"><img src="/view/<?php echo Settings::template() ?>/admin/images/langflags/<?php echo $value ?>.png"> <?php echo lang('language_name', $value) ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php
                }
                if (count(Currencies::currenciesData()) > 1) {
                    ?>
                    <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle bi-currency-exchange" data-bs-toggle="dropdown"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('navbar_currencies') ?></span></a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <?php foreach (Currencies::currenciesData() as $value) { ?>
                                <li><a href="<?php echo Settings::langCurrencyPath() . '&currency_default=' . $value['id'] ?>" class="dropdown-item"><?php echo $value['name'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php
                if (Shipping::status() == 'checked') {
                    ?>
                    <li class="nav-item dropdown"><a href="/?route=shipping" class="nav-link bi-truck"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('shipping_name') ?></span></a></li>
                    <?php
                }
                if (AboutUs::status() == 'checked') {
                    ?>
                    <li class="nav-item dropdown"><a href="/?route=about_us" class="nav-link bi-card-heading"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('about_us_name') ?></span></a></li>
                    <?php
                }
                if (Contacts::status() == 'checked') {
                    ?>
                    <li class="nav-item dropdown"><a href="/?route=contacts" class="nav-link bi-envelope"><span class="d-inline d-md-none d-lg-inline"> <?php echo lang('contacts_name') ?></span></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <?php if (CatalogAuthorize::$customer == FALSE) {
                    ?>
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
                    <li id="cart_bar" class="nav-item dropdown"></li>
                <?php } else { ?>
                    <li id="cart_bar" class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle bi-basket" data-bs-toggle="dropdown" > <?php echo Cart::totalQuantity() . ' ' . lang('navbar_pcs') ?></a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li><a href="#" class="dropdown-item disabled"><?php echo Ecb::totalPriceCartInterface(1) ?></a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="/?route=cart" class="dropdown-item"><?php echo lang('navbar_view_cart') ?></a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>
