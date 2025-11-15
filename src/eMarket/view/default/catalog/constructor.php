<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Middleware\CatalogAuthorize,
    Debug,
    Settings,
    Routing,
    Modules
};
use eMarket\Catalog\{
    Index
};
use eMarket\Admin\Templates;
?>

<!DOCTYPE html>
<html data-bs-theme="<?php echo Settings::template() ?>" dir="ltr" lang="<?php echo lang('meta-language') ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="index,follow" />
        <meta name="generator" content="Netbeans" />
        <meta name="classification" content="software" />
        <meta name="author" content="eMarket" />
        <meta name="owner" content="eMarket" />
        <meta name="copyright" content="Copyright © 2018 by eMarket Team. All right reserved." />
        <meta name="keywords" content="<?php echo Index::keywordsCatalog() ?>">
        <meta name="description" content="">

        <title><?php echo Settings::titlePageGenerator() ?></title>

        <link type="image/x-icon" rel="shortcut icon" href="favicon.ico">
        <link rel="canonical" href="<?php echo Settings::canonicalPathCatalog() ?>" />
        <link rel="stylesheet" type="text/css" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/js/ext/bootstrap-icons/bootstrap-icons.css"/>
        <link rel="stylesheet" type="text/css" href="/view/<?php echo Settings::template() ?>/catalog/style.css" media="screen" />
        <?php Settings::customCss() ?>

        <script type="text/javascript" src="/js/library/classes/helpers/helpers.js"></script>
        <script type="text/javascript" src="/js/library/classes/confirm/confirm.js"></script>
        <script type="text/javascript" src="/js/ext/kyleschaeffer/menu.js"></script>

        <script type="text/javascript">
            var Confirmation = new Confirm();
            document.addEventListener("DOMContentLoaded", function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    </head>
    <body>
        <div id="csrf_token" class='hidden' data-csrf='<?php echo CatalogAuthorize::csrfToken() ?>'></div>

        <?php
        require_once('confirm.php');
        foreach (Templates::tlpc('header') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <div id="bodyWrapper" class="container-fluid mt-3">
            <div class="row">

                <?php
                if (Templates::tlpc('boxes-left', 'count') > 0) {
                    ?>
                    <div id="columnLeft" class="col-xl-3 col-lg-3">
                        <?php
                        foreach (Templates::tlpc('boxes-left') as $path) {
                            require_once (ROOT . $path);
                        }
                        ?>
                    </div>
                    <?php
                }
                if (Templates::tlpc('boxes-left', 'count') > 0) {
                    ?>

                    <div id="bodyContent" class="col-xl-9 col-lg-9"><?php require_once(Routing::page()); ?></div>

                <?php } elseif (Templates::tlpc('boxes-left', 'count') == 0 && Templates::tlpc('boxes-right', 'count') == 0) { ?>

                    <div id="bodyContent" class="col-12"><?php require_once(Routing::page()); ?></div>

                <?php } if (Templates::tlpc('boxes-right', 'count') > 0) { ?>

                    <div id="bodyContent" class="col-xl-9 col-lg-9 order-2 order-lg-1"><?php require_once(Routing::page()); ?></div>

                <?php } elseif (Templates::tlpc('boxes-left', 'count') == 0 && Templates::tlpc('boxes-right', 'count') == 0) { ?>

                    <div id="bodyContent" class="col-12"><?php require_once(Routing::page()); ?></div>

                    <?php
                }
                if (Templates::tlpc('boxes-right', 'count') > 0) {
                    ?>

                    <div id="columnRight" class="col-xl-3 col-lg-3 order-1 order-lg-2">
                        <?php
                        foreach (Templates::tlpc('boxes-right') as $path) {
                            require_once (ROOT . $path);
                        }
                        ?>
                    </div>
                <?php } ?>

            </div>
        </div>

        <?php
        foreach (Templates::tlpc('footer') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <script type="text/javascript" src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="/js/structure/catalog/categories.js"></script>
        <?php
        require_once ('js/breadcrumb.php');

        if (Routing::js()) {
            require_once(Routing::js());
        }

        foreach (Modules::js() as $js) {
            require_once($js);
        }

        Debug::info();
        ?>
    </body>
</html>
