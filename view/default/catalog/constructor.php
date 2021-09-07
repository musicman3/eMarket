<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize,
    Debug,
    Settings,
    View
};
?>

<!DOCTYPE html>
<html dir="ltr" lang="<?php echo lang('meta-language') ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index,follow" />
        <meta name="generator" content="Netbeans" />
        <meta name="classification" content="software" />
        <meta name="author" content="eMarket" />
        <meta name="owner" content="eMarket" />
        <meta name="copyright" content="Copyright © 2018 by eMarket Team. All right reserved." />
        <meta name="keywords" content="<?php echo Settings::keywordsCatalog() ?>">
        <meta name="description" content="">

        <title><?php echo Settings::titleCatalog() ?></title>
        
        <link type="image/x-icon" rel="shortcut icon" href="favicon.ico">
        <link rel="canonical" href="<?php echo Settings::canonicalPathCatalog() ?>" />
        <link rel="stylesheet" type="text/css" href="/ext/bootstrap/css/bootstrap.min.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/ext/bootstrap/css/bootstrap-icons.css"/>
        <link rel="stylesheet" type="text/css" href="/view/<?php echo Settings::template() ?>/catalog/style.css" media="screen" />

        <script type="text/javascript" src="/model/library/js/classes/helpers/helpers.js"></script>
        <script type="text/javascript" src="/model/library/js/classes/confirm/confirm.js"></script>
        <script type="text/javascript" src="/ext/kyleschaeffer/menu.js"></script>

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
        <div id="csrf_token" class='hidden' data-csrf='<?php echo Authorize::csrfToken() ?>'></div>

        <?php
        require_once('confirm.php');
        foreach (View::tlpc('header') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <div id="bodyWrapper" class="container-fluid mt-3">
            <div class="row">

		<?php
		    if (View::tlpc('boxes-left', 'count') > 0) {
		?>
                <div id="columnLeft" class="col-xl-2 col-lg-3">
                    <?php
                        foreach (View::tlpc('boxes-left') as $path) {
                            require_once (ROOT . $path);
                        }
                    ?>
                </div>
                <?php } ?>

                <?php
                if (View::tlpc('boxes-left', 'count') > 0) {
                    ?>
                    <div id="bodyContent" class="col-xl-10 col-lg-9">
                        <?php
                        require_once(View::routingCatalog());
                        ?>
                    </div>
                <?php } elseif (View::tlpc('boxes-left', 'count') == 0 && View::tlpc('boxes-right', 'count') == 0) { ?>
                    <div id="bodyContent" class="col-12">
                        <?php
                        require_once(View::routingCatalog());
                        ?>
                    </div>
                <?php } ?>

                <?php
                if (View::tlpc('boxes-right', 'count') > 0) {
                    ?>
                    <div id="bodyContent" class="col-xl-10 col-lg-9 order-2 order-lg-1">
                        <?php
                        require_once(View::routingCatalog());
                        ?>
                    </div>
                <?php } elseif (View::tlpc('boxes-left', 'count') == 0 && View::tlpc('boxes-right', 'count') == 0) { ?>
                    <div id="bodyContent" class="col-12">
                        <?php
                        require_once(View::routingCatalog());
                        ?>
                    </div>
                <?php } ?>

                <?php
		    if (View::tlpc('boxes-right', 'count') > 0) {
		?>
                <div id="columnRight" class="col-xl-2 col-lg-3 order-1 order-lg-2">
                    <?php
                        foreach (View::tlpc('boxes-right') as $path) {
                            require_once (ROOT . $path);
                        }
                    ?>
                </div>
                <?php } ?>

            </div>
        </div>

        <?php
        foreach (View::tlpc('footer') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.bundle.min.js"></script>
        <?php
        require_once ('js/breadcrumb.php');
        require_once ('js/categories.php');

        if (Settings::$js_handler != FALSE) {
            require_once(Settings::$js_handler . '/js.php');
        }
        if (Settings::$js_modules_handler != FALSE) {
            require_once(Settings::$js_modules_handler . '/js.php');
        }

        Debug::info();
        ?>
    </body>
</html>
