<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
use eMarket\Core\{
    Settings,
    Valid,
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

        <title><?php echo lang('title_' . Settings::titleDir() . '_' . basename(Valid::inSERVER('PHP_SELF'), '.php')) ?></title>

        <link rel="stylesheet" type="text/css" href="/ext/bootstrap/css/bootstrap.min.css" media="screen" />
        <link rel="stylesheet" href="/ext/bootstrap/css/bootstrap-icons.css" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="/view/<?php echo Settings::template() ?>/install/style.css" media="screen" />
        <script type="text/javascript" src="/model/library/js/classes/helpers/helpers.js"></script>
    </head>
    <body>
        <?php
        require_once(View::routing());

        require_once (getenv('DOCUMENT_ROOT') . '/controller/install/footer.php');
        require_once (getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/install/footer.php');
        ?>

        <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.bundle.min.js"></script>

        <?php
        if (Settings::$js_handler != FALSE) {
            require_once(Settings::$js_handler . '/js.php');
        }
        ?>
    </body>
</html>
