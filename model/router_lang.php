<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Переключаем язык в Административной панели
if ($VALID->inGET('language') && $SET->path() == 'admin') {
    $PDO->inPrepare("UPDATE " . TABLE_ADMINISTRATORS . " SET language=? WHERE login=? AND password=?", [$VALID->inGET('language'), $_SESSION['login'], $_SESSION['hash']]);
    header('Location: /controller/admin/'); // переадресация
}
?>