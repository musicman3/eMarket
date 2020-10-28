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
        <title><?php echo \eMarket\Set::titlePageGenerator() ?></title>

        <link href="/ext/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <link href="/ext/bootstrap/css/normalize.css" rel="stylesheet" media="screen" />
        <link rel="stylesheet" type="text/css" href="/view/<?php echo \eMarket\Set::template() ?>/admin/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/ext/contextmenu/css/contextmenu.css" media="screen" />
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
        if (isset($_SESSION['login']) && isset($_SESSION['pass']) && file_exists(ROOT . '/view/' . \eMarket\Set::template() . '/admin/nav.css')) {
            ?>
            <link rel="stylesheet" type="text/css" href="/view/<?php echo \eMarket\Set::template() ?>/admin/nav.css" media="screen" />
        <?php } ?>
    </head>
    <body>

        <?php
        // ЗАГРУЖАЕМ HEADER
        foreach (\eMarket\View::layoutRouting('header') as $path) {
            require_once (ROOT . $path);
        }

        // ЗАГРУЖАЕМ ТЕЛО HTML СТРАНИЦЫ
        require_once(\eMarket\View::routingAdmin());

        // ЗАГРУЖАЕМ FOOTER
        foreach (\eMarket\View::layoutRouting('footer') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-confirmation.min.js"></script>
        <script type="text/javascript" src="/ext/contextmenu/js/contextmenu.js"></script>
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-multiselect.js"></script>
        
        <script type="text/javascript">
            $('[data-toggle=confirmation]').confirmation();
        </script>

        <?php
        //Если существует $JS_END
        if (isset($JS_END)) {
            //то подгружаем JS.PHP файл
            require_once($JS_END . '/js/js.php');
        }
        //Если существует $JS_MOD_END
        if (isset($JS_MOD_END)) {
            //то подгружаем JS.PHP файл
            require_once($JS_MOD_END . '/js/js.php');
        }
        // Выводим отладочную информацию
        \eMarket\Debug::info($TIME_START);
        ?>
    </body>
</html>
