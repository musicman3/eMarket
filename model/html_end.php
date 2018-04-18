<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
<?php
//вывод только в админке
if ($patch == 'admin') {

    ?>
    <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/ext/bootstrap/js/bootstrap-confirmation.min.js"></script>
    <script type="text/javascript" src="/ext/bootstrap/js/confirmation.js"></script>
    <script type="text/javascript" src="/ext/bootstrap/js/menu.js"></script>
    <script type="text/javascript" src="/ext/contextmenu/js/contextmenu.js"></script>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/controller/admin/footer.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/view/default/admin/footer.php');
} // конец вывода только в админке

?>
<?php //вывод только в каталоге
if ($patch == 'catalog') {

    ?>
    <script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
    <?php
} // конец вывода только в каталоге

?>