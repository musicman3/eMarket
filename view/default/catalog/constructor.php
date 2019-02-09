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
        <link rel="stylesheet" type="text/css" href="/view/<?php echo $SET->template() ?>/catalog/style.css" media="screen" />
        <script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
    </head>
    <body>

        <?php
        // ЗАГРУЖАЕМ HEADER
        foreach ($VIEW->layoutRouting('header', $LAYOUT_POS) as $controller => $view) {
            require_once (getenv('DOCUMENT_ROOT') . $controller);
            require_once (getenv('DOCUMENT_ROOT') . $view);
        }

        ?>

        <div id="bodyWrapper" class="container-fluid">

            <div id="header">
                <div class="col-sm-4">
                    <a href=""><img class="img-responsive pull-left" src="/view/<?php echo $SET->template() ?>/catalog/images/emarket.png"></a>
                </div>
                <div class="col-sm-8">
                    Search
                </div>
            </div>

            <div class="clearfix"></div>

            Breadcrumb

            <div class="clearfix"></div>

            Carousel

            <div class="row">

                <div id="bodyContent" class="col-md-10 col-md-push-2">
                    <?php
                    require_once($VIEW->routing());

                    ?>
                </div>

                <div id="columnLeft" class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col-md-pull-10">
                    <?php
                    // ЗАГРУЖАЕМ БОКСЫ
                    foreach ($VIEW->layoutRouting('boxes-left', $LAYOUT_POS) as $controller => $view) {
                        require_once (getenv('DOCUMENT_ROOT') . $controller);
                        require_once (getenv('DOCUMENT_ROOT') . $view);
                    }

                    ?>
                </div>

            </div>

        </div>

        <?php
        // ЗАГРУЖАЕМ FOOTER
        foreach ($VIEW->layoutRouting('footer', $LAYOUT_POS) as $controller => $view) {
            require_once (getenv('DOCUMENT_ROOT') . $controller);
            require_once (getenv('DOCUMENT_ROOT') . $view);
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
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/ext/simpleeqh/simpleeqh.js"></script>
    </body>
</html>
