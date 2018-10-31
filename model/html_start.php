<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>

<!doctype html>
<html dir="ltr" lang="<?php echo $lang['meta-language'] ?>">
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
        <title><?php echo $lang['title_' . $TITLE_DIR] // автогенерация префикса title по названию дректории. Пример: для /countries/index.php = countries         ?></title>
        <?php
        //вывод только в админке
        if ($PATH == 'admin') {

            ?>
            <link href="/ext/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
            <link href="/ext/bootstrap/css/normalize.css" rel="stylesheet" media="screen" />
            <link rel="stylesheet" type="text/css" href="/view/<?php echo $TEMPLATE ?>/admin/style.css" media="screen" />
            <link rel="stylesheet" type="text/css" href="/ext/contextmenu/css/contextmenu.css" media="screen" />
            <link rel="stylesheet" type="text/css" href="/ext/jquery/ui/jquery-ui.min.css" media="screen" />
            <script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="/ext/jquery/ui/jquery-ui.min.js"></script>

            <!-- Всплывающие подсказки" -->
            <script type="text/javascript" language="javascript">
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>

            <?php if (file_exists('products.php')) { ?>
                <script type="text/javascript" src="/ext/tinymce/tinymce.min.js"></script>
                <!-- Автовыбор языка Datepicker" -->
                <script type="text/javascript" src="/ext/jquery/ui/i18n/datepicker-<?php echo $lang['meta-language'] ?>.js"></script>

                <?php
            }
            if (isset($_SESSION['login']) == TRUE && isset($_SESSION['pass']) == TRUE) {

                ?>
                <style type="text/css">body {padding-top:40px;} @media screen and (max-height:420px) and (orientation:landscape) {body {padding-top:60px;}}</style>
                <?php
            }
            require_once(ROOT . '/controller/admin/header.php');
            require_once(ROOT . '/view/' . $TEMPLATE . '/admin/header.php');
        } // конец вывода только в админке

        ?>
        <?php
        //вывод только в каталоге
        if ($PATH == 'catalog') {

            ?>
            <link href="/ext/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
            <link href="/ext/bootstrap/css/normalize.css" rel="stylesheet" media="screen" />
            <link rel="stylesheet" type="text/css" href="/view/<?php echo $TEMPLATE ?>/catalog/style.css" media="screen" />
            <?php
        } // конец вывода только в каталоге
        //
        // ЗАГРУЖАЕМ ТЕЛО HTML СТРАНИЦЫ
        require_once($VIEW->Routing());
        //
        //вывод только в админке
        if ($PATH == 'admin') {

            ?>
            <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-confirmation.min.js"></script>
            <script type="text/javascript" src="/ext/bootstrap/js/confirmation.js"></script>
            <script type="text/javascript" src="/ext/bootstrap/js/menu.js"></script>
            <script type="text/javascript" src="/ext/contextmenu/js/contextmenu.js"></script>
            <?php
            require_once(ROOT . '/controller/admin/footer.php');
            require_once(ROOT . '/view/' . $TEMPLATE . '/admin/footer.php');
        } // конец вывода только в админке

        ?>
        <?php
        //вывод только в каталоге
        if ($PATH == 'catalog') {

            ?>
            <script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="/ext/bootstrap/js/menu.js"></script>
            <?php
        } // конец вывода только в каталоге
        //
        //Если существует $JS_END
        if (isset($JS_END)) {
            //то подгружаем JS.PHP файл
            require_once($JS_END . '/js/js.php');
        }

        ?>
    </body>
</html>