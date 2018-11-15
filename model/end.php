<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
// 
//LOAD TEMPLATE
require_once(getenv('DOCUMENT_ROOT') . '/model/html.php');

//CONNECT END
$DB = null;

 $tend=microtime(1); // Засекаем конечное время
// Округляем до двух знаков после запятой
$totaltime=round(($tend-$tstart),2);
// Результат на экран
echo "Время генерации страницы: ".$totaltime." сек.<br><br>"; 
?>
