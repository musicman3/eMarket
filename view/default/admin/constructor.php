<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!doctype html>
<html dir="ltr" lang="<?php echo lang('meta-language') ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow" />
        <meta name="generator" content="HippoEDIT, Netbeans, Notepad++" />
        <meta name="classification" content="software" />
        <meta name="author" content="eMarket" />
        <meta name="owner" content="eMarket" />
        <meta name="copyright" content="Copyright © 2018 by eMarket Team. All right reserved." />

        <!-- Автогенерация Title" -->
        <title><?php echo \eMarket\Settings::titlePageGenerator() ?></title>

        <link href="/ext/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <link rel="stylesheet" type="text/css" href="/view/<?php echo \eMarket\Settings::template() ?>/admin/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/ext/contextmenu/css/jquery.contextMenu.min.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/ext/jquery/ui/jquery-ui.min.css" media="screen" />
        <link rel="stylesheet" href="/ext/bootstrap/css/bootstrap-multiselect.css" type="text/css"/>
        <script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/ext/jquery/ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/ext/jquery/ui/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript" src="/ext/fastmd5/md5.min.js"></script>
        <script type="text/javascript" src="/ext/randomizer/randomizer.js"></script>

        <!-- Всплывающие подсказки" -->
        <script type="text/javascript">
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>

        <?php
        if (isset($_SESSION['login']) && isset($_SESSION['pass']) && file_exists(ROOT . '/view/' . \eMarket\Settings::template() . '/admin/nav.css')) {
            ?>
            <link rel="stylesheet" type="text/css" href="/view/<?php echo \eMarket\Settings::template() ?>/admin/nav.css" media="screen" />
        <?php } ?>
    </head>
    <body>

        <?php
        // ЗАГРУЖАЕМ HEADER
        foreach (\eMarket\View::tlpc('header') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <div id="bodyWrapper" class="container-fluid">
            <div id="ajax">

                <?php
                // ЗАГРУЖАЕМ ТЕЛО HTML СТРАНИЦЫ
                require_once(\eMarket\View::routingAdmin());
                ?>

            </div>
        </div>

        <?php
        // ЗАГРУЖАЕМ FOOTER
        foreach (\eMarket\View::tlpc('footer') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-confirmation.min.js"></script>
        <script type="text/javascript" src="/ext/contextmenu/js/jquery.contextMenu.min.js"></script>
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-multiselect.js"></script>

        <script type="text/javascript">
            $('[data-toggle=confirmation]').confirmation({rootSelector: '[data-toggle=confirmation]'});
        </script>

        <?php
        //Если существует \eMarket\Set::$JS_END
        if (\eMarket\Settings::$JS_END != FALSE) {
            //то подгружаем JS.PHP файл
            require_once(\eMarket\Settings::$JS_END . '/js/js.php');
        }
        //Если существует \eMarket\Set::$JS_MOD_END
        if (\eMarket\Settings::$JS_MOD_END != FALSE) {
            //то подгружаем JS.PHP файл
            require_once(\eMarket\Settings::$JS_MOD_END . '/js/js.php');
        }
        // Выводим отладочную информацию
        \eMarket\Debug::info();
        ?>

    </body>
</html>
