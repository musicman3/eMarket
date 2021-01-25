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

<!doctype html>
<html dir="ltr" lang="<?php echo lang('meta-language') ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow" />
        <meta name="generator" content="Netbeans" />
        <meta name="classification" content="software" />
        <meta name="author" content="eMarket" />
        <meta name="owner" content="eMarket" />
        <meta name="copyright" content="Copyright © 2018 by eMarket Team. All right reserved." />

        <title><?php echo Settings::titlePageGenerator() ?></title>

        <link rel="stylesheet" type="text/css" href="/ext/bootstrap/css/bootstrap5.min.css" media="screen" />
        <link rel="stylesheet" href="/ext/bootstrap/css/bootstrap-icons.css" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="/view/<?php echo Settings::template() ?>/admin/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/ext/contextmenu/css/jquery.contextMenu.min.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/ext/jquery/ui/jquery-ui.min.css" media="screen" />
        <link rel="stylesheet" href="/ext/bootstrap/css/bootstrap-multiselect.css" type="text/css"/>

        <?php
        if (isset($_SESSION['login']) && isset($_SESSION['pass']) && file_exists(ROOT . '/view/' . Settings::template() . '/admin/nav.css')) {
            ?>
            <link rel="stylesheet" type="text/css" href="/view/<?php echo Settings::template() ?>/admin/nav.css" media="screen" />
        <?php } ?>

        <script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/ext/jquery/ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/ext/jquery/ui/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript" src="/ext/fastmd5/md5.min.js"></script>
        <script type="text/javascript" src="/ext/randomizer/randomizer.js"></script>

        <script type="text/javascript">
            $(function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
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
            <div id="ajax">

                <?php
                require_once(View::routingAdmin());
                ?>

            </div>
        </div>

        <?php
        foreach (View::tlpc('footer') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-confirmation.min.js"></script>
        <script type="text/javascript" src="/ext/contextmenu/js/jquery.contextMenu.min.js"></script>
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-multiselect.js"></script>

        <script type="text/javascript">
            $('[data-bs-toggle=confirmation]').confirmation({rootSelector: '[data-bs-toggle=confirmation]'});
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
