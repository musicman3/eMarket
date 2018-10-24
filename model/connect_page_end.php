<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
// 
//LOAD TEMPLATE
require_once($VIEW->Routing());

//CONNECT END
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/connect_end.php');
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/html_end.php');

//Если существует $JS_END и JS.PHP
if (isset($JS_END)) {
    //то подгружаем JS.PHP файл
    require_once($JS_END . '/js/js.php');
}

?>
</body>
</html>