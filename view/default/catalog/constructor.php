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

        <link rel="canonical" href="<?php echo $SET->canonicalPathCatalog() ?>" />
        <link href="/ext/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <link href="/ext/bootstrap/css/normalize.css" rel="stylesheet" media="screen" />
        <link rel="stylesheet" type="text/css" href="/view/<?php echo $SET->template() ?>/catalog/style.css" media="screen" />
        <script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
    </head>
    <body>

        <?php
        // ЗАГРУЖАЕМ HEADER
        foreach ($VIEW->layoutRouting('header') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <div id="bodyWrapper" class="container-fluid">

            <div class="row">

                <?php
                // ПРОВЕРЯЕМ НАЛИЧИЕ БОКСА В РАЗМЕТКЕ
                $COUNT_BOX_LEFT = count($VIEW->layoutRouting('boxes-left'));

                if ($COUNT_BOX_LEFT != 0) {
                    ?>

                    <div id="bodyContent" class="col-md-10 col-md-push-2">
                        <?php
                        require_once($VIEW->routingCatalog());
                        ?>
                    </div>

                <?php } else { ?>

                    <div id="bodyContent" class="col-xs-12">
                        <?php
                        require_once($VIEW->routingCatalog());
                        ?>
                    </div>

                    <?php
                }

                if ($COUNT_BOX_LEFT != 0) {
                    ?>

                    <div id="columnLeft" class="col-md-2 col-xs-12 col-md-pull-10">
                        <?php
                        // ЗАГРУЖАЕМ БОКСЫ
                        foreach ($VIEW->layoutRouting('boxes-left') as $path) {
                            require_once (ROOT . $path);
                        }
                        ?>
                    </div>

                <?php } ?>

            </div>

        </div>

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
        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/ext/simpleeqh/simpleeqh.js"></script>
        <script type="text/javascript" src="/ext/jstree/jstree.min.js"></script>
    </body>
</html>
