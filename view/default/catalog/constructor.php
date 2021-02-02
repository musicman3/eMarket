<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
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

        <title><?php echo Settings::titleCatalog() ?></title>
        <meta name="keywords" content="<?php echo Settings::keywordsCatalog() ?>">
        <meta name="description" content="">

        <link type="image/x-icon" rel="shortcut icon" href="favicon.ico">
        <link rel="canonical" href="<?php echo Settings::canonicalPathCatalog() ?>" />
        <link rel="stylesheet" type="text/css" href="/ext/bootstrap/css/bootstrap5.min.css" media="screen" />
        <link rel="stylesheet" href="/ext/bootstrap/css/bootstrap-icons.css" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="/view/<?php echo Settings::template() ?>/catalog/style.css" media="screen" />
        <script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/ext/jquery/ui/jquery.ui.touch-punch.min.js"></script>

        <script type="text/javascript">
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </head>
    <body>

        <?php
        foreach (View::tlpc('header') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <div id="bodyWrapper" class="container-fluid">
            <div class="row">

		<?php
		    if (View::tlpc('boxes-left', 'count') > 0) {
		?>
                <div id="columnLeft" class="col-xxl-2 col-xl-3 col-lg-3">
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
                    <div id="bodyContent" class="col-xxl-10 col-xl-9 col-lg-9">
                        <?php
                        require_once(View::routingCatalog());
                        ?>
                    </div>
                <?php } else { ?>
                    <div id="bodyContent" class="col-12">
                        <?php
                        require_once(View::routingCatalog());
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
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-confirmation.min.js"></script>
        <script type="text/javascript" src="/ext/jstree/jstree.min.js"></script>
        <?php
        require_once ('js/breadcrumb.php');
        require_once ('js/categories.php');
        ?>

        <script type="text/javascript">
            $('[data-toggle=confirmation]').confirmation({rootSelector: '[data-toggle=confirmation]'});
        </script>

        <?php
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
