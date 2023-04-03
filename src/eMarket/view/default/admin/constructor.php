<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize,
    Debug,
    Settings,
    Routing
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

        <link rel="stylesheet" type="text/css" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" media="screen" />
        <link rel="stylesheet" href="/ext/bootstrap-icons/bootstrap-icons.css" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="/view/<?php echo Settings::template() ?>/admin/style.css" media="screen" />

        <?php
        if (isset($_SESSION['login']) && isset($_SESSION['pass']) && file_exists(ROOT . '/view/' . Settings::template() . '/admin/nav.css')) {
            ?>
            <link rel="stylesheet" type="text/css" href="/view/<?php echo Settings::template() ?>/admin/nav.css" media="screen" />
        <?php } ?>

        <script type="text/javascript" src="/ext/fastmd5/md5.min.js"></script>
        <script type="text/javascript" src="/ext/randomizer/randomizer.js"></script>
        <script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
        <script type="text/javascript" src="/model/library/js/classes/chatgpt/chatgpt.js"></script>
        <script type="text/javascript" src="/model/library/js/classes/update/update.js"></script>
        <script type="text/javascript" src="/model/library/js/classes/helpers/helpers.js"></script>
        <script type="text/javascript" src="/model/library/js/classes/confirm/confirm.js"></script>

        <script type="text/javascript">
            var Confirmation = new Confirm();
            document.addEventListener("DOMContentLoaded", function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>

    </head>
    <body>
        <div id="csrf_token" class='hidden' data-csrf='<?php echo Authorize::csrfToken() ?>'></div>
        <div id="user_login" class='hidden' data-login='<?php echo Authorize::encryptedLogin() ?>'></div>

        <?php
        foreach (Routing::tlpc('header') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <div id="bodyWrapper" class="container-fluid">
            <div id="ajax">

                <?php
                require_once(Routing::template());
                require_once('confirm.php');
                ?>

            </div>
        </div>

        <?php
        foreach (Routing::tlpc('footer') as $path) {
            require_once (ROOT . $path);
        }
        ?>

        <script type="text/javascript" src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

        <?php
        if (Routing::$js_handler) {
            require_once(Routing::$js_handler . '/js.php');
        }
        if (Routing::$js_modules_handler) {
            require_once(Routing::$js_modules_handler . '/js.php');
        }
        Debug::info();
        ?>

        <script type="text/javascript">
            new Ajax();
            new Update();
        </script>
    </body>
</html>
