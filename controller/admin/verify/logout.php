<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

session_start();    //инициализируем механизм сессий
session_destroy();    //удаляем текущую сессию
header('Location: /controller/admin/verify/login.php');    //перенаправляем на protected.php
?>