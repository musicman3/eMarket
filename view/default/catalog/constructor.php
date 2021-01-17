<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!DOCTYPE html>
<html dir="ltr" lang="<?php echo lang('meta-language') ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index,follow" />
        <meta name="generator" content="HippoEDIT, Netbeans, Notepad++" />
        <meta name="classification" content="software" />
        <meta name="author" content="eMarket" />
        <meta name="owner" content="eMarket" />
        <meta name="copyright" content="Copyright © 2018 by eMarket Team. All right reserved." />

        <title><?php echo \eMarket\Core\Settings::titleCatalog() ?></title>
        <meta name="keywords" content="<?php echo \eMarket\Core\Settings::keywordsCatalog() ?>">
        <meta name="description" content="">

        <link type="image/x-icon" rel="shortcut icon" href="favicon.ico">
        <link rel="canonical" href="<?php echo \eMarket\Core\Settings::canonicalPathCatalog() ?>" />
        <link href="/ext/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <link rel="stylesheet" type="text/css" href="/view/<?php echo \eMarket\Core\Settings::template() ?>/catalog/style.css" media="screen" />
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
        foreach (\eMarket\Core\View::tlpc('header') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <div id="bodyWrapper" class="container-fluid">
            <div class="row">

                <?php
                if (\eMarket\Core\View::tlpc('boxes-left', 'count') > 0) {
                    ?>

                    <div id="bodyContent" class="col-lg-10 col-md-9 col-lg-push-2 col-md-push-3">
                        <?php
                        require_once(\eMarket\Core\View::routingCatalog());
                        ?>
                    </div>

                <?php } else { ?>

                    <div id="bodyContent" class="col-xs-12">
                        <?php
                        require_once(\eMarket\Core\View::routingCatalog());
                        ?>
                    </div>

                    <?php
                }

                if (\eMarket\Core\View::tlpc('boxes-left', 'count') > 0) {
                    ?>

                    <div id="columnLeft" class="col-lg-2 col-md-3 col-lg-pull-10 col-md-pull-9">
                        <?php
                        foreach (\eMarket\Core\View::tlpc('boxes-left') as $path) {
                            require_once (ROOT . $path);
                        }
                        ?>
                    </div>

                <?php } ?>

            </div>
        </div>

        <?php
        foreach (\eMarket\Core\View::tlpc('footer') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
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
        if (\eMarket\Core\Settings::$JS_HANDLER != FALSE) {
            require_once(\eMarket\Core\Settings::$JS_HANDLER . '/js.php');
        }
        if (\eMarket\Core\Settings::$JS_MODULES_HANDLER != FALSE) {
            require_once(\eMarket\Core\Settings::$JS_MODULES_HANDLER . '/js.php');
        }

        \eMarket\Core\Debug::info();
        ?>
    </body>
</html>
