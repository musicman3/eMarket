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
        <title><?php echo lang('title_' . \eMarket\Set::titleDir() . '_' . basename(\eMarket\Valid::inSERVER('PHP_SELF'), '.php')) ?></title>

        <link href="/ext/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <link rel="stylesheet" type="text/css" href="/view/<?php echo \eMarket\Set::template() ?>/install/style.css" media="screen" />
        <script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
    </head>
    <body>
        <?php
        // ЗАГРУЖАЕМ ТЕЛО HTML СТРАНИЦЫ
        require_once(\eMarket\View::routing());

        // ЗАГРУЖАЕМ FOOTER
        require_once (getenv('DOCUMENT_ROOT') . '/controller/install/footer.php');
        require_once (getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Set::template() . '/install/footer.php');

        ?>

        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>

        <?php
        //Если существует \eMarket\Set::$JS_END
        if (\eMarket\Set::$JS_END != FALSE) {
            //то подгружаем JS.PHP файл
            require_once(\eMarket\Set::$JS_END . '/js/js.php');
        }

        ?>
    </body>
</html>
