<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
// Подключаем языковую функцию
require_once(ROOT . '/model/functions/core/lang.php');

//Переключаем язык
if ($VALID->inGET('language')) {
    $PDO->inPrepare("UPDATE " . TABLE_ADMINISTRATORS . " SET language=? WHERE login=? AND password=?", [$VALID->inGET('language'), $_SESSION['login'], $_SESSION['pass']]);
    header('Location: /controller/admin/'); // переадресация
}
?>