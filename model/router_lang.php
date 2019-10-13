<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Переключаем язык в Административной панели
if (\eMarket\Valid::inGET('language') && \eMarket\Set::path() == 'admin') {
    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_ADMINISTRATORS . " SET language=? WHERE login=? AND password=?", [\eMarket\Valid::inGET('language'), $_SESSION['login'], $_SESSION['pass']]);
    header('Location: ?route=dashboard'); // переадресация
}
?>