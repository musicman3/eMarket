<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<!doctype html>
<html dir="ltr" lang="<?php echo lang('meta-language') ?>">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow" />
        <meta name="generator" content="HippoEDIT, Netbeans, Notepad++" />
        <meta name="classification" content="software" />
        <meta name="author" content="eMarket" />
        <meta name="owner" content="eMarket" />
        <meta name="copyright" content="Copyright © 2018 by eMarket Team. All right reserved." />

        <!-- Автогенерация Title" -->
        <title><?php echo lang('title_' . $SET->titleDir() . '_' . basename($VALID->inSERVER('PHP_SELF'), '.php')) ?></title>

        <link href="/ext/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <link href="/ext/bootstrap/css/normalize.css" rel="stylesheet" media="screen" />
        <link rel="stylesheet" type="text/css" href="/view/<?php echo $SET->template() ?>/admin/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/ext/contextmenu/css/contextmenu.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/ext/jquery/ui/jquery-ui.min.css" media="screen" />
        <link rel="stylesheet" href="/ext/bootstrap/css/bootstrap-multiselect.css" type="text/css"/>
        <script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/ext/jquery/ui/jquery-ui.min.js"></script>

        <!-- Всплывающие подсказки" -->
        <script type="text/javascript">
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>

        <?php
        if (isset($_SESSION['login']) && isset($_SESSION['pass']) && file_exists(ROOT . '/view/' . $SET->template() . '/admin/nav.css')) {

            ?>
            <link rel="stylesheet" type="text/css" href="/view/<?php echo $SET->template() ?>/admin/nav.css" media="screen" />
        <?php } ?>
    </head>
    <body>

        <?php
        // ЗАГРУЖАЕМ HEADER
        foreach ($VIEW->layoutRouting('header') as $path) {
            require_once (ROOT . $path);
        }

        // ЗАГРУЖАЕМ ТЕЛО HTML СТРАНИЦЫ
        require_once($VIEW->routingAdmin());

        ?>

        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-confirmation.min.js"></script>
        <script type="text/javascript" src="/ext/contextmenu/js/contextmenu.js"></script>
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-multiselect.js"></script>

        <?php
        // ЗАГРУЖАЕМ FOOTER
        foreach ($VIEW->layoutRouting('footer') as $path) {
            require_once (ROOT . $path);
        }

        //Если существует $JS_END
        if (isset($JS_END)) {
            //то подгружаем JS.PHP файл
            require_once($JS_END . '/js/js.php');
        }

        $tend = microtime(1); // Засекаем конечное время
        // Округляем до двух знаков после запятой
        $totaltime = round(($tend - $tstart), 2);
        // Результат на экран
        echo "Время генерации страницы: " . $totaltime . " сек.<br><br>";

        ?>
    </body>
</html>
