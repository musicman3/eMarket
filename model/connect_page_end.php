<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
// 
//LOAD TEMPLATE
require_once(ROOT . '/model/html_start.php');

//CONNECT END
$DB = null;

//Если существует $JS_END
if (isset($JS_END)) {
    //то подгружаем JS.PHP файл
    require_once($JS_END . '/js/js.php');
}

?>
</body>
</html>